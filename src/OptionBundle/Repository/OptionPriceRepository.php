<?php

namespace OptionBundle\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use OptionBundle\Entity\OptionPrice;
use OptionBundle\Exception\PriceNotFound;
use OptionBundle\Repository\Infrastructure\AbstractRepository;

class OptionPriceRepository extends AbstractRepository
{

    /**
     * @var \DateTime
     */
    private $dateTime;

    public function __construct($em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->dateTime = new \DateTime();
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @param int $optionId
     * @return OptionPrice|null
     */
    public function findOneForLastHourByOptionId(int $optionId)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder->select('option_price');
        $queryBuilder->from('OptionBundle:OptionPrice', 'option_price');
        $queryBuilder->where('option_price.optionContract = :option_id');
        $queryBuilder->andWhere(
            $queryBuilder->expr()->between('option_price.date', ':date_from', ':date_to')
        );

        $queryBuilder->setParameter('option_id', $optionId);

        $lastHour = (new \DateTime($this->dateTime->format('Y-m-d H:i:s')))->modify('-50 minutes');

        $queryBuilder->setParameter('date_from', $lastHour, Type::DATETIME);
        $queryBuilder->setParameter('date_to', $this->dateTime, Type::DATETIME);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $optionPriceId
     * @return OptionPrice
     * @throws PriceNotFound
     */
    public function findOptionPriceById(int $optionPriceId)
    {
        $price = $this->find($optionPriceId);
        
        if (!$price) {
        	throw new PriceNotFound();
        }
        
        return $price;
    }

    /**
     * Найти текущую (последнюю) цену опционного контракта
     * @param int $optionId
     * @return OptionPrice
     */
    public function findOptionCurrentPrice(int $optionId): OptionPrice
    {
        $queryBuilder = $this->createQueryBuilder('option_price');
        $queryBuilder->where('option_price.optionContract = :optionId');
        $queryBuilder->addOrderBy('option_price.date', Criteria::DESC);
        $queryBuilder->setParameter('optionId', $optionId);
        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getSingleResult();
    }
}
