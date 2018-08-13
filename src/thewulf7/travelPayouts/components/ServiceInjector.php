<?php

namespace thewulf7\travelPayouts\components;

use thewulf7\travelPayouts\services\DataService;
use thewulf7\travelPayouts\services\FlightService;
use thewulf7\travelPayouts\services\HotelsSearchService;
use thewulf7\travelPayouts\services\HotelsService;
use thewulf7\travelPayouts\services\PartnerService;
use thewulf7\travelPayouts\services\TicketsService;

/**
 * Class ServiceInjector
 *
 * @method DataService         getDataService()
 * @method FlightService       getFlightService()
 * @method PartnerService      getPartnerService()
 * @method TicketsService      getTicketsService()
 * @method HotelsService       getHotelsService()
 * @method HotelsSearchService getHotelsSearchService()
 *
 * @package thewulf7\travelPayouts\components
 */
trait ServiceInjector
{

    private $_serviceMap = [];

    /**
     * Get service
     *
     * @param $name
     * @param $args
     *
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($name, $args)
    {
        if (array_key_exists($name, $this->getServiceMap())) {
            return $this->getService($this->_serviceMap[$name]);
        }

        throw new \BadMethodCallException('Calling unknown method: ' . get_class($this) . "::$name()");
    }

    /**
     * @return array
     */
    private function getServiceMap()
    {
        if (count($this->_serviceMap) === 0) {
            $services = require(__DIR__ . '/../config/services.php');

            foreach ($services as $serviceName => $serviceClass) {
                $methodName                     = 'get' . ucfirst($serviceName);
                $this->_serviceMap[$methodName] = $serviceClass;
            }
        }

        return $this->_serviceMap;
    }

    /**
     * @param $serviceName
     *
     * @return mixed
     */
    private function getService($serviceName)
    {

        if (!($this->getClient() instanceof Client)) {
            throw new \RuntimeException('No token specified');
        }
        $service = new $serviceName();
        $service->setClient($this->getClient());

        return $service;
    }
}