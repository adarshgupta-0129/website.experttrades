<?php

namespace AppBundle\Entity\Gallery;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\Gallery\Gallery
 * @ORM\Table(name="gallery")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Gallery\GalleryRepository")
 */
class Gallery{

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
     * @var string $header_text
     *
     * @ORM\Column(name="header_text", type="text", length=25555, nullable=true)
     */
    private $header_text;

    /**
     * @var string $header_title
     *
     * @ORM\Column(name="header_title", type="text", length=2555, nullable=true)
     */
    private $header_title;

    /**
     * @var string $meta_title
     *
     * @ORM\Column(name="meta_title", type="text", length=2555, nullable=true)
     */
    private $meta_title;

    /**
     * @var string $meta_description
     *
     * @ORM\Column(name="meta_description", type="text", length=2555, nullable=true)
     */
    private $meta_description;
    
    /**
     * @var string $type_pagination
     * 0 -> pagination
     * 1 -> showmore
     *
     * @ORM\Column(name="type_pagination", type="integer", options={"default" = 1})
     */
    private $type_pagination;
    
    /**
     * @var string $type_tags
     * 0 -> buttons
     * 1 -> selector
     *
     * @ORM\Column(name="type_tags", type="integer", options={"default" = 1})
     */
    private $type_tags;

    public function __construct(){
    	$this->type_pagination = 1;
    	$this->$type_tags = 1;
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
     * Set header_title
     *
     * @param string $header_title
     */
    public function setHeaderTitle($header_title)
    {
        $this->header_title = $header_title;
    }

    /**
     * Get header_title
     *
     * @return string
     */
    public function getHeaderTitle()
    {
        return $this->header_title;
    }

    /**
     * Set header_text
     *
     * @param string $header_text
     */
    public function setHeaderText($header_text)
    {
        $this->header_text = $header_text;
    }

    /**
     * Get header_text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return $this->header_text;
    }

    /**
     * Set meta_title
     *
     * @param string $meta_title
     */
    public function setMetaTitle($meta_title)
    {
        $this->meta_title = $meta_title;
    }

    /**
     * Get meta_title
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * Set meta_description
     *
     * @param string $meta_description
     */
    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;
    }

    /**
     * Get meta_description
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }
	public function getTypePagination() {
		return $this->type_pagination;
	}
	public function setTypePagination($type_pagination) {
		$this->type_pagination = $type_pagination;
		return $this;
	}
	public function getTypeTags() {
		return $this->type_tags;
	}
	public function setTypeTags($type_tags) {
		$this->type_tags = $type_tags;
		return $this;
	}
	
    

}
