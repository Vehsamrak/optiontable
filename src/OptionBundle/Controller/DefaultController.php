<?php
/**
 * Author: Vehsamrak
 * Date Created: 14.02.16 16:17
 */

namespace OptionBundle\Controller;

use OptionBundle\Entity\Futures;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
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
     * Список открытых сделок
     * @Route("/trades")
     * @return Response
     */
    public function openedTradesAction()
    {
        $tradesRepository = $this->get('optionboard.trade_repository');
        $trades = $tradesRepository->findAllOpenedTrades();

        return $this->render('OptionBundle:Default:trades.html.twig', [
            'trades' => $trades, 
        ]);
    }

    /**
     * Открыть сделку с заданной ценой
     * @Route("/trades/open/{optionPriceId}")
     * @return Response
     */
    public function openTradeAction(int $optionPriceId)
    {
        $trader = $this->get('optionboard.trader');
        $trader->openTrade($optionPriceId);

        return $this->redirectToRoute('option_default_openedtrades');
    }

    /**
     * Закрыть определенную сделку по заданной цене
     * @Route("/trades/close/{tradeId}/{optionPriceId}")
     * @param int $tradeId
     * @param int $optionPriceId
     * @return Response
     */
    public function closeTradeAction(int $tradeId, int $optionPriceId)
    {
        $trader = $this->get('optionboard.trader');
        $trader->closeTrade($tradeId, $optionPriceId);

        return $this->redirectToRoute('option_default_openedtrades');
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
