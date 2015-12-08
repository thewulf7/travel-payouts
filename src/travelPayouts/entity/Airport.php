<?php
namespace travelPayouts\entity;


/**
 * Class Airport
 *
 * @package travelPayouts\entity
 */
class Airport
{
    /**
     * @var string
     */
    private $_iata;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var array
     */
    private $_coordinates = [];

    /**
     * @var string
     */
    private $_timeZone;

    /**
     * @var array
     */
    private $_nameTranslations = [];

    /**
     * @var City
     */
    private $_city;

    /**
     * @param string $iataCode
     */
    public function __construct($iataCode = '')
    {
        if ($iataCode !== '')
        {
            $this->setIata($iataCode);
        }
    }

    /**
     * Get Iata
     *
     * @return string
     */
    public function getIata()
    {
        return $this->_iata;
    }

    /**
     * Set iata
     *
     * @param string $iata
     *
     * @return Airport
     */
    public function setIata($iata)
    {
        $this->_iata = $iata;

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
     * @return Airport
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Get Coordinates
     *
     * @return array
     */
    public function getCoordinates()
    {
        return $this->_coordinates;
    }

    /**
     * Set coordinates
     *
     * @param array $coordinates
     *
     * @return Airport
     */
    public function setCoordinates($coordinates)
    {
        $this->_coordinates = $coordinates;

        return $this;
    }

    /**
     * Get TimeZone
     *
     * @return string
     */
    public function getTimeZone()
    {
        return $this->_timeZone;
    }

    /**
     * Set timeZone
     *
     * @param string $timeZone
     *
     * @return Airport
     */
    public function setTimeZone($timeZone)
    {
        $this->_timeZone = $timeZone;

        return $this;
    }

    /**
     * Get NameTranslations
     *
     * @return array
     */
    public function getNameTranslations()
    {
        return $this->_nameTranslations;
    }

    /**
     * Set nameTranslations
     *
     * @param array $nameTranslations
     *
     * @return Airport
     */
    public function setNameTranslations($nameTranslations)
    {
        $this->_nameTranslations = $nameTranslations;

        return $this;
    }

    /**
     * Get City
     *
     * @return City
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * Set city
     *
     * @param City $city
     *
     * @return Airport
     */
    public function setCity($city)
    {
        $this->_city = $city;

        return $this;
    }

}