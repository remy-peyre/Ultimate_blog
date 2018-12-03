<?php
 namespace App\Entity;
 use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
 /**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
     /**
     * @ORM\Column(name="firstname", type="string", length=100)
     */
	private $firstname;
     /**
     * @ORM\Column(name="lastname", type="string", length=100)
     */
	private $lastname;
     /**
     * @ORM\Column(name="username", type="string", length=100, nullable=true)
     */
    private $username;
    
    /**
     * @var string
     *
     * @ORM\Column(name="role", type="array", nullable=false)
     * @Assert\NotBlank()
     */
    private $role;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     * @ORM\Column(name="password", type="string", length=255)
     */
	private $password;
	
	/**
	 * @var \DateTime $createdAt
	 * @ORM\Column(name="created_at", type="datetime", length=100)
	 */
    private $createdAt;
    
     /**
     * @ORM\Column(name="sortRole", type="string", length=100)
     */
    private $sortRole;
	
	
    
    public function __construct()
    {
        $this->createdAt = new \DateTime(date('Y-m-d H:i:s'));
        $this->sortRole = "ROLE_USER";
    }
     public function __toString()
    {
        return $this->username;
    }
	
	public function getId()
    {
        return $this->id;
    }
	
	public function getFirstname()
	{
		return $this->firstname;
	}
	
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
	}
	
	public function getLastname()
	{
		return $this->lastname;
	}
	
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
	}
     public function getPassword()
    {
        return $this->password;
    }
     public function setPassword($password)
    {
        $this->password = $password;
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
	public function setCreatedAt(\DateTime $createdAt)
	{
		$this->createdAt = $createdAt;
	}
     /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }
     /**
     * Set role
     *
     * @param array $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
         return $this;
    }
     /**
     * Get role
     *
     * @return array
     */
    public function getRole()
    {
        return $this->role;
    }
     /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->role;
    }
     /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
	
 	/**
	 * Get the value of sortRole
	 */ 
	public function getSortRole()
	{
		return $this->sortRole;
	}
 	/**
	 * Set the value of sortRole
	 *
	 * @return  self
	 */ 
	public function setSortRole($sortRole)
	{
		$this->sortRole = $sortRole;
 		return $this;
	}
}