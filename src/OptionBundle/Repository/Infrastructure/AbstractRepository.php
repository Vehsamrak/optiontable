<?php
/**
 * Author: Vehsamrak
 * Date Created: 07.02.16 19:17
 */

namespace OptionBundle\Repository\Infrastructure;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AbstractRepository extends EntityRepository
{

    /**
     * @param object $entity
     */
    public function persist($entity)
    {
        $this->_em->persist($entity);
    }

    /**
     * @param object|null $entity
     */
    public function flush($entity = null)
    {
        $this->_em->flush($entity);
    }

    /**
     * @param object $entity
     */
    public function remove($entity)
    {
        $this->_em->remove($entity);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->_em;
    }
}
