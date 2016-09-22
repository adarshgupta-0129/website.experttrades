<?php

namespace AppBundle\Entity\Gallery\Tag;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation\Exclude;

/**
 * AppBundle\Entity\Gallery\Tag\Tag
 * @ORM\Table(name="item_tag")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Gallery\Tag\TagRepository")
 */
class Tag implements TagInterface{

	
      /**
      * @ORM\OneToMany(targetEntity="AppBundle\Entity\Gallery\Tag\ItemTag", mappedBy="tag")
      * @EXCLUDE
      */
      private $tag_items;
      
      /**
	 * @ORM\OneToMany(targetEntity="Tag", mappedBy="parent")
	 */
	 private $children;
	
	
	/**
	 * @ORM\ManyToOne(targetEntity="Tag", inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	private $parent;

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
     * @ORM\Column(name="name", type="string", length=2555, nullable=false)
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text",  nullable=true)
     */
    private $description;

    /**
     * @var string $color
     *
     * @ORM\Column(name="color", type="string", length=7,  nullable=true)
     */
    private $color;
    
    /**
     * @var string $bgcolor
     *
     * @ORM\Column(name="bgcolor", type="string", length=7,  nullable=true)
     */
    private $bgcolor;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=2555,  nullable=false)
     */
    private $path;



    /**
    * @var datetime $created
    *
    * @ORM\Column(type="datetime")
    */
    private $created;

    public function __construct(){
      $this->tag_items = new ArrayCollection();
      $this->children = new ArrayCollection();
      $this->bgcolor = "#E9EBEE";
      $this->color = "#000000";
      $this->created = new \DateTime("now",new \DateTimeZone('Europe/London'));
    }

   
    /**
    * Get Items Tag
    *
    * @return ArrayCollection
    */
    public function getTagItems()
    {
      return $this->tag_items;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return  $this->id;
    }
    
    /**
	 * @return AppBundle\Entity\Gallery\Tag
	 */
	public function getParent() {
	    return $this->parent;
	}
	
    /**
	 * @return integer
	 */
	public function getParentId() {
	    return ( is_null($this->parent) )? null:$this->parent->getId();
	}
	
	/**
	 * @param mixed $parent
	 */
	public function setParent(\AppBundle\Entity\Gallery\Tag\Tag $parent ) {
	    $this->parent = $parent;
	}
	public function unsetParent()
	{
	    $this->parent = null;
	}
	
	/**
	 * @return mixed
	 */
	public function getChildren() {
	    return $this->children;
	}
	
	/**
	 * @return mixed
	 */
	public function hasChildren() {
	    return ( count($this->children) > 0 );
	}
	
	
    /**
     *
     * @param boolean $name
     */
    public function setName($name)
    {

        $this->name = $name;
    }

    /**
     *
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param boolean $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @return description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @return color
     */
    public function getBgColor()
    {
    	return $this->bgcolor;
    }
    /**
     *
     * @param boolean $bgcolor
     */
    public function setBgColor($bgcolor)
    {
    	$this->bgcolor = $bgcolor;
    }

    /**
     *
     * @param boolean $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     *
     * @return color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     *
     * @return path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     *
     * @param boolean $path
     */
    public function setPath($path)
    {
        $this->path = $path;
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
