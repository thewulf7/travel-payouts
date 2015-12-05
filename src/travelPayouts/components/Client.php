<?php

namespace travelPayouts\components;

use GuzzleHttp\Client as HttpClient;

/**
 * Class Client
 *
 * @package travelPayouts\components
 */
class Client
{
    /**
     *
     */
    const API_HOST = 'http://api.travelpayouts.com';

    /**
     * @var HttpClient
     */
    private $_client;

    /**
     * @var string
     */
    private $_apiVersion = 'v2';

    /**
     * @var string
     */
    private $_token;

    /**
     * @param $token
     */
    public function __construct($token)
    {
        $this->_token = $token;

        $this->_client = new HttpClient(
            [
                'base_uri' => self::API_HOST,
                'headers'  =>
                    [
                        'Content-Type'    => 'application/json',
                        'X-Access-Token'  => $this->_token,
                        'Accept-Encoding' => 'gzip,deflate,sdch',
                    ],
            ]
        );
    }

    /**
     * @param        $url
     * @param array  $options
     * @param string $type
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function execute($url, array $options, $type = 'GET')
    {
        $url = '/' . $this->getApiVersion() . '/' . $url;

        /** @var \GuzzleHttp\Psr7\Request $res */
        $res = $this->getClient()->request($type, $url, $options);

        $statusCode = $res->getStatusCode();
        $body       = $res->getBody();

        if ($statusCode !== 200)
        {
            $strBody = (string)$body;
            throw new \RuntimeException("Remote host status code exception: {$statusCode}:{$strBody}");
        }

        return $this->makeApiResponse($body);
    }

    /**
     * @param $jsonString
     *
     * @return mixed
     * @throws \RuntimeException
     */
    private function makeApiResponse($jsonString)
    {
        $data = json_decode($jsonString, true);
        if (!$data)
        {
            throw new \RuntimeException("Unable to decode json response: $jsonString");
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @return mixed
     */
    public function getApiVersion()
    {
        return $this->_apiVersion;
    }

    /**
     * @param mixed $apiVersion
     *
     * @return $this
     */
    public function setApiVersion($apiVersion)
    {
        $this->_apiVersion = $apiVersion;

        return $this;
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
}