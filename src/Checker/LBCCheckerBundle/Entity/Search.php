<?php

namespace Checker\LBCCheckerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Checker\LBCCheckerBundle\Entity\Search
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Checker\LBCCheckerBundle\Entity\SearchRepository")
 */
class Search
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=500)
     */
    private $url;

    /**
     * @var integer $checkingInterval
     *
     * @ORM\Column(name="checkingInterval", type="integer")
     */
    private $checkingInterval;

    /**
     * @var integer $maxPrice
     *
     * @ORM\Column(name="maxPrice", type="integer")
     */
    private $maxPrice;

    /**
     * @var integer $minPrice
     *
     * @ORM\Column(name="minPrice", type="integer")
     */
    private $minPrice;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime $lastCheckingDate
     *
     * @ORM\Column(name="lastCheckingDate", type="datetime")
     */
    private $lastCheckingDate;

    /**
     * @var boolean $enabled
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;


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
     * Set url
     *
     * @param string $url
     * @return Search
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set checkingInterval
     *
     * @param integer $checkingInterval
     * @return Search
     */
    public function setCheckingInterval($checkingInterval)
    {
        $this->checkingInterval = $checkingInterval;
    
        return $this;
    }

    /**
     * Get checkingInterval
     *
     * @return integer 
     */
    public function getCheckingInterval()
    {
        return $this->checkingInterval;
    }

    /**
     * Set maxPrice
     *
     * @param integer $maxPrice
     * @return Search
     */
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;
    
        return $this;
    }

    /**
     * Get maxPrice
     *
     * @return integer 
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set minPrice
     *
     * @param integer $minPrice
     * @return Search
     */
    public function setMinPrice($minPrice)
    {
        $this->minPrice = $minPrice;
    
        return $this;
    }

    /**
     * Get minPrice
     *
     * @return integer 
     */
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Search
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastCheckingDate
     *
     * @param \DateTime $lastCheckingDate
     * @return Search
     */
    public function setLastCheckingDate($lastCheckingDate)
    {
        $this->lastCheckingDate = $lastCheckingDate;
    
        return $this;
    }

    /**
     * Get lastCheckingDate
     *
     * @return \DateTime 
     */
    public function getLastCheckingDate()
    {
        return $this->lastCheckingDate;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Search
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
}
