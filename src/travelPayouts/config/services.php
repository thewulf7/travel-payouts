<?php

namespace travelPayouts\config;


use travelPayouts\components\iService;
use travelPayouts\services\TicketsService;
use travelPayouts\services\DataService;
use travelPayouts\services\FlightService;
use travelPayouts\services\PartnerService;

return [
    iService::DATA_SERVICE    => DataService::class,
    iService::FLIGHT_SERVICE  => FlightService::class,
    iService::PARTNER_SERVICE => PartnerService::class,
    iService::TICKETS_SERVICE => TicketsService::class,
];