<?php

use travelPayouts\config;

class TravelTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \travelPayouts\Travel
     */
    protected $travel;

    public function setUp()
    {
        $config = require(__DIR__ . '/../../src/travelPayouts/config/tests.php');

        $this->travel = new \travelPayouts\Travel($config['token']);
        date_default_timezone_set('UTC');
    }

    public function testGetTicketsService()
    {
        $ticket = $this->travel->getTicketsService();

        self::assertInstanceOf('travelPayouts\services\TicketsService', $ticket);
    }

    public function testGetDataService()
    {
        $ticket = $this->travel->getDataService();

        self::assertInstanceOf('travelPayouts\services\DataService', $ticket);
    }

    public function testGetFlightService()
    {
        $ticket = $this->travel->getFlightService();

        self::assertInstanceOf('travelPayouts\services\FlightService', $ticket);
    }

}
