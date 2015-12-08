<?php
namespace travelPayouts\services;


use travelPayouts\components\AbstractService;
use travelPayouts\components\Client;
use travelPayouts\components\iService;
use travelPayouts\entity\Ticket;

/**
 * Tickets service
 *
 * @package travelPayouts
 */
class Tickets extends AbstractService implements iService
{
    /**
     *  Class of service
     */
    const ECONOMY_CLASS = 0;

    /**
     *  Class of service
     */
    const BUSINESS_CLASS = 1;

    /**
     *  Class of service
     */
    const FIRST_CLASS = 2;

    /**
     * @var \travelPayouts\components\Client
     */
    private $_client;

    /**
     * @return \travelPayouts\components\Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->_client = $client;
    }

    /**
     * Flights found by our users in the last 48 hours.
     *
     * @param string        $origin              City IATA code.
     * @param string        $destination         City IATA code.
     * @param boolean|false $one_way             One-way or round trip. Default value: false
     * @param string        $currency            Currency of prices. Default value is rub.
     * @param string        $period_type         Type of date period. Should be in ['year', 'month', 'seasson', 'day']
     * @param int           $page                Number of the page. Default value: 1
     * @param int           $limit               Number or the results. Default value: 1
     * @param bool|true     $show_to_affiliates  false - all prices, true - prices found with affiliate marker
     *                                           (recommended). Default value is true.
     * @param string        $sorting             Sort by field. Possible values ['price', 'route',
     *                                           'distance_unit_price']
     * @param int           $trip_class          Class of trip. Can be 0,1,2
     * @param int           $trip_duration       Trip duration in days
     *
     * @return array Ticket[]
     * @throws \RuntimeException
     */
    public function getLatestPrices($origin = '', $destination = '', $one_way = false, $currency = 'rub', $period_type = 'year', $page = 1, $limit = 30, $show_to_affiliates = true, $sorting = 'price', $trip_class = self::ECONOMY_CLASS, $trip_duration = 0)
    {
        $url = 'prices/latest';

        $options = [
            'origin'             => strlen($origin) > 0 ? $origin : null,
            'destination'        => strlen($destination) > 0 ? $destination : null,
            'one_way'            => $one_way,
            'currency'           => $currency,
            'period_type'        => in_array($period_type, ['year', 'month', 'seasson', 'day'], true) ? $period_type : 'year',
            'page'               => $page,
            'limit'              => $limit,
            'show_to_affiliates' => $show_to_affiliates,
            'sorting'            => $sorting,
            'trip_class'         => $trip_class,
            'trip_duration'      => $trip_duration > 0 ? $trip_duration : null,
        ];

        $response = $this->getClient()->execute($url, $options);

        $dataService = $this->getDataService();

        return array_map(function ($item) use ($currency, $dataService)
        {
            $ticket = new Ticket();
            $ticket
                ->setValue($item['value'])
                ->setDestination($dataService->getPlace($item['destination']))
                ->setOrigin($dataService->getPlace($item['origin']))
                ->setCurrency($currency)
                ->setActual($item['actual'])
                ->setDepartDate(new \DateTime($item['depart_date']))
                ->setReturnDate(new \DateTime($item['return_date']))
                ->setFoundAt(new \DateTime($item['found_at']))
                ->setNumberOfChanges($item['number_of_changes'])
                ->setDistance($item['distance'])
                ->setShowToAffiliates($item['show_to_affiliates'])
                ->setTripClass($item['trip_class']);

            return $ticket;
        }, $response['data']);

    }

