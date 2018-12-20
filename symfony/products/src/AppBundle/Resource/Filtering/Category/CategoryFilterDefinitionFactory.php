<?php

namespace AppBundle\Resource\Filtering\Category;

use AppBundle\Resource\Filtering\AbstractFilterDefinitionFactory;
use AppBundle\Resource\Filtering\FilterDefinitionFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoryFilterDefinitionFactory extends AbstractFilterDefinitionFactory implements FilterDefinitionFactoryInterface
{
    private const ACCEPTED_SORT_FIELDS = ['id', 'title', 'createdAt'];

    public function factory(Request $request): CategoryFilterDefinition
    {
        return new CategoryFilterDefinition(
            $request->get('title'),
            $request->get('createdFrom'),
            $request->get('createdTo'),
            $request->get('sortBy'),
            $this->sortQueryToArray($request->get('sortBy'))
        );
    }

    public function getAcceptedSortFields(): array
    {
        return self::ACCEPTED_SORT_FIELDS;
    }
}