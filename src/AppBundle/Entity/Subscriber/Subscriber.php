<?php

namespace AppBundle\Entity\Subscriber;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\Subscriber\Subscriber
 * @ORM\Table(name="subscriber")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Subscriber\SubscriberRepository")
 */
class Subscriber{

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
      * @var string $email
      *
      * @ORM\Column(name="email", type="text", length=2555, nullable=true)
      */
     private $email;

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
     * Get created
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
