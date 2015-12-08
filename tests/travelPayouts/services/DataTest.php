<?php
namespace services;

use travelPayouts\services\Data;

class DataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \travelPayouts\services\Data
     */
    protected $service;

    public function setUp()
    {
        $travel        = new \travelPayouts\Travel('321d6a221f8926b5ec41ae89a3b2ae7b');
        $this->service = $travel->getDataService();

        date_default_timezone_set('UTC');
    }

    public function testGetCountries()
    {
        $countries = $this->service->getCountries();
        $countries = array_slice($countries, 0, 10);

        /** @var \travelPayouts\entity\Country $country */
        foreach ($countries as $country)
        {
            self::assertInstanceOf('\travelPayouts\entity\Country', $country);
            self::assertNotEmpty($country->getName());
            self::assertNotEmpty($country->getIata());
            self::assertNotEmpty($country->getNameTranslations());
        }

        return $this->service;
    }

    /**
     * @depends testGetCountries
     */
    public function testGetCities(Data $service)
    {
        $cities = $service->getCities();
        $cities = array_slice($cities, 0, 10);

        /** @var \travelPayouts\entity\City $city */
        foreach ($cities as $city)
        {
            self::assertInstanceOf('\travelPayouts\entity\City', $city);
            self::assertNotEmpty($city->getIata());
            self::assertNotEmpty($city->getName());
            self::assertNotEmpty($city->getNameTranslations());
            self::assertInstanceOf('\travelPayouts\entity\Country', $city->getCountry());
        }

        return $service;
    }


    /**
     * @depends testGetCities
     */
    public function testGetAirports(Data $service)
    {
        $airports = $service->getAirports();
        $airports = array_slice($airports, 0, 10);

        /** @var \travelPayouts\entity\Airport $airport */
        foreach ($airports as $airport)
        {
            self::assertInstanceOf('\travelPayouts\entity\Airport', $airport);
            self::assertNotEmpty($airport->getName());
            self::assertNotEmpty($airport->getTimeZone());
            self::assertInstanceOf('\travelPayouts\entity\Country', $airport->getCity()->getCountry());
            self::assertInstanceOf('\travelPayouts\entity\City', $airport->getCity());
        }

        return $service;
    }

    /**
     * @depends testGetAirports
     */
    public function testGetAirport(Data $service)
    {
        $code         = 'JFK';
        $name         = 'John F Kennedy International';
        $coordinates  = ['lon' => '-73.78817', 'lat' => '40.642334'];
        $country_code = 'US';
        $city_code    = 'NYC';

        $airport = $service->getAirport($code);

        self::assertEquals($code, $airport->getIata());
        self::assertEquals($name, $airport->getName());
        self::assertEquals($coordinates, $airport->getCoordinates());
        self::assertEquals($country_code, $airport->getCity()->getCountry()->getIata());
        self::assertEquals($city_code, $airport->getCity()->getIata());

        return $service;
    }

    /**
     * @depends testGetAirport
     */
    public function testGetCity(Data $service)
    {
        $code         = 'NYC';
        $name         = 'New York';
        $coordinates  = ['lon' => '-74.0059731', 'lat' => '40.7143528'];
        $timeZone     = 'America/New_York';
        $country_code = 'US';

        $city = $service->getCity($code);

        self::assertEquals($code, $city->getIata());
        self::assertEquals($name, $city->getName());
        self::assertEquals($coordinates, $city->getCoordinates());
        self::assertEquals($country_code, $city->getCountry()->getIata());
        self::assertEquals($timeZone, $city->getTimeZone());

        return $service;
    }

    /**
     * @depends testGetCity
     */
    public function testGetCountry(Data $service)
    {
        $code     = 'US';
        $name     = 'United States';
        $currency = 'USD';

        $country = $service->getCountry($code);

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

    public function testWhereAmI()
    {
        $ip       = '109.195.95.73';
        $response = $this->service->whereAmI($ip);

        self::assertEquals('LED', $response['iata']);
        self::assertEquals('Санкт-Петербург', $response['name']);
        self::assertEquals('Россия', $response['country_name']);
    }

    public function testGetCurrencies()
    {
        $response = $this->service->getCurrencies();

        self::assertArrayHasKey('usd', $response);
        self::assertArrayHasKey('eur', $response);
    }
}
