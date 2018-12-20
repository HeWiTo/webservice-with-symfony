<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use AppBundle\Annotation as App;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 * @Serializer\ExclusionPolicy("All")
 * @Hateoas\Relation(
 *     "category",
 *     href=@Hateoas\Route("get_category", parameters={"category" = "expr(object.getCategory().getId())"})
 * )
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"Default", "Deserialize"})
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category")
     * @App\DeserializeEntity(type="AppBundle\Entity\Category", idField="id", idGetter="getId", setter="setCategory")
     * @Serializer\Groups({"Deserialize"})
     * @Serializer\Expose()
     */
    private $category;

    /**
     * @var string
     * @ORM\Column(name="tag_name", type="string", length=100)
     * @Serializer\Groups({"Default", "Deserialize"})
     * @Serializer\Expose()
     */
    private $tagName;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="tags")
     */
    private $product;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }

    /**
     * @param string $tagName
     */
    public function setTagName(string $tagName)
    {
        $this->tagName = $tagName;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
}
