<?php

namespace AppBundle\Entity\Visit;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\Visit\Visit
 * @ORM\Table(name="visit")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Visit\VisitRepository")
 */
class Visit{

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
      * @var string $ip
      *
      * @ORM\Column(name="ip", type="string", length=60, nullable=true)
      */
     private $ip;

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
     * Set tab
     *
     * @param string $ip
     */
    public function setIp()
    {
	 if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
         } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
         } else {
                $ip = $_SERVER['REMOTE_ADDR'];
         }

        $this->ip = $ip;
    }

    /**
     * Get tab
     *
     * @return ip
     */
    public function getIp()
    {
        return $this->ip;
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
