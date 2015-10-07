<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AppBundle\Entity\Website
 * @ORM\Table(name="website")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WebsiteRepository")
 */
class Website{

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $logo_file;

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
     * @var string $trade_id
     *
     * @ORM\Column(name="trade_id", type="integer", nullable=true)
     */
    private $trade_id;

    /**
     * @var string $access_token
     *
     * @ORM\Column(name="access_token", type="text", length=2555, nullable=true)
     */
    private $access_token;

    /**
    * @ORM\Column(type="boolean")
    */
    public $show_logo;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $trade_url;

    /**
     * @var string $facebook_link
     *
     * @ORM\Column(name="facebook_link", type="text", length=2555, nullable=true)
     */
    private $facebook_link;

    /**
     * @var string $twitter_link
     *
     * @ORM\Column(name="twitter_link", type="text", length=2555, nullable=true)
     */
    private $twitter_link;

    /**
     * @var string $youtube_link
     *
     * @ORM\Column(name="youtube_link", type="text", length=2555, nullable=true)
     */
    private $youtube_link;

    /**
     * @var string $google_link
     *
     * @ORM\Column(name="google_link", type="text", length=2555, nullable=true)
     */
    private $google_link;

    /**
     * @var string $postcode
     *
     * @ORM\Column(name="postcode", type="string", length=255, nullable=true)
     */
    private $postcode;

    /**
     * @var string $subscribe_title
     *
     * @ORM\Column(name="subscribe_title", type="text", length=2555, nullable=true)
     */
    private $subscribe_title;

    /**
     * @var string $subscribe_subtitle
     *
     * @ORM\Column(name="subscribe_subtitle", type="text", length=2555, nullable=true)
     */
    private $subscribe_subtitle;

    /**
     * @var string $copyright
     *
     * @ORM\Column(name="copyright", type="text", length=2555, nullable=true)
     */
    private $copyright;

    /**
     * @var string $company_name
     *
     * @ORM\Column(name="company_name", type="text", length=2555, nullable=true)
     */
    private $company_name;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $logo_path;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $main_color;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $dark_color;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $light_color;

    public function __construct(){
        $this->show_logo = false;
    }
    /**
     * Get path
     *
     * @return string
     */
    public function getLogoPath()
    {
        return $this->logo_path;
    }

    /**
     * Sets logo_file.
     *
     * @param UploadedFile $file
     */
    public function setLogoFile(UploadedFile $logo_file = null)
    {
        $this->logo_file = $logo_file;
    }

    /**
     * Get logo_file.
     *
     * @return UploadedFile
     */
    public function getLogoFile()
    {
        return $this->logo_file;
    }

    /**
     * Get google_link
     *
     * @return string
     */
    public function hasSocial()
    {
        if(!is_null($this->getFacebookLink())){
          return true;
        }
        if(!is_null($this->getTwitterLink())){
          return true;
        }
        if(!is_null($this->getYoutubeLink())){
          return true;
        }
        if(!is_null($this->getGoogleLink())){
          return true;
        }

        return false;
    }

    /**
     * Set trade_id
     *
     * @param string $trade_id
     */
    public function setTradeId($trade_id)
    {
        $this->trade_id = $trade_id;
    }

    /**
     * Get trade_id
     *
     * @return inetegr
     */
    public function getTradeId()
    {
        return $this->trade_id;
    }

    /**
     * Set access_token
     *
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * Get access_token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Set facebook_link
     *
     * @param string $facebook_link
     */
    public function setFacebookLink($facebook_link)
    {
        $this->facebook_link = $facebook_link;
    }

    /**
     * Get facebook_link
     *
     * @return string
     */
    public function getFacebookLink()
    {
        return $this->facebook_link;
    }

    /**
     * Set twitter_link
     *
     * @param string $twitter_link
     */
    public function setTwitterLink($twitter_link)
    {
        $this->twitter_link = $twitter_link;
    }

    /**
     * Get twitter_link
     *
     * @return string
     */
    public function getTwitterLink()
    {
        return $this->twitter_link;
    }

    /**
     * Set youtube_link
     *
     * @param string $youtube_link
     */
    public function setYoutubeLink($youtube_link)
    {
        $this->youtube_link = $youtube_link;
    }

