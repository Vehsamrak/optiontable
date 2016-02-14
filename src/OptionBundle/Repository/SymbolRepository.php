<?php

namespace OptionBundle\Repository;

use OptionBundle\Entity\Symbol;
use OptionBundle\Enum\SymbolCode;
use OptionBundle\Repository\Infrastructure\AbstractRepository;

/**
 * SymbolRepository
 */
class SymbolRepository extends AbstractRepository
{

    /**
     * @param SymbolCode $symbolCode
     * @return Symbol|null
     */
    public function findOneBySymbol(SymbolCode $symbolCode): Symbol
    {
        return $this->findOneBy([
            'symbol' => $symbolCode,
        ]);
    }
}
