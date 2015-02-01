<?php

namespace Handy\FlightMonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Airline
 */
class Airline
{
    /**
     * @var string
     */
    private $airName;

    /**
     * @var string
     */
    private $airUrl;

    /**
     * @var boolean
     */
    private $airPost;

    /**
     * @var integer
     */
    private $id;

    public function __toString()
    {
    	return $this->airName;
    }

    /**
     * Set airName
     *
     * @param string $airName
     * @return Airline
     */
    public function setAirName($airName)
    {
        $this->airName = $airName;

        return $this;
    }

    /**
     * Get airName
     *
     * @return string 
     */
    public function getAirName()
    {
        return $this->airName;
    }

    /**
     * Set airUrl
     *
     * @param string $airUrl
     * @return Airline
     */
    public function setAirUrl($airUrl)
    {
        $this->airUrl = $airUrl;

        return $this;
    }

    /**
     * Get airUrl
     *
     * @return string 
     */
    public function getAirUrl()
    {
        return $this->airUrl;
    }

    /**
     * Set airPost
     *
     * @param boolean $airPost
     * @return Airline
     */
    public function setAirPost($airPost)
    {
        $this->airPost = $airPost;

        return $this;
    }

    /**
     * Get airPost
     *
     * @return boolean 
     */
    public function getAirPost()
    {
        return $this->airPost;
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
