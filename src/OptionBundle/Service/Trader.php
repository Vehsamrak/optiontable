<?php

namespace OptionBundle\Service;

use OptionBundle\Entity\OptionPrice;
use OptionBundle\Entity\Trade;
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
     * @param int $optionPriceId
     * @return bool
     */
    public function openTrade(int $optionPriceId): bool
    {
        $optionPrice = $this->optionPriceRepository->findOptionPriceById($optionPriceId);

        if (!$optionPrice) {
            return false;
        }

        $trade = new Trade($optionPrice);
        $this->tradeRepository->persist($trade);
        $this->tradeRepository->flush($trade);

        return true;
    }

    /**
     * @param int         $tradeId
     * @param OptionPrice $optionPriceClose
     * @return bool
     * @throws TradeNotFound
     */
    public function closeTrade(int $tradeId, OptionPrice $optionPriceClose): bool
    {
        $trade = $this->tradeRepository->findTradeById($tradeId);
        
        if (!$trade) {
        	throw new TradeNotFound();
        }
        
        $trade->setClosePrice($optionPriceClose);
        $this->tradeRepository->flush($trade);
        
        return true;
    }
}