    /**
     * Get youtube_link
     *
     * @return string
     */
    public function getYoutubeLink()
    {
        return $this->youtube_link;
    }

    /**
     * Set google_link
     *
     * @param string $google_link
     */
    public function setGoogleLink($google_link)
    {
        $this->google_link = $google_link;
    }

    /**
     * Get google_link
     *
     * @return string
     */
    public function getGoogleLink()
    {
        return $this->google_link;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set subscribe_title
     *
     * @param string $subscribe_title
     */
    public function setSubscribeTitle($subscribe_title)
    {
        $this->subscribe_title = $subscribe_title;
    }

    /**
     * Get subscribe_title
     *
     * @return string
     */
    public function getSubscribeTitle()
    {
        return $this->subscribe_title;
    }

    /**
     * Set subscribe_subtitle
     *
     * @param string $subscribe_subtitle
     */
    public function setSubscribeSubtitle($subscribe_subtitle)
    {
        $this->subscribe_subtitle = $subscribe_subtitle;
    }

    /**
     * Get subscribe_subtitle
     *
     * @return string
     */
    public function getSubscribeSubtitle()
    {
        return $this->subscribe_subtitle;
    }

    /**
     * Set copyright
     *
     * @param string $copyright
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
    }

    /**
     * Get copyright
     *
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * Get trade_url
     *
     * @return string
     */
    public function getTradeUrl()
    {
        return $this->trade_url;
    }

    /**
     * Set trade_url
     *
     * @param string $trade_url
     */
    public function setTradeUrl($trade_url)
    {
        $this->trade_url = $trade_url;
    }

    /**
     * Set company_name
     *
     * @param string $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }

    /**
     * Get company_name
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * Set main_color
     *
     * @param string $main_color
     */
    public function setMainColor($main_color)
    {
        $this->main_color = $main_color;
    }

    /**
     * Get main_color
     *
     * @return string
     */
    public function getMainColor()
    {
        return $this->main_color;
    }

    /**
     * Set dark_color
     *
     * @param string $dark_color
     */
    public function setDarkColor($dark_color)
    {
        $this->dark_color = $dark_color;
    }

    /**
     * Get dark_color
     *
     * @return string
     */
    public function getDarkColor()
    {
        return $this->dark_color;
    }

    /**
     * Set light_color
     *
     * @param string $light_color
     */
    public function setLightColor($light_color)
    {
        $this->light_color = $light_color;
    }

    /**
     * Get light_color
     *
     * @return string
     */
    public function getLightColor()
    {
        return $this->light_color;
    }

    /**
     * Set show_logo
     *
     * @param string $show_logo
     */
    public function setShowLogo($show_logo)
    {
        $this->show_logo = $show_logo;
    }

    /**
     * Get show_logo
     *
     * @return string
     */
    public function getShowLogo()
    {
        return $this->show_logo;
    }

    public function logoUpload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getLogoFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        $filename = substr( md5(rand()), 0, 15).'.'.$this->getLogoFile()->guessExtension();
        // move takes the target directory and then the
        // target filename to move to
        $this->getLogoFile()->move(
            $this->getLogoUploadRootDir(),
            $filename
        );

        // set the path property to the filename where you've saved the file
        $this->logo_path = $filename;

        // clean up the file property as you won't need it anymore
        $this->logo_file = null;
     }

     public function getLogoAbsolutePath()
     {
         return null === $this->path
             ? null
             : $this->getLogoUploadRootDir().'/'.$this->path;
     }

     public function getLogoWebPath()
     {
         return null === $this->path
             ? null
             : $this->getLogoUploadDir().'/'.$this->logo_path;
     }

     protected function getLogoUploadRootDir()
     {
         // the absolute directory path where uploaded
         // documents should be saved
         return __DIR__.'/../../../web/'.$this->getLogoUploadDir();
     }

     protected function getLogoUploadDir()
     {
         // get rid of the __DIR__ so it doesn't screw up
         // when displaying uploaded doc/image in the view.
         return 'images/logo';
     }

     public function deleteLogoFile()
     {
         $path = $this->getLogoUploadRootDir().'/'.$this->logo_path;
         if(file_exists ($path)){
           unlink($path);
         }
     }

}
