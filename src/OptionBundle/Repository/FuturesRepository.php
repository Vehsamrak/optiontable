<?php

namespace OptionBundle\Repository;

use OptionBundle\Entity\Futures;
use OptionBundle\Entity\Symbol;

/**
 * FuturesRepository
 */
class FuturesRepository extends \Doctrine\ORM\EntityRepository
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
}
