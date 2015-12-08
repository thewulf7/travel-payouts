<?php
namespace travelPayouts\entity;


/**
 * Class City
 *
 * @package travelPayouts\entity
 */
class City
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
    private $_coordinates;

    /**
     * @var string
     */
    private $_timeZone;

    /**
     * @var array
     */
    private $_nameTranslations;

    /**
     * @var Country
     */
    private $_country;

    /**
     * @param $code
     */
    public function __construct($code = '')
    {
        if ($code !== '')
        {
            $this->setIata($code);
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
     * @return City
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
     * @return City
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
     * @return City
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
     * @return City
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
     * @return City
     */
    public function setNameTranslations($nameTranslations)
    {
        $this->_nameTranslations = $nameTranslations;

        return $this;
    }

    /**
     * Get Country
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->_country;
    }

    /**
     * Set country
     *
     * @param Country $country
     *
     * @return City
     */
    public function setCountry($country)
    {
        $this->_country = $country;

        return $this;
    }
}