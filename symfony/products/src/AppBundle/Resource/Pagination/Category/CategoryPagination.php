<?php

namespace AppBundle\Resource\Pagination\Category;

use AppBundle\Resource\Filtering\Category\CategoryResourceFilter;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use AppBundle\Resource\Pagination\AbstractPagination;
use AppBundle\Resource\Pagination\PaginationInterface;

class CategoryPagination extends AbstractPagination implements PaginationInterface
{
    private const ROUTE = 'get_categories';

    /**
     * @var CategoryResourceFilter
     */
    private $resourceFilter;

    public function __construct(CategoryResourceFilter $resourceFilter)
    {
        $this->resourceFilter = $resourceFilter;
    }

    public function getResourceFilter(): ResourceFilterInterface
    {
        return $this->resourceFilter;
    }

    public function getRouteName(): string
    {
        return self::ROUTE;
    }
}