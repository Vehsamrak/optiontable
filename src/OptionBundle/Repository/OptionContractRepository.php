<?php

namespace OptionBundle\Repository;

use Doctrine\Common\Collections\Criteria;
use OptionBundle\Entity\Futures;
use OptionBundle\Entity\OptionContract;
use OptionBundle\Repository\Infrastructure\AbstractRepository;

class OptionContractRepository extends AbstractRepository
{

    /**
     * @param string $optionType
     * @param int $futuresId
     * @param float  $strike
     * @return OptionContract|null
     */
    public function findOneByTypeFuturesAndStrike(string $optionType, int $futuresId, float $strike)
    {
        return $this->findOneBy([
            'type'    => $optionType,
            'futures' => $futuresId,
            'strike'  => $strike,
        ]);
    }

    /**
     * @param Futures $futures
     * @return OptionContract[]
     */
    public function findByFuturesAndOrderByStrike(Futures $futures): array
    {
        return $this->findBy(
            ['futures' => $futures],
            ['strike' => Criteria::ASC]
        );
    }
}
