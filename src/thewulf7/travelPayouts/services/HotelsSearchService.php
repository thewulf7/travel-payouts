<?php

namespace thewulf7\travelPayouts\services;


use thewulf7\travelPayouts\components\AbstractService;
use thewulf7\travelPayouts\components\Client;
use thewulf7\travelPayouts\components\iService;
use thewulf7\travelPayouts\entity\enums\EnumSortAsc;
use thewulf7\travelPayouts\entity\enums\EnumSortHotels;

/**
 * Class Flight
 *
 * @package thewulf7\travelPayouts\services
 */
class HotelsSearchService extends AbstractService implements iService
{
    /**
     * @var Client
     */
    private $_client;

    /**
     * @var int
     */
    private $_marker;

    /**
     * @var string
     */
    private $_ip;

    /**
     * @var string
     */
    private $_token;

    /**
     * @var int
     */
    private $_cityId;

    /**
     * @var int
     */
    private $_hotelId;

    /**
     * @var string
     */
    private $_iata;

    /**
     * @var string
     */
    private $_checkIn;

    /**
     * @var int
     */
    private $_checkOut;

    /**
     * @var int
     */
    private $_adultsCount;

    /**
     * @var int
     */
    private $_childrenCount;

    /**
     * @var int
     */
    private $_timeout = 20;

    /**
     * @var string
     */
    private $_customerIP;

    /**
     * @param string $locale
     * @param string $currency
     *
     * @return mixed
     */
    public function search($locale = 'en_US', $currency = 'USD')
    {
        $url = 'search/start';

        $options = [
            'marker'         => $this->getMarker(),
            'adultsCount'    => $this->getAdultsCount(),
            'checkIn'        => $this->getCheckIn(),
            'checkOut'       => $this->getCheckOut(),
            'childrenCount'  => $this->getChildrenCount(),
            'currency'       => $currency,
            'customerIP'     => $this->getCustomerIP(),
            'iata'           => $this->getIata(),
            'lang'           => in_array($locale, [
                'en_US',
                'en_GB',
                'de_DE',
                'en_AU',
                'en_CA',
                'en_IE',
                'es_ES',
                'fr_FR',
                'it_IT',
                'pl_PL',
                'th_TH',
            ], true) ? $locale : 'en_US',
            'timeout'        => $this->getTimeout(),
            'waitForResults' => '1',
        ];

        $options['signature'] = $this->getSignature($options);

        return $this->getClient()->execute($url, $options, 'GET', false);
    }

    /**
     * @return mixed
     */
    public function getMarker()
    {
        return $this->_marker;
    }

    /**
     * @param mixed $marker
     *
     * @return $this
     */
    public function setMarker($marker)
    {
        $this->_marker = $marker;

        return $this;
    }

    /**
     * Get AdultsCount
     *
     * @return int
     */
    public function getAdultsCount()
    {
        return $this->_adultsCount;
    }

    /**
     * Set adultsCount
     *
     * @param int $adultsCount
     *
     * @return HotelsSearchService
     */
    public function setAdultsCount($adultsCount)
    {
        $this->_adultsCount = $adultsCount;

        return $this;
    }

    /**
     * Get CheckIn
     *
     * @return string
     */
    public function getCheckIn()
    {
        return $this->_checkIn;
    }

    /**
     * Set checkIn
     *
     * @param string $checkIn
     *
     * @return HotelsSearchService
     */
    public function setCheckIn($checkIn)
    {
        $this->_checkIn = $checkIn;

        return $this;
    }

    /**
     * Get CheckOut
     *
     * @return int
     */
    public function getCheckOut()
    {
        return $this->_checkOut;
    }

    /**
     * Set checkOut
     *
     * @param int $checkOut
     *
     * @return HotelsSearchService
     */
    public function setCheckOut($checkOut)
    {
        $this->_checkOut = $checkOut;

        return $this;
    }

    /**
     * Get ChildrenCount
     *
     * @return int
     */
    public function getChildrenCount()
    {
        return $this->_childrenCount;
    }