    /**
     * Prices for each day of the month, grouped by number of stops
     *
     * @param string    $origin              City IATA code.
     * @param string    $destination         City IATA code.
     * @param string    $month               First day of month in format "%Y-%m-01"
     * @param string    $currency            Currency of prices. Default value is rub.
     * @param bool|true $show_to_affiliates  false - all prices, true - prices found with affiliate marker
     *                                       (recommended). Default value is true.
     *
     * @return array Ticket[]
     * @throws \RuntimeException
     */
    public function getMonthMatrix($origin, $destination, $month, $currency = 'rub', $show_to_affiliates = true)
    {
        $url = 'prices/month-matrix';

        $date = new \DateTime($month);

        $options = [
            'currency'           => $currency,
            'origin'             => $origin,
            'destination'        => $destination,
            'show_to_affiliates' => $show_to_affiliates,
            'month'              => $date->format('Y-m-d'),
        ];

        $response = $this->getClient()->execute($url, $options);

        $dataService = $this->getDataService();

        return array_map(function ($item) use ($currency, $dataService)
        {
            $ticket = new Ticket();
            $ticket
                ->setValue($item['value'])
                ->setDestination($dataService->getPlace($item['destination']))
                ->setOrigin($dataService->getPlace($item['origin']))
                ->setCurrency($currency)
                ->setActual($item['actual'])
                ->setDepartDate(new \DateTime($item['depart_date']))
                ->setFoundAt(new \DateTime($item['found_at']))
                ->setNumberOfChanges($item['number_of_changes'])
                ->setDistance($item['distance'])
                ->setShowToAffiliates($item['show_to_affiliates'])
                ->setTripClass($item['trip_class']);

            return $ticket;
        }, $response['data']);
    }

    /**
     * Returns prices for cities closest to the ones specified.
     *
     * @param string    $origin              City IATA code.
     * @param string    $destination         City IATA code.
     * @param string    $depart_date         Depart date in format '%Y-%m-%d'.
     * @param string    $return_date         Return date in format '%Y-%m-%d'.
     * @param string    $currency            Currency of prices. Default value is rub.
     * @param bool|true $show_to_affiliates  false - all prices, true - prices found with affiliate marker
     *                                       (recommended). Default value is true.
     *
     * @return array
     * @throws \RuntimeException
     */
    public function getNearestPlacesMatrix($origin = '', $destination = '', $depart_date, $return_date, $currency = 'rub', $show_to_affiliates = true)
    {
        $arResult = [];

        $url = 'prices/nearest-places-matrix';

        $depart_date = new \DateTime($depart_date);
        $return_date = new \DateTime($return_date);

        $options = [
            'currency'           => $currency,
            'origin'             => $origin,
            'destination'        => $destination,
            'show_to_affiliates' => $show_to_affiliates,
            'depart_date'        => $depart_date->format('Y-m-d'),
            'return_date'        => $return_date->format('Y-m-d'),
        ];

        $response = $this->getClient()->execute($url, $options);

        $dataService = $this->getDataService();

        $arResult['origins'] = array_map(function ($iata) use ($dataService)
        {
            return $dataService->getAirport($iata);
        }, $response['data']['origins']);

        $arResult['destinations'] = array_map(function ($iata) use ($dataService)
        {
            return $dataService->getAirport($iata);
        }, $response['data']['destinations']);

        $arResult['prices'] = array_map(function ($item) use ($currency, $dataService)
        {
            $ticket = new Ticket();
            $ticket
                ->setValue($item['value'])
                ->setDestination($dataService->getPlace($item['destination']))
                ->setOrigin($dataService->getPlace($item['origin']))
                ->setCurrency($currency)
                ->setActual($item['actual'])
                ->setDepartDate(new \DateTime($item['depart_date']))
                ->setReturnDate(new \DateTime($item['return_date']))
                ->setFoundAt(new \DateTime($item['found_at']))
                ->setNumberOfChanges($item['number_of_changes'])
                ->setDistance($item['distance'])
                ->setShowToAffiliates($item['show_to_affiliates'])
                ->setTripClass($item['trip_class']);

            return $ticket;
        }, $response['data']['prices']);

        return $arResult;
    }

