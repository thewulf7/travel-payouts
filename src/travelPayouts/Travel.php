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
    private $_client;

    /**
     * @param string $token
     */
    public function __construct($token)
    {
        $this->_client = new Client($token);
    }

    public function getTicketsService()
    {
        $service = new \travelPayouts\services\Tickets();
        $service->setClient($this->getClient());

        return $service;
    }

    public function getDataService()
    {
        $service = new \travelPayouts\services\Data();
        $service->setClient($this->getClient());

        return $service;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->_client;
    }
}