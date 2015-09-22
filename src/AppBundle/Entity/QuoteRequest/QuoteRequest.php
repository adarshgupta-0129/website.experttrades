<?php

namespace AppBundle\Entity\QuoteRequest;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\QuoteRequest\QuoteRequest
 * @ORM\Table(name="quote_request")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuoteRequest\QuoteRequestRepository")
 */
class QuoteRequest{

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\QuoteRequest\JobCategory\JobCategory", mappedBy="quote_request")
     */
     private $job_categories;

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
      * @ORM\Column(name="phone", type="text", length=255, nullable=true)
      */
     private $phone;

    /**
     * @var string $job_location
     *
     * @ORM\Column(name="job_location", type="text", length=255, nullable=true)
     */
     private $job_location;

     /**
      * @var string $job_description
      *
      * @ORM\Column(name="job_description", type="text", length=25555, nullable=true)
      */
     private $job_description;

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
     * Set job_location
     *
     * @param string $job_location
     */
    public function setJobLocation($job_location)
    {
        $this->job_location = $job_location;
    }

    /**
     * Get job_location
     *
     * @return string
     */
    public function getJobLocation()
    {
        return $this->job_location;
    }

    /**
     * Set job_description
     *
     * @param string $job_description
     */
    public function setJobDescription($job_description)
    {
        $this->job_description = $job_description;
    }

    /**
     * Get job_description
     *
     * @return string
     */
    public function getJobDescription()
    {
        return $this->job_description;
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
