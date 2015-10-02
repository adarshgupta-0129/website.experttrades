<?php

namespace AppBundle\Entity\AboutUs;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AppBundle\Entity\AboutUs\AboutUs
 * @ORM\Table(name="about_us")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AboutUs\AboutUsRepository")
 */
class AboutUs{

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
     * @var string $header_text
     *
     * @ORM\Column(name="header_text", type="text", length=25555, nullable=true)
     */
    private $header_text;

    /**
     * @var string $header_title
     *
     * @ORM\Column(name="header_title", type="text", length=2555, nullable=true)
     */
    private $header_title;

    /**
     * @var string $about_us_title
     *
     * @ORM\Column(name="about_us_title", type="text", length=2555, nullable=true)
     */
    private $about_us_title;

    /**
     * @var string $about_us_text
     *
     * @ORM\Column(name="about_us_text", type="text", length=25555, nullable=true)
     */
    private $about_us_text;

    /**
     * @var string $about_us_first_point_title
     *
     * @ORM\Column(name="about_us_first_point_title", type="text", length=2555, nullable=true)
     */
    private $about_us_first_point_title;

    /**
     * @var string $about_us_first_point_text
     *
     * @ORM\Column(name="about_us_first_point_text", type="text", length=25555, nullable=true)
     */
    private $about_us_first_point_text;

    /**
     * @var string $about_us_first_point_image
     *
     * @ORM\Column(name="about_us_first_point_image", type="text", length=2555, nullable=true)
     */
    private $about_us_first_point_image;

    /**
     * @var string $about_us_second_point_title
     *
     * @ORM\Column(name="about_us_second_point_title", type="text", length=2555, nullable=true)
     */
    private $about_us_second_point_title;

    /**
     * @var string $about_us_second_point_text
     *
     * @ORM\Column(name="about_us_second_point_text", type="text", length=25555, nullable=true)
     */
    private $about_us_second_point_text;

    /**
     * @var string $about_us_second_point_image
     *
     * @ORM\Column(name="about_us_second_point_image", type="text", length=2555, nullable=true)
     */
    private $about_us_second_point_image;

    /**
     * @var string $about_us_third_point_title
     *
     * @ORM\Column(name="about_us_third_point_title", type="text", length=2555, nullable=true)
     */
    private $about_us_third_point_title;

    /**
     * @var string $about_us_third_point_text
     *
     * @ORM\Column(name="about_us_third_point_text", type="text", length=25555, nullable=true)
     */
    private $about_us_third_point_text;

    /**
     * @var string $about_us_third_point_image
     *
     * @ORM\Column(name="about_us_third_point_image", type="text", length=2555, nullable=true)
     */
    private $about_us_third_point_image;

    /**
     * @var string $statistics_title
     *
     * @ORM\Column(name="statistics_title", type="text", length=2555, nullable=true)
     */
    private $statistics_title;

    /**
     * @var string $statistics_first_box_number
     *
     * @ORM\Column(name="statistics_first_box_number", type="text", length=2555, nullable=true)
     */
    private $statistics_first_box_number;

    /**
     * @var string $statistics_first_box_text
     *
     * @ORM\Column(name="statistics_first_box_text", type="text", length=2555, nullable=true)
     */
    private $statistics_first_box_text;


    /**
     * @var string $statistics_second_box_number
     *
     * @ORM\Column(name="statistics_second_box_number", type="text", length=2555, nullable=true)
     */
    private $statistics_second_box_number;

    /**
     * @var string $statistics_second_box_text
     *
     * @ORM\Column(name="statistics_second_box_text", type="text", length=2555, nullable=true)
     */
    private $statistics_second_box_text;

    /**
     * @var string $statistics_third_box_number
     *
     * @ORM\Column(name="statistics_third_box_number", type="text", length=2555, nullable=true)
     */
    private $statistics_third_box_number;

    /**
     * @var string $statistics_third_box_text
     *
     * @ORM\Column(name="statistics_third_box_text", type="text", length=2555, nullable=true)
     */
    private $statistics_third_box_text;

    /**
     * @var string $statistics_fourth_box_number
     *
     * @ORM\Column(name="statistics_fourth_box_number", type="text", length=2555, nullable=true)
     */
    private $statistics_fourth_box_number;

    /**
     * @var string $statistics_fourth_box_text
     *
     * @ORM\Column(name="statistics_fourth_box_text", type="text", length=2555, nullable=true)
     */
    private $statistics_fourth_box_text;

    /**
     * @var string $team_title
     *
     * @ORM\Column(name="team_title", type="text", length=2555, nullable=true)
     */
    private $team_title;

    /**
     * @var string $team_subtitle
     *
     * @ORM\Column(name="team_subtitle", type="text", length=25555, nullable=true)
     */
    private $team_subtitle;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;

    /**
     * @var string $meta_title
     *
     * @ORM\Column(name="meta_title", type="text", length=2555, nullable=true)
     */
    private $meta_title;

    /**
     * @var string $meta_description
     *
     * @ORM\Column(name="meta_description", type="text", length=2555, nullable=true)
     */
    private $meta_description;

