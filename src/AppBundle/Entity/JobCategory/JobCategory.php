<?php

namespace AppBundle\Entity\JobCategory;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\JobCategory\JobCategory
 * @ORM\Table(name="job_category")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobCategory\JobCategoryRepository")
 */
class JobCategory{

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
     * @var datetime $deleted_at
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
     private $deleted_at;

     public function __construct(){

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
     * Set deleted_at
     *
     * @param datetime $deleted_at
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

    /**
     * Get deleted_at
     *
     * @return datetime
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }
}
