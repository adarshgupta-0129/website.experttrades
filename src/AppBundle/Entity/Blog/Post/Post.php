<?php

namespace AppBundle\Entity\Blog\Post;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\OrderBy;
use AppBundle\Entity\Blog\Post\Item\Item;



/**
 * AppBundle\Entity\Blog\Post\Post
 * @ORM\Table(name="blog_post")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Blog\Post\PostRepository")
 */
class Post{
	


	/**
	 * @var string $blog
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Blog\Blog" , inversedBy="posts")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="blog_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 * })
	 */
	private $blog;
	

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Blog\Post\Item\Item", mappedBy="post")
	 */
	private $items;

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
    * @ORM\Column(name="title", type="string", length=1024, nullable=false)
    */
    private $title;

   /**
    * @var text $slug
    *
    * @ORM\Column(name="slug", type="text", length=1024, nullable=false)
    */
    private $slug;
    
    /**
     * @var text $excerpt
     *
     * @ORM\Column(name="excerpt", type="text", length=2555, nullable=true)
     */
    private $excerpt;

   /**
    * @var text $body
    *
    * @ORM\Column(name="body", type="text", length=25555, nullable=true)
    */
    private $body;
    

    /**
     * @var search $body
     *
     * @ORM\Column(name="search", type="text", nullable=true)
     */
    private $search;

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
     * @var datetime $publish
     *
     * @ORM\Column(name="publish",type="datetime", nullable=true)
     */
    private $publish;
    
  /**
   * @var datetime $created
   *
   * @ORM\Column(type="datetime")
   */
   private $created;

   public function __construct(\AppBundle\Entity\Blog\Blog $blog ){
		$this->blog = $blog;
   	   	$this->items = new ArrayCollection();
       	$this->created = new \DateTime("now",new \DateTimeZone('Europe/London'));
       	$this->publish = null;
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
     * Get blog
     *
     * @return AppBundle\Entity\Blog\Blog $blog
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set blog
     *
     * @return AppBundle\Entity\Blog\Blog $blog
     */
    public function setBlog(\AppBundle\Entity\Blog\Blog $blog)
    {
        $this->blog = $blog;
    }
    
    /**
     * Get Items
     *
     * @return ArrayCollection
     */
    public function getItems( $type = Item::ITEM_IMAGE)
    {

    	$criteria = Criteria::create();
    	$criteria->where(Criteria::expr()->eq('type', $type));
    	$arr = $this->items->matching($criteria);
    	return $arr;
    }
    
    /**
     * Get featured_item
     *
     * @return AppBundle\Entity\Blog\Post\Item
     */
    public function getFeaturedItem()
    {
    	$criteria = Criteria::create();
    	$criteria->where(Criteria::expr()->eq('featured', true));
    	$arr = $this->items->matching($criteria);
    	return (count($arr[0]) > 0)?$arr[0]:FALSE;
    }

   /**
   * Set $title
   *
   * @param integer $title
   */
  public function setTitle($title)
  {
      $this->title = $title;
		$this->regenerateSearch();
		return $this;
  }

  /**
   * Get $title
   *
   * @return string
   */
  public function getTitle()
  {
      return $this->title;
  }
	public function getSlug() {
		return $this->slug;
	}
	public function setSlug($slug) {
		$this->slug = $slug;
		$this->regenerateSearch();
		return $this;
	}
	public function getExcerpt() {
		return $this->excerpt;
	}
	public function setExcerpt($excerpt) {
		$this->excerpt = $excerpt;
		$this->regenerateSearch();
		return $this;
	}
	public function getBody() {
		return $this->body;
	}
	public function setBody($body) {
		$this->body = $body;
		$this->regenerateSearch();
		return $this;
	}
	public function getMetaTitle() {
		return $this->meta_title;
	}
	public function setMetaTitle($meta_title) {
		$this->meta_title = $meta_title;
		$this->regenerateSearch();
		return $this;
	}
	public function getMetaDescription() {
		return $this->meta_description;
	}
	public function setMetaDescription($meta_description) {
		$this->meta_description = $meta_description;
		$this->regenerateSearch();
		return $this;
	}
	public function getPublish() {
		return $this->publish;
	}
	public function setPublish($publish) {
		$this->publish = $publish;
		return $this;
	}
	public function getSearch() {
		return $this->search;
	}
	public function regenerateSearch() {
		$search = "";
		$search .= $this->title." ";
		$search .= $this->slug." ";
		$search .= $this->meta_title." ";
		$search .= $this->meta_description." ";
		$search .= strip_tags( $this->excerpt ) ." ";
		$search .= strip_tags( $this->body ) ." ";
		$this->search = $search;
		return $this;
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
