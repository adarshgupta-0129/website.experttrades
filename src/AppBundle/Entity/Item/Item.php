<?php

namespace AppBundle\Entity\Item;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * AppBundle\Entity\Item
 * @ORM\Table(name="website_item")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Item\ItemRepository")
 */
class Item{

	const  ITEM_PDF = 'pdf';
	const  ITEM_IMAGE = 'img';
	const  ITEM_ZIP = 'zip';
	const  ITEM_ICON = 'icon';
	
	const  STORE_HEADER = 'headers';
	const  STORE_SOCIAL_FB = 'social_fb';
	const  STORE_SOCIAL_TWITTER = 'social_tt';
	const  STORE_FAVICON = 'favicon';

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
			'tif'  => 'image/tiff'
			),
			self::ITEM_PDF => array (
					'pdf'  => 'application/pdf'
			),
			self::ITEM_ICON => array (
				'png'  => 'image/png',
				'gif'  => 'image/gif',
				'ico2'  => 'image/x-icon',
				'ico'  => 'image/vnd.microsoft.icon'
			),
			self::ITEM_ZIP => array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed')
		];
	
	public static $STORECONFIG = [
			self::STORE_HEADER => array (
				'folder'  => 'headers',
				'quantity'  => 'unique',
				'access'  => 'admin',
				'type'  => self::ITEM_ZIP
			),
			self::STORE_SOCIAL_FB => array (
				'width'  => '1200',
				'height'  => '630',
				'folder'  => 'social',
				'name'  => 'social_fb',
				'quantity'  => 'unique',
				'type'  => self::ITEM_IMAGE
			),
			self::STORE_SOCIAL_TWITTER => array (
				'width'  => '1000',
				'height'  => '500',
				'folder'  => 'social',
				'name'  => 'social_tt',
				'quantity'  => 'unique',
				'type'  => self::ITEM_IMAGE
			),
			self::STORE_FAVICON => array (
				'width'  => '32',
				'height'  => '32',
				'folder'  => 'logo',
				'name'  => 'favicon',
				'quantity'  => 'unique',
				'type'  => self::ITEM_ICON
			)
		];

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
     * @var boolean $featured
     *
     * @ORM\Column(name="featured", type="boolean",  nullable=true)
     */
    private $featured;


    /**
     * @var type $type
     *
     * @ORM\Column(name="type", type="string", length=4,  nullable=true)
     */
    private $type;

    /**
     * @var type $featured
     *
     * @ORM\Column(name="storage", type="string", length=10,  nullable=true)
     */
    private $storage;

    /**
     * @var string $order
     *
     * @ORM\Column(name="ordering", type="smallint", options={"default" = 0})
     */
    private $order;

    /**
     * @var string $width
     *
     * @ORM\Column(name="width", type="smallint", options={"default" = 630})
     */
    private $width;

    /**
     * @var string $height
     *
     * @ORM\Column(name="height", type="smallint", options={"default" = 420})
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

    public function __construct($type)
    {
    	/*$this->width = 0;
    	$this->height = 0;*/
    	$this->order = 0;
    	$this->featured = false;
    	if(array_key_exists(strtolower($type), self::$STORECONFIG) !== FALSE ){
    		$this->storage = $type;
    		$this->type = self::$STORECONFIG[$this->storage]['type'];
    	} else {
    		throw new \Exception('The '.$type.' type is invalid');
    	}
    	if(array_key_exists(strtolower($this->type), self::$MIMETYPE) === FALSE ){
    		throw new \Exception('The '.$type.' type is invalid');
    	} 
    	if( isset( self::$STORECONFIG[$this->storage]['width']) )$this->width = self::$STORECONFIG[$this->storage]['width'];
    	else $this->width = 0;
    	if( isset( self::$STORECONFIG[$this->storage]['height']) )$this->height = self::$STORECONFIG[$this->storage]['height'];
    	else $this->height = 0;

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



    public function getType() {
    	return $this->type;
    }
    public function setType($type) {
    	$this->type = $type;
    	return $this;
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
		//check document type
		
    	if( !in_array($this->getFile()->getMimeType(), self::$MIMETYPE[$this->type]) ){
    		throw new \Exception('The '.$this->getFile()->getMimeType().' format is invalid');
    	}
    	// use the original file name here but you should
    	// sanitize it at least to avoid any security issues
    	$random_name = substr( md5(rand()), 0, 15);
    	$ext = strtolower($this->getFile()->guessExtension());
    	$this->ext = $ext;
    	if( isset(self::$STORECONFIG[$this->storage]['name']) && self::$STORECONFIG[$this->storage]['name'] == 'random' ){
    		$filename = $random_name.'.'.$this->ext;
    	} elseif( isset(self::$STORECONFIG[$this->storage]['name']) ) {
    		$filename = self::$STORECONFIG[$this->storage]['name'].'.'.$this->ext;
    	} else {
    		$filename = $random_name.'-'.$this->getFile()->getClientOriginalName();
    	}
    	// move takes the target directory and then the
    	// target filename to move to

    	if(!file_exists($this->getUploadRootDir())) mkdir($this->getUploadRootDir());
    	
    	$this->getFile()->move(
    			$this->getUploadRootDir(),
    			$filename
    			);
    	// set the path property to the filename where you've saved the file
    	$this->path = $filename;
    	if( $this->type === self::ITEM_IMAGE  
    			&& isset(self::$STORECONFIG[$this->storage]['width']) && is_numeric(self::$STORECONFIG[$this->storage]['width'])
    			&& isset(self::$STORECONFIG[$this->storage]['height']) && is_numeric(self::$STORECONFIG[$this->storage]['height'])
    			) 
    	{
    
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
	    	$final_width = self::$STORECONFIG[$this->storage]['width'];
	    	$final_height = self::$STORECONFIG[$this->storage]['height'];
	    	
	    	$width = imagesx($img);
	    	$height = imagesy($img);
	    	$new_width = $width;
	    	$new_height = $height;
	    	$this->width = $width;
	    	$this->height = $height;
	    	if( $final_width > $final_height ){
	    		$max = $final_width;
	    		if( $height > $width ){
	    			$max_height = $final_width;
	    			$max_width = $final_height;
	    		}else{
	    			$max_height = $final_height;
	    			$max_width = $final_width;
	    		}
	    	} else {
	    		$max = $final_height;
	    		if( $height > $width ){
	    			$max_height = $final_width;
	    			$max_width = $final_height;
	    		}else{
	    			$max_height = $final_height;
	    			$max_width = $final_width;
	    		}
	    	}
	    	$this->width = $max_width;
	    	$this->height = $max_height;
	    	if( ($height > $width && $height < $max) || ($height < $width && $width < $max)  ){
	    		return;
	    	}
	    	if($width == $final_width || $height == $final_height){
	    		return;
	    	}
	    
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
	    	$tmp_img = imagecreatetruecolor( $new_width, $new_height );
	    
	    	// copy and resize old image into new image
	    	imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	    	 
	    	//$tmp_img = imagescale($img, $new_width, $new_height);
	    	 
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
    	} 
    	else if( $this->type === self::ITEM_ZIP) 
    	{
    			$zip = new \ZipArchive();
    			$x = $zip->open($this->getAbsolutePath());  // open the zip file to extract
    			if ($x === true) {
    				$zip->extractTo($this->getUploadRootDir()); // place in the directory with same name
    				$zip->close();
    		
    				unlink($this->getAbsolutePath());
    			}
    	}
    
    
    	// clean up the file property as you won't need it anymore
    	$this->file = null;
    }
     
    public function rotateImage( $degrees ){

	    if( $this->type === self::ITEM_IMAGE ) {
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
	    	 
	    	if($degrees != 180){
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
	    		$this->width = $height;
	    		$this->height = $width;
	    	} else {
	    		$image = imagerotate($image, $degrees, 0);
	    		$this->width = $width;
	    		$this->height = $height;
	    	}
	    	 
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
    	return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
    	// get rid of the __DIR__ so it doesn't screw up
    	// when displaying uploaded doc/image in the view.
    	
    	return 'images/'.self::$STORECONFIG[$this->storage]['folder'];
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
	public function getStorage() {
		return $this->storage;
	}
	public function setStorage($storage) {
		$this->storage = $storage;
		return $this;
	}
	
    
}
