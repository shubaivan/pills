<?php
namespace PillsBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PillsBundle\Entity\Repository\TagRepository")
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $hashTag;

    /**
     * @Gedmo\Slug(fields={"hashTag"})
     * @ORM\Column(type="string", length=12)
     */
    protected $hashSlug;

    /**
     * @ORM\ManyToMany(targetEntity="Post", inversedBy="tag")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * @ORM\ManyToMany(targetEntity="Get", inversedBy="tag")
     * @ORM\JoinColumn(name="get_id", referencedColumnName="id")
     */
    protected $get;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="createdAt")
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    protected $deletedAt;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->post = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set hashTag
     *
     * @param string $hashTag
     * @return Tag
     */
    public function setHashTag($hashTag)
    {
        $this->hashTag = $hashTag;

        return $this;
    }

    /**
     * Get hashTag
     *
     * @return string 
     */
    public function getHashTag()
    {
        return $this->hashTag;
    }

    /**
     * Set hashSlug
     *
     * @param string $hashSlug
     * @return Tag
     */
    public function setHashSlug($hashSlug)
    {
        $this->hashSlug = $hashSlug;

        return $this;
    }

    /**
     * Get hashSlug
     *
     * @return string 
     */
    public function getHashSlug()
    {
        return $this->hashSlug;
    }

    /**
     * Add post
     *
     * @param \PillsBundle\Entity\Post $post
     * @return Tag
     */
    public function addPost(\PillsBundle\Entity\Post $post)
    {
        $this->post[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \PillsBundle\Entity\Post $post
     */
    public function removePost(\PillsBundle\Entity\Post $post)
    {
        $this->post->removeElement($post);
    }

    /**
     * Get post
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPost()
    {
        return $this->post;
    }

    public function __toString()
    {
        return $this->hashTag;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Tag
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Tag
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
     * Add get
     *
     * @param \PillsBundle\Entity\Get $get
     * @return Tag
     */
    public function addGet(\PillsBundle\Entity\Get $get)
    {
        $this->get[] = $get;

        return $this;
    }

    /**
     * Remove get
     *
     * @param \PillsBundle\Entity\Get $get
     */
    public function removeGet(\PillsBundle\Entity\Get $get)
    {
        $this->get->removeElement($get);
    }

    /**
     * Get get
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGet()
    {
        return $this->get;
    }
}
