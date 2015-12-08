<?php
namespace travelPayouts\entity;


/**
 * Class Country
 *
 * @package travelPayouts\entity
 */
class Country
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
     * @var string
     */
    private $_currency;

    /**
     * @var array
     */
    private $_nameTranslations;

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
     * @return Country
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
     * @return Country
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Get Currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Country
     */
    public function setCurrency($currency)
    {
        $this->_currency = $currency;

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
     * @return Country
     */
    public function setNameTranslations($nameTranslations)
    {
        $this->_nameTranslations = $nameTranslations;

        return $this;
    }
}