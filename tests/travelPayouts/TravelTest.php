<?php

class TravelTest extends PHPUnit_Framework_TestCase
{
    public function testGetTicketsService()
    {
        $travel = new \travelPayouts\Travel('');
        $ticket = $travel->getTicketsService();

        self::assertInstanceOf('\travelPayouts\services\Tickets', $ticket);
    }
}
