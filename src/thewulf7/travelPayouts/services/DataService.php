<?php
namespace thewulf7\travelPayouts\services;


use thewulf7\travelPayouts\components\AbstractService;
use thewulf7\travelPayouts\components\iService;
use thewulf7\travelPayouts\components\Client;
use thewulf7\travelPayouts\entity\Airport;
use thewulf7\travelPayouts\entity\City;
use thewulf7\travelPayouts\entity\Country;

/**
 * Class Data. Used to receive different data from the travelPayouts.
 *
 * @package thewulf7\travelPayouts\services
 */
class DataService extends AbstractService implements iService
{
    /**
     * Include only once data from JSON
     *
     * @var array
     */
    public $data = [
        'countries'          => [],
        'cities'             => [],
        'airports'           => [],
        'airlines'           => [],
        'airlines_alliances' => [],
        'planes'             => [],
        'routes'             => [],
    ];

    /**
     * @var Client
     */
    private $_client;

    /**
     * Get countries
     *
     * @param bool $simpleArray
     *
     * @return array Country[]
     * @throws \RuntimeException
     */
    public function getCountries($simpleArray = false)
    {
        $fileName = 'countries.json';

        $sResult = self::getPath($fileName);

        if (!$sResult)
        {
            throw new \RuntimeException("File `{$fileName}` doesn't exists. Reinstall the package.");
        }

        if (count($this->data['countries']) === 0)
        {
            $this->data['countries'] = json_decode(file_get_contents($sResult), true);
        }

        return $simpleArray === true ? $this->data['countries'] : array_map(function ($country)
        {
            $model = new Country();

            $model
                ->setIata($country['code'])
                ->setName($country['name'])
                ->setNameTranslations($country['name_translations'])
                ->setCurrency($country['currency']);

            return $model;
        }, $this->data['countries']);
    }

    /**
     * Get cities
     *
     * @param bool $simpleArray
     *
     * @return array City[]
     * @throws \RuntimeException
     */
    public function getCities($simpleArray = false)
    {
        $fileName = 'cities.json';

        $sResult = self::getPath($fileName);

        if (!$sResult)
        {
            throw new \RuntimeException("File `{$fileName}` doesn't exists. Reinstall package.");
        }

        if (count($this->data['cities']) === 0)
        {
            $this->data['cities'] = json_decode(file_get_contents($sResult), true);
        }

        return $simpleArray === true ? $this->data['cities'] : array_map(function ($city)
        {
            $model = new City();

            $model
                ->setIata($city['code'])
                ->setName($city['name'])
                ->setNameTranslations($city['name_translations'])
                ->setCoordinates($city['coordinates'])
                ->setTimeZone($city['time_zone'])
                ->setCountry($this->getCountry($city['country_code']));

            return $model;
        }, $this->data['cities']);
    }

    /**
     * Get airports
     *
     * @param bool $simpleArray
     *
     * @return array Airport[]
     * @throws \RuntimeException
     */
    public function getAirports($simpleArray = false)
    {
        $fileName = 'airports.json';

        $sResult = self::getPath($fileName);

        if (!$sResult)
        {
            throw new \RuntimeException("File `{$fileName}` doesn't exists. Reinstall package.");
        }

        if (count($this->data['airports']) === 0)
        {
            $this->data['airports'] = json_decode(file_get_contents($sResult), true);
        }

        return $simpleArray === true ? $this->data['airports'] : array_map(function ($airport)
        {
            $model = new Airport();

            $model
                ->setIata($airport['code'])
                ->setName($airport['name'])
                ->setCoordinates($airport['coordinates'])
                ->setNameTranslations($airport['name_translations'])
                ->setTimeZone($airport['time_zone'])
                ->setCity($this->getCity($airport['city_code']));

            return $model;
        }, $this->data['airports']);
    }

    /**
     * Get Airport object by code
     *
     * @param $code
     *
     * @return null|Airport
     * @throws \RuntimeException
     */
    public function getAirport($code)
    {
        $jsonArray = $this->getAirports(true);

        $key = array_search($code, array_column($jsonArray, 'code'), true);

        if ($key === false)
        {
            return null;
        }

        $model = new Airport();

        $model
            ->setIata($jsonArray[$key]['code'])
            ->setName($jsonArray[$key]['name'])
            ->setCoordinates($jsonArray[$key]['coordinates'])
            ->setNameTranslations($jsonArray[$key]['name_translations'])
            ->setTimeZone($jsonArray[$key]['time_zone'])
            ->setCity($this->getCity($jsonArray[$key]['city_code']));

        return $model;
    }

