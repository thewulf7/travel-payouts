<?php

class TravelTest extends PHPUnit_Framework_TestCase
{
    public function testGetTicketsService()
    {
        $travel = new \travelPayouts\Travel('123testtoken');
        $ticket = $travel->getTicketsService();

        self::assertInstanceOf('\travelPayouts\services\Tickets', $ticket);
    }

    public function testGetDataService()
    {
        $travel = new \travelPayouts\Travel('123testtoken');
        $ticket = $travel->getDataService();

        self::assertInstanceOf('\travelPayouts\services\Data', $ticket);
    }

    public function testGetFlightService()
    {
        $travel = new \travelPayouts\Travel('123testtoken');
        $ticket = $travel->getFlightService();

        self::assertInstanceOf('\travelPayouts\services\Flight', $ticket);
    }

}
