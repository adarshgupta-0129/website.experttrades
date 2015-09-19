<?php

namespace AppBundle\Entity\Review\Item;

use Doctrine\ORM\Mapping as ORM;


/**
 * AppBundle\Entity\Review\Item\Item
 * @ORM\Table(name="review_item")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Review\Item\ItemRepository")
 */
class Item{

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
    * @ORM\Column(name="title", type="string", length=2555, nullable=true)
    */
    private $title;

   /**
    * @var text $message
    *
    * @ORM\Column(name="message", type="text", length=25555, nullable=true)
    */
    private $message;

   /**
    * @var string $job_description
    *
    * @ORM\Column(name="job_description", type="string", length=2500, nullable=true)
    */
   private $job_description;

   /**
    * @var string $job_location
    *
    * @ORM\Column(name="job_location", type="string", length=2500, nullable=true)
    */
   private $job_location;

   /**
    * @var integer $rate_time_management
    *
    * @ORM\Column(name="rate_time_management", type="integer", nullable=true)
    */
   private $rate_time_management;

   /**
    * @var integer $rate_friendly
    *
    * @ORM\Column(name="rate_friendly", type="integer", nullable=true)
    */
   private $rate_friendly;

    /**
    * @var integer $rate_tidiness
    *
    * @ORM\Column(name="rate_tidiness", type="integer", nullable=true)
    */
   private $rate_tidiness;

   /**
    * @var integer $rate_value
    *
    * @ORM\Column(name="rate_value", type="integer", nullable=true)
    */
   private $rate_value;

   /**
    * @var integer $rate_total
    *
    * @ORM\Column(name="rate_total", type="integer", nullable=true)
    */
   private $rate_total;

  /**
   * @var datetime $job_done_date
   *
   * @ORM\Column(type="datetime", nullable=true)
   */
   private $job_done_date;

  /**
   * @var datetime $created
   *
   * @ORM\Column(type="datetime")
   */
   private $created;

   public function __construct(){

       $this->created = new \DateTime("now",new \DateTimeZone('Europe/London'));
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
   * Set $title
   *
   * @param integer $title
   */
  public function setTitle($title)
  {
      $this->title = $title;
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

  /**
   * Set message
   *
   * @param string $message
   */
   public function setMessage($message)
   {
      $this->message = $message;
   }

  /**
   * Get message
   *
   * @return string
   */
   public function getMessage()
   {
      return $this->message;
   }

   /**
    * Set rate_time_management
    *
    * @param integer $rate_time_management
    */
   public function setRateTimeManagement($rate_time_management)
   {
       $this->rate_time_management = $rate_time_management;
   }

   /**
    * Get rate_time_management
    *
    * @return integer
    */
   public function getRateTimeManagement()
   {
       return  $this->rate_time_management;
   }

   /**
    * Set rate_friendly
    *
    * @param integer $rate_friendly
    */
   public function setRateFriendly($rate_friendly)
   {
       $this->rate_friendly = $rate_friendly;
   }

   /**
    * Get rate_time_management
    *
    * @return integer
    */
   public function getRateFriendly()
   {
       return  $this->rate_friendly;
   }

   /**
    * Set rate_tidiness
    *
    * @param integer $rate_tidiness
    */
   public function setRateTidiness($rate_tidiness)
   {
       $this->rate_tidiness = $rate_tidiness;
   }

   /**
    * Get rate_tidiness
    *
    * @return integer
    */
   public function getRateTidiness()
   {
       return  $this->rate_tidiness;
   }

    /**
    * Set $rate_value
    *
    * @param integer $rate_value
    */
   public function setRateValue($rate_value)
   {
       $this->rate_value = $rate_value;
   }

   /**
    * Get rate_value
    *
    * @return integer
    */
   public function getRateValue()
   {
       return  $this->rate_value;
   }

  /**
    * Set $rate_total
    *
    * @param integer $rate_total
    */
   public function setRateTotal($rate_total)
   {
       $this->rate_total = $rate_total;
   }

   /**
    * Get $rate_total
    *
    * @return integer
    */
   public function getRateTotal()
   {
       return  $this->rate_total;
   }

  /**
    * Set JobDescription
    *
    * @param string $job_description
    */
   public function setJobDescription($job_description)
   {
       $this->job_description = $job_description;
   }

  /**
    * Get JobDescription
    *
    * @return string
    */
   public function getJobDescription()
   {
       return $this->job_description;
   }

  /**
   * Set JobLocation
   *
   * @param string $job_location
   */
   public function setJobLocation($job_location)
   {
       $this->job_location = $job_location;
   }

  /**
   * Get JobDescription
   *
   * @return string
   */
   public function getJobLocation()
   {
       return $this->job_location;
   }

   /**
    * Set JobDoneDate
    *
    * @param datetime $job_done_date
    */
    public function setJobDoneDate($job_done_date)
    {
        $this->job_done_date = $job_done_date;
    }
    /**
     * Get JobDoneDate
     *
     * @return datetime
     */
    public function getJobDoneDate()
    {
        return $this->job_done_date;
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

   /**
    * Calculate Total
    *
    * @return integer
    */
   public function calculateTotal() {

       $total = round((($this->getRateTimeManagement() +
               $this->getRateFriendly() +
               $this->getRateTidiness() +
               $this->getRateValue()) / 4), 0, PHP_ROUND_HALF_UP);

       $this->rate_total = $total;

       return $total;
   }

   /**
    * Get Stars
    *
    * @return array
    */
   public function getStars($type = 'total', $img = null) {

     $total = 0;
     switch($type){
         case 'total':
             $total = $this->getRateTotal();
             break;
         case 'time_management':
             $total = $this->getRateTimeManagement();
             break;
         case 'friendly':
             $total = $this->getRateFriendly();
             break;
         case 'tidiness':
             $total = $this->getRateTidiness();
             break;
         case 'value':
             $total = $this->getRateValue();
             break;

     }

     if(!is_null($img)){

       $result = [];
       for ($i = 0; $i < $total; $i++) {
          $result[$i] = $img;
       }

       return $result;
     }


     $result = array('sm-star-empty.png','sm-star-empty.png','sm-star-empty.png','sm-star-empty.png','sm-star-empty.png');

     for ($i = 0; $i < $total; $i++) {
        $result[$i] = 'sm-star.png';
     }

     return $result;
   }
}
