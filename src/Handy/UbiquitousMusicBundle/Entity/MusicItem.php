<?php

namespace Handy\UbiquitousMusicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MusicItem
 */
class MusicItem
{
    /**
     * @var string
     */
    private $muiName;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Handy\UbiquitousMusicBundle\Entity\MusicItem
     */
    private $muiMuiParent;
    
    public function __toString()
    {
        return $this->muiName;
    }


    /**
     * Set muiName
     *
     * @param string $muiName
     * @return MusicItem
     */
    public function setMuiName($muiName)
    {
        $this->muiName = $muiName;

        return $this;
    }

    /**
     * Get muiName
     *
     * @return string 
     */
    public function getMuiName()
    {
        return $this->muiName;
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
     * Set muiMuiParent
     *
     * @param \Handy\UbiquitousMusicBundle\Entity\MusicItem $muiMuiParent
     * @return MusicItem
     */
    public function setMuiMuiParent(\Handy\UbiquitousMusicBundle\Entity\MusicItem $muiMuiParent = null)
    {
        $this->muiMuiParent = $muiMuiParent;

        return $this;
    }

    /**
     * Get muiMuiParent
     *
     * @return \Handy\UbiquitousMusicBundle\Entity\MusicItem 
     */
    public function getMuiMuiParent()
    {
        return $this->muiMuiParent;
    }
    /**
     * @var boolean
     */
    private $muiIsDirectory;


    /**
     * Set muiIsDirectory
     *
     * @param boolean $muiIsDirectory
     * @return MusicItem
     */
    public function setMuiIsDirectory($muiIsDirectory)
    {
        $this->muiIsDirectory = $muiIsDirectory;

        return $this;
    }

    /**
     * Get muiIsDirectory
     *
     * @return boolean 
     */
    public function getMuiIsDirectory()
    {
        return $this->muiIsDirectory;
    }
    /**
     * @var integer
     */
    private $muiBitrate;

    /**
     * @var float
     */
    private $muiPlaytime;


    /**
     * Set muiBitrate
     *
     * @param integer $muiBitrate
     * @return MusicItem
     */
    public function setMuiBitrate($muiBitrate)
    {
        $this->muiBitrate = $muiBitrate;

        return $this;
    }

    /**
     * Get muiBitrate
     *
     * @return integer 
     */
    public function getMuiBitrate()
    {
        return $this->muiBitrate;
    }

    /**
     * Set muiPlaytime
     *
     * @param float $muiPlaytime
     * @return MusicItem
     */
    public function setMuiPlaytime($muiPlaytime)
    {
        $this->muiPlaytime = $muiPlaytime;

        return $this;
    }

    /**
     * Get muiPlaytime
     *
     * @return float 
     */
    public function getMuiPlaytime()
    {
        return $this->muiPlaytime;
    }
}
