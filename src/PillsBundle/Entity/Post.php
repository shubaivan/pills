<?php
namespace PillsBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="PillsBundle\Entity\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="createdAt")
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="photo_storage", nullable=true)
     * @Assert\File( maxSize="20M")
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="post")
     * @ORM\JoinColumn(name="user_post_file", nullable = true, referencedColumnName="id")
     * */
    protected $author;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=128, unique=true)
     */
    protected $slug;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="post")
     * @ORM\JoinTable(name="posts_tag")
     */
    protected $tag;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    protected $deletedAt;


    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="post")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="post")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="Cities", inversedBy="post")
     * @ORM\JoinColumn(name="cities_id", referencedColumnName="id")
     */
    protected $city = NULL;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="post", cascade={"persist", "remove"})
     */
    protected $ratings;

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
     * @return Post
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
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

    /**
     * Set photo
     *
     * @param string $photo
     * @return Post
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Post
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
     * Set author
     *
     * @param \UserBundle\Entity\User $author
     * @return Post
     */
    public function setAuthor(\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;
        $author->addPost($this);

        return $this;
    }

    /**
     * Get author
     *
     * @return \UserBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tag
     *
     * @param \PillsBundle\Entity\Tag $tag
     * @return Post
     */
    public function addTag(\PillsBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \PillsBundle\Entity\Tag $tag
     */
    public function removeTag(\PillsBundle\Entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Post
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set category
     *
     * @param \PillsBundle\Entity\Category $category
     * @return Post
     */
    public function setCategory(\PillsBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \PillsBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set type
     *
     * @param \PillsBundle\Entity\Type $type
     * @return Post
     */
    public function setType(\PillsBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \PillsBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set country
     *
     * @param \PillsBundle\Entity\Country $country
     * @return Post
     */
    public function setCountry(\PillsBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \PillsBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param \PillsBundle\Entity\Cities $city
     * @return Post
     */
    public function setCity(\PillsBundle\Entity\Cities $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \PillsBundle\Entity\Cities 
     */
    public function getCity()
    {
        return $this->city;
    }



    /**
     * Add ratings
     *
     * @param \PillsBundle\Entity\Rating $ratings
     * @return Post
     */
    public function addRating(\PillsBundle\Entity\Rating $ratings)
    {
        $this->ratings[] = $ratings;

        return $this;
    }

    /**
     * Remove ratings
     *
     * @param \PillsBundle\Entity\Rating $ratings
     */
    public function removeRating(\PillsBundle\Entity\Rating $ratings)
    {
        $this->ratings->removeElement($ratings);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRatings()
    {
        return $this->ratings;
    }
}
