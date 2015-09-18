<?php

namespace AppBundle\Entity\Homepage\Slider;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppBundle\Entity\Homepage\Slider\Slider
 * @ORM\Table(name="homepage_slider")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Homepage\Slider\SliderRepository")
 */
class Slider{


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Homepage\Homepage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="homepage_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     * })
     */
    private $homepage;


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
     * @var string $title
     *
     * @ORM\Column(name="title", type="text", length=2555, nullable=true)
     */
    private $title;

    /**
     * @var string $subtitle
     *
     * @ORM\Column(name="subtitle", type="text", length=2555, nullable=true)
     */
    private $subtitle;

    /**
     * @var string $button_text
     *
     * @ORM\Column(name="button_text", type="text", length=2555, nullable=true)
     */
    private $button_text;

    public function __construct(){

    }

    /**
     * Get trade
     *
     * @return \AppBundle\Entity\Homepage\Homepage $homepage
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Set homepage
     *
     * @return \AppBundle\Entity\Homepage\Homepage $homepage
     */
    public function setHomepage(\AppBundle\Entity\Homepage\Homepage $homepage)
    {
        $this->homepage = $homepage;
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set button_text
     *
     * @param string $button_text
     */
    public function setButtonText($button_text)
    {
        $this->button_text = $button_text;
    }

    /**
     * Get button_text
     *
     * @return string
     */
    public function getButtonText()
    {
        return $this->button_text;
    }


}
