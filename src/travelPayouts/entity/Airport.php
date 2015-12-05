<?php
namespace travelPayouts\entity;


class Airport
{
    private $_iata;

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

}