<?php

namespace AppBundle\Entity\Message;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\Message\Message
 * @ORM\Table(name="message")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Message\MessageRepository")
 */
class Message{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
      * @var string $name
      *
      * @ORM\Column(name="name", type="text", length=2555, nullable=true)
      */
     private $name;

     /**
      * @var string $email
      *
      * @ORM\Column(name="email", type="text", length=2555, nullable=true)
      */
     private $email;

     /**
      * @var string $phone
      *
      * @ORM\Column(name="phone", type="text", length=2555, nullable=true)
      */
     private $phone;

    /**
      * @var string $message
      *
      * @ORM\Column(name="message", type="text", length=25555, nullable=true)
      */
     private $message;

     /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
     private $created;

    public function __construct(){
        $this->created = new \DateTime("now",new \DateTimeZone('Europe/London'));
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }


    /**
     * Set message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get created
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
