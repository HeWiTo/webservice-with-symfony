<?php

namespace AppBundle\Resource\Pagination\Tag;

use AppBundle\Resource\Filtering\ResourceFilterInterface;
use AppBundle\Resource\Filtering\Tag\TagResourceFilter;
use AppBundle\Resource\Pagination\AbstractPagination;
use AppBundle\Resource\Pagination\PaginationInterface;

class TagPagination
    extends AbstractPagination
    implements PaginationInterface
{
    private const ROUTE = 'get_product_tags';

    /**
     * @var TagResourceFilter
     */
    private $resourceFilter;

    public function __construct(TagResourceFilter $resourceFilter)
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