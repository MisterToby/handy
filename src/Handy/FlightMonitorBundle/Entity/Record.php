<?php

namespace Handy\FlightMonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Record
 */
class Record
{
    /**
     * @var integer
     */
    private $recLowestOutboundPrice;

    /**
     * @var integer
     */
    private $recLowestInboundPrice;

    /**
     * @var \DateTime
     */
    private $recDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Handy\FlightMonitorBundle\Entity\Trip
     */
    private $recTri;


    /**
     * Set recLowestOutboundPrice
     *
     * @param integer $recLowestOutboundPrice
     * @return Record
     */
    public function setRecLowestOutboundPrice($recLowestOutboundPrice)
    {
        $this->recLowestOutboundPrice = $recLowestOutboundPrice;

        return $this;
    }

    /**
     * Get recLowestOutboundPrice
     *
     * @return integer 
     */
    public function getRecLowestOutboundPrice()
    {
        return $this->recLowestOutboundPrice;
    }

    /**
     * Set recLowestInboundPrice
     *
     * @param integer $recLowestInboundPrice
     * @return Record
     */
    public function setRecLowestInboundPrice($recLowestInboundPrice)
    {
        $this->recLowestInboundPrice = $recLowestInboundPrice;

        return $this;
    }

    /**
     * Get recLowestInboundPrice
     *
     * @return integer 
     */
    public function getRecLowestInboundPrice()
    {
        return $this->recLowestInboundPrice;
    }

    /**
     * Set recDate
     *
     * @param \DateTime $recDate
     * @return Record
     */
    public function setRecDate($recDate)
    {
        $this->recDate = $recDate;

        return $this;
    }

    /**
     * Get recDate
     *
     * @return \DateTime 
     */
    public function getRecDate()
    {
        return $this->recDate;
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
     * Set recTri
     *
     * @param \Handy\FlightMonitorBundle\Entity\Trip $recTri
     * @return Record
     */
    public function setRecTri(\Handy\FlightMonitorBundle\Entity\Trip $recTri = null)
    {
        $this->recTri = $recTri;

        return $this;
    }

    /**
     * Get recTri
     *
     * @return \Handy\FlightMonitorBundle\Entity\Trip 
     */
    public function getRecTri()
    {
        return $this->recTri;
    }
}