    /**
     * Price calendar. Returns prices for dates closest to the ones specified.
     *
     * @param string    $origin              City IATA code.
     * @param string    $destination         City IATA code.
     * @param string    $depart_date         Depart date in format '%Y-%m-%d'.
     * @param string    $return_date         Return date in format '%Y-%m-%d'.
     * @param string    $currency            Currency of prices. Default value is rub.
     * @param bool|true $show_to_affiliates  false - all prices, true - prices found with affiliate marker
     *                                       (recommended). Default value is true.
     *
     * @return array Ticket[]
     * @throws \RuntimeException
     */
    public function getWeekMatrix($origin, $destination, $depart_date, $return_date, $currency = 'rub', $show_to_affiliates = true)
    {
        $url = 'prices/week-matrix';

        $depart_date = new \DateTime($depart_date);
        $return_date = new \DateTime($return_date);

        $options = [
            'currency'           => $currency,
            'origin'             => $origin,
            'destination'        => $destination,
            'show_to_affiliates' => $show_to_affiliates,
            'depart_date'        => $depart_date->format('Y-m-d'),
            'return_date'        => $return_date->format('Y-m-d'),
        ];

        $response = $this->getClient()->execute($url, $options);

        $dataService = $this->getDataService();

        return array_map(function ($item) use ($currency, $dataService)
        {
            $ticket = new Ticket();
            $ticket
                ->setValue($item['value'])
                ->setDestination($dataService->getPlace($item['destination']))
                ->setOrigin($dataService->getPlace($item['origin']))
                ->setCurrency($currency)
                ->setActual($item['actual'])
                ->setDepartDate(new \DateTime($item['depart_date']))
                ->setReturnDate(new \DateTime($item['return_date']))
                ->setFoundAt(new \DateTime($item['found_at']))
                ->setNumberOfChanges($item['number_of_changes'])
                ->setDistance($item['distance'])
                ->setShowToAffiliates($item['show_to_affiliates'])
                ->setTripClass($item['trip_class']);

            return $ticket;
        }, $response['data']);

    }

    /**
     * The best offers on holidays from popular cities
     *
     * @return array
     * @throws \RuntimeException
     */
    public function getHolidaysByRoute()
    {
        $arResult = [];

        $url = 'prices/holidays-by-routes';

        $response = $this->getClient()->execute($url, []);

        $arResult['title'] = $response['data']['title'];

        $arResult['dates'] = array_map(function ($item)
        {
            return new \DateTime($item);
        }, $response['data']['dates']);

        $dataService = $this->getDataService();

        $arResult['origins'] = array_map(function ($originArray) use ($dataService)
        {
            return [
                'airport' => $dataService->getAirport($originArray['iata']),
                'prices'  => array_map(function ($item) use ($dataService)
                {
                    $ticket = new Ticket();
                    $ticket
                        ->setValue($item['value'])
                        ->setDestination($dataService->getPlace($item['destination']))
                        ->setOrigin($dataService->getPlace($item['origin']))
                        ->setCurrency('rub')
                        ->setActual($item['actual'])
                        ->setDepartDate(new \DateTime($item['depart_date']))
                        ->setReturnDate(new \DateTime($item['return_date']))
                        ->setFoundAt(new \DateTime($item['found_at']))
                        ->setNumberOfChanges($item['number_of_changes'])
                        ->setDistance($item['distance'])
                        ->setShowToAffiliates($item['show_to_affiliates'])
                        ->setTripClass($item['trip_class']);

                    return $ticket;
                }, $originArray['prices']),
            ];
        }, $response['data']['origins']);

        return $arResult;
    }

    /**
     * Returns the cheapest non-stop tickets, as well as tickets with 1 or 2 stops,
     * for the selected route for each day of the selected month.
     *
     * @param string $origin         City IATA code.
     * @param string $destination    City IATA code.
     * @param string $depart_date    Depart date in format '%Y-%m-%d'.
     * @param string $return_date    Return date in format '%Y-%m-%d'.
     * @param string $currency       Currency of prices. Default value is rub.
     * @param string $calendar_type  Field for which the calendar is to be built.
     *                               Default value is departure_date. Should be in ["departure_date", "return_date"].
     * @param int    $trip_duration  Trip duration in days.
     *
     * @return array Ticket[]
     * @throws \RuntimeException
     */
    public function getCalendar($origin, $destination, $depart_date, $return_date = '', $currency = 'rub', $calendar_type = 'departure_date', $trip_duration = 0)
    {
        $url = 'prices/calendar';

        $depart_date = new \DateTime($depart_date);
        $return_date = strlen($return_date) > 0 ? new \DateTime($return_date) : false;

        $options = [
            'currency'      => in_array($currency, ['usd', 'eur', 'rub'], true) ? $currency : 'rub',
            'origin'        => $origin,
            'destination'   => $destination,
            'depart_date'   => $depart_date->format('Y-m'),
            'return_date'   => $return_date ? $return_date->format('Y-m') : null,
            'trip_duration' => $trip_duration > 0 ? $trip_duration : null,
            'calendar_type' => in_array($calendar_type, ['departure_date', 'return_date'], true) ? $calendar_type : null,
        ];

        $response = $this->getClient()->setApiVersion('v1')->execute($url, $options);

        $dataService = $this->getDataService();

        return array_map(function ($item) use ($currency, $dataService)
        {
            $ticket = new Ticket();
            $ticket
                ->setValue($item['price'])
                ->setDestination($dataService->getPlace($item['destination']))
                ->setOrigin($dataService->getPlace($item['origin']))
                ->setCurrency($currency)
                ->setDepartDate(new \DateTime($item['departure_at']))
                ->setReturnDate(new \DateTime($item['return_at']))
                ->setExpires(new \DateTime($item['expires_at']))
                ->setNumberOfChanges($item['transfers'])
                ->setAirline($item['airline'])
                ->setFlightNumber($item['flight_number']);

            return $ticket;
        }, $response['data']);
    }

