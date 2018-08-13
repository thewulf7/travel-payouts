<?php

namespace thewulf7\travelPayouts\components;

use GuzzleHttp\Client as HttpClient;

/**
 * Class Client
 *
 * @package thewulf7\travelPayouts\components
 */
class HotelsClient
{
    /**
     *
     */
    const API_HOST = 'http://engine.hotellook.com/api/';

    const API_STATIC_HOST = 'http://yasen.hotellook.com/tp/';

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
     * @param string $token
     * @param string $defaultHost
     */
    public function __construct($token, $defaultHost = self::API_HOST)
    {
        $this->_token = $token;

        $this->_client = new HttpClient(
            [
                'base_uri' => $defaultHost,
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
     * @param string    $url
     * @param array     $options
     * @param string    $type
     * @param bool|true $replaceOptions
     *
     * @return mixed
     */
    public function execute($url, array $options, $type = 'GET', $replaceOptions = true)
    {
        $url    = '/' . $this->getApiVersion() . '/' . $url . '.json';
        $params = [
            'http_errors' => false,
        ];

        if ($replaceOptions) {
            $paramName          = $type === 'GET' ? 'query' : 'body';
            $params[$paramName] = $options;
        } else {
            $params += $options;
        }

        /** @var \GuzzleHttp\Psr7\Request $res */
        $res = $this->getClient()->request($type, $url, $params);

        $statusCode = $res->getStatusCode();
        $body       = $res->getBody();

        if ($statusCode !== 200) {
            $strBody = json_decode((string)$body, true);

            $message = isset($strBody['message']) ? $strBody['message'] : 'unknown';

            throw new \RuntimeException("{$statusCode}:{$message}");
        }

        return $this->makeApiResponse($body);
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
     * @return mixed
     */
    public function getClient()
    {
        return $this->_client;
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
        if (!$data) {
            throw new \RuntimeException("Unable to decode json response: $jsonString");
        }

        return $data;
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