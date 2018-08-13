<?php

namespace thewulf7\travelPayouts\services;


use Guzzle\Service\Exception\ValidationException;
use thewulf7\travelPayouts\components\AbstractService;
use thewulf7\travelPayouts\components\Client;
use thewulf7\travelPayouts\components\iService;
use thewulf7\travelPayouts\entity\Hotel;
use thewulf7\travelPayouts\entity\HotelLocation;
use thewulf7\travelPayouts\entity\HotelLocationSmall;
use thewulf7\travelPayouts\entity\HotelSmall;

/**
 * Tickets service
 *
 * @package thewulf7\travelPayouts
 */
class HotelsService extends AbstractService implements iService
{
    const CITY_TYPE = 'city';

    const HOTEL_TYPE = 'hotel';

    const BOTH_TYPE = 'both';

    /**
     * @var \thewulf7\travelPayouts\components\HotelsClient
     */
    private $_client;

    /**
     * @var \thewulf7\travelPayouts\components\HotelsClient
     */
    private $_staticClient;

    /**
     * @var array
     */
    private $_availableLanguages = [
        'pt',
        'en',
        'fr',
        'de',
        'id',
        'it',
        'pl',
        'es',
        'th',
        'ru',
    ];

    /**
     * Hotel search by name or location
     * Search for a specific location or name places of a hotel (city, island).
     *
     * @param string $query               the main parameter, it is set: as a text; by the longitude and latitude
     *                                    (also displays the nearest objects).
     * @param bool   $searchByCoordinates if query parameter have coordinates
     * @param string $lookFor             objects displayed in the results (CITY_TYPE, HOTEL_TYPE, BOTH)
     * @param string $lang                the display language. It can take any iso-language code
     * @param int    $limit               limitation of output results from 1 to 100, default - 10.
     * @param bool   $convertCase         automatically change the keyboard layout
     *
     * @return array
     */
    public function searchHotels(
        $query,
        $searchByCoordinates = false,
        $lookFor = self::BOTH_TYPE,
        $lang = 'en',
        $limit = 30,
        $convertCase = true
    ) {
        $arResult = [];
        $url      = 'lookup';

        $options = [
            'query'       => $query,
            'lang'        => $lang,
            'lookFor'     => $lookFor,
            'limit'       => $limit,
            'convertCase' => $convertCase,
        ];

        $response = $this->getClient()->execute($url, $options);

        foreach ($response['results'] as $resultType => $resultSet) {
            switch ($resultType) {
                case 'locations':
                    foreach ($resultSet as $item) {

                        if ($searchByCoordinates) {
                            $model = new HotelLocationSmall();

                            $model
                                ->setId($item['id'])
                                ->setName($item['name'])
                                ->setCountryIso($item['countryIso'])
                                ->setState($item['state'])
                                ->setType($item['type'])
                                ->setGeo($item['geo'])
                                ->setFullName($item['fullName']);
                        } else {
                            $model = new HotelLocation();

                            $model
                                ->setId($item['id'])
                                ->setCityName($item['cityName'])
                                ->setIata($item['iata'])
                                ->setLocation($item['location'])
                                ->setFullName($item['fullName'])
                                ->setCountryCode($item['countryCode'])
                                ->setCountryName($item['countryName'])
                                ->setHotelsCount($item['hotelsCount'])
                                ->setScore($item['_score']);
                        }

                        $arResult['locations'][] = $model;
                    }
                    break;
                case 'hotels':
                    foreach ($resultSet as $item) {
                        $model = new HotelSmall();

                        $model
                            ->setId($item['id'])
                            ->setFullName(isset($item['fullName']) ? $item['fullName'] : null)
                            ->setLocation($item['location'])
                            ->setLabel(array_key_exists('label', $item) ? $item['label'] : $item['name'])
                            ->setLocationId($item['locationId'])
                            ->setLocationName(isset($item['locationName']) ? $item['locationName'] : null);

                        $arResult['hotels'][] = $model;
                    }
                    break;
            }
        }

        return $arResult;
    }

    /**
     * @return \thewulf7\travelPayouts\components\HotelsClient
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->_client = $client;
    }

    /**
     * Displays the cost of living in hotels
     *
     * Request is used to get the price of hotel's rooms from the cache for the period.
     * It doesn't contain information about rooms availability.
     *
     * @param string $location
     * @param string $checkIn
     * @param string $checkOut
     * @param int    $locationId
     * @param int    $hotelId
     * @param string $hotel
     * @param int    $adults
     * @param int    $children
     * @param int    $infants
     * @param int    $limit
     * @param null   $customerIp
     *
     * @return array
     */
    public function getCostOfLiving(
        $location,
        $checkIn,
        $checkOut,
        $locationId = null,
        $hotelId = null,
        $hotel = null,
        $adults = 2,
        $children = 0,
        $infants = 0,
        $limit = 4,
        $customerIp = null
    ) {
        $url = 'cache';

        $options = [
            'location' => $location,
            'checkIn'  => $checkIn,
            'checkOut' => $checkOut,
            'adults'   => $adults,
            'children' => $children,
            'infants'  => $infants,
            'limit'    => $limit,
        ];

        if ($locationId) {
            $options['locationId'] = $locationId;
        }

        if ($hotelId) {
            $options['hotelId'] = $hotelId;
        }

        if ($hotel) {
            $options['hotel'] = $hotel;
        }

        if ($customerIp) {
            $options['customerIp'] = $customerIp;
        }

        $response = $this->getClient()->execute($url, $options);

        $dataService = $this->getDataService();

        $country = $dataService->getCountryByName($response['location']['country']);

        $locationModel = new HotelLocationSmall();
        $locationModel
            ->setGeo($response['location']['geo'])
            ->setName($response['location']['name'])
            ->setState($response['location']['state'])
            ->setCountryIso($country != null ? $country['code'] : null);

        $arResult             = $response;
        $arResult['location'] = $locationModel;

        return $arResult;
    }

