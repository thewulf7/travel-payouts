<?php
namespace thewulf7\travelPayouts\services;


use thewulf7\travelPayouts\components\AbstractService;
use thewulf7\travelPayouts\components\iService;
use thewulf7\travelPayouts\components\Client;

/**
 * Class PartnerService
 *
 * @package thewulf7\travelPayouts\services
 */
class PartnerService extends AbstractService implements iService
{
    /**
     * @var Client
     */
    private $_client;

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

        return $this;
    }

    /**
     * Returns your current balance.
     *
     * @return array
     */
    public function getBalance()
    {
        $url = 'statistics/balance';

        $response = $this->getClient()->execute($url, []);

        return $response['data'];
    }

    /**
     * Returns a list of payments made to you.
     *
     * @return array
     */
    public function getPayments()
    {
        $url = 'statistics/payments';

        $response = $this->getClient()->execute($url, []);

        return $response['data']['payments'];
    }

    /**
     * Returns your number of searches/clicks/reservations and corresponding earnings, grouped by a parameter.
     * Monthly data for hotels and for plane tickets.
     * Data can be filtered by host and/or marker.
     *
     * @param string $groupBy Value to use for grouping. Use date, host, or marker to sort by the respective parameter.
     *                        Should be in ["date", "host", "marker"].
     *                        Default value is date.
     * @param string $month   First day of month in format "%Y-%m-01". Default value is NOW().
     * @param string $host    Filter by the host. Default value is null.
     * @param string $marker  Filter by the marker. Default value is null.
     *
     * @return array
     */
    public function getSales($groupBy = 'date', $month = null, $host = null, $marker = null)
    {
        $url = 'statistics/sales';

        $date = new \DateTime($month);

        $options = [
            'group_by'      => in_array($groupBy, ['date', 'host', 'marker'], true) ? $groupBy : null,
            'month'         => $date->modify('first day of this month')->setTime(0, 0, 0)->format('Y-m-d'),
            'host_filter'   => $host,
            'marker_filter' => $marker,
        ];

        $response = $this->getClient()->execute($url, $options);

        return $response['data']['sales'];
    }

    /**
     * Returns your number of searches/clicks/reservations and corresponding earnings, grouped by date and marker.
     * Monthly data for hotels and for plane tickets.
     * Data can be filtered by host and/or marker.
     *
     * @param string $month  First day of month in format "%Y-%m-01". Default value is NOW().
     * @param string $host   Filter by the host. Default value is null.
     * @param string $marker Filter by the marker. Default value is null.
     *
     * @return array
     */
    public function getDetailedSales($month = null, $host = null, $marker = null)
    {
        $url = 'statistics/detailed-sales';

        $date = new \DateTime($month);

        $options = [
            'group_by'      => 'date_marker',
            'month'         => $date->modify('first day of this month')->setTime(0, 0, 0)->format('Y-m-d'),
            'host_filter'   => $host,
            'marker_filter' => $marker,
        ];

        $response = $this->getClient()->execute($url, $options);

        return $response['data']['sales'];
    }
}