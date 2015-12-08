<?php

use thewulf7\travelPayouts\config;

class TravelTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \thewulf7\travelPayouts\Travel
     */
    protected $travel;

    public function setUp()
    {
        $config = require(__DIR__ . '/../../../src/thewulf7/travelPayouts/config/tests.php');

        $this->travel = new \thewulf7\travelPayouts\Travel($config['token']);
        date_default_timezone_set('UTC');
    }

    public function testGetTicketsService()
    {
        $ticket = $this->travel->getTicketsService();

        self::assertInstanceOf('thewulf7\travelPayouts\services\TicketsService', $ticket);
    }

    public function testGetDataService()
    {
        $ticket = $this->travel->getDataService();

        self::assertInstanceOf('thewulf7\travelPayouts\services\DataService', $ticket);
    }

    public function testGetFlightService()
    {
        $ticket = $this->travel->getFlightService();

        self::assertInstanceOf('thewulf7\travelPayouts\services\FlightService', $ticket);
    }

}
