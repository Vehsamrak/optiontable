<?php

namespace OptionBundle\Repository;

use OptionBundle\Entity\Trade;
use OptionBundle\Repository\Infrastructure\AbstractRepository;

/**
 * TradeRepository
 */
class TradeRepository extends AbstractRepository
{

    /**
     * @return Trade[]
     */
    public function findAllTrades()
    {
        return $this->findAll();
    }

    /**
     * @param $tradeId
     * @return Trade|null
     */
    public function findTradeById($tradeId)
    {
        return $this->find($tradeId);
    }
}
