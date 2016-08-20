<?php

namespace AppBundle\Entity\Service\Item\File;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * AppBundle\Entity\Service\Item\File\File
 * @ORM\Table(name="service_item_file")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Service\Item\File\FileRepository")
 */
class File{

	const  FILE_PDF = 'pdf';
	const  FILE_IMAGE = 'img';

	public static $MIMETYPE = [
			self::FILE_IMAGE => array (
			'png'  => 'image/png',
			'jpe'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg'  => 'image/jpeg',
			'gif'  => 'image/gif',
			'bmp'  => 'image/bmp',
			'ico'  => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif'  => 'image/tiff'),
			self::FILE_PDF => array (
					'pdf'  => 'application/pdf')
			];

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;


    /**
     * @var string $post
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Service\Item\Item" , inversedBy="files")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * })
     */
    private $item;

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
     * @var type $featured
     *
     * @ORM\Column(name="type", type="string", length=3,  nullable=true)
     */
    private $type;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;

    public function __construct()
    {

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
     * @return AppBundle\Entity\Service\Item\Item $item
     */
    public function getItem()
    {
    	return $this->item;
    }

    /**
     * Set post
     *
     * @return AppBundle\Entity\Service\Item\Item $item
     */
    public function setItem(\AppBundle\Entity\Service\Item\Item $item)
    {
    	$this->item = $item;
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

				if(!file_exists($this->getUploadRootDir())) mkdir($this->getUploadRootDir());
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
