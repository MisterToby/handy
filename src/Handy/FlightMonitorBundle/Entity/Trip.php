<?php

namespace Handy\FlightMonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trip
 */
class Trip
{
    /**
     * @var string
     */
    private $triDescription;

    /**
     * @var string
     */
    private $triFields;

    /**
     * @var string
     */
    private $triProcessingMethod;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Handy\FlightMonitorBundle\Entity\Airline
     */
    private $triAir;


    /**
     * Set triDescription
     *
     * @param string $triDescription
     * @return Trip
     */
    public function setTriDescription($triDescription)
    {
        $this->triDescription = $triDescription;

        return $this;
    }

    /**
     * Get triDescription
     *
     * @return string 
     */
    public function getTriDescription()
    {
        return $this->triDescription;
    }

    /**
     * Set triFields
     *
     * @param string $triFields
     * @return Trip
     */
    public function setTriFields($triFields)
    {
        $this->triFields = $triFields;

        return $this;
    }

    /**
     * Get triFields
     *
     * @return string 
     */
    public function getTriFields()
    {
        return $this->triFields;
    }

    /**
     * Set triProcessingMethod
     *
     * @param string $triProcessingMethod
     * @return Trip
     */
    public function setTriProcessingMethod($triProcessingMethod)
    {
        $this->triProcessingMethod = $triProcessingMethod;

        return $this;
    }

    /**
     * Get triProcessingMethod
     *
     * @return string 
     */
    public function getTriProcessingMethod()
    {
        return $this->triProcessingMethod;
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
     * Set triAir
     *
     * @param \Handy\FlightMonitorBundle\Entity\Airline $triAir
     * @return Trip
     */
    public function setTriAir(\Handy\FlightMonitorBundle\Entity\Airline $triAir = null)
    {
        $this->triAir = $triAir;

        return $this;
    }

    /**
     * Get triAir
     *
     * @return \Handy\FlightMonitorBundle\Entity\Airline 
     */
    public function getTriAir()
    {
        return $this->triAir;
    }
}
