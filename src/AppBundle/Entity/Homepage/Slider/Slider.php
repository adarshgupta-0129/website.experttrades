<?php

namespace AppBundle\Entity\Homepage\Slider;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AppBundle\Entity\Homepage\Slider\Slider
 * @ORM\Table(name="homepage_slider")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Homepage\Slider\SliderRepository")
 */
class Slider{

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Homepage\Homepage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="homepage_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     * })
     */
    private $homepage;


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
     * @ORM\Column(name="title", type="text", length=2555, nullable=true)
     */
    private $title;

    /**
     * @var string $subtitle
     *
     * @ORM\Column(name="subtitle", type="text", length=2555, nullable=true)
     */
    private $subtitle;


    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;
    

    /**
     * @var string $button_text
     *
     * @ORM\Column(name="button_text", type="text", length=125, nullable=true)
     */
    private $button_text;

    /**
     * @var string $url
     * 
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;
    
    /**
     * @var string $button_text2
     *
     * @ORM\Column(name="button_text2", type="text", length=125, nullable=true)
     */
    private $button_text2;

    /**
     * @var string $url
     * 
     * @ORM\Column(name="url2", type="string", length=255, nullable=true)
     */
    private $url2;
    
    /**
     * @var string $button_text3
     *
     * @ORM\Column(name="button_text3", type="text", length=2555, nullable=true)
     */
    private $button_text3;

    /**
     * @var string $url3
     * 
     * @ORM\Column(name="url3", type="string", length=125, nullable=true)
     */
    private $url3;
    
    

    public function __construct(){
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Get trade
     *
     * @return \AppBundle\Entity\Homepage\Homepage $homepage
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Set homepage
     *
     * @return \AppBundle\Entity\Homepage\Homepage $homepage
     */
    public function setHomepage(\AppBundle\Entity\Homepage\Homepage $homepage)
    {
        $this->homepage = $homepage;
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set button_text
     *
     * @param string $button_text
     */
    public function setButtonText($button_text)
    {
        $this->button_text = $button_text;
    }

    /**
     * Get button_text
     *
     * @return string
     */
    public function getButtonText()
    {
        return $this->button_text;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
    
    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        $filename = substr( md5(rand()), 0, 15).'.'.$this->getFile()->guessExtension();
        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $filename
        );

        // set the path property to the filename where you've saved the file
        $this->path = $filename;

        // clean up the file property as you won't need it anymore
        $this->file = null;
     }

     public function getAbsolutePath()
     {
         return null === $this->path
             ? null
             : $this->getUploadRootDir().'/'.$this->path;
     }

     public function getWebPath()
     {
         return null === $this->path
             ? null
             : $this->getUploadDir().'/'.$this->path;
     }

     protected function getUploadRootDir()
     {
         // the absolute directory path where uploaded
         // documents should be saved
         return __DIR__.'/../../../../../web/'.$this->getUploadDir();
     }

     protected function getUploadDir()
     {
         // get rid of the __DIR__ so it doesn't screw up
         // when displaying uploaded doc/image in the view.
         return 'images/homepage/sliders';
     }
	public function getUrl() {
		return $this->url;
	}
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}
	public function getButtonText2() {
		return $this->button_text2;
	}
	public function setButtonText2($button_text2) {
		$this->button_text2 = $button_text2;
		return $this;
	}
	public function getUrl2() {
		return $this->url2;
	}
	public function setUrl2($url2) {
		$this->url2 = $url2;
		return $this;
	}
	public function getButtonText3() {
		return $this->button_text3;
	}
	public function setButtonText3($button_text3) {
		$this->button_text3 = $button_text3;
		return $this;
	}
	public function getUrl3() {
		return $this->url3;
	}
	public function setUrl3($url3) {
		$this->url3 = $url3;
		return $this;
	}
	
     
     
}
