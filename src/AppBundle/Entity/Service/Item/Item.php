<?php

namespace AppBundle\Entity\Service\Item;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AppBundle\Entity\Service\Item\Item
 * @ORM\Table(name="service_item")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Service\Item\ItemRepository")
 */
class Item{

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;


  	/**
  	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Service\Item\File\File", mappedBy="item")
  	 */
  	private $files;

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
     * @var string $page_slug
     *
     * @ORM\Column(name="page_slug", type="string", length=2555, nullable=true)
     */
    private $page_slug;

    /**
     * @var string $page_meta_title
     *
     * @ORM\Column(name="page_meta_title", length=2555, nullable=true)
     */
    private $page_meta_title;

    /**
     * @var string $page_meta_description
     *
     * @ORM\Column(name="page_meta_description", type="text", nullable=true)
     */
    private $page_meta_description;

    /**
     * @var string $page_title
     *
     * @ORM\Column(name="page_title", type="text", nullable=true)
     */
    private $page_title;

    /**
     * @var string $page_html
     *
     * @ORM\Column(name="page_html", type="text", nullable=true)
     */
    private $page_html;

    /**
     * @var string $page_active
     *
     * @ORM\Column(name="page_active", type="boolean")
     */
    private $page_active;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;

    public function __construct(){

      $this->page_active = false;
      $this->files = new ArrayCollection();
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * Set page_slug
     *
     * @param string $page_slug
     */
    public function setPageSlug($page_slug)
    {
        $this->page_slug = $page_slug;
    }

    /**
     * Get page_html
     *
     * @return string
     */
    public function getPageSlug()
    {
        return $this->page_slug;
    }

    /**
     * Set page_meta_title
     *
     * @param string $page_meta_title
     */
    public function setPageMetaTitle($page_meta_title)
    {
        $this->page_meta_title = $page_meta_title;
    }

    /**
     * Get page_meta_title
     *
     * @return string
     */
    public function getPageMetaTitle()
    {
        return $this->page_meta_title;
    }

    /**
     * Set page_meta_description
     *
     * @param string $page_meta_description
     */
    public function setPageMetaDescription($page_meta_description)
    {
        $this->page_meta_description = $page_meta_description;
    }

    /**
     * Get page_meta_description
     *
     * @return string
     */
    public function getPageMetaDescription()
    {
        return $this->page_meta_description;
    }

    /**
     * Set page_title
     *
     * @param string $page_title
     */
    public function setPageTitle($page_title)
    {
        $this->page_title = $page_title;
    }

    /**
     * Get page_title
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->page_title;
    }

    /**
     * Set page_html
     *
     * @param string $page_html
     */
    public function setPageHtml($page_html)
    {
        $this->page_html = $page_html;
    }

    /**
     * Get page_html
     *
     * @return string
     */
    public function getPageHtml()
    {
        return $this->page_html;
    }

    /**
     * Set page_active
     *
     * @param string $page_active
     */
    public function setPageActive($page_active)
    {
        $this->page_active = $page_active;
    }

    /**
     * Get page_active
     *
     * @return string
     */
    public function getPageActive()
    {
        return $this->page_active;
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
         return 'images/services';
     }

     public function deleteFile()
     {
         $path = $this->getUploadRootDir().'/'.$this->path;
         if(file_exists ($path)){
           unlink($path);
         }
     }
}
