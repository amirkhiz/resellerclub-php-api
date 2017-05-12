<?php

namespace afbora\ResellerClub;

use afbora\ResellerClub\APIs\Contacts;
use afbora\ResellerClub\APIs\Customers;
use afbora\ResellerClub\APIs\Domains;
use GuzzleHttp\Client as Guzzle;

class ResellerClub
{
    const API_URL      = 'https://httpapi.com/api/';
    const API_TEST_URL = 'https://test.httpapi.com/api/';

    /**
     * @var Guzzle
     */
    private $guzzle;

    /**
     * List of API classes
     * @var array
     */
    private $apiList = [];

    /**
     * Authentication info needed for every request
     * @var array
     */
    private $authentication = [];

    public function __construct($userId, $apiKey, $testMode = FALSE)
    {
        $this->authentication = [
            'auth-userid' => $userId,
            'api-key'     => $apiKey,
        ];

        $this->guzzle = new Guzzle(
            [
                'base_uri' => $testMode ? self::API_TEST_URL : self::API_URL,
                'defaults' => [
                    'query' => $this->authentication,
                ],
                'verify'   => FALSE,
            ]
        );
    }

    private function _getAPI($api)
    {
        if (empty($this->apiList[$api])) {
            $class               = 'afbora\\ResellerClub\\APIs\\' . $api;
            $this->apiList[$api] = new $class($this->guzzle, $this->authentication);
        }

        return $this->apiList[$api];
    }

    /**
     * @return Domains
     */
    public function domains()
    {
        return $this->_getAPI('Domains');
    }

    /**
     * @return Contacts
     */
    public function contacts()
    {
        return $this->_getAPI('Contacts');
    }

    /**
     * @return Customers
     */
    public function customers()
    {
        return $this->_getAPI('Customers');
    }
}