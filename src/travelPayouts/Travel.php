<?php
namespace travelPayouts;


use travelPayouts\components\Client;

/**
 * Class Travel
 *
 * @package travelPayouts
 */
class Travel
{
    /**
     * @var Client
     */
    private $_client;

    /**
     * @param string $token
     *
     * @throws \RuntimeException
     */
    public function __construct($token)
    {
        if ($token === '')
        {
            throw new \RuntimeException('Invalid token');
        }

        $this->_client = new Client($token);
    }

    /**
     * Get tickets service
     *
     * @return services\Tickets
     */
    public function getTicketsService()
    {
        $service = new \travelPayouts\services\Tickets();
        $service->setClient($this->getClient());

        return $service;
    }

    /**
     * Get data service
     *
     * @return services\Data
     */
    public function getDataService()
    {
        $service = new \travelPayouts\services\Data();
        $service->setClient($this->getClient());

        return $service;
    }

    /**
     * Get flight service
     *
     * @return services\Flight
     */
    public function getFlightService()
    {
        $service = new \travelPayouts\services\Flight();
        $service->setClient($this->getClient());

        return $service;
    }

    /**
     * Get client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->_client;
    }
}