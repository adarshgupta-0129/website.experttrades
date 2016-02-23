<?php

namespace AppBundle\Entity\QuoteRequest\JobCategory;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\QuoteRequest\JobCategory\JobCategory
 * @ORM\Table(name="quote_request_job_category")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuoteRequest\JobCategory\JobCategoryRepository")
 */
class JobCategory{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\QuoteRequest\QuoteRequest", inversedBy="job_categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quote_request_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     * })
     */
    private $quote_request;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobCategory\JobCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_category_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     * })
     */
    private $job_category;

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
     * Get quote_request
     *
     * @return \AppBundle\Entity\QuoteRequest\QuoteRequest $quote_request
     */
    public function getQuoteRequest()
    {
        return $this->quote_request;
    }

    /**
     * Set quote_request
     *
     * @return \AppBundle\Entity\QuoteRequest\QuoteRequest $quote_request
     */
    public function setQuoteRequest(\AppBundle\Entity\QuoteRequest\QuoteRequest $quote_request)
    {
        $this->quote_request = $quote_request;
    }

    /**
     * Get job_category
     *
     * @return \AppBundle\Entity\JobCategory\JobCategory $job_category
     */
    public function getJobCategory()
    {
        return $this->job_category;
    }

    /**
     * Set job_category
     *
     * @return \AppBundle\Entity\JobCategory\JobCategory $job_category
     */
    public function setJobCategory(\AppBundle\Entity\JobCategory\JobCategory $job_category)
    {
        $this->job_category = $job_category;
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
}
