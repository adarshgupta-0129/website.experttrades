<?php

namespace AppBundle\Entity\Gallery\Item;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AppBundle\Entity\Gallery\Item\Item
 * @ORM\Table(name="gallery_item")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Gallery\Item\ItemRepository")
 */
class Item{

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

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
     * @var string $order
     *
     * @ORM\Column(name="ordering", type="smallint", options={"default" = 0})
     */
    private $order;

    /**
     * @var string $width
     *
     * @ORM\Column(name="width", type="smallint", options={"default" = 0})
     */
    private $width;

    /**
     * @var string $height
     *
     * @ORM\Column(name="height", type="smallint", options={"default" = 0})
     */
    private $height;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;
    
    /**
    * @ORM\Column(name="extension",type="string", length=5, nullable=true)
    */
    public $ext;

    public function __construct(){
        $this->order = 0;
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
     * Get width
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
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
     * Set order
     *
     * @param string $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        $random_name = substr( md5(rand()), 0, 15);
        $ext = strtolower($this->getFile()->guessExtension());
        $this->ext = $ext;
        $filename = $random_name.'.'.$this->ext;
        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
        		$this->getUploadRootDir(),
        		$filename
        		);
        // set the path property to the filename where you've saved the file
        $this->path = $filename;
        

        $imageURL = $this->getAbsolutePath();
        $img = null;
        if(getimagesize($imageURL)){
        
        	if ($this->ext == 'gif'){
        		$img = imagecreatefromgif($imageURL);
        	}else if ($this->ext == 'png'){
        		$img = imagecreatefrompng($imageURL);
        	}else if ($this->ext == 'jpg' || $this->ext == 'jpeg'){
        		$img = imagecreatefromjpeg($imageURL);
        	}
        }
        if(is_null($img)){
        	return false;
        }
        
       	$width = imagesx($img);
    	$height = imagesy($img);
    	$new_width = $width;
    	$new_height = $height;
    	$this->width = $width;
    	$this->height = $height;
    	if( ($height > $width && $height < 630) || ($height < $width && $width < 630)  ){
    		return;
    	}
    	if( $height > $width){
    		$max_height = 630;
    		$max_width = 420;
    	}else if( $height < $width){
    		$max_height = 420;
    		$max_width = 630;
    	}
    	$this->width = $max_width;
    	$this->height = $max_height;

    	// calculate thumbnail size
	     # taller
	    if ($max_height != 'auto' && $height > $max_height) {
	        $new_height = $max_height;
	        $new_width = floor( $width * ( $max_height / $height ) );
	    }
	
	    # wider
	    if ($max_width != 'auto' &&  $width > $max_width) {
	        $new_width = $max_width;
	        $new_height = floor( $height * ( $max_width / $width ) );
	    }
    
    	// create a new temporary image
    	//$tmp_img = imagecreatetruecolor( $new_width, $new_height );

    	// copy and resize old image into new image
    	//imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
    	
    	$tmp_img = imagescale($img, $new_width, $new_height);
    	
    	$tmp_path = sys_get_temp_dir(  )."/tmp_file.".$this->ext;
    	if ($this->ext == 'gif'){
    		imagegif($tmp_img, $tmp_path);
    	}else if ($this->ext == 'png'){
    		imagepng($tmp_img, $tmp_path,1);
    	}else if ($this->ext == 'jpg' || $this->ext == 'jpeg'){
    		imagejpeg($tmp_img, $tmp_path);
    	}

    	//move temporaly to image name
    	rename($imageURL, $this->getUploadRootDir().'/'.$random_name.'_original.'.$this->ext);
    	//move temporaly to image name
    	rename($tmp_path, $imageURL);

        
        // clean up the file property as you won't need it anymore
        $this->file = null;
     }
     
     public function rotateImage( $degrees ){
     	
     	$imageURL = $this->getAbsolutePath();
     	if( is_null($this->ext) || $this->ext == "" ){
	     	$fparts = pathinfo($imageURL);
	     	if(!isset($fparts['extension'])){
	     		return;
	     	}
	     	$ext = strtolower($fparts['extension']);
	     	$this->ext = $ext;
     	}
        $image = null;
        if(getimagesize($imageURL)){
        
        	if ($this->ext == 'gif'){
        		$image = imagecreatefromgif($imageURL);
        	}else if ($this->ext == 'png'){
        		$image = imagecreatefrompng($imageURL);
        	}else if ($this->ext == 'jpg' || $this->ext == 'jpeg'){
        		$image = imagecreatefromjpeg($imageURL);
        	}
        }
        if(is_null($image)){
        	return false;
        }
        
       	$width = imagesx($image);
    	$height = imagesy($image);
    	$side = $width > $height ? $width : $height;
    	$imageSquare = imagecreatetruecolor($side, $side);
    	imagecopy($imageSquare, $image, 0, 0, 0, 0, $width, $height);
    	imagedestroy($image);
    	$imageSquare = imagerotate($imageSquare, $degrees, 0, -1);
    	$image = imagecreatetruecolor($height, $width);
    	$x = $degrees == 90 ? 0 : ($height > $width ? 0 : ($side - $height));
    	$y = $degrees == 270 ? 0 : ($height < $width ? 0 : ($side - $width));
    	imagecopy($image, $imageSquare, 0, 0, $x, $y, $height, $width);
    	imagedestroy($imageSquare);
    	
    	$tmp_path = sys_get_temp_dir(  )."/tmp_file.".$this->ext;
    	if ($this->ext == 'gif'){
    		imagegif($image, $tmp_path);
    	}else if ($this->ext == 'png'){
    		imagepng($image, $tmp_path,1);
    	}else if ($this->ext == 'jpg' || $this->ext == 'jpeg'){
    		imagejpeg($image, $tmp_path);
    	}
    	
    	//move temporaly to image name
    	rename($imageURL, str_replace(".".$this->ext,"_original.".$this->ext,$imageURL));
    	//move temporaly to image name
    	rename($tmp_path, $imageURL);
    	
     	
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
         return 'images/gallery';
     }

     public function deleteFile()
     {
         $path = $this->getUploadRootDir().'/'.$this->path;
         $fparts = pathinfo($path);
         if(isset($fparts['extension'])){
         	$ext = strtolower($fparts['extension']);
         	$path2 = str_replace(".".$ext,"_original.".$ext,$path);
         	if(file_exists ($path2)){
	           unlink($path2);
	         }
         }
         if(file_exists ($path)){
           unlink($path);
         }
     }
}
