<?php

namespace OptionBundle\Repository;

use OptionBundle\Entity\Symbol;
use OptionBundle\Repository\Infrastructure\AbstractRepository;

/**
 * SymbolRepository
 */
class SymbolRepository extends AbstractRepository
{

    /**
     * @param string $symbolCode
     * @return Symbol|null
     */
    public function findOneBySymbol(string $symbolCode): Symbol
    {
        return $this->findOneBy([
            'symbol' => $symbolCode,
        ]);
    }
}