    public function __construct(){

    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
     * Set header_title
     *
     * @param string $header_title
     */
    public function setHeaderTitle($header_title)
    {
        $this->header_title = $header_title;
    }

    /**
     * Get header_title
     *
     * @return string
     */
    public function getHeaderTitle()
    {
        return $this->header_title;
    }

    /**
     * Set header_text
     *
     * @param string $header_text
     */
    public function setHeaderText($header_text)
    {
        $this->header_text = $header_text;
    }

    /**
     * Get header_text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return $this->header_text;
    }

    /**
     * Set about_us_title
     *
     * @param string $about_us_title
     */
    public function setAboutUsTitle($about_us_title)
    {
        $this->about_us_title = $about_us_title;
    }

    /**
     * Get about_us_title
     *
     * @return string
     */
    public function getAboutUsTitle()
    {
        return $this->about_us_title;
    }

    /**
     * Set about_us_text
     *
     * @param string $about_us_text
     */
    public function setAboutUsText($about_us_text)
    {
        $this->about_us_text = $about_us_text;
    }

    /**
     * Get about_us_text
     *
     * @return string
     */
    public function getAboutUsText()
    {
        return $this->about_us_text;
    }

    /**
     * Set about_us_first_point_title
     *
     * @param string $about_us_first_point_title
     */
    public function setAboutUsFirstPointTitle($about_us_first_point_title)
    {
        $this->about_us_first_point_title = $about_us_first_point_title;
    }

    /**
     * Get about_us_first_point_title
     *
     * @return string
     */
    public function getAboutUsFirstPointTitle()
    {
        return $this->about_us_first_point_title;
    }

    /**
     * Set about_us_first_point_text
     *
     * @param string $about_us_first_point_text
     */
    public function setAboutUsFirstPointText($about_us_first_point_text)
    {
        $this->about_us_first_point_text = $about_us_first_point_text;
    }

    /**
     * Get about_us_first_point_text
     *
     * @return string
     */
    public function getAboutUsFirstPointText()
    {
        return $this->about_us_first_point_text;
    }

    /**
     * Set about_us_first_point_image
     *
     * @param string $about_us_first_point_image
     */
    public function setAboutUsFirstPointImage($about_us_first_point_image)
    {
        $this->about_us_first_point_image = $about_us_first_point_image;
    }

    /**
     * Get about_us_first_point_image
     *
     * @return string
     */
    public function getAboutUsFirstPointImage()
    {
        return $this->about_us_first_point_image;
    }

    /**
     * Set about_us_second_point_title
     *
     * @param string $about_us_second_point_title
     */
    public function setAboutUsSecondPointTitle($about_us_second_point_title)
    {
        $this->about_us_second_point_title = $about_us_second_point_title;
    }

    /**
     * Get about_us_second_point_title
     *
     * @return string
     */
    public function getAboutUsSecondPointTitle()
    {
        return $this->about_us_second_point_title;
    }

    /**
     * Set about_us_second_point_text
     *
     * @param string $about_us_second_point_text
     */
    public function setAboutUsSecondPointText($about_us_second_point_text)
    {
        $this->about_us_second_point_text = $about_us_second_point_text;
    }

    /**
     * Get about_us_second_point_text
     *
     * @return string
     */
    public function getAboutUsSecondPointText()
    {
        return $this->about_us_second_point_text;
    }

    /**
     * Set about_us_second_point_image
     *
     * @param string $about_us_second_point_image
     */
    public function setAboutUsSecondPointImage($about_us_second_point_image)
    {
        $this->about_us_second_point_image = $about_us_second_point_image;
    }

    /**
     * Get about_us_second_point_image
     *
     * @return string
     */
    public function getAboutUsSecondPointImage()
    {
        return $this->about_us_second_point_image;
    }

    /**
     * Set about_us_third_point_title
     *
     * @param string $about_us_third_point_title
     */
    public function setAboutUsThirdPointTitle($about_us_third_point_title)
    {
        $this->about_us_third_point_title = $about_us_third_point_title;
    }

    /**
     * Get about_us_third_point_title
     *
     * @return string
     */
    public function getAboutUsThirdPointTitle()
    {
        return $this->about_us_third_point_title;
    }

    /**
     * Set about_us_third_point_text
     *
     * @param string $about_us_third_point_text
     */
    public function setAboutUsThirdPointText($about_us_third_point_text)
    {
        $this->about_us_third_point_text = $about_us_third_point_text;
    }

    /**
     * Get about_us_third_point_text
     *
     * @return string
     */
    public function getAboutUsThirdPointText()
    {
        return $this->about_us_third_point_text;
    }

    /**
     * Set about_us_third_point_image
     *
     * @param string $about_us_third_point_image
     */
    public function setAboutUsThirdPointImage($about_us_third_point_image)
    {
        $this->about_us_third_point_image = $about_us_third_point_image;
    }

    /**
     * Get about_us_third_point_image
     *
     * @return string
     */
    public function getAboutUsThirdPointImage()
    {
        return $this->about_us_third_point_image;
    }

    /**
     * Set statistics_title
     *
     * @param string $statistics_title
     */
    public function setStatisticsTitle($statistics_title)
    {
        $this->statistics_title = $statistics_title;
    }

    /**
     * Get statistics_title
     *
     * @return string
     */
    public function getStatisticsTitle()
    {
        return $this->statistics_title;
    }

    /**
     * Set statistics_first_box_number
     *
     * @param string $statistics_first_box_number
     */
    public function setStatisticsFirstBoxNumber($statistics_first_box_number)
    {
        $this->statistics_first_box_number = $statistics_first_box_number;
    }

    /**
     * Get statistics_first_box_number
     *
     * @return string
     */
    public function getStatisticsFirstBoxNumber()
    {
        return $this->statistics_first_box_number;
    }

    /**
     * Set statistics_first_box_text
     *
     * @param string $statistics_first_box_text
     */
    public function setStatisticsFirstBoxText($statistics_first_box_text)
    {
        $this->statistics_first_box_text = $statistics_first_box_text;
    }

    /**
     * Get statistics_first_box_text
     *
     * @return string
     */
    public function getStatisticsFirstBoxText()
    {
        return $this->statistics_first_box_text;
    }

    /**
     * Set statistics_second_box_number
     *
     * @param string $statistics_second_box_number
     */
    public function setStatisticsSecondBoxNumber($statistics_second_box_number)
    {
        $this->statistics_second_box_number = $statistics_second_box_number;
    }

    /**
     * Get statistics_second_box_number
     *
     * @return string
     */
    public function getStatisticsSecondBoxNumber()
    {
        return $this->statistics_second_box_number;
    }

    /**
     * Set statistics_second_box_text
     *
     * @param string $statistics_second_box_text
     */
    public function setStatisticsSecondBoxText($statistics_second_box_text)
    {
        $this->statistics_second_box_text = $statistics_second_box_text;
    }

    /**
     * Get statistics_second_box_text
     *
     * @return string
     */
    public function getStatisticsSecondBoxText()
    {
        return $this->statistics_second_box_text;
    }

    /**
     * Set statistics_second_box_number
     *
     * @param string $statistics_third_box_number
     */
    public function setStatisticsThirdBoxNumber($statistics_third_box_number)
    {
        $this->statistics_third_box_number = $statistics_third_box_number;
    }

    /**
     * Get statistics_third_box_number
     *
     * @return string
     */
    public function getStatisticsThirdBoxNumber()
    {
        return $this->statistics_third_box_number;
    }

    /**
     * Set statistics_third_box_text
     *
     * @param string $statistics_third_box_text
     */
    public function setStatisticsThirdBoxText($statistics_third_box_text)
    {
        $this->statistics_third_box_text = $statistics_third_box_text;
    }

    /**
     * Get statistics_third_box_text
     *
     * @return string
     */
    public function getStatisticsThirdBoxText()
    {
        return $this->statistics_third_box_text;
    }



    /**
     * Set statistics_fourth_box_number
     *
     * @param string $statistics_fourth_box_number
     */
    public function setStatisticsFourthBoxNumber($statistics_fourth_box_number)
    {
        $this->statistics_fourth_box_number = $statistics_fourth_box_number;
    }

    /**
     * Get statistics_fourth_box_number
     *
     * @return string
     */
    public function getStatisticsFourthBoxNumber()
    {
        return $this->statistics_fourth_box_number;
    }

    /**
     * Set statistics_fourth_box_text
     *
     * @param string $statistics_fourth_box_text
     */
    public function setStatisticsFourthBoxText($statistics_fourth_box_text)
    {
        $this->statistics_fourth_box_text = $statistics_fourth_box_text;
    }

    /**
     * Get statistics_fourth_box_text
     *
     * @return string
     */
    public function getStatisticsFourthBoxText()
    {
        return $this->statistics_fourth_box_text;
    }

    /**
     * Set team_title
     *
     * @param string $team_title
     */
    public function setTeamTitle($team_title)
    {
        $this->team_title = $team_title;
    }

    /**
     * Get team_title
     *
     * @return string
     */
    public function getTeamTitle()
    {
        return $this->team_title;
    }

    /**
     * Set team_subtitle
     *
     * @param string $team_subtitle
     */
    public function setTeamSubtitle($team_subtitle)
    {
        $this->team_subtitle = $team_subtitle;
    }

    /**
     * Get team_subtitle
     *
     * @return string
     */
    public function getTeamSubtitle()
    {
        return $this->team_subtitle;
    }

    /**
     * Get meta_title
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * Set meta_description
     *
     * @param string $meta_description
     */
    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;
    }

    /**
     * Get meta_description
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
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
         return __DIR__.'/../../../../web/'.$this->getUploadDir();
     }

     protected function getUploadDir()
     {
         // get rid of the __DIR__ so it doesn't screw up
         // when displaying uploaded doc/image in the view.
         return 'images/about_us';
     }

     public function deleteFile()
     {
         $path = $this->getUploadRootDir().'/'.$this->path;
         if(file_exists ($path)){
           unlink($path);
         }
     }
}
