<?php

namespace OptionBundle\Repository;

use OptionBundle\Entity\Futures;
use OptionBundle\Entity\Symbol;
use OptionBundle\Repository\Infrastructure\AbstractRepository;

/**
 * FuturesRepository
 */
class FuturesRepository extends AbstractRepository
{

    /**
     * @param Symbol $symbol
     * @param string $futuresExpirationDate
     * @return Futures
     */
    public function findOneBySymbolAndExpiration(Symbol $symbol, string $futuresExpirationDate)
    {
        return $this->findOneBy([
            'symbol'     => $symbol->getSymbol(),
            'expiration' => new \DateTime($futuresExpirationDate),
        ]);
    }

    /**
     * @return Futures[]
     */
    public function findAll()
    {
        return $this->findBy([]);
    }
}
