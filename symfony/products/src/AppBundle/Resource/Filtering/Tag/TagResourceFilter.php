<?php

namespace AppBundle\Resource\Filtering\Tag;

use AppBundle\Repository\TagRepository;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use Doctrine\ORM\QueryBuilder;

class TagResourceFilter implements ResourceFilterInterface
{
    /**
     * @var TagRepository
     */
    private $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param TagFilterDefinition $filter
     * @return QueryBuilder
     */
    public function getResources($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('tag');

        return $qb;
    }

    /**
     * @param TagFilterDefinition $filter
     * @return QueryBuilder
     */
    public function getResourceCount($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('count(tag)');

        return $qb;
    }

    private function getQuery(TagFilterDefinition $filter): QueryBuilder
    {
        $qb = $this->repository->createQueryBuilder('tag');

        if (null !== $filter->getTagName()) {
            $qb->where(
                $qb->expr()->like('tag.tagName', ':tagName')
            );
            $qb->setParameter('tagName', "%{$filter->getTagName()}%");
        }

        if (null !== $filter->getProduct()) {
            $qb->andWhere(
                $qb->expr()->eq('tag.product', ':productId')
            );
            $qb->setParameter('productId', $filter->getProduct());
        }

        if (null !== $filter->getSortByArray()) {
            foreach ($filter->getSortByArray() as $by => $order) {
                $expr = 'desc' == $order
                    ? $qb->expr()->desc("tag.$by")
                    : $qb->expr()->asc("tag.$by");
                $qb->addOrderBy($expr);
            }
        }

        return $qb;
    }
}