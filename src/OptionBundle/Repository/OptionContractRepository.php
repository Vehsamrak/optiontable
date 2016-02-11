<?php

namespace OptionBundle\Repository;

use OptionBundle\Entity\OptionContract;
use OptionBundle\Repository\Infrastructure\AbstractRepository;

class OptionContractRepository extends AbstractRepository
{

    /**
     * @param string $optionType
     * @param int $futuresId
     * @param float  $strike
     * @return null|object
     */
    public function findOneByTypeFuturesAndStrike(string $optionType, int $futuresId, float $strike)
    {
        return $this->findOneBy([
            'type'    => $optionType,
            'futures' => $futuresId,
            'strike'  => $strike,
        ]);
    }
}
