<?php

namespace OptionBundle\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use OptionBundle\Entity\Futures;
use OptionBundle\Entity\Symbol;
use OptionBundle\Repository\Infrastructure\AbstractRepository;

class FuturesRepository extends AbstractRepository
{

    /**
     * @param Symbol $symbol
     * @param string $futuresExpirationDate
     * @return Futures
     */
    public function findOneBySymbolAndExpiration(Symbol $symbol, string $futuresExpirationDate): Futures
    {
        return $this->findOneBy([
            'symbol'     => $symbol->getSymbol(),
            'expiration' => new \DateTime($futuresExpirationDate),
        ]);
    }

    /**
     * @return Futures[]
     */
    public function findAll(): array
    {
        return $this->findBy([], ['symbol' => Criteria::ASC]);
    }

    /**
     * @param string $symbolCode
     * @param int    $expirationMonth
     * @param int    $expirationYear
     * @return Futures|null
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findOneBySymbolAndExpirationMonthAndYear(
        string $symbolCode,
        int $expirationMonth,
        int $expirationYear
    ) {

        $expirationMonth = str_pad($expirationMonth, 2, 0, STR_PAD_LEFT);

        $queryBuilder = $this->createQueryBuilder('futures');
        $queryBuilder->where('futures.symbol = :symbol');
        $queryBuilder->andWhere($queryBuilder->expr()->like('futures.expiration', ':expiration'));

        $queryBuilder->setParameters(
            [
                'symbol'     => $symbolCode,
                'expiration' => "%$expirationYear-$expirationMonth-%",
            ]
        );

        return $queryBuilder->getQuery()->getSingleResult();
    }
}
