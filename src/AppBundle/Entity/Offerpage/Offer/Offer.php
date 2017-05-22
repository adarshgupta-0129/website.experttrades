<?php

namespace AppBundle\Entity\Offerpage\Offer;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\OrderBy;
use AppBundle\Entity\Offerpage\Offer\Item\Item;



/**
 * AppBundle\Entity\Offerpage\Offer\Offer
 * @ORM\Table(name="offerpage_offer")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Offerpage\Offer\OfferRepository")
 */
class Offer{



	/**
	 * @var string $offerpage
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Offerpage\OfferPage" , inversedBy="offers")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="offerpage_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 * })
	 */
	private $offerpage;


	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Offerpage\Offer\Item\Item", mappedBy="offer")
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
    * @ORM\Column(name="slug", type="text", length=1024, nullable=true)
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
     * @var datetime $publish_until
     *
     * @ORM\Column(name="publish_until",type="datetime", nullable=true)
     */
    private $publish_until;

    /**
     * @var boolean $active
     *
     * @ORM\Column(name="active",type="boolean")
     */
    private $active;

    /**
     * @var boolean $is_published
     *
     * @ORM\Column(name="is_published",type="boolean")
     */
    private $is_published;

    /**
     * @var boolean $show_homepage
     *
     * @ORM\Column(name="show_homepage",type="boolean")
     */
    private $show_homepage;

   /**
    * @var string $btn_text
    *
    * @ORM\Column(name="btn_text", type="string", length=255, nullable=true)
    */
    private $btn_text;

   /**
    * @var string $btn_action
    *
    *  'contact': redirect contactpage and add btn_contact_text in job description
    *  'int_redirect': open internal link
    *  'ext_redirect': open btn_link in a new tab
    *
    * @ORM\Column(name="btn_action", type="string", length=255, nullable=true)
    */
    private $btn_action;

   /**
    * @var string $btn_contact_text
    *
    * @ORM\Column(name="btn_contact_text", type="string", length=1024, nullable=true)
    */
    private $btn_contact_text;

   /**
    * @var string $btn_link
    *
    * @ORM\Column(name="btn_link", type="string", length=1024, nullable=true)
    */
    private $btn_link;

  /**
   * @var datetime $created
   *
   * @ORM\Column(type="datetime")
   */
   private $created;

   public function __construct(\AppBundle\Entity\Offerpage\OfferPage $offerpage ){
		$this->offerpage = $offerpage;
   	   	$this->items = new ArrayCollection();
       	$this->created = new \DateTime("now",new \DateTimeZone('Europe/London'));
       	$this->active = false;
       	$this->publish = null;
       	$this->publish_until = null;
       	$this->is_published = false;
       	$this->show_homepage = false;
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
     * Get offerpage
     *
     * @return AppBundle\Entity\Offerpage\OfferPage $offerpage
     */
    public function getOfferpage()
    {
        return $this->offerpage;
    }

    /**
     * Set offerpage
     *
     * @return AppBundle\Entity\Offerpage\OfferPage $offerpage
     */
    public function setOfferpage(\AppBundle\Entity\Offerpage\OfferPage $offerpage)
    {
        $this->offerpage = $offerpage;
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
     * @return AppBundle\Entity\Offerpage\Offer\Item
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
			$this->btn_contact_text = "RE: ". $this->title;
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
	public function setPublished() {
		$this->is_published = $this->isActive();
		return $this;
	}
	public function isPublished() {
		return $this->isActive();
	}
	public function isScheduled() {
		if($this->active){
			$now = (new \DateTime);
			if( is_null($this->publish_until) && $now->getTimestamp() < $this->publish->getTimestamp() ){
				return true;
			} else if($now->getTimestamp() <= $this->publish_until->getTimestamp() && $now->getTimestamp() < $this->publish->getTimestamp()){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function getPublish() {
		return $this->publish;
	}
	public function setPublish($publish) {
		$this->publish = $publish;
		if(is_object($this->publish))
			$this->publish->setTime('0','0');
		return $this;
	}
	public function getPublishUntil() {
		return $this->publish_until;
	}
	public function setPublishUntil($publish_until) {
		$this->publish_until = $publish_until;
		if(is_object($this->publish_until))
			$this->publish_until->setTime('23','59');
		return $this;
	}
	public function setActive($active) {
		$this->active = $active;
		return $this;
	}
	public function getActive() {
		return $this->active;
	}
	public function setShowHomepage($show_homepage) {
		$this->show_homepage = $show_homepage;
		return $this;
	}
	public function getShowHomepage() {
		return $this->show_homepage;
	}
	public function isActive() {
		$now = (new \DateTime);
		if( is_null($this->publish) && is_null($this->publish_until) ){
			return $this->active;
		} else if(is_null($this->publish_until)){
			//check publidh date  is LT today
			if( $now->getTimestamp() >= $this->publish->getTimestamp())
				return $this->active;
			else
				return false;
		} else  if(is_null($this->publish)){
			//check publidh date  is LT today
			if( $now->getTimestamp() <= $this->publish_until->getTimestamp())
				return $this->active;
			else
				return false;
		} else {
			//check publidh date  is LT today and publish until GT today
			if( $now->getTimestamp() >= $this->publish->getTimestamp() && $now->getTimestamp() <= $this->publish_until->getTimestamp())
				return $this->active;
			else
				return false;
		}
		return $this->active;
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
	public function getBtnText() {
		return $this->btn_text;
	}
	public function setBtnText($btn_text) {
		$this->btn_text = $btn_text;
		return $this;
	}
	public function getBtnAction() {
		return $this->btn_action;
	}
	public function setBtnAction($btn_action) {
		$this->btn_action = $btn_action;
		return $this;
	}
	public function getBtnContactText() {
		return $this->btn_contact_text;
	}
	public function setBtnContactText($btn_contact_text) {
		$this->btn_contact_text = $btn_contact_text;
		return $this;
	}
	public function getBtnLink() {
		return $this->btn_link;
	}
	public function setBtnLink($btn_link) {
		$this->btn_link = $btn_link;
		return $this;
	}



}
