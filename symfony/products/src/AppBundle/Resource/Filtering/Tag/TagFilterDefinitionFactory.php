<?php

namespace AppBundle\Resource\Filtering\Tag;

use AppBundle\Resource\Filtering\AbstractFilterDefinitionFactory;
use AppBundle\Resource\Filtering\FilterDefinitionFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class TagFilterDefinitionFactory extends AbstractFilterDefinitionFactory implements FilterDefinitionFactoryInterface
{
    private const ACCEPTED_SORT_FIELDS = ['tagName', 'product'];

    public function factory(Request $request, ?int $product): TagFilterDefinition
    {
        return new TagFilterDefinition(
            $request->get('tagName'),
            $product,
            $request->get('sortBy'),
            $this->sortQueryToArray($request->get('sortBy'))
        );
    }

    public function getAcceptedSortFields(): array
    {
        return self::ACCEPTED_SORT_FIELDS;
    }
}