<?php
/**
 * Author: Vehsamrak
 * Date Created: 14.02.16 16:17
 */

namespace OptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/options")
 */
class OptionsController extends Controller
{

    /**
     * @Route("/{futuresCode}")
     * @return Response
     */
    public function indexAction(string $futuresCode): Response
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

        return $this->render('OptionBundle:Options:index.html.twig', $viewParameters);
    }
}
