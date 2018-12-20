<?php

namespace AppBundle\Resource\Filtering\Category;

use AppBundle\Repository\CategoryRepository;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use Doctrine\ORM\QueryBuilder;

class CategoryResourceFilter
    implements ResourceFilterInterface
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CategoryFilterDefinition $filter
     * @return QueryBuilder
     */
    public function getResources($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('category');

        return $qb;
    }

    /**
     * @param CategoryFilterDefinition $filter
     * @return QueryBuilder
     */
    public function getResourceCount($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('count(category)');

        return $qb;
    }

    /**
     * @param CategoryFilterDefinition $filter
     * @return QueryBuilder
     */
    private function getQuery(CategoryFilterDefinition $filter): QueryBuilder
    {
        $qb = $this->repository->createQueryBuilder('category');

        if (null !== $filter->getTitle()) {
            $qb->where(
                $qb->expr()->like('category.title', ':title')
            );
            $qb->setParameter('title', "%{$filter->getFirstName()}%");
        }

        if (null !== $filter->getCreatedFrom()) {
            $qb->andWhere(
                $qb->expr()->gte('category.createdAt', ':createdFrom')
            );
            $qb->setParameter('createdFrom', $filter->getCreatedFrom());
        };

        if (null !== $filter->getCreatedTo()) {
            $qb->andWhere(
                $qb->expr()->lte('category.createdAt', ':createdTo')
            );
            $qb->setParameter('createdTo', $filter->getCreatedTo());
        }

        if (null !== $filter->getSortByArray()) {
            foreach ($filter->getSortByArray() as $by => $order) {
                $expr = 'desc' == $order
                    ? $qb->expr()->desc("category.$by")
                    : $qb->expr()->asc("category.$by");
                $qb->addOrderBy($expr);
            }
        }

        return $qb;
    }
}