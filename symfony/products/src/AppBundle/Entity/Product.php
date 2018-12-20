<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @Hateoas\Relation("tags", href=@Hateoas\Route("get_product_tags", parameters={"product" = "expr(object.getId())"}))
 * )
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(groups={"Default"})
     * @Assert\Length(max=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255)
     * @Assert\NotBlank(groups={"Default", "Patch"})
     * @Assert\Length(max=255)
     */
    private $brand;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\NotBlank(groups={"Default"})
     * @Assert\Range(min=0, groups={"Default", "Patch"})
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="smallint")
     * @Assert\NotBlank(groups={"Default"})
     * @Assert\Range(min=0, max=100, groups={"Default", "Patch"})
     */
    private $stock;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="product", cascade={"remove"})
     * @Serializer\Exclude()
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return Product
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return Collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }
}