    /**
     * Hotels Selections
     *
     * The request recovers the list of the specific hotels according to the ID of a location.
     * A collection is formed according to the specified period. If the period is not specified,
     * a collection shall be formed from the hotels, found for the last three days.
     *
     * @param string $checkIn  the date of check-in
     * @param string $checkOut the date of check-out
     * @param string $type     type of hotels from request /tp/public/available_selections.json
     * @param string $currency currency of response, default usd
     * @param string $language language of reaponse (pt, en, fr, de, id, it, pl, es, th, ru)
     * @param int    $id       id of the city
     * @param int    $limit    limitation of output results from 1 to 100, default - 10
     *
     * @return array
     */
    public function getHotelsSelection(
        $checkIn,
        $checkOut,
        $type,
        $currency = 'usd',
        $language = 'en',
        $id = null,
        $limit = 10
    ) {
        $url = 'public/widget_location_dump';

        $options = [
            'check_in'  => $checkIn,
            'check_out' => $checkOut,
            'currency'  => $currency,
            'language'  => $language,
            'limit'     => $limit,
            'type'      => $type,
            'id'        => $id,
        ];

        if (!in_array($language, $this->_availableLanguages)) {
            throw new ValidationException(sprintf("%s is not a valid language. Possible options: %s", $language,
                                                  var_export($this->_availableLanguages, false)));
        }

        $response = $this->getStaticClient()->execute($url, $options);

        return $response;
    }

    /**
     * Get StaticClient
     *
     * @return \thewulf7\travelPayouts\components\HotelsClient
     */
    public function getStaticClient()
    {
        return $this->_staticClient;
    }

    /**
     * Set staticClient
     *
     * @param \thewulf7\travelPayouts\components\HotelsClient $staticClient
     *
     * @return HotelsService
     */
    public function setStaticClient($staticClient)
    {
        $this->_staticClient = $staticClient;

        return $this;
    }

    /**
     * The types of hotel collections
     *
     * The request recovers the list of all available separate collections.
     * This type is used for searching of the hotels with a discount.
     *
     * @param int $id hotel id
     *
     * @return string[]
     */
    public function getHotelCollectionsTypes($id)
    {
        $url = 'public/available_selections';

        return $response = $this->getStaticClient()->execute($url, ['id' => $id]);
    }

    /**
     * Get hotels list by location
     *
     * @param int $id location id
     *
     * @return Hotel[]
     */
    public function getHotelsListByLocation($id)
    {
        $arResult = [];

        $url = 'static/hotels';

        $response = $this->getClient()->execute($url, ['locationId' => $id]);

        foreach ($response['hotels'] as $hotel) {

            $model = new Hotel();
            $model->setAttributes($hotel);

            $arResult[] = $model;
        }

        return $arResult;
    }

    /**
     * Request "Types of rooms"
     *
     * @param string $language
     *
     * @return array
     */
    public function getRoomTypes($language = 'en')
    {
        $url = 'static/roomTypes';

        if (!in_array($language, $this->_availableLanguages)) {
            throw new ValidationException(sprintf("%s is not a valid language. Possible options: %s", $language,
                                                  var_export($this->_availableLanguages, false)));
        }

        return $this->getClient()->execute($url, ['language' => $language]);
    }

    /**
     * Request "Types of hotels"
     *
     * @param string $language
     *
     * @return array
     */
    public function getHotelsTypes($language = 'en')
    {
        $url = 'static/hotelTypes';

        if (!in_array($language, $this->_availableLanguages)) {
            throw new ValidationException(sprintf("%s is not a valid language. Possible options: %s", $language,
                                                  var_export($this->_availableLanguages, false)));
        }

        return $this->getClient()->execute($url, ['language' => $language]);
    }

    /**
     * Hotel photos
     *
     * @param int    $hotelId   hotel id
     * @param int    $photoId   number of the hotel's photo
     * @param string $photoSize size of the photo (width/height).
     * @param bool   $auto      means that our system detects if users browser can accept Webp image format or not.
     *
     * @return string
     */
    public function getHotelPhoto($hotelId, $photoId, $photoSize, $auto = false)
    {
        $url_example = 'http://cdn.photo.hotellook.com/image_v2/crop/h%s_%s/%s.';

        $url_example .= $auto ? 'auto' : 'jpg';

        return sprintf($url_example, $hotelId, $photoId, $photoSize);
    }
}