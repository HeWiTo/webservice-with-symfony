<?php

namespace AppBundle\Resource\Filtering\Product;

use AppBundle\Resource\Filtering\AbstractFilterDefinitionFactory;
use AppBundle\Resource\Filtering\FilterDefinitionFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductFilterDefinitionFactory extends AbstractFilterDefinitionFactory implements FilterDefinitionFactoryInterface
{
    private const ACCEPTED_SORT_FIELDS = ['id', 'title', 'brand'];

    public function factory(Request $request): ProductFilterDefinition
    {
        return new ProductFilterDefinition(
            $request->get('title'),
            $request->get('brand'),
            $request->get('sortBy'),
            $this->sortQueryToArray($request->get('sortBy'))
        );
    }

    public function getAcceptedSortFields(): array
    {
        return self::ACCEPTED_SORT_FIELDS;
    }
}