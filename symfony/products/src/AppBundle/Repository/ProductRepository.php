<?php

namespace AppBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function count(): int
    {
        $qb = $this->createQueryBuilder('p');

        return $qb->select('count(p.id)')->getQuery()->getSingleScalarResult();
    }
}
