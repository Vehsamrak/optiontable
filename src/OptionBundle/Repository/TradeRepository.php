<?php

namespace OptionBundle\Repository;

use OptionBundle\Entity\Trade;
use OptionBundle\Exception\TradeNotFound;
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
     * @return Trade
     * @throws TradeNotFound
     */
    public function findTradeById($tradeId)
    {
        $trade = $this->find($tradeId);

        if (!$trade) {
            throw new TradeNotFound();
        }

        return $trade;
    }

    /**
     * @return Trade[]
     */
    public function findAllOpenedTrades()
    {
        return $this->findBy([
            'closePrice' => null,
        ]);
    }

    /**
     * @return Trade[]
     */
    public function findAllClosedTrades()
    {
        $queryBuilder = $this->createQueryBuilder('trades');
        $queryBuilder->where($queryBuilder->expr()->isNotNull('trades.closePrice'));
        
        return $queryBuilder->getQuery()->getResult();
    }
}
