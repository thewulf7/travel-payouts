<?php

namespace thewulf7\travelPayouts\entity;


/**
 * Class HotelLocationSmall
 *
 * @package thewulf7\travelPayouts\entity
 */
class HotelLocationSmall
{
    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_type;

    /**
     * @var string
     */
    private $_countryIso;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_state;

    /**
     * @var string
     */
    private $_fullName;

    /**
     * @var array
     */
    private $_geo;

    /**
     * Get Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set id
     *
     * @param int $id
     *
     * @return HotelLocationSmall
     */
    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return HotelLocationSmall
     */
    public function setType($type)
    {
        $this->_type = $type;

        return $this;
    }

    /**
     * Get CountryIso
     *
     * @return string
     */
    public function getCountryIso()
    {
        return $this->_countryIso;
    }

    /**
     * Set countryIso
     *
     * @param string $countryIso
     *
     * @return HotelLocationSmall
     */
    public function setCountryIso($countryIso)
    {
        $this->_countryIso = $countryIso;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return HotelLocationSmall
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Get State
     *
     * @return string
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return HotelLocationSmall
     */
    public function setState($state)
    {
        $this->_state = $state;

        return $this;
    }

    /**
     * Get FullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->_fullName;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return HotelLocationSmall
     */
    public function setFullName($fullName)
    {
        $this->_fullName = $fullName;

        return $this;
    }

    /**
     * Get Geo
     *
     * @return array
     */
    public function getGeo()
    {
        return $this->_geo;
    }

    /**
     * Set geo
     *
     * @param array $geo
     *
     * @return HotelLocationSmall
     */
    public function setGeo($geo)
    {
        $this->_geo = $geo;

        return $this;
    }
}