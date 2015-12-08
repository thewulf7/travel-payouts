<?php
namespace thewulf7\travelPayouts\services;


use thewulf7\travelPayouts\components\AbstractService;
use thewulf7\travelPayouts\components\iService;
use thewulf7\travelPayouts\components\Client;

/**
 * Class Flight
 *
 * @package thewulf7\travelPayouts\services
 */
class FlightService extends AbstractService implements iService
{
    /**
     * @var Client
     */
    private $_client;

    /**
     * @var int
     */
    private $_marker;

    /**
     * @var string
     */
    private $_host;

    /**
     * @var string
     */
    private $_ip;

    /**
     * @var array
     */
    private $_segments = [];

    /**
     * @var array
     */
    private $_passengers = [
        'adults'   => 0,
        'children' => 0,
        'infants'  => 0,
    ];

    /**
     * @param string $locale
     * @param string $trip_class
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function search($locale = 'ru', $trip_class = 'Y')
    {
        $url = 'flight_search';

        $options = [
            'json' => [
                'marker'     => $this->getMarker(),
                'host'       => $this->getHost(),
                'user_ip'    => $this->getIp(),
                'locale'     => in_array($locale, ['en', 'ru', 'de', 'fr', 'it', 'pl', 'th'], true) ? $locale : 'ru',
                'trip_class' => in_array($trip_class, ['Y', 'C'], true) ? $trip_class : 'Y',
                'passengers' => $this->getPassengers(),
                'segments'   => $this->getSegments(),
            ],
        ];

        $options['json']['signature'] = $this->getSignature($options['json']);

        return $this->getClient()->setApiVersion('v1')->execute($url, $options, 'POST', false);
    }

    /**
     * Get search results
     *
     * @param string $uuid Search ID
     *
     * @return mixed
     */
    public function getSearchResults($uuid)
    {
        $url = 'flight_search_results';

        $options = [
            'uuid' => $uuid,
        ];

        return $this->getClient()->setApiVersion('v1')->execute($url, $options);
    }

    /**
     * @param array $options
     *
     * @return string
     */
    public function getSignature(array $options)
    {
        ksort($options);

        ksort($options['passengers']);

        foreach ($options['segments'] as $key => $value)
        {
            ksort($value);
            $options['segments'][$key] = implode(':', $value);
        }

        $options['passengers'] = implode(':', $options['passengers']);
        $options['segments']   = implode(':', $options['segments']);

        return md5(implode(':', $options));

    }

    /**
     * @return \thewulf7\travelPayouts\components\Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @param Client $client
     *
     * @return $this
     */
    public function setClient($client)
    {
        $this->_client = $client;

        $this->_client->setApiVersion('v1');

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMarker()
    {
        return $this->_marker;
    }

    /**
     * @param mixed $marker
     *
     * @return $this
     */
    public function setMarker($marker)
    {
        $this->_marker = $marker;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->_host;
    }

    /**
     * @param mixed $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->_host = $host;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->_ip;
    }

    /**
     * @param mixed $ip
     *
     * @return $this
     */
    public function setIp($ip)
    {
        $this->_ip = $ip;

        return $this;
    }

    /**
     * @return array
     */
    public function getSegments()
    {
        return $this->_segments;
    }

    /**
     * Add segment
     *
     * @param string $origin
     * @param string $destination
     * @param string $date
     *
     * @return $this
     */
    public function addSegment($origin, $destination, $date)
    {
        $date = new \DateTime($date);

        $this->_segments[] = [
            'origin'      => $origin,
            'destination' => $destination,
            'date'        => $date->format('Y-m-d'),
        ];

        return $this;
    }

    /**
     * Clear all segments
     *
     * @return $this
     */
    public function clearSegments()
    {
        $this->_segments = [];

        return $this;
    }

    /**
     * @return array
     */
    public function getPassengers()
    {
        return $this->_passengers;
    }

    /**
     * Add $count passenger of $type type
     *
     * @param string $type
     * @param int    $count
     *
     * @return $this|bool
     */
    public function addPassenger($type, $count = 1)
    {
        if (isset($this->_passengers[$type]))
        {
            $this->_passengers[$type] += $count;

            return $this;
        }

        return false;
    }

    /**
     * Remove $count passengers of $type type
     *
     * @param string $type
     * @param int    $count
     *
     * @return $this|bool
     */
    public function removePassenger($type, $count = 1)
    {
        if (isset($this->_passengers[$type]))
        {
            $this->_passengers[$type] -= $count;

            return $this;
        }

        return false;
    }

    /**
     * Remove all passengers
     *
     * @return $this
     */
    public function clearPassengers()
    {
        $this->_passengers = [];

        return $this;
    }
}