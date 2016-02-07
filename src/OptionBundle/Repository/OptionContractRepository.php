<?php

namespace OptionBundle\Repository;

use OptionBundle\Entity\OptionContract;
use OptionBundle\Repository\Infrastructure\AbstractRepository;

class OptionContractRepository extends AbstractRepository
{

    /**
     * @param string $optionType
     * @param float  $strike
     * @return OptionContract
     */
    public function findOneByTypeAndStrike(string $optionType, float $strike)
    {
        return $this->findOneBy([
            'type'   => $optionType,
            'strike' => $strike,
        ]);
    }
}
