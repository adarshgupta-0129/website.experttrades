<?php

namespace AppBundle\Entity\Script;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\Script\Script
 * @ORM\Table(name="script")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Script\ScriptRepository")
 */
class Script{

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
    * @var string $value
    *
    * @ORM\Column(name="value", type="text", length=25555, nullable=true)
    */
    private $value;

    /**
    * @var string $name
    *
    * @ORM\Column(name="name", type="text", length=2555, nullable=true)
    */
    private $name;

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
     * Set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
}
