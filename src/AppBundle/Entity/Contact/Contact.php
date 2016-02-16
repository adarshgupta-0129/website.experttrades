<?php

namespace AppBundle\Entity\Contact;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\Contact\Contact
 * @ORM\Table(name="contact")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Contact\ContactRepository")
 */
class Contact{

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
     * @var string $address_first_line
     *
     * @ORM\Column(name="address_first_line", type="text", length=2555, nullable=true)
     */
    private $address_first_line;

    /**
     * @var string $address_second_line
     *
     * @ORM\Column(name="address_second_line", type="text", length=2555, nullable=true)
     */
    private $address_second_line;

    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="text", length=2555, nullable=true)
     */
    private $phone;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="text", length=2555, nullable=true)
     */
    private $email;

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
     * Set address_first_line
     *
     * @param string $address_first_line
     */
    public function setAddressFirstLine($address_first_line)
    {
        $this->address_first_line = $address_first_line;
    }

    /**
     * Get address_first_line
     *
     * @return string
     */
    public function getAddressFirstLine()
    {
        return $this->address_first_line;
    }

    /**
     * Set address_second_line
     *
     * @param string $address_second_line
     */
    public function setAddressSecondLine($address_second_line)
    {
        $this->address_second_line = $address_second_line;
    }

    /**
     * Get address_second_line
     *
     * @return string
     */
    public function getAddressSecondLine()
    {
        return $this->address_second_line;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set meta_title
     *
     * @param string $meta_title
     */
    public function setMetaTitle($meta_title)
    {
        $this->meta_title = $meta_title;
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

}
