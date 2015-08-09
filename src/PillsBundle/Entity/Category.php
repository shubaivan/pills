<?php
namespace PillsBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="categories")
 * use repository for handy tree functions
 * @ORM\Entity(repositoryClass="PillsBundle\Entity\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=64)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="category")
     */
    protected $posts;

    /**
     * @ORM\OneToMany(targetEntity="GetMed", mappedBy="category")
     */
    protected $getMed;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=128, unique=true)
     */
    protected $slug;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->getMed = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
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
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add posts
     *
     * @param \PillsBundle\Entity\Post $posts
     * @return Category
     */
    public function addPost(\PillsBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \PillsBundle\Entity\Post $posts
     */
    public function removePost(\PillsBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add getMed
     *
     * @param \PillsBundle\Entity\GetMed $getMed
     * @return Category
     */
    public function addGetMed(\PillsBundle\Entity\GetMed $getMed)
    {
        $this->getMed[] = $getMed;

        return $this;
    }

    /**
     * Remove getMed
     *
     * @param \PillsBundle\Entity\GetMed $getMed
     */
    public function removeGetMed(\PillsBundle\Entity\GetMed $getMed)
    {
        $this->getMed->removeElement($getMed);
    }

    /**
     * Get getMed
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGetMed()
    {
        return $this->getMed;
    }

    public function __toString()
    {
        return $this->title;
    }
}
