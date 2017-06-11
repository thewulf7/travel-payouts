<?php

namespace thewulf7\travelPayouts\entity;


/**
 * Class Airport
 *
 * @package thewulf7\travelPayouts\entity
 */
class HotelSmall
{
    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_label;

    /**
     * @var string
     */
    private $_locationName;

    /**
     * @var int
     */
    private $_locationId;

    /**
     * @var string
     */
    private $_fullName;

    /**
     * @var array
     */
    private $_location = [];

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
     * @return HotelSmall
     */
    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * Get Label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return HotelSmall
     */
    public function setLabel($label)
    {
        $this->_label = $label;

        return $this;
    }

    /**
     * Get LocationName
     *
     * @return string
     */
    public function getLocationName()
    {
        return $this->_locationName;
    }

    /**
     * Set locationName
     *
     * @param string $locationName
     *
     * @return HotelSmall
     */
    public function setLocationName($locationName)
    {
        $this->_locationName = $locationName;

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
     * @return HotelSmall
     */
    public function setFullName($fullName)
    {
        $this->_fullName = $fullName;

        return $this;
    }

    /**
     * Get Location
     *
     * @return array
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * Set location
     *
     * @param array $location
     *
     * @return HotelSmall
     */
    public function setLocation($location)
    {
        $this->_location = $location;

        return $this;
    }

    /**
     * Get LocationId
     *
     * @return int
     */
    public function getLocationId()
    {
        return $this->_locationId;
    }

    /**
     * Set locationId
     *
     * @param int $locationId
     *
     * @return HotelSmall
     */
    public function setLocationId($locationId)
    {
        $this->_locationId = $locationId;

        return $this;
    }
}