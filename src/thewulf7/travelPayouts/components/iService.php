<?php

namespace thewulf7\travelPayouts\components;


interface iService
{
    const DATA_SERVICE          = 'DataService';
    const FLIGHT_SERVICE        = 'FlightService';
    const PARTNER_SERVICE       = 'PartnerService';
    const TICKETS_SERVICE       = 'TicketsService';
    const HOTELS_SERVICE        = 'HotelsService';
    const HOTELS_SEARCH_SERVICE = 'HotelsSearchService';

    /**
     * @return \thewulf7\travelPayouts\components\Client
     */
    public function getClient();

    /**
     * @param Client $client
     */
    public function setClient($client);
}