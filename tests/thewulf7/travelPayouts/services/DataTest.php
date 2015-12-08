<?php
namespace services;


class DataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \thewulf7\travelPayouts\services\DataService
     */
    protected $service;

    public function setUp()
    {
        $config = require(__DIR__ . '/../../../../src/thewulf7/travelPayouts/config/tests.php');
        $travel        = new \thewulf7\travelPayouts\Travel($config['token']);
        $this->service = $travel->getDataService();

        date_default_timezone_set('UTC');
    }

    public function testGetCity()
    {
        $code         = 'NYC';
        $name         = 'New York';
        $coordinates  = ['lon' => '-74.0059731', 'lat' => '40.7143528'];
        $timeZone     = 'America/New_York';
        $country_code = 'US';

        $city = $this->service->getPlace($code);

        self::assertEquals($code, $city->getIata());
        self::assertEquals($name, $city->getName());
        self::assertEquals($coordinates, $city->getCoordinates());
        self::assertEquals($country_code, $city->getCountry()->getIata());
        self::assertEquals($timeZone, $city->getTimeZone());
    }

    public function testGetCountry()
    {
        $code     = 'US';
        $name     = 'United States';
        $currency = 'USD';

        $country = $this->service->getCountry($code);

        self::assertEquals($code, $country->getIata());
        self::assertEquals($name, $country->getName());
        self::assertEquals($currency, $country->getCurrency());
    }

    public function testGetAirlines()
    {
        $json = $this->service->getAirlines();

        foreach ($json as $item)
        {
            self::assertArrayHasKey('name', $item);
        }
    }

    public function testGetCurrencies()
    {
        $response = $this->service->getCurrencies();

        self::assertArrayHasKey('usd', $response);
        self::assertArrayHasKey('eur', $response);
    }
}
