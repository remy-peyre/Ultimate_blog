<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

 /**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
     /**
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;
    
    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    
    /**
     * @ORM\Column(name="picture", type="string", length=100)
     */
    private $picture;
     /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="post")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $users;
     /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    private $commentaires;
     public function __toString(){
        return $this->title;
    }
     public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }
     /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
     /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;
         return $this;
    }
     /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }
     /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;
         return $this;
    }
     /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }
     /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;
         return $this;
    }
     /**
     * Get the value of picture
     */ 
    public function getPicture()
    {
        return $this->picture;
    }
     /**
     * Set the value of picture
     *
     * @return  self
     */ 
    public function setPicture($picture)
    {
        $this->picture = $picture;
         return $this;
    }
     /**
     * Get the value of users
     */ 
    public function getUsers()
    {
        return $this->users;
    }
     /**
     * Set the value of users
     *
     * @return  self
     */ 
    public function setUsers($users)
    {
        $this->users = $users;
         return $this;
    }
     /**
     * Get the value of commentaires
     */ 
    public function getCommentaires()
    {
        return $this->commentaires;
    }
     /**
     * Set the value of commentaires
     *
     * @return  self
     */ 
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
         return $this;
    }
} 