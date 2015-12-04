<?php
namespace travelPayouts\services;


use travelPayouts\components\iService;
use travelPayouts\components\Client;

/**
 * Class Data. Used to receive different data from the travelPayouts.
 *
 * @package travelPayouts\services
 */
class Data implements iService
{
    /**
     * @var Client
     */
    private $_client;

    /**
     * Get countries
     *
     * @return array
     */
    public function getCountries()
    {
        $url = 'countries.json';

        return $this->getClient()->execute($url, []);
    }

    /**
     * Get cities
     *
     * @return array
     */
    public function getCities()
    {
        $url = 'cities.json';

        return $this->getClient()->execute($url, []);
    }

    /**
     * Get airports
     *
     * @return array
     */
    public function getAirports()
    {
        $url = 'airports.json';

        return $this->getClient()->execute($url, []);
    }

    /**
     * Get airlines
     *
     * @return mixed
     */
    public function getAirlines()
    {
        $url = 'airlines.json';

        return $this->getClient()->execute($url, []);
    }

    /**
     * Get airlines alliances
     *
     * @return mixed
     */
    public function getAirlinesAlliances()
    {
        $url = 'airlines_alliances.json';

        return $this->getClient()->execute($url, []);
    }

    /**
     * Get planes codes
     *
     * @return array
     */
    public function getPlanes()
    {
        $url = 'planes.json';

        return $this->getClient()->execute($url, []);
    }

    /**
     * Get popular routes
     *
     * @return array
     */
    public function getRoutes()
    {
        $url = 'routes.json';

        return $this->getClient()->execute($url, []);
    }

    /**
     * Detect city and nearest airport of the user with given ip
     *
     * @param        $ip
     * @param string $locale
     * @param string $funcName
     *
     * @return array
     */
    public static function whereAmI($ip, $locale = 'ru', $funcName = 'useriata')
    {
        $uri    = 'http://www.travelpayouts.com/whereami';
        $locale = in_array($locale, ['en', 'ru', 'de', 'fr', 'it', 'pl', 'th'], true) ? $locale : 'ru';

        if(!filter_var($ip, FILTER_VALIDATE_IP))
        {
            throw new \RuntimeException($ip . ' is not a valid ip');
        }

        $client = new \GuzzleHttp\Client(
            [
                'headers' =>
                    [
                        'Content-Type' => 'application/json',
                    ],
            ]
        );

        $res = $client->get($uri, [
            'locale'   => $locale,
            'callback' => $funcName,
            'ip'       => $ip,
        ]);

        return json_decode((string)$res->getBody(), true);
    }

    /**
     * Get currency rates to rouble
     *
     * @return array
     */
    public static function getCurrencies()
    {
        $uri = 'http://engine.aviasales.ru/currencies/all_currencies_rates';

        $client = new \GuzzleHttp\Client(
            [
                'headers' =>
                    [
                        'Content-Type' => 'application/json',
                    ],
            ]
        );

        return json_decode((string)$client->get($uri)->getBody(), true);
    }

    /**
     * @return \travelPayouts\components\Client
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

        $this->_client->setApiVersion('data');

        return $this;
    }
}