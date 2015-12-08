<?php
namespace services;


class PartnerServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \thewulf7\travelPayouts\services\PartnerService
     */
    protected $service;

    public function setUp()
    {
        $config        = require(__DIR__ . '/../../../../src/thewulf7/travelPayouts/config/tests.php');
        $travel        = new \thewulf7\travelPayouts\Travel($config['token']);
        $this->service = $travel->getPartnerService();

        date_default_timezone_set('UTC');
    }

    public function testGetBalance()
    {
        $balance = $this->service->getBalance();

        self::assertGreaterThanOrEqual(0, $balance['balance']);
        self::assertContains($balance['currency'], ['RUB', 'USD', 'EUR']);
    }

    public function testGetPayments()
    {
        $payments = $this->service->getPayments();

        foreach($payments as $payment)
        {
            self::assertGreaterThanOrEqual(0, $payment['amount']);
        }
    }

    public function testGetSales()
    {
        $date = new \DateTime('2015-11');

        $sales = $this->service->getSales('date', $date->format('Y-m'));

        $period = [
            $date->getTimestamp(),
            $date->modify('first day of next month')->getTimestamp(),
        ];

        foreach($sales as $sale)
        {
            self::assertGreaterThanOrEqual($period[0], strtotime($sale['key']));
            self::assertLessThanOrEqual($period[1], strtotime($sale['key']));

            $saleCount = 0;

            $saleCount += array_sum($sale['flights']) + array_sum($sale['hotels']);

            self::assertGreaterThan(0, $saleCount);
        }
    }

    public function testGetDetailedSales()
    {
        $date = new \DateTime('2015-11');

        $sales = $this->service->getDetailedSales($date->format('Y-m'));

        $period = [
            $date->getTimestamp(),
            $date->modify('first day of next month')->getTimestamp(),
        ];

        foreach($sales as $key => $sale)
        {
            self::assertGreaterThanOrEqual($period[0], strtotime($key));
            self::assertLessThanOrEqual($period[1], strtotime($key));

            $saleCount = 0;

            foreach($sale as $source => $types)
            {
                foreach($types as $type)
                {
                    $saleCount += array_sum($type);
                }
            }

            self::assertGreaterThan(0, $saleCount);
        }
    }
}
