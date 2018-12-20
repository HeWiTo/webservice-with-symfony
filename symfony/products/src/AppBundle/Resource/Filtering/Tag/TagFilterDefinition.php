<?php

namespace AppBundle\Resource\Filtering\Tag;

use AppBundle\Resource\Filtering\AbstractFilterDefinition;
use AppBundle\Resource\Filtering\FilterDefinitionInterface;
use AppBundle\Resource\Filtering\SortableFilterDefinitionInterface;

class TagFilterDefinition extends AbstractFilterDefinition implements FilterDefinitionInterface, SortableFilterDefinitionInterface
{
    /**
     * @var null|string
     */
    private $tagName;
    /**
     * @var int|null
     */
    private $product;
    /**
     * @var null|string
     */
    private $sortBy;
    /**
     * @var array|null
     */
    private $sortByArray;

    public function __construct(
        ?string $tagName,
        ?int $product,
        ?string $sortByQuery,
        ?array $sortByArray
    )
    {
        $this->tagName = $tagName;
        $this->product = $product;
        $this->sortBy = $sortByQuery;
        $this->sortByArray = $sortByArray;
    }

    /**
     * @return null|string
     */
    public function getTagName(): ?string
    {
        return $this->tagName;
    }

    /**
     * @return int|null
     */
    public function getProduct(): ?int
    {
        return $this->product;
    }

    /**
     * @return null|string
     */
    public function getSortByQuery(): ?string
    {
        return $this->sortBy;
    }

    /**
     * @return array|null
     */
    public function getSortByArray(): ?array
    {
        return $this->sortByArray;
    }

    public function getParameters(): array
    {
        return get_object_vars($this);
    }
}