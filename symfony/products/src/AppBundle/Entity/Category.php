<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @Serializer\ExclusionPolicy("All")
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=70)
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=70)
     * @Serializer\Groups({"Default", "Deserialize"})
     * @Serializer\Expose()
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Assert\Length(min=10, max=5000)
     * @Serializer\Groups({"Default", "Deserialize"})
     * @Serializer\Expose()
     * @Serializer\Since("1.1")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Assert\NotBlank()
     * @Assert\Date()
     * @Serializer\Groups({"Default", "Deserialize"})
     * @Serializer\Expose()
     */
    private $createdAt;


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
     * @return Category
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Category
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