    /**
     * Set childrenCount
     *
     * @param int $childrenCount
     *
     * @return HotelsSearchService
     */
    public function setChildrenCount($childrenCount)
    {
        $this->_childrenCount = $childrenCount;

        return $this;
    }

    /**
     * Get CustomerIP
     *
     * @return string
     */
    public function getCustomerIP()
    {
        return $this->_customerIP;
    }

    /**
     * Set customerIP
     *
     * @param string $customerIP
     *
     * @return HotelsSearchService
     */
    public function setCustomerIP($customerIP)
    {
        $this->_customerIP = $customerIP;

        return $this;
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
     * @return HotelsSearchService
     */
    public function setIata($iata)
    {
        $this->_iata = $iata;

        return $this;
    }

    /**
     * Get Timeout
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->_timeout;
    }

    /**
     * Set timeout
     *
     * @param int $timeout
     *
     * @return HotelsSearchService
     */
    public function setTimeout($timeout)
    {
        $this->_timeout = $timeout;

        return $this;
    }

    /**
     * @param array $options
     *
     * @return string
     */
    public function getSignature(array $options)
    {
        $options['token'] = $this->getToken();

        ksort($options);

        return md5(implode(':', $options));

    }

    /**
     * Get Token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return HotelsSearchService
     */
    public function setToken($token)
    {
        $this->_token = $token;

        return $this;
    }

    /**
     * @return \thewulf7\travelPayouts\components\Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @param Client $client
     *
     * @return $this
     */
    public function setClient($client)
    {
        $this->_client = $client;

        return $this;
    }

    /**
     * Get search results
     *
     * @param string $uuid       Search ID
     *
     * @param string $sortBy     how to sort:
     *                           popularity - by popularity;
     *                           price - by price;
     *                           name - by name;
     *                           guestScore – by User Rating;
     *                           stars – by number of stars
     * @param int    $sortAsc    how to sort the values: 1 – ascending; 0 – descending.
     * @param int    $roomsCount the maximum number of rooms that are returned in each hotel, from 0 to infinity, where
     *                           0 - no limit
     * @param int    $limit      maximum number of hotels, from 0 to infinity, where 0 - no limit
     * @param int    $offset     to skip a number of hotels from 0 to infinity, where 0 - no hotel not passed
     *
     * @return mixed
     */
    public function getSearchResults(
        $uuid,
        $sortBy = EnumSortHotels::POPULARITY,
        $sortAsc = EnumSortAsc::ASCENDING,
        $roomsCount = 0,
        $limit = 0,
        $offset = 0
    ) {
        $url = 'search/getResult';

        $options = [
            'marker'     => $this->getMarker(),
            'searchId'   => $uuid,
            'limit'      => $limit,
            'sortBy'     => $sortBy,
            'offset'     => $offset,
            'sortAsc'    => $sortAsc,
            'roomsCount' => $roomsCount,
        ];

        $options['signature'] = $this->getSignature($options);

        return $this->getClient()->setApiVersion('v1')->execute($url, $options);
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->_host;
    }

    /**
     * @param mixed $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->_host = $host;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->_ip;
    }

    /**
     * @param mixed $ip
     *
     * @return $this
     */
    public function setIp($ip)
    {
        $this->_ip = $ip;

        return $this;
    }

    /**
     * Get CityId
     *
     * @return int
     */
    public function getCityId()
    {
        return $this->_cityId;
    }

    /**
     * Set cityId
     *
     * @param int $cityId
     *
     * @return HotelsSearchService
     */
    public function setCityId($cityId)
    {
        $this->_cityId = $cityId;

        return $this;
    }

    /**
     * Get HotelId
     *
     * @return int
     */
    public function getHotelId()
    {
        return $this->_hotelId;
    }

    /**
     * Set hotelId
     *
     * @param int $hotelId
     *
     * @return HotelsSearchService
     */
    public function setHotelId($hotelId)
    {
        $this->_hotelId = $hotelId;

        return $this;
    }
}