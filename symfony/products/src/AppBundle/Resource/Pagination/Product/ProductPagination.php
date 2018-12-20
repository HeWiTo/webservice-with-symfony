<?php

namespace AppBundle\Resource\Pagination\Product;

use AppBundle\Resource\Filtering\Product\ProductResourceFilter;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use AppBundle\Resource\Pagination\AbstractPagination;
use AppBundle\Resource\Pagination\PaginationInterface;

class ProductPagination
    extends AbstractPagination
    implements PaginationInterface
{
    private const ROUTE = 'get_products';
    /**
     * @var ProductResourceFilter
     */
    private $resourceFilter;

    public function __construct(ProductResourceFilter $resourceFilter)
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