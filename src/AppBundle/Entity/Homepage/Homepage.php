<?php

namespace AppBundle\Entity\Homepage;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\Homepage\Homepage
 * @ORM\Table(name="homepage")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Homepage\HomepageRepository")
 */
class Homepage{

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Homepage\Slider\Slider", mappedBy="homepage")
     */
     private $sliders;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    public function __construct(){
        $this->sliders = new ArrayCollection();
    }

    /**
     * Get sliders
     *
     * @return ArrayCollection
     */
    public function getSliders()
    {
        return $this->sliders;
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
}