    /**
     * @param $code
     *
     * @return null|City
     * @throws \RuntimeException
     */
    public function getCity($code)
    {
        $jsonArray = $this->getCities(true);

        $key = array_search($code, array_column($jsonArray, 'code'), true);

        if ($key === false)
        {
            return null;
        }

        $model = new City();

        $model
            ->setIata($jsonArray[$key]['code'])
            ->setName($jsonArray[$key]['name'])
            ->setNameTranslations($jsonArray[$key]['name_translations'])
            ->setCoordinates($jsonArray[$key]['coordinates'])
            ->setTimeZone($jsonArray[$key]['time_zone'])
            ->setCountry($this->getCountry($jsonArray[$key]['country_code']));

        return $model;
    }

    /**
     * @param $code
     *
     * @return null|Country
     * @throws \RuntimeException
     */
    public function getCountry($code)
    {
        $jsonArray = $this->getCountries(true);

        $key = array_search($code, array_column($jsonArray, 'code'), true);

        if ($key === false)
        {
            return null;
        }
        $model = new Country();

        $model
            ->setIata($jsonArray[$key]['code'])
            ->setName($jsonArray[$key]['name'])
            ->setNameTranslations($jsonArray[$key]['name_translations'])
            ->setCurrency($jsonArray[$key]['currency']);

        return $model;
    }

    /**
     * Get City or Airport
     *
     * @param $code
     *
     * @return null|Airport|City
     */
    public function getPlace($code)
    {
        $oResult = $this->getCity($code);

        if(!$oResult)
        {
            $oResult = $this->getAirport($code);
        }

        return $oResult;
    }

    /**
     * Get airlines
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function getAirlines()
    {
        $fileName = 'airlines.json';

        $sResult = self::getPath($fileName);

        if (!$sResult)
        {
            throw new \RuntimeException("File `{$fileName}` doesn't exists. Reinstall package.");
        }

        if (count($this->data['airlines']) === 0)
        {
            $this->data['airlines'] = json_decode(file_get_contents($sResult), true);
        }

        return $this->data['airlines'];
    }

    /**
     * Get airlines alliances
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function getAirlinesAlliances()
    {
        $fileName = 'airlines_alliances.json';

        $sResult = self::getPath($fileName);

        if (!$sResult)
        {
            throw new \RuntimeException("File `{$fileName}` doesn't exists. Reinstall package.");
        }

        if (count($this->data['airlines_alliances']) === 0)
        {
            $this->data['airlines_alliances'] = json_decode(file_get_contents($sResult), true);
        }

        return $this->data['airlines_alliances'];
    }

    /**
     * Get planes codes
     *
     * @return array
     * @throws \RuntimeException
     */
    public function getPlanes()
    {
        $fileName = 'planes.json';

        $sResult = self::getPath($fileName);

        if (!$sResult)
        {
            throw new \RuntimeException("File `{$fileName}` doesn't exists. Reinstall package.");
        }

        if (count($this->data['planes']) === 0)
        {
            $this->data['planes'] = json_decode(file_get_contents($sResult), true);
        }

        return $this->data['planes'];
    }

    /**
     * Get popular routes
     *
     * @return array
     * @throws \RuntimeException
     */
    public function getRoutes()
    {
        $fileName = 'routes.json';

        $sResult = self::getPath($fileName);

        if (!$sResult)
        {
            throw new \RuntimeException("File `{$fileName}` doesn't exists. Reinstall package.");
        }

        if (count($this->data['routes']) === 0)
        {
            $this->data['routes'] = json_decode(file_get_contents($sResult), true);
        }

        return $this->data['routes'];
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
        $locale = in_array($locale, ['en', 'ru', 'de', 'fr', 'it', 'pl', 'th'], true) ? $locale : 'ru';
        $uri    = "http://www.travelpayouts.com/whereami?locale={$locale}";

        if (!filter_var($ip, FILTER_VALIDATE_IP))
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

        $this->_client->setApiVersion('data');

        return $this;
    }

    /**
     * Get Path
     *
     * @param $fileName
     *
     * @return bool|string
     */
    private static function getPath($fileName)
    {
        $path = __DIR__ . '/../data/' . $fileName;

        return file_exists($path) ? $path : false;
    }
}