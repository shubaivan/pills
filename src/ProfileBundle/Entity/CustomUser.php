<?php
namespace ProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Gedmo\Mapping\Annotation as Gedmo,
    Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/** @ORM\MappedSuperclass */
class CustomUser implements UserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\Length(min=3, max=255)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=80, nullable=true)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=25, nullable=false)
     * Assert\NotBlank
     */
    protected $roles = 'ROLE_AGENT';

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     * @Assert\Length(min=3, max=255)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255,  unique=true, nullable=false)
     * @Assert\Length(min=3, max=255)
     * @Assert\NotBlank
     */
    protected $email;

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
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     * @Assert\Length(min=3, max=255)
     */
    protected $company;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\Length(min=3, max=65000)
     */
    protected $description;

    /**
     * @ORM\Column(name="is_outsource", type="boolean")
     */
    private $isOutsource = 0;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(name="image_path")
     * @Assert\File( maxSize="20M")
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_summary", type="text", nullable=true)
     * @Assert\Length(min=3, max=65000)
     */
    protected $profileSummary;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    // -------------------------- Interface fields --------------------------

    /**
     * Set username
     *
     * @param  string $username
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param  string $username
     * @return Users
     */
    public function setName($name)
    {
        $this->username = $name;

        return $this;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->username;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * Set password
     *
     * @param  string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set roles
     *
     * @param  string $roles
     * @return Users
     */
    public function setRole($roles)
    {
        $this->roles = $roles;

        return $this;
    }
    /**
     * Get roles
     *
     * @return string
     */
    public function getRole()
    {
        return $this->roles;
    }
    /**
     * Set roles
     *
     * @param  string $roles
     * @return Users
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return string
     */
    public function getRoles()
    {
        return array($this->roles);
    }

    /**
     * @param string $image
     *
     * @return $this;
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() { }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user)
    {
        return $this->id.'_'.$this->username === $this->id.'_'.$user->getUsername();
    }

    // -------------------------------- Additional fields --------------------------------

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $skype
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }
    /**
     * @return string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }
    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set company
     *
     * @param  string $company
     * @return Users
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }
    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \Datetime
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }
    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }
    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set isOutsource
     *
     * @param  boolean $isOutsource
     * @return Users
     */
    public function setIsOutSource($isOutsource)
    {
        $this->isOutsource = $isOutsource;

        return $this;
    }
    /**
     * Get isOutsource
     *
     * @return boolean
     */
    public function getIsOutsource()
    {
        return $this->isOutsource;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getProfileSummary()
    {
        return $this->profileSummary;
    }

    /**
     * @param string $profileSummary
     *
     * @return SUser
     */
    public function setProfileSummary($profileSummary)
    {
        $this->profileSummary = $profileSummary;

        return $this;
    }
}
