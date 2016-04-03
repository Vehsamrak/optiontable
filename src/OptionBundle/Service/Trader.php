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

    /**
     * @param OptionPriceRepository $optionPriceRepository
     * @param TradeRepository       $tradeRepository
     */
    public function __construct(OptionPriceRepository $optionPriceRepository, TradeRepository $tradeRepository)
    {
        $this->optionPriceRepository = $optionPriceRepository;
        $this->tradeRepository = $tradeRepository;
    }


    /**
     * Открытие сделки и запись ее в БД
     * @param string $direction
     * @param int    $optionPriceId
     * @param int    $volume
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
     * @param int $tradeId
     * @param int $optionPriceCloseId
     * @return bool
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
     * @return int
     */
    public function updateOpenedTradesHighsAndLows(): int
    {
        $trades = $this->tradeRepository->findAllOpenedTrades();

        $updatedTradesCount = 0;
        foreach ($trades as $trade) {
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
}
