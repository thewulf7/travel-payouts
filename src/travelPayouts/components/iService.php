<?php
namespace travelPayouts\components;


interface iService
{
    /**
     * @return \travelPayouts\components\Client
     */
    public function getClient();

    /**
     * @param Client $client
     */
    public function setClient($client);
}