    /**
     * Returns the cheapest non-stop tickets, as well as tickets with 1 or 2 stops,
     * for the selected route with filters by departure and return date.
     *
     * @param string $origin      City IATA code.
     * @param string $destination City IATA code.
     * @param string $depart_date Depart date in format '%Y-%m-%d'.
     * @param string $return_date Return date in format '%Y-%m-%d'.
     * @param string $currency    Currency of prices. Default value is rub.
     *
     * @return array Ticket[]
     * @throws \RuntimeException
     */
    public function getCheap($origin, $destination, $depart_date = '', $return_date = '', $currency = 'rub')
    {
        $url = 'prices/cheap';

        $depart = new \DateTime($depart_date);
        $return = new \DateTime($return_date);

        $depart = preg_match('/(\d{4}\-\d{2}\-\d{2})/', $depart_date) ? $depart->format('Y-m-d') : $depart->format('Y-m');
        $return = preg_match('/(\d{4}\-\d{2}\-\d{2})/', $depart_date) ? $return->format('Y-m-d') : $return->format('Y-m');

        $options = [
            'currency'    => in_array($currency, ['usd', 'eur', 'rub'], true) ? $currency : 'rub',
            'origin'      => $origin,
            'destination' => $destination,
            'depart_date' => $depart_date !== '' ? $depart : null,
            'return_date' => $return_date !== '' ? $return : null,
        ];

        $response = $this->getClient()->setApiVersion('v1')->execute($url, $options);

        $dataService = $this->getDataService();

        return array_map(function ($item) use ($currency, $destination, $origin, $dataService)
        {
            $ticket = new Ticket();
            $ticket
                ->setValue($item['price'])
                ->setDestination($dataService->getPlace($destination))
                ->setOrigin($dataService->getPlace($origin))
                ->setCurrency($currency)
                ->setDepartDate(new \DateTime($item['departure_at']))
                ->setReturnDate(new \DateTime($item['return_at']))
                ->setExpires(new \DateTime($item['expires_at']))
                ->setAirline($item['airline'])
                ->setFlightNumber($item['flight_number']);

            return $ticket;
        }, $response['data'][$destination]);
    }

    /**
     * Non-stop tickets. Returns the cheapest non-stop tickets for the selected route with filters by departure and
     * return date.
     *
     * @param string $origin      City IATA code.
     * @param string $destination City IATA code.
     * @param string $depart_date Depart date in format '%Y-%m-%d'.
     * @param string $return_date Return date in format '%Y-%m-%d'.
     * @param string $currency    Currency of prices. Default value is rub.
     *
     * @return Ticket
     * @throws \RuntimeException
     */
    public function getDirect($origin, $destination, $depart_date = '', $return_date = '', $currency = 'rub')
    {
        $url = 'prices/direct';

        $depart = new \DateTime($depart_date);
        $return = new \DateTime($return_date);

        $depart = preg_match('/(\d{4}\-\d{2}\-\d{2})/', $depart_date) ? $depart->format('Y-m-d') : $depart->format('Y-m');
        $return = preg_match('/(\d{4}\-\d{2}\-\d{2})/', $depart_date) ? $return->format('Y-m-d') : $return->format('Y-m');

        $options = [
            'currency'    => in_array($currency, ['usd', 'eur', 'rub'], true) ? $currency : 'rub',
            'origin'      => $origin,
            'destination' => $destination,
            'depart_date' => $depart_date !== '' ? $depart : null,
            'return_date' => $return_date !== '' ? $return : null,
        ];

        $response = $this->getClient()->setApiVersion('v1')->execute($url, $options);

        //TODO: replace with city_code
        $item = array_shift($response['data']);

        if(count($item) === 0 && $response['success'])
        {
            return null;
        }

        $dataService = $this->getDataService();

        $ticket = new Ticket();
        $ticket
            ->setValue($item[0]['price'])
            ->setDestination($dataService->getPlace($destination))
            ->setOrigin($dataService->getPlace($origin))
            ->setCurrency($currency)
            ->setDepartDate(new \DateTime($item[0]['departure_at']))
            ->setReturnDate(new \DateTime($item[0]['return_at']))
            ->setExpires(new \DateTime($item[0]['expires_at']))
            ->setAirline($item[0]['airline'])
            ->setFlightNumber($item[0]['flight_number']);

        return $ticket;
    }

