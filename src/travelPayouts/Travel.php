<?php
namespace travelPayouts;


use travelPayouts\components\Client;
use travelPayouts\components\ServiceInjector;
use travelPayouts\services\TicketsService;
use travelPayouts\services\DataService;
use travelPayouts\services\FlightService;
use travelPayouts\services\PartnerService;

/**
 * Class Travel
 *
 * @package travelPayouts
 */
class Travel
{
    use ServiceInjector;

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
}