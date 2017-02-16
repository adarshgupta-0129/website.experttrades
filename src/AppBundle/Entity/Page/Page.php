<?php

namespace AppBundle\Entity\Page;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\OrderBy;
use AppBundle\Entity\Page\Item\Item;



/**
 * AppBundle\Entity\Page\Page
 * @ORM\Table(name="page")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Page\PageRepository")
 */
class Page{
	

	


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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Page\Item\Item", mappedBy="page")
     */
    private $items;

   /**
    * @var string $type
    * 0 -> page
    * 1 -> redirection
    * 2 -> admin page created
    * 
    * @ORM\Column(name="type", type="integer", options={"default" = 0})
    */
    private $type;

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
    * @var text $static_page_name
    *
    * @ORM\Column(name="static_page_name", type="text", length=1024, nullable=true)
    */
    private $static_page_name;

    /**
     * @var boolean $is_admin
     * only manage for admin users, that means experttrades users
     *
     * @ORM\Column(name="is_admin", type="boolean", options={"default" = 0})
     */
    private $is_admin;

    /**
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean", options={"default" = 1})
     */
    private $active;
    
    /**
     * @var boolean $redirection
     *
     * @ORM\Column(name="redirection", type="boolean", options={"default" = 0})
     */
    private $redirection;
    
    /**
     * @var string $url_redirection
     *
     * @ORM\Column(name="url_redirection", type="text", length=1024, nullable=true)
     */
    private $url_redirection;

    /**
     * @var boolean $show_menu
     *
     * @ORM\Column(name="show_menu", type="boolean", options={"default" = 0})
     */
    private $show_menu;

    /**
     * @var int $option_menu
     *
     * @ORM\Column(name="option_menu", type="integer", options={"default" = 0})
     */
    private $option_menu;

    /**
     * @var text $header
     *
     * @ORM\Column(name="header", type="text", length=25555, nullable=true)
     */
    private $header;

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
     * @ORM\Column(name="meta_tags", type="text", length=2555, nullable=true)
     */
    private $meta_tags;
    
    /**
     * @var string $tag_style
     *
     * @ORM\Column(name="tag_style", type="text", length=2555, nullable=true)
     */
    private $tag_style;
    
    /**
     * @var string $tag_script
     *
     * @ORM\Column(name="tag_script", type="text", length=2555, nullable=true)
     */
    private $tag_script;


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
    
  /**
   * @var datetime $deleted_at
   *
   * @ORM\Column(type="datetime", nullable=true)
   */
   private $deleted_at;
    
   public function __construct( ){
       	$this->created = new \DateTime("now",new \DateTimeZone('Europe/London'));
       	$this->publish = null;
       	$this->show_menu = false;
       	$this->option_menu = 0;
       	$this->active = true;
   		$this->redirection = false;
   		$this->is_admin = false;
   		$this->type = 0;
   }

   public function active(){
   		$this->active = true;
   		$this->publish = new \DateTime("now",new \DateTimeZone('Europe/London'));
   }

   public function unactive(){
   		$this->active = false;
   		$this->publish = null;
   }

   public function delete(){
   		$this->active = false;
   		$this->publish = null;
   		$this->publish = null;
   		$this->deleted_at = new \DateTime("now",new \DateTimeZone('Europe/London'));
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
     * @return AppBundle\Entity\Page\Item\Item
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
	public function getBody() {
		return $this->body;
	}
	public function setBody($body) {
		$this->body = $body;
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
		$search .= strip_tags( $this->meta_tags )." ";
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
	public function getStaticPageName() {
		return $this->static_page_name;
	}
	public function setStaticPageName($static_page_name) {
		$this->static_page_name = $static_page_name;
		return $this;
	}
	public function getActive() {
		return $this->active;
	}
	public function setActive($active) {
		$this->active = $active;
		return $this;
	}
	public function getShowMenu() {
		return $this->show_menu;
	}
	public function setShowMenu($show_menu) {
		$this->show_menu = $show_menu;
		return $this;
	}
	public function getMetaTags() {
		return $this->meta_tags;
	}
	public function setMetaTags($meta_tags) {
		$this->meta_tags = $meta_tags;
		return $this;
	}
	public function getTagStyle() {
		return $this->tag_style;
	}
	public function setTagStyle($tag_style) {
		$this->tag_style = $tag_style;
		return $this;
	}
	public function getTagScript() {
		return $this->tag_script;
	}
	public function setTagScript($tag_script) {
		$this->tag_script = $tag_script;
		return $this;
	}
	public function getRedirection() {
		return $this->redirection;
	}
	public function setRedirection($redirection) {
		$this->redirection = $redirection;
		return $this;
	}
	public function getUrlRedirection() {
		return $this->url_redirection;
	}
	public function setUrlRedirection($url_redirection) {
		$this->url_redirection = $url_redirection;
		return $this;
	}
	public function getOptionMenu() {
		return $this->option_menu;
	}
	public function setOptionMenu($option_menu) {
		$this->option_menu = $option_menu;
		return $this;
	}
	public function getType() {
		return $this->type;
	}
	public function setType($type) {
		$this->type = $type;
		return $this;
	}
	public function getIsAdmin() {
		return $this->is_admin;
	}
	public function setIsAdmin($is_admin) {
		$this->is_admin = $is_admin;
		return $this;
	}
	public function getHeader() {
		return $this->header;
	}
	public function setHeader($header) {
		$this->header = $header;
		return $this;
	}
	
	
	
	
	
	
}
