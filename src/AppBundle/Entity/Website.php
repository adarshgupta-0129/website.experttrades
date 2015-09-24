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
     * @var string $access_token
     *
     * @ORM\Column(name="access_token", type="text", length=2555, nullable=true)
     */
    private $access_token;

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

    public function __construct(){

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

    public function logoUpload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getLogoFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        $filename = substr( md5(rand()), 0, 15).'.'.$this->getFile()->guessExtension();
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
         return __DIR__.'/../../../../../web/'.$this->getLogoUploadDir();
     }

     protected function getLogoUploadDir()
     {
         // get rid of the __DIR__ so it doesn't screw up
         // when displaying uploaded doc/image in the view.
         return 'images/logo';
     }

     public function deleteLogoFile()
     {
         $path = $this->getUploadRootDir().'/'.$this->logo_path;
         if(file_exists ($path)){
           unlink($path);
         }
     }

}
