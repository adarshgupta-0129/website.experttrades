<?php

namespace AppBundle\Entity\Gallery\Tag;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation\Exclude;

/**
 * AppBundle\Entity\Gallery\Tag\ItemTag
 * @ORM\Table(name="item_tag_relation")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Gallery\Tag\ItemTagRepository")
 */
class ItemTag implements ItemTagInterface{

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
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Gallery\Item\Item" , inversedBy="item_tags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     * @EXCLUDE
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Gallery\Tag\Tag", inversedBy="tag_items")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="CASCADE")
     * */
    private $tag;



    /**
     * Get id
     *
     * @return Id $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get customer
     *
     * @return AppBundle\Entity\Gallery\Item\Item $item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set customer
     *
     * @return AppBundle\Entity\Gallery\Item\Item $item
     */
    public function setItem(\AppBundle\Entity\Gallery\Item\Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get tag
     *
     * @return AppBundle\Entity\Gallery\Tag\Tag $tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set tag
     *
     * @return AppBundle\Entity\Gallery\Tag\Tag $tag
     */
    public function setTag(\AppBundle\Entity\Gallery\Tag\Tag $tag)
    {
        $this->tag = $tag;
    }


}
