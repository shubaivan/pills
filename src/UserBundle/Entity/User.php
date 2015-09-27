<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $avatar;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $facebookId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $facebookAccessToken;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $vkontakteId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $vkontakteAccessToken;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $linkedinId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $linkedinAccessToken;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $githubId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $githubAccessToken;

    /**
     * @Gedmo\Slug(fields={"firstName", "lastName"}, separator="-")
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @var \PillsBundle\Entity\Cities
     *
     * @ORM\ManyToOne(targetEntity="\PillsBundle\Entity\Cities")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=true)
     */
    private $city;

    /**
     * @var \PillsBundle\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="\PillsBundle\Entity\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="skype", type="string", length=255, nullable=true)
     * @Assert\Length(min=3, max=255)
     */
    protected $skype;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     * @Assert\Length(min=3, max=255)
     */
    protected $telephone;

    /**
     * @ORM\OneToMany(targetEntity="\PillsBundle\Entity\Post", mappedBy="author",  cascade={"persist", "remove"})
     */
    protected $post;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $socialNetworkUrl;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $socialNetworkName;

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
     * @var string
     *
     * @ORM\Column(name="main_skill", type="string", length=80, nullable=true)
     */
    private $main_skill;

    /**
     * @var string
     *
     * @ORM\Column(name="skills", type="array", nullable=true)
     */
    private $skills = array();

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=10, nullable=true)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="qualification", type="string", length=80, nullable=true)
     */
    private $qualification;

    /**
     * @var string
     *
     * @ORM\Column(name="english", type="string", length=30, nullable=true)
     */
    private $english;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="smallint", nullable=true)
     */
    private $rate;

    /**
     * @ORM\OneToMany(targetEntity="\PillsBundle\Entity\Rating", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $ratings;


    public function isFakeEmail()
    {
        return false === strpos($this->email, '@example.com') && $this->email ? false : true;
    }

    public function isFakeUsername()
    {
        return (($this->username == $this->vkontakteId) || ($this->username == $this->facebookId));
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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Set vkontakteId
     *
     * @param string $vkontakteId
     * @return User
     */
    public function setVkontakteId($vkontakteId)
    {
        $this->vkontakteId = $vkontakteId;

        return $this;
    }

    /**
     * Get vkontakteId
     *
     * @return string 
     */
    public function getVkontakteId()
    {
        return $this->vkontakteId;
    }

    /**
     * Set vkontakteAccessToken
     *
     * @param string $vkontakteAccessToken
     * @return User
     */
    public function setVkontakteAccessToken($vkontakteAccessToken)
    {
        $this->vkontakteAccessToken = $vkontakteAccessToken;

        return $this;
    }

    /**
     * Get vkontakteAccessToken
     *
     * @return string 
     */
    public function getVkontakteAccessToken()
    {
        return $this->vkontakteAccessToken;
    }

    /**
     * Set linkedinId
     *
     * @param string $linkedinId
     * @return User
     */
    public function setLinkedinId($linkedinId)
    {
        $this->linkedinId = $linkedinId;

        return $this;
    }

    /**
     * Get linkedinId
     *
     * @return string 
     */
    public function getLinkedinId()
    {
        return $this->linkedinId;
    }

    /**
     * Set linkedinAccessToken
     *
     * @param string $linkedinAccessToken
     * @return User
     */
    public function setLinkedinAccessToken($linkedinAccessToken)
    {
        $this->linkedinAccessToken = $linkedinAccessToken;

        return $this;
    }

    /**
     * Get linkedinAccessToken
     *
     * @return string 
     */
    public function getLinkedinAccessToken()
    {
        return $this->linkedinAccessToken;
    }

    /**
     * Set githubId
     *
     * @param string $githubId
     * @return User
     */
    public function setGithubId($githubId)
    {
        $this->githubId = $githubId;

        return $this;
    }

    /**
     * Get githubId
     *
     * @return string 
     */
    public function getGithubId()
    {
        return $this->githubId;
    }

    /**
     * Set githubAccessToken
     *
     * @param string $githubAccessToken
     * @return User
     */
    public function setGithubAccessToken($githubAccessToken)
    {
        $this->githubAccessToken = $githubAccessToken;

        return $this;
    }

    /**
     * Get githubAccessToken
     *
     * @return string 
     */
    public function getGithubAccessToken()
    {
        return $this->githubAccessToken;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return User
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
     * Set skype
     *
     * @param string $skype
     * @return User
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string 
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set socialNetworkUrl
     *
     * @param string $socialNetworkUrl
     * @return User
     */
    public function setSocialNetworkUrl($socialNetworkUrl)
    {
        $this->socialNetworkUrl = $socialNetworkUrl;

        return $this;
    }

    /**
     * Get socialNetworkUrl
     *
     * @return string 
     */
    public function getSocialNetworkUrl()
    {
        return $this->socialNetworkUrl;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set socialNetworkName
     *
     * @param string $socialNetworkName
     * @return User
     */
    public function setSocialNetworkName($socialNetworkName)
    {
        $this->socialNetworkName = $socialNetworkName;

        return $this;
    }

    /**
     * Get socialNetworkName
     *
     * @return string 
     */
    public function getSocialNetworkName()
    {
        return $this->socialNetworkName;
    }

    /**
     * Add post
     *
     * @param \PillsBundle\Entity\Post $post
     * @return User
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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


    public function setRoles(array $role)
    {
        $this->roles = $role;
        return $this;
    }
    /**
     * Get User Roles
     *
     * @return User roles array
     */
    public function getRoles()
    {
        $roles = $this->roles;
        return $roles;
    }

    /**
     * Set mainSkill
     *
     * @param string $mainSkill
     *
     * @return User
     */
    public function setMainSkill($mainSkill)
    {
        $this->main_skill = $mainSkill;

        return $this;
    }

    /**
     * Get mainSkill
     *
     * @return string
     */
    public function getMainSkill()
    {
        return $this->main_skill;
    }

    /**
     * Set skills
     *
     * @param array $skills
     *
     * @return User
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * Get skills
     *
     * @return array
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return User
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set qualification
     *
     * @param string $qualification
     *
     * @return User
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set english
     *
     * @param string $english
     *
     * @return User
     */
    public function setEnglish($english)
    {
        $this->english = $english;

        return $this;
    }

    /**
     * Get english
     *
     * @return string
     */
    public function getEnglish()
    {
        return $this->english;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     *
     * @return User
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer
     */
    public function getRate()
    {
        return $this->rate;
    }


    /**
     * Set city
     *
     * @param \PillsBundle\Entity\Cities $city
     * @return User
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
     * Set country
     *
     * @param \PillsBundle\Entity\Country $country
     * @return User
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
     * Add ratings
     *
     * @param \PillsBundle\Entity\Rating $ratings
     * @return User
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
