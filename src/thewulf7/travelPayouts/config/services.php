<?php

namespace thewulf7\travelPayouts\config;


use thewulf7\travelPayouts\components\iService;
use thewulf7\travelPayouts\services\DataService;
use thewulf7\travelPayouts\services\FlightService;
use thewulf7\travelPayouts\services\HotelsSearchService;
use thewulf7\travelPayouts\services\HotelsService;
use thewulf7\travelPayouts\services\PartnerService;
use thewulf7\travelPayouts\services\TicketsService;

return [
    iService::DATA_SERVICE          => DataService::class,
    iService::FLIGHT_SERVICE        => FlightService::class,
    iService::PARTNER_SERVICE       => PartnerService::class,
    iService::TICKETS_SERVICE       => TicketsService::class,
    iService::HOTELS_SERVICE        => HotelsService::class,
    iService::HOTELS_SEARCH_SERVICE => HotelsSearchService::class,
];