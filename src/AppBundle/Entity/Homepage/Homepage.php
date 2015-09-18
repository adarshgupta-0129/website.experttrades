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

    /**
     * @var string $about_us_title
     *
     * @ORM\Column(name="about_us_title", type="text", length=2555, nullable=true)
     */
    private $about_us_title;

    /**
     * @var string $about_us_text
     *
     * @ORM\Column(name="about_us_text", type="text", length=25555, nullable=true)
     */
    private $about_us_text;

    /**
     * @var string $about_us_first_point_title
     *
     * @ORM\Column(name="about_us_first_point_title", type="text", length=2555, nullable=true)
     */
    private $about_us_first_point_title;

    /**
     * @var string $about_us_first_point_text
     *
     * @ORM\Column(name="about_us_first_point_text", type="text", length=25555, nullable=true)
     */
    private $about_us_first_point_text;

    /**
     * @var string $about_us_first_point_image
     *
     * @ORM\Column(name="about_us_first_point_image", type="text", length=2555, nullable=true)
     */
    private $about_us_first_point_image;

    /**
     * @var string $about_us_second_point_title
     *
     * @ORM\Column(name="about_us_second_point_title", type="text", length=2555, nullable=true)
     */
    private $about_us_second_point_title;

    /**
     * @var string $about_us_second_point_text
     *
     * @ORM\Column(name="about_us_second_point_text", type="text", length=25555, nullable=true)
     */
    private $about_us_second_point_text;

    /**
     * @var string $about_us_second_point_image
     *
     * @ORM\Column(name="about_us_second_point_image", type="text", length=2555, nullable=true)
     */
    private $about_us_second_point_image;

    /**
     * @var string $about_us_third_point_title
     *
     * @ORM\Column(name="about_us_third_point_title", type="text", length=2555, nullable=true)
     */
    private $about_us_third_point_title;

    /**
     * @var string $about_us_third_point_text
     *
     * @ORM\Column(name="about_us_third_point_text", type="text", length=25555, nullable=true)
     */
    private $about_us_third_point_text;

    /**
     * @var string $about_us_third_point_image
     *
     * @ORM\Column(name="about_us_third_point_image", type="text", length=2555, nullable=true)
     */
    private $about_us_third_point_image;

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

    /**
     * Set about_us_title
     *
     * @param string $about_us_title
     */
    public function setAboutUsTitle($about_us_title)
    {
        $this->about_us_title = $about_us_title;
    }

    /**
     * Get about_us_title
     *
     * @return string
     */
    public function getAboutUsTitle()
    {
        return $this->about_us_title;
    }

    /**
     * Set about_us_text
     *
     * @param string $about_us_text
     */
    public function setAboutUsText($about_us_text)
    {
        $this->about_us_text = $about_us_text;
    }

    /**
     * Get about_us_text
     *
     * @return string
     */
    public function getAboutUsText()
    {
        return $this->about_us_text;
    }

    /**
     * Set about_us_first_point_title
     *
     * @param string $about_us_first_point_title
     */
    public function setAboutUsFirstPointTitle($about_us_first_point_title)
    {
        $this->about_us_first_point_title = $about_us_first_point_title;
    }

    /**
     * Get about_us_first_point_title
     *
     * @return string
     */
    public function getAboutUsFirstPointTitle()
    {
        return $this->about_us_first_point_title;
    }

    /**
     * Set about_us_first_point_text
     *
     * @param string $about_us_first_point_text
     */
    public function setAboutUsFirstPointText($about_us_first_point_text)
    {
        $this->about_us_first_point_text = $about_us_first_point_text;
    }

    /**
     * Get about_us_first_point_text
     *
     * @return string
     */
    public function getAboutUsFirstPointText()
    {
        return $this->about_us_first_point_text;
    }

    /**
     * Set about_us_first_point_image
     *
     * @param string $about_us_first_point_image
     */
    public function setAboutUsFirstPointImage($about_us_first_point_image)
    {
        $this->about_us_first_point_image = $about_us_first_point_image;
    }

    /**
     * Get about_us_first_point_image
     *
     * @return string
     */
    public function getAboutUsFirstPointImage()
    {
        return $this->about_us_first_point_image;
    }

    /**
     * Set about_us_second_point_title
     *
     * @param string $about_us_second_point_title
     */
    public function setAboutUsSecondPointTitle($about_us_second_point_title)
    {
        $this->about_us_second_point_title = $about_us_second_point_title;
    }

    /**
     * Get about_us_second_point_title
     *
     * @return string
     */
    public function getAboutUsSecondPointTitle()
    {
        return $this->about_us_second_point_title;
    }

    /**
     * Set about_us_second_point_text
     *
     * @param string $about_us_second_point_text
     */
    public function setAboutUsSecondPointText($about_us_second_point_text)
    {
        $this->about_us_second_point_text = $about_us_second_point_text;
    }

    /**
     * Get about_us_second_point_text
     *
     * @return string
     */
    public function getAboutUsSecondPointText()
    {
        return $this->about_us_second_point_text;
    }

    /**
     * Set about_us_second_point_image
     *
     * @param string $about_us_second_point_image
     */
    public function setAboutUsSecondPointImage($about_us_second_point_image)
    {
        $this->about_us_second_point_image = $about_us_second_point_image;
    }

    /**
     * Get about_us_second_point_image
     *
     * @return string
     */
    public function getAboutUsSecondPointImage()
    {
        return $this->about_us_second_point_image;
    }

    /**
     * Set about_us_third_point_title
     *
     * @param string $about_us_third_point_title
     */
    public function setAboutUsThirdPointTitle($about_us_third_point_title)
    {
        $this->about_us_third_point_title = $about_us_third_point_title;
    }

    /**
     * Get about_us_third_point_title
     *
     * @return string
     */
    public function getAboutUsThirdPointTitle()
    {
        return $this->about_us_third_point_title;
    }

    /**
     * Set about_us_third_point_text
     *
     * @param string $about_us_third_point_text
     */
    public function setAboutUsThirdPointText($about_us_third_point_text)
    {
        $this->about_us_third_point_text = $about_us_third_point_text;
    }

    /**
     * Get about_us_third_point_text
     *
     * @return string
     */
    public function getAboutUsThirdPointText()
    {
        return $this->about_us_third_point_text;
    }

    /**
     * Set about_us_third_point_image
     *
     * @param string $about_us_third_point_image
     */
    public function setAboutUsThirdPointImage($about_us_third_point_image)
    {
        $this->about_us_third_point_image = $about_us_third_point_image;
    }

    /**
     * Get about_us_third_point_image
     *
     * @return string
     */
    public function getAboutUsThirdPointImage()
    {
        return $this->about_us_third_point_image;
    }

}
