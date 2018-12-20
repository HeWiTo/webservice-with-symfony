<?php

namespace AppBundle\Resource\Filtering\Product;

use AppBundle\Repository\ProductRepository;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use Doctrine\ORM\QueryBuilder;

class ProductResourceFilter implements ResourceFilterInterface
{
    /**
     * @var ProductRepository
     */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ProductFilterDefinition $filter
     * @return QueryBuilder
     */
    public function getResources($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('product');

        return $qb;
    }

    /**
     * @param ProductFilterDefinition $filter
     * @return QueryBuilder
     */
    public function getResourceCount($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('count(product)');

        return $qb;
    }

    /**
     * @param ProductFilterDefinition $filter
     * @return QueryBuilder
     */
    private function getQuery(ProductFilterDefinition $filter): QueryBuilder
    {
        $qb = $this->repository->createQueryBuilder('product');

        if (null !== $filter->getTitle()) {
            $qb->where(
                $qb->expr()->like('product.title', ':title')
            );
            $qb->setParameter('title', "%{$filter->getTitle()}%");
        }

        if (null !== $filter->getBrand()) {
            $qb->andWhere(
                $qb->expr()->gte('product.brand', ':brand')
            );
            $qb->setParameter('brand', "%{$filter->getBrand()}%");
        }

        if (null !== $filter->getSortByArray()) {
            foreach ($filter->getSortByArray() as $by => $order) {
                $expr = 'desc' == $order
                    ? $qb->expr()->desc("product.$by")
                    : $qb->expr()->asc("product.$by");
                $qb->addOrderBy($expr);
            }
        }

        return $qb;
    }
}