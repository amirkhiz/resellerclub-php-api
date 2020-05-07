<?php

namespace habil\ResellerClub;

use habil\ResellerClub\APIs\Actions;
use habil\ResellerClub\APIs\Contacts;
use habil\ResellerClub\APIs\Customers;
use habil\ResellerClub\APIs\Domains;
use habil\ResellerClub\APIs\Orders;
use GuzzleHttp\Client as Guzzle;
use habil\ResellerClub\APIs\Products;

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

    public function __construct($userId, $apiKey, $testMode = FALSE, $timeout = 0, $bindIp = '0')
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
                'connect_timeout' => (float)$timeout,
                'timeout' => (float)$timeout,
                'curl' => [
                    CURLOPT_INTERFACE => null !== $bindIp ? $bindIp : '0',
                ],
                'stream_context' => [
                    'socket' => [
                        'bindto' => null !== $bindIp ? $bindIp : '0',
                    ]
                ],
            ]
        );
    }

    private function _getAPI($api)
    {
        if (empty($this->apiList[$api])) {
            $class               = 'habil\\ResellerClub\\APIs\\' . $api;
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

    /**
     * @return Products
     */
    public function products()
    {
        return $this->_getAPI('Products');
    }

    /**
     * @return Orders
     */
    public function orders()
    {
        return $this->_getAPI('Orders');
    }

    /**
     * @return Actions
     */
    public function actions()
    {
        return $this->_getAPI('Actions');
    }
}
