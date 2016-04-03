<?php

namespace OptionBundle\Controller;

use OptionBundle\Entity\Trade;
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

        return $this->render(
            'OptionBundle:Trades:trades.html.twig',
            [
                'openedTrades' => $this->formatOpenedTrades(),
                'closedTrades' => $tradesRepository->findAllClosedTrades(),
            ]
        );
    }

    /**
     * @return array
     */
    private function formatOpenedTrades()
    {
        $openedTrades = $this->get('optionboard.trade_repository')->findAllOpenedTrades();
        $optionPriceRepository = $this->get('optionboard.option_price_repository');
        $priceCollector = $this->get('optionboard.price_collector');

        $openedTradesView = [];
        foreach ($openedTrades as $openedTradeKey => $openedTrade) {
            $openPrice = $openedTrade->getOpenPrice();
            $optionContract = $openPrice->getOptionContract();
            $futures = $optionContract->getFutures();
            $optionPrice = $openPrice->getOptionPrice();
            $tradeDirection = $openedTrade->getDirection();
            $currentPrice = $optionPriceRepository->findOptionCurrentPrice(
                $optionContract->getId()
            )->getOptionPrice();

            $openedTradesView[$openedTradeKey]['futures'] = $priceCollector->getFuturesName($futures);
            $openedTradesView[$openedTradeKey]['futuresPrice'] = $openPrice->getFuturesPrice();
            $openedTradesView[$openedTradeKey]['openDate'] = $openPrice->getDay();
            $openedTradesView[$openedTradeKey]['volume'] = $openedTrade->getVolume();
            $openedTradesView[$openedTradeKey]['openPrice'] = $optionPrice;
            $openedTradesView[$openedTradeKey]['highPrice'] = $openedTrade->getHighPrice()->getOptionPrice();
            $openedTradesView[$openedTradeKey]['lowPrice'] = $openedTrade->getLowPrice()->getOptionPrice();
            $openedTradesView[$openedTradeKey]['profit'] = $this->calculateProfit($openedTrade, $currentPrice);

            $openedTradesView[$openedTradeKey]['expiration'] = sprintf(
                '%s (%d)',
                $futures->getExpiration(),
                $futures->getDaysToExpiration()
            );

            $openedTradesView[$openedTradeKey]['type'] = sprintf(
                '%s %s',
                $tradeDirection,
                $optionContract->getType()
            );

            $openedTradesView[$openedTradeKey]['currentPrice'] = $currentPrice;
        }

        return $openedTradesView;
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

    /**
     * Расчет бумажной прибыли сделки при относительной цене
     * @param Trade $trade
     * @param float $currentPrice
     * @return float
     */
    private function calculateProfit(Trade $trade, float $currentPrice)
    {
        $optionPrice = $trade->getOpenPrice();
        $optionPointPrice = $optionPrice->getOptionContract()->getFutures()->getSymbol()->getOptionPointPrice();
        $openPrice = $optionPrice->getOptionPrice();

        if ($trade->isDirectionBuy()) {
            $result = $currentPrice - $openPrice;
        } else {
            $result = $openPrice - $currentPrice;
        }

        return $result * $trade->getVolume() * $optionPointPrice;
    }
}
