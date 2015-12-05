<?php

class TicketsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \travelPayouts\services\Tickets
     */
    protected $service;

    public function setUp()
    {
        $travel = new \travelPayouts\Travel('321d6a221f8926b5ec41ae89a3b2ae7b');
        $this->service = $travel->getTicketsService();

        date_default_timezone_set('UTC');
    }

    public function testGetLatestPrices()
    {
        $tickets = $this->service->getLatestPrices();
        /** @var \travelPayouts\entity\Ticket $firstTicket */
        $firstTicket = $tickets[0];

        self::assertInstanceOf('\travelPayouts\entity\Ticket', $firstTicket);

        self::assertGreaterThan(0, $firstTicket->getValue());
        self::assertGreaterThan(0, $firstTicket->getDistance());

        self::assertInstanceOf('\travelPayouts\entity\Airport', $firstTicket->getOrigin());
        self::assertInstanceOf('\travelPayouts\entity\Airport', $firstTicket->getDestination());

        self::assertNotEmpty($firstTicket->getOrigin()->getIata());
        self::assertStringMatchesFormat('%c%c%c', $firstTicket->getOrigin()->getIata());
    }

    public function testGetMonthMatrix()
    {
        $tickets = $this->service->getMonthMatrix('LED','MOW','2016-01-01');
        /** @var \travelPayouts\entity\Ticket $firstTicket */
        $firstTicket = $tickets[0];

        //add check of the content

        self::assertInstanceOf('\travelPayouts\entity\Ticket', $firstTicket);

        self::assertGreaterThan(0, $firstTicket->getValue());
        self::assertGreaterThan(0, $firstTicket->getDistance());

        self::assertInstanceOf('\travelPayouts\entity\Airport', $firstTicket->getOrigin());
        self::assertInstanceOf('\travelPayouts\entity\Airport', $firstTicket->getDestination());

        self::assertNotEmpty($firstTicket->getOrigin()->getIata());
        self::assertStringMatchesFormat('%c%c%c', $firstTicket->getOrigin()->getIata());

    }

    public function testGetNearestPlacesMatrix()
    {
        $tickets = $this->service->getNearestPlacesMatrix('LED', 'HKG', '2016-01-02', '2016-01-03');

        self::assertGreaterThan(0, $tickets['origins']);
        self::assertGreaterThan(0, $tickets['destinations']);

        //add check of the content

        self::assertInstanceOf('\travelPayouts\entity\Airport',$tickets['origins'][0]);
        self::assertInstanceOf('\travelPayouts\entity\Airport',$tickets['destinations'][0]);

        self::assertNotEmpty($tickets['origins'][0]->getIata());
        self::assertStringMatchesFormat('%c%c%c', $tickets['origins'][0]->getIata());
        self::assertNotEmpty($tickets['origins'][0]->getIata());
        self::assertStringMatchesFormat('%c%c%c', $tickets['origins'][0]->getIata());

        /** @var \travelPayouts\entity\Ticket $firstTicket */
        $firstTicket = $tickets['prices'][0];

        self::assertInstanceOf('\travelPayouts\entity\Ticket', $firstTicket);

        self::assertGreaterThan(0, $firstTicket->getValue());
        self::assertGreaterThan(0, $firstTicket->getDistance());

        self::assertInstanceOf('\travelPayouts\entity\Airport', $firstTicket->getOrigin());
        self::assertInstanceOf('\travelPayouts\entity\Airport', $firstTicket->getDestination());

        self::assertNotEmpty($firstTicket->getOrigin()->getIata());
        self::assertStringMatchesFormat('%c%c%c', $firstTicket->getOrigin()->getIata());

    }

    public function testGetWeekMatrix()
    {
        $tickets = $this->service->getWeekMatrix('LED', 'HKG', '2016-01-02', '2016-01-03');

        /** @var \travelPayouts\entity\Ticket $firstTicket */
        $firstTicket = $tickets[0];

        self::assertInstanceOf('\travelPayouts\entity\Ticket', $firstTicket);

        //add check of the content

        self::assertGreaterThan(0, $firstTicket->getValue());
        self::assertGreaterThan(0, $firstTicket->getDistance());

        self::assertInstanceOf('\travelPayouts\entity\Airport', $firstTicket->getOrigin());
        self::assertInstanceOf('\travelPayouts\entity\Airport', $firstTicket->getDestination());

        self::assertNotEmpty($firstTicket->getOrigin()->getIata());
        self::assertStringMatchesFormat('%c%c%c', $firstTicket->getOrigin()->getIata());
    }

    public function testGetHolidaysByRoute()
    {
        $holidays = $this->service->getHolidaysByRoute();

        self::assertNotEmpty($holidays['title']);
        self::assertNotEmpty($holidays['dates']);

        if(time() <= $holidays['dates']['to']->getTimestamp())
        {
            $firstTicket = $holidays['origins'][0]['prices'][0];

            self::assertInstanceOf('\travelPayouts\entity\Ticket', $firstTicket);

            self::assertGreaterThan(0, $firstTicket->getValue());
            self::assertGreaterThan(0, $firstTicket->getDistance());
        }

        /** @var \travelPayouts\entity\Airport $airport */
        $airport = $holidays['origins'][0]['airport'];

        self::assertInstanceOf('\travelPayouts\entity\Airport', $airport);

        self::assertNotEmpty($airport->getIata());
        self::assertStringMatchesFormat('%c%c%c', $airport->getIata());
    }

    public function testGetCalendar()
    {
        $tickets = $this->service->getCalendar('LED', 'HKG', '2016-01');
        //strange things with method - wrong content, but works with file_get_content
    }

    public function testGetCheap()
    {

    }

    public function testGetDirect()
    {

    }

    public function testGetMonthly()
    {

    }

    public function testGetPopularRoutesFromCity()
    {

    }

    public function testGetAirlineDirections()
    {

    }

}
