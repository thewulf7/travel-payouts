<?php

namespace thewulf7\travelPayouts\entity;


/**
 * Class HotelLocation
 *
 * @package thewulf7\travelPayouts\entity
 */
class HotelLocation
{
    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_cityName;

    /**
     * @var string
     */
    private $_fullName;

    /**
     * @var array
     */
    private $_iata;

    /**
     * @var string
     */
    private $_countryCode;

    /**
     * @var string
     */
    private $_countryName;

    /**
     * @var int
     */
    private $_hotelsCount;

    /**
     * @var array
     */
    private $_location = [];

    /**
     * @var string
     */
    private $_score;

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
     * @return HotelLocation
     */
    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * Get CityName
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->_cityName;
    }

    /**
     * Set cityName
     *
     * @param string $cityName
     *
     * @return HotelLocation
     */
    public function setCityName($cityName)
    {
        $this->_cityName = $cityName;

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
     * @return HotelLocation
     */
    public function setFullName($fullName)
    {
        $this->_fullName = $fullName;

        return $this;
    }

    /**
     * Get Iata
     *
     * @return array
     */
    public function getIata()
    {
        return $this->_iata;
    }

    /**
     * Set iata
     *
     * @param array $iata
     *
     * @return HotelLocation
     */
    public function setIata($iata)
    {
        $this->_iata = $iata;

        return $this;
    }

    /**
     * Get CountryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->_countryCode;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return HotelLocation
     */
    public function setCountryCode($countryCode)
    {
        $this->_countryCode = $countryCode;

        return $this;
    }

    /**
     * Get CountryName
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->_countryName;
    }

    /**
     * Set countryName
     *
     * @param string $countryName
     *
     * @return HotelLocation
     */
    public function setCountryName($countryName)
    {
        $this->_countryName = $countryName;

        return $this;
    }

    /**
     * Get HotelsCount
     *
     * @return int
     */
    public function getHotelsCount()
    {
        return $this->_hotelsCount;
    }

    /**
     * Set hotelsCount
     *
     * @param int $hotelsCount
     *
     * @return HotelLocation
     */
    public function setHotelsCount($hotelsCount)
    {
        $this->_hotelsCount = $hotelsCount;

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
     * @return HotelLocation
     */
    public function setLocation($location)
    {
        $this->_location = $location;

        return $this;
    }

    /**
     * Get Score
     *
     * @return string
     */
    public function getScore()
    {
        return $this->_score;
    }

    /**
     * Set score
     *
     * @param string $score
     *
     * @return HotelLocation
     */
    public function setScore($score)
    {
        $this->_score = $score;

        return $this;
    }
}