    /**
     * Cheapest tickets grouped by month
     *
     * @param string $origin      City IATA code.
     * @param string $destination City IATA code.
     * @param string $currency    Currency of prices. Default value is rub.
     *
     * @return array Ticket[]
     * @throws \RuntimeException
     */
    public function getMonthly($origin, $destination, $currency = 'rub')
    {
        $url = 'prices/monthly';

        $options = [
            'currency'    => in_array($currency, ['usd', 'eur', 'rub'], true) ? $currency : 'rub',
            'origin'      => $origin,
            'destination' => $destination,
        ];

        $response = $this->getClient()->setApiVersion('v1')->execute($url, $options);

        $dataService = $this->getDataService();

        return array_map(function ($item) use ($currency, $dataService)
        {
            $ticket = new Ticket();
            $ticket
                ->setValue($item['price'])
                ->setDestination($dataService->getPlace($item['destination']))
                ->setOrigin($dataService->getPlace($item['origin']))
                ->setCurrency($currency)
                ->setDepartDate(new \DateTime($item['departure_at']))
                ->setReturnDate(new \DateTime($item['return_at']))
                ->setExpires(new \DateTime($item['expires_at']))
                ->setNumberOfChanges($item['transfers'])
                ->setAirline($item['airline'])
                ->setFlightNumber($item['flight_number']);

            return $ticket;
        }, $response['data']);
    }

    /**
     * Returns most popular routes for selected origin
     *
     * @param string $origin City IATA code.
     *
     * @return array Ticket[]
     * @throws \RuntimeException
     */
    public function getPopularRoutesFromCity($origin)
    {
        $url = 'city-directions';

        $options = [
            'origin' => $origin,
        ];

        $response = $this->getClient()->setApiVersion('v1')->execute($url, $options);

        $dataService = $this->getDataService();

        return array_map(function ($item) use ($dataService)
        {
            $ticket = new Ticket();
            $ticket
                ->setValue($item['price'])
                ->setDestination($dataService->getPlace($item['destination']))
                ->setOrigin($dataService->getPlace($item['origin']))
                ->setCurrency('rub')
                ->setDepartDate(new \DateTime($item['departure_at']))
                ->setReturnDate(new \DateTime($item['return_at']))
                ->setExpires(new \DateTime($item['expires_at']))
                ->setNumberOfChanges($item['transfers'])
                ->setAirline($item['airline'])
                ->setFlightNumber($item['flight_number']);

            return $ticket;
        }, $response['data']);
    }

    /**
     * @param string $airline_code Company IATA code in uppercase.
     * @param int    $limit        Number of records. Default value: 30. Max value: 1000
     *
     * @return array
     * @throws \RuntimeException
     */
    public function getAirlineDirections($airline_code, $limit = 30)
    {
        $arResult = [];
        $url      = 'airline-directions';

        $options = [
            'airline_code' => $airline_code,
            'limit'        => $limit,
        ];

        $response = $this->getClient()->setApiVersion('v1')->execute($url, $options);

        $dataService = $this->getDataService();

        foreach ($response['data'] as $direction => $rating)
        {

            list($origin, $destination) = explode('-', $direction);

            $arResult[] = [
                'origin'      => $dataService->getPlace($origin),
                'destination' => $dataService->getPlace($destination),
                'rating'      => $rating,
            ];
        }

        return $arResult;

    }
}