<?php

namespace AppBundle\Entity\Blog;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * AppBundle\Entity\Blog\Blog
 * @ORM\Table(name="blog")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Blog\BlogRepository")
 */
class Blog{

	
	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Blog\Post\Post", mappedBy="blog")
	 */
	private $posts;
	
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
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean",  nullable=false)
     */
    private $active;
    

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

    public function __construct(){
   	   	$this->posts = new ArrayCollection();
   	   	$this->active = 1;
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
     * Get Posts
     *
     * @return ArrayCollection
     */
    public function getPosts()
    {
    	return $this->posts;
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
    
	public function getActive() {
		return $this->active;
	}
	public function setActive($active) {
		$this->active = $active;
		return $this;
	}
	
    
    

}
