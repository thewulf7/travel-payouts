<?php
namespace travelPayouts\components;


trait services
{
    /**
     * Get tickets service
     *
     * @return \travelPayouts\services\Tickets
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
     * @return \travelPayouts\services\Data
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
     * @return \travelPayouts\services\Flight
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