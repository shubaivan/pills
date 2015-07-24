<?php
namespace ProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;

/**
 * Developers
 *
 * @ORM\Table(name="developers")
 * @ORM\Entity(repositoryClass="ProfileBundle\Entity\DeveloperRepository")
 */
class Developer extends CustomUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255,  unique=false, nullable=false)
     * @Assert\Length(min=3, max=255)
     * @Assert\NotBlank
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="qualification", type="string", length=80, nullable=true)
     */
    private $qualification;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=10)
     */
    private $level;

    /**
	 * @var string
	 *
	 * @ORM\Column(name="main_skill", type="string", length=80, nullable=true)
	 */
    private $main_skill;

    /**
     * @var string
     *
     * @ORM\Column(name="skills", type="array")
     */
    private $skills = array();

    /**
     * @var string
     *
     * @ORM\Column(name="english", type="string", length=30)
     */
    private $english;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="smallint")
     */
    private $rate;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="cv_uri", type="string", length=255, nullable=true)
     */
    private $cvUri;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_show", type="integer", length=1)
     */
    private $countShow = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active  = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="approved", type="integer")
     */
    private $approved  = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="float")
     */
    protected $rating = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="sum_rating", type="float")
     */
    protected $sumRating = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="numVotes", type="smallint")
     */
    protected $numVotes = 0;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="date")
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="certificates", type="array")
     */
    private $certificates = array();

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNumVotes()
    {
        return $this->numVotes;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $numVotes
     */
    public function setNumVotes($numVotes)
    {
        $this->numVotes = $numVotes;
    }

    public function addVotes($vote)
    {
        $this->votes->add($vote);

        return $this;
    }

    public function removeVotes($vote)
    {
        $this->votes->remove($vote);

        return $this;
    }

    public function getVotes()
    {
        return $this->votes;
    }

    public function addFeedback($feedback)
    {
        $this->feedback->add($feedback);

        return $this;
    }

    public function removeFeedback($feedback)
    {
        $this->feedback->remove($feedback);

        return $this;
    }

    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return float
     */
    public function getSumRating()
    {
        return $this->sumRating;
    }

    /**
     * @param float $sumRating
     */
    public function setSumRating($sumRating)
    {
        $this->sumRating = $sumRating;
    }

    /**
     * @param  string     $qualification
     * @return Developers
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set level
     *
     * @param  string     $level
     * @return Developers
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
     * Set skills
     *
     * @param  array      $skills
     * @return Developers
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
     * Set english
     *
     * @param  string     $english
     * @return Developers
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
     * @param  integer    $rate
     * @return Developers
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
     * Set location
     *
     * @param  string     $location
     * @return Developers
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set type
     *
     * @param  string     $type
     * @return Developers
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
    /**
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param int $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }
    /**
     * @return int
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @param int $countShow
     */
    public function setCountShow($countShow)
    {
        $this->countShow = $countShow;

        return $this;
    }
    /**
     * @return int
     */
    public function getCountShow()
    {
        return $this->countShow;
    }

    /**
     * @param string $cvUri
     */
    public function setCvUri($cvUri)
    {
        $this->cvUri = $cvUri;

        return $this;
    }
    /**
     * @return string
     */
    public function getCvUri()
    {
        return $this->cvUri;
    }

    public function addEducations($educations)
    {
        $this->educations->add($educations);

        return $this;
    }

    public function removeEducations($educations)
    {
        $this->educations->remove($educations);

        return $this;
    }

    public function getEducations()
    {
        return $this->educations;
    }

    public function addEducation($educations)
    {
        $this->educations->add($educations);

        return $this;
    }

    public function removeEducation($educations)
    {
        $this->educations->remove($educations);

        return $this;
    }

    public function getEducation()
    {
        return $this->educations;
    }

    /**
     * @return string
     */
    public function getCertificates()
    {
        return $this->certificates;
    }

    /**
     * @param string $certificates
     */
    public function setCertificates($certificates)
    {
        $this->certificates = $certificates;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getMainSkill()
    {
        return $this->main_skill;
    }

    /**
     * @param string $main_skill
     */
    public function setMainSkill($main_skill)
    {
        $this->main_skill = $main_skill;
    }

}
