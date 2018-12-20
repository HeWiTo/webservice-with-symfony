<?php

namespace AppBundle\Resource\Filtering\Category;

use AppBundle\Resource\Filtering\AbstractFilterDefinition;
use AppBundle\Resource\Filtering\FilterDefinitionInterface;
use AppBundle\Resource\Filtering\SortableFilterDefinitionInterface;

class CategoryFilterDefinition extends AbstractFilterDefinition implements FilterDefinitionInterface, SortableFilterDefinitionInterface
{
    /**
     * @var null|string
     */
    private $title;
    /**
     * @var null|string
     */
    private $createdFrom;
    /**
     * @var null|string
     */
    private $createdTo;
    /**
     * @var null|string
     */
    private $sortBy;
    /**
     * @var array|null
     */
    private $sortByArray;

    public function __construct(
        ?string $title,
        ?string $createdFrom,
        ?string $createdTo,
        ?string $sortByQuery,
        ?array $sortByArray
    )
    {
        $this->title = $title;
        $this->createdFrom = $createdFrom;
        $this->createdTo = $createdTo;
        $this->sortBy = $sortByQuery;
        $this->sortByArray = $sortByArray;
    }

    public function getParameters(): array
    {
        return get_object_vars($this);
    }

    public function getSortByQuery(): ?string
    {
        return $this->sortBy;
    }

    public function getSortByArray(): ?array
    {
        return $this->sortByArray;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
     * @return null|string
     */
    public function getCreatedFrom(): ?string
    {
        return $this->createdFrom;
    }

    /**
     * @return null|string
     */
    public function getCreatedTo(): ?string
    {
        return $this->createdTo;
    }
}