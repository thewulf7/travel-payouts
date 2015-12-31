<?php
namespace thewulf7\travelPayouts\entity;
use thewulf7\travelPayouts\services\TicketsService;


/**
 * Class Ticket
 *
 * @package thewulf7\travelPayouts\entity
 */
class Ticket
{
    /**
     * @var City|Airport
     */
    private $_origin;

    /**
     * @var City|Airport
     */
    private $_destination;

    /**
     * @var \DateTime
     */
    private $_departDate;

    /**
     * @var \DateTime
     */
    private $_returnDate;

    /**
     * @var int
     */
    private $_value;

    /**
     * @var string
     */
    private $_currency;

    /**
     * @var int
     */
    private $_distance;

    /**
     * @var boolean
     */
    private $_actual;

    /**
     * @var \DateTime
     */
    private $_foundAt;

    /**
     * @var int
     */
    private $_tripClass;

    /**
     * @var boolean
     */
    private $_showToAffiliates;

    /**
     * @var int
     */
    private $_numberOfChanges;

    /**
     * @var string
     */
    private $_airline;

    /**
     * @var \DateTime
     */
    private $_expires;

    /**
     * @var int
     */
    private $_flightNumber;

    /**
     * Get Origin
     *
     * @return City|Airport
     */
    public function getOrigin()
    {
        return $this->_origin;
    }

    /**
     * Set origin
     *
     * @param City|Airport $origin
     *
     * @return Ticket
     */
    public function setOrigin($origin)
    {
        $this->_origin = $origin;

        return $this;
    }

    /**
     * Get Destination
     *
     * @return City|Airport
     */
    public function getDestination()
    {
        return $this->_destination;
    }

    /**
     * Set destination
     *
     * @param City|Airport $destination
     *
     * @return Ticket
     */
    public function setDestination($destination)
    {
        $this->_destination = $destination;

        return $this;
    }

    /**
     * Get DepartDate
     *
     * @return \DateTime
     */
    public function getDepartDate()
    {
        return $this->_departDate;
    }

    /**
     * Set departDate
     *
     * @param \DateTime $departDate
     *
     * @return Ticket
     */
    public function setDepartDate($departDate)
    {
        $this->_departDate = $departDate;

        return $this;
    }

    /**
     * Get ReturnDate
     *
     * @return \DateTime
     */
    public function getReturnDate()
    {
        return $this->_returnDate;
    }

    /**
     * Set returnDate
     *
     * @param \DateTime $returnDate
     *
     * @return Ticket
     */
    public function setReturnDate($returnDate)
    {
        $this->_returnDate = $returnDate;

        return $this;
    }

    /**
     * Get Value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Set value
     *
     * @param int $value
     *
     * @return Ticket
     */
    public function setValue($value)
    {
        $this->_value = $value;

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
     * @return Ticket
     */
    public function setCurrency($currency)
    {
        $this->_currency = $currency;

        return $this;
    }

    /**
     * Get Distance
     *
     * @return int
     */
    public function getDistance()
    {
        return $this->_distance;
    }

    /**
     * Set distance
     *
     * @param int $distance
     *
     * @return Ticket
     */
    public function setDistance($distance)
    {
        $this->_distance = $distance;

        return $this;
    }

    /**
     * Get Actual
     *
     * @return boolean
     */
    public function isActual()
    {
        return $this->_actual;
    }

    /**
     * Set actual
     *
     * @param boolean $actual
     *
     * @return Ticket
     */
    public function setActual($actual)
    {
        $this->_actual = $actual;

        return $this;
    }

    /**
     * Get FoundAt
     *
     * @return \DateTime
     */
    public function getFoundAt()
    {
        return $this->_foundAt;
    }

    /**
     * Set foundAt
     *
     * @param \DateTime $foundAt
     *
     * @return Ticket
     */
    public function setFoundAt($foundAt)
    {
        $this->_foundAt = $foundAt;

        return $this;
    }

    /**
     * Get TripClass
     *
     * @return int
     */
    public function getTripClass()
    {
        return $this->_tripClass;
    }

    /**
     * Set tripClass
     *
     * @param int $tripClass
     *
     * @return Ticket
     */
    public function setTripClass($tripClass)
    {
        $this->_tripClass = $tripClass;

        return $this;
    }

    /**
     * Get ShowToAffiliates
     *
     * @return boolean
     */
    public function isShowToAffiliates()
    {
        return $this->_showToAffiliates;
    }

    /**
     * Set showToAffiliates
     *
     * @param boolean $showToAffiliates
     *
     * @return Ticket
     */
    public function setShowToAffiliates($showToAffiliates)
    {
        $this->_showToAffiliates = $showToAffiliates;

        return $this;
    }

    /**
     * Get NumberOfChanges
     *
     * @return int
     */
    public function getNumberOfChanges()
    {
        return $this->_numberOfChanges;
    }

    /**
     * Set numberOfChanges
     *
     * @param int $numberOfChanges
     *
     * @return Ticket
     */
    public function setNumberOfChanges($numberOfChanges)
    {
        $this->_numberOfChanges = $numberOfChanges;

        return $this;
    }

    /**
     * Get Airline
     *
     * @return string
     */
    public function getAirline()
    {
        return $this->_airline;
    }

    /**
     * Set airline
     *
     * @param string $airline
     *
     * @return Ticket
     */
    public function setAirline($airline)
    {
        $this->_airline = $airline;

        return $this;
    }

    /**
     * Get Expires
     *
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->_expires;
    }

    /**
     * Set expires
     *
     * @param \DateTime $expires
     *
     * @return Ticket
     */
    public function setExpires($expires)
    {
        $this->_expires = $expires;

        return $this;
    }

    /**
     * Get FlightNumber
     *
     * @return int
     */
    public function getFlightNumber()
    {
        return $this->_flightNumber;
    }

    /**
     * Set flightNumber
     *
     * @param int $flightNumber
     *
     * @return Ticket
     */
    public function setFlightNumber($flightNumber)
    {
        $this->_flightNumber = $flightNumber;

        return $this;
    }

    public function getUrl($type = 'aviasales')
    {
        $url = '';

        $getTripClass = function ($class)
        {
            $ticketClass = 'Y';

            switch ($class)
            {
                case TicketsService::BUSINESS_CLASS:
                    $ticketClass = 'C';
                    break;
                case TicketsService::FIRST_CLASS:
                    $ticketClass = 'F';
                    break;
                case TicketsService::ECONOMY_CLASS:
                    $ticketClass = 'Y';
                    break;
            }

            return $ticketClass;
        };

        switch ($type)
        {
            case 'aviasales':
                $url .= 'http://search.aviasales.ru/';
                $url .= mb_strtoupper($this->getOrigin()->getIata()) . $this->getDepartDate()->format('dm');
                $url .= mb_strtolower($this->getDestination()->getIata()) . $this->getReturnDate()->format('dm');
                $url .= '1';
                break;
            case 'jetradar':
                $url .= 'http://www.jetradar.com/searches/';
                $origin = $this->getOrigin();
                $dest   = $this->getDestination();

                $url .= $origin instanceof Airport ? 'A' : 'C';
                $url .= mb_strtoupper($origin->getIata()) . $this->getDepartDate()->format('dm');
                $url .= $dest instanceof Airport ? 'A' : 'C';
                $url .= mb_strtolower($dest->getIata()) . $this->getReturnDate()->format('dm');
                $url .= $getTripClass($this->getTripClass()) . '1';
                break;
            default:
                throw new \InvalidArgumentException('Type of website not found');
                break;
        }

        return $url;
    }

}