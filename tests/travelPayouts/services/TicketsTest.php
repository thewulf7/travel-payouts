<?php

class TicketsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \travelPayouts\services\Tickets
     */
    protected $service;

    public function setUp()
    {
        $travel        = new \travelPayouts\Travel('321d6a221f8926b5ec41ae89a3b2ae7b');
        $this->service = $travel->getTicketsService();

        date_default_timezone_set('UTC');
    }

    public function testGetLatestPrices()
    {
        $origin      = 'LED';
        $destination = 'MOW';

        $tickets = $this->service->getLatestPrices($origin, $destination, false, 'rub', 'year', 1, 10);
        /** @var \travelPayouts\entity\Ticket $ticket */
        foreach ($tickets as $ticket)
        {
            self::assertGreaterThan(0, $ticket->getValue());
            self::assertGreaterThan(0, $ticket->getDistance());

            self::assertEquals($origin, $ticket->getOrigin()->getIata());
            self::assertEquals($destination, $ticket->getDestination()->getIata());
        }
    }

    public function testGetMonthMatrix()
    {
        $origin      = 'LED';
        $destination = 'HKT';
        $month       = new \DateTime('+1 month');
        $date        = $month->modify('first day of this month')->format('Y-m-d H:i:s');

        $dateArray = [
            $month->setTime(0, 0, 0)->getTimestamp(),
            $month->modify('last day of this month')->getTimestamp(),
        ];

        $tickets = $this->service->getMonthMatrix($origin, $destination, $date);
        /** @var \travelPayouts\entity\Ticket $ticket */
        foreach ($tickets as $ticket)
        {
            self::assertGreaterThan(0, $ticket->getValue());
            self::assertGreaterThan(0, $ticket->getDistance());

            self::assertEquals($origin, $ticket->getOrigin()->getIata());
            self::assertEquals($destination, $ticket->getDestination()->getIata());

            self::assertGreaterThanOrEqual($dateArray[0], $ticket->getDepartDate()->getTimestamp());
            self::assertLessThanOrEqual($dateArray[1], $ticket->getDepartDate()->getTimestamp());
        }
    }

    public function testGetNearestPlacesMatrix()
    {
        $origin      = 'LED';
        $destination = 'HKT';
        $depart      = '2016-01-02';
        $return      = '2016-02-02';

        $tickets = $this->service->getNearestPlacesMatrix($origin, $destination, $depart, $return);

        $departObject = new \DateTime($depart);
        $returnObject = new \DateTime($return);

        $departA = [
            $departObject->modify('-7 day')->getTimestamp(),
            $departObject->modify('+14 day')->getTimestamp(),
        ];

        $returnA = [
            $returnObject->modify('-7 day')->getTimestamp(),
            $returnObject->modify('+14 day')->getTimestamp(),
        ];

        $origins      = array_map(function ($airport)
        {
            return $airport->getIata();
        }, $tickets['origins']);
        $destinations = array_map(function ($airport)
        {
            return $airport->getIata();
        }, $tickets['destinations']);

        self::assertContains($origin, $origins);
        self::assertContains($destination, $destinations);

        /** @var \travelPayouts\entity\Ticket $ticket */
        foreach ($tickets['prices'] as $ticket)
        {
            self::assertGreaterThan(0, $ticket->getValue());
            self::assertGreaterThan(0, $ticket->getDistance());

            self::assertContains($ticket->getOrigin()->getIata(), $origins);
            self::assertContains($ticket->getDestination()->getIata(), $destinations);

            self::assertGreaterThanOrEqual($departA[0], $ticket->getDepartDate()->getTimestamp());
            self::assertGreaterThanOrEqual($returnA[0], $ticket->getReturnDate()->getTimestamp());

            self::assertLessThanOrEqual($returnA[1], $ticket->getReturnDate()->getTimestamp());
            self::assertLessThanOrEqual($departA[1], $ticket->getDepartDate()->getTimestamp());
        }

    }

    public function testGetWeekMatrix()
    {
        $origin      = 'LED';
        $destination = 'HKT';
        $depart      = '2016-01-02';
        $return      = '2016-02-02';

        $tickets = $this->service->getWeekMatrix($origin, $destination, $depart, $return);

        $departObject = new \DateTime($depart);
        $returnObject = new \DateTime($return);

        $departA = [
            $departObject->modify('-7 day')->getTimestamp(),
            $departObject->modify('+14 day')->getTimestamp(),
        ];

        $returnA = [
            $returnObject->modify('-7 day')->getTimestamp(),
            $returnObject->modify('+14 day')->getTimestamp(),
        ];

        /** @var \travelPayouts\entity\Ticket $ticket */
        foreach ($tickets as $ticket)
        {
            self::assertEquals($origin, $ticket->getOrigin()->getIata());
            self::assertEquals($destination, $ticket->getDestination()->getIata());
            self::assertGreaterThan(0, $ticket->getValue());
            self::assertGreaterThan(0, $ticket->getDistance());

            self::assertGreaterThanOrEqual($departA[0], $ticket->getDepartDate()->getTimestamp());
            self::assertGreaterThanOrEqual($returnA[0], $ticket->getReturnDate()->getTimestamp());

            self::assertLessThanOrEqual($returnA[1], $ticket->getReturnDate()->getTimestamp());
            self::assertLessThanOrEqual($departA[1], $ticket->getDepartDate()->getTimestamp());
        }
    }

    public function testGetHolidaysByRoute()
    {
        $holidays = $this->service->getHolidaysByRoute();

        self::assertNotEmpty($holidays['title']);
        self::assertNotEmpty($holidays['dates']);

        if (time() <= $holidays['dates']['to']->getTimestamp())
        {
            $firstTicket = $holidays['origins'][0]['prices'][0];

            self::assertGreaterThan(0, $firstTicket->getValue());
            self::assertGreaterThan(0, $firstTicket->getDistance());
        }

        /** @var \travelPayouts\entity\Airport $airport */
        $airport = $holidays['origins'][0]['airport'];

        self::assertNotEmpty($airport->getIata());
        self::assertStringMatchesFormat('%c%c%c', $airport->getIata());
    }

    public function testGetCalendar()
    {
        $origin      = 'LED';
        $destination = 'HKT';
        $date        = '2016-01';

        $tickets = $this->service->getCalendar($origin, $destination, $date);

        /** @var \travelPayouts\entity\Ticket $ticket */
        foreach ($tickets as $ticket)
        {
            self::assertEquals($origin, $ticket->getOrigin()->getIata());
            self::assertEquals($destination, $ticket->getDestination()->getIata());
            self::assertEquals($date, $ticket->getDepartDate()->format('Y-m'));
            self::assertGreaterThan(0, $ticket->getValue());
        }

    }

    public function testGetCheap()
    {
        $origin      = 'MOW';
        $destination = 'HKT';

        $month = new \DateTime('+1 month');

        $depart = $month->setTime(0, 0, 0)->format('Y-m');

        $departA = [
            $month->modify('last day of previous month')->getTimestamp(),
            $month->modify('+1 month')->modify('first day of next month')->getTimestamp(),
        ];

        $return = $month->format('Y-m');

        $returnA = [
            $month->modify('last day of previous month')->getTimestamp(),
            $month->modify('+1 month')->modify('first day of this month')->getTimestamp(),
        ];

        $tickets = $this->service->getCheap($origin, $destination, $depart, $return);

        /** @var \travelPayouts\entity\Ticket $ticket */
        foreach ($tickets as $ticket)
        {
            self::assertEquals($origin, $ticket->getOrigin()->getIata());
            self::assertEquals($destination, $ticket->getDestination()->getIata());
            self::assertGreaterThan(0, $ticket->getValue());

            self::assertGreaterThanOrEqual($departA[0], $ticket->getDepartDate()->getTimestamp());
            self::assertGreaterThanOrEqual($returnA[0], $ticket->getReturnDate()->getTimestamp());

            self::assertLessThanOrEqual($returnA[1], $ticket->getReturnDate()->getTimestamp());
            self::assertLessThanOrEqual($departA[1], $ticket->getDepartDate()->getTimestamp());

        }
    }

    public function testGetDirect()
    {
        $origin      = 'MOW';
        $destination = 'JFK';

        $month = new \DateTime('+1 month');

        $depart = $month->setTime(0, 0, 0)->format('Y-m');

        $departA = [
            $month->modify('last day of previous month')->getTimestamp(),
            $month->modify('+1 month')->modify('first day of next month')->getTimestamp(),
        ];

        $return = $month->format('Y-m');

        $returnA = [
            $month->modify('last day of previous month')->getTimestamp(),
            $month->modify('+1 month')->modify('first day of this month')->getTimestamp(),
        ];

        /** @var \travelPayouts\entity\Ticket $ticket */
        $ticket = $this->service->getDirect($origin, $destination, $depart, $return);

        self::assertEquals($origin, $ticket->getOrigin()->getIata());
        self::assertEquals($destination, $ticket->getDestination()->getIata());
        self::assertGreaterThan(0, $ticket->getValue());

        self::assertGreaterThanOrEqual($departA[0], $ticket->getDepartDate()->getTimestamp());
        self::assertGreaterThanOrEqual($returnA[0], $ticket->getReturnDate()->getTimestamp());

        self::assertLessThanOrEqual($returnA[1], $ticket->getReturnDate()->getTimestamp());
        self::assertLessThanOrEqual($departA[1], $ticket->getDepartDate()->getTimestamp());
    }

    public function testGetDirectNotExist()
    {
        $origin      = 'LED';
        $destination = 'JFK';

        $month = new \DateTime('+1 month');

        $depart = $month->setTime(0, 0, 0)->format('Y-m');
        $return = $month->format('Y-m');

        /** @var \travelPayouts\entity\Ticket $ticket */
        $ticket = $this->service->getDirect($origin, $destination, $depart, $return);

        self::assertEquals(null, $ticket);
    }

    public function testGetMonthly()
    {
        $origin      = 'MOW';
        $destination = 'HKT';

        $tickets = $this->service->getMonthly($origin, $destination);

        /** @var \travelPayouts\entity\Ticket $ticket */
        foreach ($tickets as $ticket)
        {
            self::assertEquals($origin, $ticket->getOrigin()->getIata());
            self::assertEquals($destination, $ticket->getDestination()->getIata());
            self::assertGreaterThan(0, $ticket->getValue());
        }
    }

    public function testGetPopularRoutesFromCity()
    {
        $origin = 'LED';

        $tickets = $this->service->getPopularRoutesFromCity($origin);

        /** @var \travelPayouts\entity\Ticket $ticket */
        foreach ($tickets as $ticket)
        {
            self::assertEquals($origin, $ticket->getOrigin()->getIata());
            self::assertStringMatchesFormat('%c%c%c', $ticket->getDestination()->getIata());
            self::assertGreaterThan(0, $ticket->getValue());
        }
    }

    public function testGetAirlineDirections()
    {
        $iata = 'SU';

        $directions = $this->service->getAirlineDirections($iata, 10);

        foreach ($directions as $dir)
        {
            self::assertInstanceOf('\travelPayouts\entity\Airport', $dir['origin']);
            self::assertInstanceOf('\travelPayouts\entity\Airport', $dir['destination']);
            self::assertGreaterThan(0, $dir['rating']);
        }

    }

}
