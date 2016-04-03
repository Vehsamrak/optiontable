<?php

namespace OptionBundle\Controller;

use OptionBundle\Entity\Futures;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Vehsamrak
 * @Route("/")
 */
class DefaultController extends Controller
{

    /**
     * @Route("/")
     * @return Response
     */
    public function indexAction()
    {
        $futuresRepository = $this->get('optionboard.futures_repository');
        $futures = $futuresRepository->findAll();

        return $this->render('OptionBundle:Default:index.html.twig', [
            'futuresList' => $this->getFuturesNames($futures),
        ]);
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
