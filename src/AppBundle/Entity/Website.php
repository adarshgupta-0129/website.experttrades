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
     * @var string $admin_access_token
     *
     * @ORM\Column(name="admin_access_token", type="text", length=2555, nullable=true)
     */
    private $admin_access_token;

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
     * @var string $twitter_page
     *
     * @ORM\Column(name="twitter_page", type="text", length=2555, nullable=true)
     */
    private $twitter_page;

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
     * @var string $linkedin_link
     *
     * @ORM\Column(name="linkedin_link", type="text", length=2555, nullable=true)
     */
    private $linkedin_link;

    /**
     * @var string $instagram_link
     *
     * @ORM\Column(name="instagram_link", type="text", length=2555, nullable=true)
     */
    private $instagram_link;
    


    /**
     * @var boolean $facebook_link_enabled
     *
     * @ORM\Column(name="facebook_link_enabled", type="boolean")
     */
    private $facebook_link_enabled;

    /**
     * @var boolean $twitter_link_enabled
     *
     * @ORM\Column(name="twitter_link_enabled", type="boolean")
     */
    private $twitter_link_enabled;

    /**
     * @var boolean $youtube_link_enabled
     *
     * @ORM\Column(name="youtube_link_enabled", type="boolean")
     */
    private $youtube_link_enabled;

    /**
     * @var boolean $google_link_enabled
     *
     * @ORM\Column(name="google_link_enabled", type="boolean")
     */
    private $google_link_enabled;

    /**
     * @var boolean $linkedin_link_enabled
     *
     * @ORM\Column(name="linkedin_link_enabled", type="boolean")
     */
    private $linkedin_link_enabled;

    /**
     * @var boolean $instagram_link_enabled
     *
     * @ORM\Column(name="instagram_link_enabled", type="boolean")
     */
    private $instagram_link_enabled;

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

    /**
     * @var string $show_about_tab
     *
     * @ORM\Column(name="show_about_tab", type="boolean")
     */
    private $show_about_tab;

    /**
     * @var string $show_services_tab
     *
     * @ORM\Column(name="show_services_tab", type="boolean")
     */
    private $show_services_tab;

    /**
     * @var string $show_reviews_tab
     *
     * @ORM\Column(name="show_reviews_tab", type="boolean")
     */
    private $show_reviews_tab;

    /**
     * @var string £show_gallery_tab
     *
     * @ORM\Column(name="show_gallery_tab", type="boolean")
     */
    private $show_gallery_tab;

    /**
     * @var string $show_contact_tab
     *
     * @ORM\Column(name="show_contact_tab", type="boolean")
     */
    private $show_contact_tab;

    /**
     * @var string $show_subscription
     *
     * @ORM\Column(name="show_subscription", type="boolean", options={"default" = 1})
     */
    private $show_subscription;

    /**
     * @var string $btn_txt_raq button text request a quote
     *
     * @ORM\Column(name="btn_txt_raq", type="string", length=25, options={"default" = "Request A Quote"})
     */
    private $btn_txt_raq;
    
    /**
     * @var string $btn_txt_gaq button text get a quote
     *
     * @ORM\Column(name="btn_txt_gaq", type="string", length=25, options={"default" = "Get A Quote"})
     */
    private $btn_txt_gaq;
    
    /**
     * @var string $btn_txt_war button text write a review
     *
     * @ORM\Column(name="btn_txt_war", type="string", length=25, options={"default" = "Write A Review"})
     */
    private $btn_txt_war;

    /**
    * @ORM\Column(type="boolean")
    */
    public $disabled;

    public function __construct(){

        $this->show_logo = false;
        $this->facebook_link_enabled = false;
        $this->twitter_link_enabled = false;
        $this->youtube_link_enabled = false;
        $this->google_link_enabled = false;
        $this->linkedin_link_enabled = false;
        $this->instagram_link_enabled = false;
        $this->disabled = false;

        $this->show_about_tab = true;
        $this->show_services_tab = true;
        $this->show_gallery_tab = true;
        $this->show_reviews_tab = true;
        $this->show_contact_tab = true;
        $this->show_subscription = true;
        
        $this->btn_txt_raq = "Request A quote";
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
        if(!is_null($this->getFacebookLink())  && $this->getFacebookLinkEnabled() ){
          return true;
        }
        if(!is_null($this->getTwitterLink()) && $this->getTwitterLinkEnabled() ){
          return true;
        }
        if(!is_null($this->getYoutubeLink()) && $this->getYoutubeLinkEnabled() ){
          return true;
        }
        if(!is_null($this->getGoogleLink()) && $this->getGoogleLinkEnabled() ){
          return true;
        }
        if(!is_null($this->getInstagramLink()) && $this->getInstagramLinkEnabled() ){
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
     * Set linkedin_link
     *
     * @param string $linkedin_link
     */
    public function setLinkedinLink($linkedin_link)
    {
        $this->linkedin_link = $linkedin_link;
    }

    /**
     * Get linkedin_link
     *
     * @return string
     */
    public function getLinkedinLink()
    {
        return $this->linkedin_link;
    }


    /**
     * Set facebook_link_enabled
     *
     * @param string $facebook_link_enabled
     */
    public function setFacebookLinkEnabled($facebook_link_enabled)
    {
        $this->facebook_link_enabled = $facebook_link_enabled;
    }

    /**
     * Get facebook_link_enabled
     *
     * @return string
     */
    public function getFacebookLinkEnabled()
    {
        return $this->facebook_link_enabled;
    }

    /**
     * Set twitter_link_enabled
     *
     * @param string $twitter_link_enabled
     */
    public function setTwitterLinkEnabled($twitter_link_enabled)
    {
        $this->twitter_link_enabled = $twitter_link_enabled;
    }

    /**
     * Get twitter_link_enabled
     *
     * @return string
     */
    public function getTwitterLinkEnabled()
    {
        return $this->twitter_link_enabled;
    }

    /**
     * Set youtube_link_enabled
     *
     * @param string $youtube_link_enabled
     */
    public function setYoutubeLinkEnabled($youtube_link_enabled)
    {
        $this->youtube_link_enabled = $youtube_link_enabled;
    }

    /**
     * Get youtube_link_enabled
     *
     * @return string
     */
    public function getYoutubeLinkEnabled()
    {
        return $this->youtube_link_enabled;
    }

    /**
     * Set google_link_enabled
     *
     * @param string $google_link_enabled
     */
    public function setGoogleLinkEnabled($google_link_enabled)
    {
        $this->google_link_enabled = $google_link_enabled;
    }

    /**
     * Get google_link_enabled
     *
     * @return string
     */
    public function getGoogleLinkEnabled()
    {
        return $this->google_link_enabled;
    }

    /**
     * Set linkedin_link_enabled
     *
     * @param string $linkedin_link_enabled
     */
    public function setLinkedinLinkEnabled($linkedin_link_enabled)
    {
        $this->linkedin_link_enabled = $linkedin_link_enabled;
    }

    /**
     * Get linkedin_link_enabled
     *
     * @return string
     */
    public function getLinkedinLinkEnabled()
    {
        return $this->linkedin_link_enabled;
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

    /**
     * Set show_about_tab
     *
     * @param string $show_about_tab
     */
    public function setShowAboutTab($show_about_tab)
    {
        $this->show_about_tab = $show_about_tab;
    }

    /**
     * Get show_about_tab
     *
     * @return string
     */
    public function getShowAboutTab()
    {
        return $this->show_about_tab;
    }

    /**
     * Set show_services_tab
     *
     * @param string $show_services_tab
     */
    public function setShowServicesTab($show_services_tab)
    {
        $this->show_services_tab = $show_services_tab;
    }

    /**
     * Get show_services_tab
     *
     * @return string
     */
    public function getShowServicesTab()
    {
        return $this->show_services_tab;
    }

    /**
     * Set show_gallery_tab
     *
     * @param string $show_gallery_tab
     */
    public function setShowGalleryTab($show_gallery_tab)
    {
        $this->show_gallery_tab = $show_gallery_tab;
    }

    /**
     * Get show_gallery_tab
     *
     * @return string
     */
    public function getShowGalleryTab()
    {
        return $this->show_gallery_tab;
    }

    /**
     * Set show_reviews_tab
     *
     * @param string $show_reviews_tab
     */
    public function setShowReviewsTab($show_reviews_tab)
    {
        $this->show_reviews_tab = $show_reviews_tab;
    }

    /**
     * Get show_reviews_tab
     *
     * @return string
     */
    public function getShowReviewsTab()
    {
        return $this->show_reviews_tab;
    }

    /**
     * Set show_contact_tab
     *
     * @param string $show_contact_tab
     */
    public function setShowContactTab($show_contact_tab)
    {
        $this->show_contact_tab = $show_contact_tab;
    }

    /**
     * Get show_contact_tab
     *
     * @return string
     */
    public function getShowContactTab()
    {
        return $this->show_contact_tab;
    }

    /**
     * Set disabled
     *
     * @param string $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

    /**
     * Get show_logo
     *
     * @return string
     */
    public function getDisabled()
    {
        return $this->disabled;
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
	public function getAdminAccessToken() {
		return $this->admin_access_token;
	}
	public function setAdminAccessToken($admin_access_token) {
		$this->admin_access_token = $admin_access_token;
		return $this;
	}
	public function getTwitterPage() {
		return $this->twitter_page;
	}
	public function setTwitterPage($twitter_page) {
		$this->twitter_page = $twitter_page;
		return $this;
	}
	public function getId() {
		return $this->id;
	}
	public function getInstagramLink() {
		return $this->instagram_link;
	}
	public function setInstagramLink($instagram_link) {
		$this->instagram_link = $instagram_link;
		return $this;
	}
	public function getInstagramLinkEnabled() {
		return $this->instagram_link_enabled;
	}
	public function setInstagramLinkEnabled($instagram_link_enabled) {
		$this->instagram_link_enabled = $instagram_link_enabled;
		return $this;
	}
	public function getShowSubscription() {
		return $this->show_subscription;
	}
	public function setShowSubscription($show_subscription) {
		$this->show_subscription = $show_subscription;
		return $this;
	}
	public function getBtnTxtRaq() {
		return $this->btn_txt_raq;
	}
	public function setBtnTxtRaq($btn_txt_raq) {
		$this->btn_txt_raq = $btn_txt_raq;
		return $this;
	}
	public function getBtnTxtGaq() {
		return $this->btn_txt_gaq;
	}
	public function setBtnTxtGaq($btn_txt_gaq) {
		$this->btn_txt_gaq = $btn_txt_gaq;
		return $this;
	}
	public function getBtnTxtWar() {
		return $this->btn_txt_war;
	}
	public function setBtnTxtWar($btn_txt_war) {
		$this->btn_txt_war = $btn_txt_war;
		return $this;
	}
	
	
	
	
	

}
