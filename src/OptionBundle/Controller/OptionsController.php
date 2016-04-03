<?php

namespace OptionBundle\Controller;

use OptionBundle\Entity\Futures;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Vehsamrak
 * @Route("/options")
 */
class OptionsController extends Controller
{
    /**
     * @Route("/")
     * @return Response
     */
    public function indexAction()
    {
        $futuresRepository = $this->get('optionboard.futures_repository');
        $futures = $futuresRepository->findAll();

        return $this->render('OptionBundle:Options:index.html.twig', [
            'futuresList' => $this->getFuturesNames($futures),
        ]);
    }

    /**
     * @Route("/{futuresCode}")
     * @return Response
     */
    public function showPricesAction(string $futuresCode): Response
    {
        $futuresRepository = $this->get('optionboard.futures_repository');
        $priceCollector = $this->get('optionboard.price_collector');

        $symbolCode = substr($futuresCode, 0, 2);
        $expirationMonthLetter = substr($futuresCode, 2, 1);

        $expirationMonth = $priceCollector->getMonthByLetter($expirationMonthLetter);
        $expirationYear = substr($futuresCode, 3, 2);

        /** If PriceCollector::getMonthByLetter() shifts year */
        $expirationYear = $expirationMonth == 12 ? $expirationYear - 1 : $expirationYear;

        $futures = $futuresRepository->findOneBySymbolAndExpirationMonthAndYear(
            $symbolCode,
            $expirationMonth,
            $expirationYear
        );

        $viewParameters = [];

        if ($futures) {
            $options = $this->get('optionboard.option_contract_repository')->findByFuturesAndOrderByStrike($futures);

            foreach ($options as $option) {
                $optionId = $option->getId();

                $viewParameters['options'][$optionId] = [
                    'type'   => $option->getType(),
                    'strike' => $option->getStrike(),
                    'prices' => $option->getOptionPrices(),
                ];
            }
        }

        return $this->render('OptionBundle:Options:prices.html.twig', $viewParameters);
    }

    /**
     * @param Futures[] $futuresList
     * @return array Futures full names
     */
    private function getFuturesNames(array $futuresList)
    {
        $priceCollector = $this->get('optionboard.price_collector');

        $futuresNames = [];
        foreach ($futuresList as $futures) {
            $futuresId = $futures->getId();

            $futuresNames[$futuresId]['code'] = sprintf(
                '%s%s%d',
                $futures->getSymbol()->getSymbol(),
                $priceCollector->getMonthLetter($futures->getExpirationMonth()),
                $futures->getExpirationYear()
            );

            $futuresNames[$futuresId]['daysToExpiration'] = $futures->getDaysToExpiration();
        }

        return $futuresNames;
    }
}
