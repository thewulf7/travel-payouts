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
     * @var string
     */
    private $_token;

    /**
     * @param string $token
     */
    public function __construct($token = '')
    {
        if ($token !== '')
        {
            $this->setToken($token);
        }
    }

    private function init()
    {
        $this->_client = new Client($this->getToken());
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

    /**
     * Get Token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Travel
     */
    public function setToken($token)
    {
        $this->_token = $token;
        $this->init();

        return $this;
    }

    /**
     * Get tickets service
     *
     * @return services\Tickets
     * @throws \RuntimeException
     */
    public function getTicketsService()
    {
        if (!($this->getClient() instanceof Client))
        {
            throw new \RuntimeException('No token specified');
        }

        $service = new \travelPayouts\services\Tickets();
        $service->setClient($this->getClient());

        return $service;
    }

    /**
     * Get data service
     *
     * @return services\Data
     * @throws \RuntimeException
     */
    public function getDataService()
    {
        if (!($this->getClient() instanceof Client))
        {
            throw new \RuntimeException('No token specified');
        }

        $service = new \travelPayouts\services\Data();
        $service->setClient($this->getClient());

        return $service;
    }

    /**
     * Get flight service
     *
     * @return services\Flight
     * @throws \RuntimeException
     */
    public function getFlightService()
    {
        if (!($this->getClient() instanceof Client))
        {
            throw new \RuntimeException('No token specified');
        }

        $service = new \travelPayouts\services\Flight();
        $service->setClient($this->getClient());

        return $service;
    }
}