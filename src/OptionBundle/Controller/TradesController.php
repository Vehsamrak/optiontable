<?php

namespace OptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Vehsamrak
 * @Route("/trades")
 */
class TradesController extends Controller
{

    /**
     * Список открытых сделок
     * @Route("/", name="option_trades_list")
     * @return Response
     */
    public function listTradesAction()
    {
        $tradesRepository = $this->get('optionboard.trade_repository');

        return $this->render('OptionBundle:Trades:trades.html.twig', [
            'openedTrades' => $tradesRepository->findAllOpenedTrades(),
            'closedTrades' => $tradesRepository->findAllClosedTrades(),
        ]);
    }

    /**
     * Открыть сделку с заданной ценой
     * @Route("/open/{direction}/{optionPriceId}/{volume}", name="option_trade_open")
     * @return Response
     */
    public function openTradeAction(string $direction, int $optionPriceId, int $volume)
    {
        $trader = $this->get('optionboard.trader');
        $trader->openTrade($direction, $optionPriceId, $volume);

        return $this->redirectToRoute('option_trades_list');
    }

    /**
     * Закрыть определенную сделку по заданной цене
     * @Route("/close/{tradeId}/{optionPriceId}", name="option_trade_close")
     * @param int $tradeId
     * @param int $optionPriceId
     * @return Response
     */
    public function closeTradeAction(int $tradeId, int $optionPriceId)
    {
        $trader = $this->get('optionboard.trader');
        $trader->closeTrade($tradeId, $optionPriceId);

        return $this->redirectToRoute('option_trades_list');
    }
}
