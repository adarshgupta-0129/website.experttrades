<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppBundle\Entity\Website
 * @ORM\Table(name="website")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WebsiteRepository")
 */
class Website{

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
     * @ORM\Column(name="access_token", type="string", length=2555, nullable=true)
     */
    private $access_token;

    /**
     * @var string $facebook_link
     *
     * @ORM\Column(name="facebook_link", type="string", length=2555, nullable=true)
     */
    private $facebook_link;

    /**
     * @var string $twitter_link
     *
     * @ORM\Column(name="twitter_link", type="string", length=2555, nullable=true)
     */
    private $twitter_link;

    /**
     * @var string $youtube_link
     *
     * @ORM\Column(name="youtube_link", type="string", length=2555, nullable=true)
     */
    private $youtube_link;

    /**
     * @var string $google_link
     *
     * @ORM\Column(name="google_link", type="string", length=2555, nullable=true)
     */
    private $google_link;

    /**
     * @var string $postcode
     *
     * @ORM\Column(name="postcode", type="string", length=255, nullable=true)
     */
    private $postcode;

    public function __construct(){

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

}
