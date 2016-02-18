<?php

namespace AppBundle\Entity\Blog\Post\Item;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * AppBundle\Entity\Blog\Post\Item\Item
 * @ORM\Table(name="blog_item")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Blog\Post\Item\ItemRepository")
 */
class Item{

	const  ITEM_PDF = 'pdf';
	const  ITEM_IMAGE = 'img';
	
	public static $MIMETYPE = [
			self::ITEM_IMAGE => array (	
			'png'  => 'image/png',
			'jpe'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg'  => 'image/jpeg',
			'gif'  => 'image/gif',
			'bmp'  => 'image/bmp',
			'ico'  => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif'  => 'image/tiff'),
			self::ITEM_PDF => array (
					'pdf'  => 'application/pdf')
			];
	
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    

    /**
     * @var string $post
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Blog\Post\Post" , inversedBy="items")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * })
     */
    private $post;

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
     * @var boolean $featured
     *
     * @ORM\Column(name="featured", type="boolean",  nullable=true)
     */
    private $featured;
    

    /**
     * @var type $featured
     *
     * @ORM\Column(name="type", type="string", length=3,  nullable=true)
     */
    private $type;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;

    public function __construct(\AppBundle\Entity\Blog\Post\Post $post)
    {
    	$this->post = $post;
    	$this->featured = false;

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
     * Get post
     *
     * @return AppBundle\Entity\Blog\Post\Post $post
     */
    public function getPost()
    {
    	return $this->post;
    }
    
    /**
     * Set post
     *
     * @return AppBundle\Entity\Blog\Post\Post $post
     */
    public function setPost(\AppBundle\Entity\Blog\Post\Post $post)
    {
    	$this->post = $post;
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
     * Get featured
     *
     * @return boolean
     */
    public function getFeatured()
    {
    	return $this->featured;
    }
    

    /**
     * Get featured
     *
     * @param boolean $featured
     */
    public function setFeatured( $featured )
    {
    	$this->featured = $featured;
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
    

    public function getType() {
    	return $this->type;
    }
    public function setType($type) {
    	$this->type = $type;
    	return $this;
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
         return __DIR__.'/../../../../../../web/'.$this->getUploadDir();
     }

     protected function getUploadDir()
     {
         // get rid of the __DIR__ so it doesn't screw up
         // when displaying uploaded doc/image in the view.
         return 'images/blog/post/'.$this->post->getId();
     }

     public function deleteFile()
     {
         $path = $this->getUploadRootDir().'/'.$this->path;
         if(file_exists ($path)){
           unlink($path);
         }
     }
	
}
