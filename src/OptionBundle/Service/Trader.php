<?php

namespace OptionBundle\Service;

use OptionBundle\Entity\Trade;
use OptionBundle\Enum\TradeDirection;
use OptionBundle\Exception\InvalidTradeDirection;
use OptionBundle\Exception\PriceNotFound;
use OptionBundle\Exception\TradeNotFound;
use OptionBundle\Repository\OptionPriceRepository;
use OptionBundle\Repository\TradeRepository;

/**
 * @author Vehsamrak
 */
class Trader
{

    /** @var OptionPriceRepository */
    private $optionPriceRepository;

    /** @var TradeRepository */
    private $tradeRepository;

    public function __construct(
        OptionPriceRepository $optionPriceRepository,
        TradeRepository $tradeRepository
    )
    {
        $this->optionPriceRepository = $optionPriceRepository;
        $this->tradeRepository = $tradeRepository;
    }


    /**
     * Открытие сделки и запись ее в БД
     * @throws InvalidTradeDirection
     * @throws PriceNotFound
     */
    public function openTrade(string $direction, int $optionPriceId, int $volume)
    {
        if (!TradeDirection::isValid($direction)) {
            throw new InvalidTradeDirection();
        }

        $optionPrice = $this->optionPriceRepository->findOptionPriceById($optionPriceId);

        $trade = new Trade($direction, $optionPrice, $volume);

        $this->tradeRepository->persist($trade);
        $this->tradeRepository->flush($trade);
    }

    /**
     * Закрытие сделки и запись результатов в БД
     * @throws TradeNotFound
     */
    public function closeTrade(int $tradeId, int $optionPriceCloseId)
    {
        $trade = $this->tradeRepository->findTradeById($tradeId);
        $optionPriceClose = $this->optionPriceRepository->findOptionPriceById($optionPriceCloseId);

        $trade->setClosePrice($optionPriceClose);

        $this->tradeRepository->flush($trade);
    }

    /**
     * Обновление минимумов и максимумов для открытых сделок
     * @param Trade[] $openedTrades
     */
    public function updateOpenedTradesHighsAndLows(array $openedTrades): int
    {
        $updatedTradesCount = 0;
        foreach ($openedTrades as $trade) {
            $optionContract = $trade->getOpenPrice()->getOptionContract();
            $currentOptionPrice = $this->optionPriceRepository->findOptionCurrentPrice($optionContract->getId());

            if ($trade->getHighPrice()->isLowerThan($currentOptionPrice)) {
                $trade->setHighPrice($currentOptionPrice);
                $updatedTradesCount++;
            } elseif ($trade->getLowPrice()->isGreaterThan($currentOptionPrice)) {
                $trade->setLowPrice($currentOptionPrice);
                $updatedTradesCount++;
            }
        }

        $this->tradeRepository->flush();

        return $updatedTradesCount;
    }

    /**
     * @param Trade[] $openedTrades
     */
    public function closeExpiredTrades(array $openedTrades): int
    {
        $closedTradesCount = 0;
        foreach ($openedTrades as $trade) {
            $optionPrice = $trade->getOpenPrice();
            $optionContract = $optionPrice->getOptionContract();
            $futures = $optionContract->getFutures();

            if ($futures->isExpired()) {
                $trade->expire();
                $closedTradesCount++;
            }
        }

        $this->tradeRepository->flush();

        return $closedTradesCount;
    }
}
