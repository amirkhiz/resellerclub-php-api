<?php

namespace habil\ResellerClub;

use GuzzleHttp\Client as Guzzle;
use habil\ResellerClub\APIs\Actions;
use habil\ResellerClub\APIs\Billing;
use habil\ResellerClub\APIs\Contacts;
use habil\ResellerClub\APIs\Customers;
use habil\ResellerClub\APIs\Domains;
use habil\ResellerClub\APIs\Orders;
use habil\ResellerClub\APIs\Products;

/**
 * Class ResellerClub
 *
 * @package habil\ResellerClub
 */
class ResellerClub
{
    const API_URL = 'https://httpapi.com/api/';
    const API_TEST_URL = 'https://test.httpapi.com/api/';

    /**
     * @var Guzzle
     */
    private $guzzle;

    /**
     * List of API classes
     *
     * @var array
     */
    private $apiList = [];

    /**
     * Authentication info needed for every request
     *
     * @var array
     */
    private $authentication = [];

    /**
     * ResellerClub constructor.
     *
     * @param int    $userId
     * @param string $apiKey
     * @param bool   $testMode
     * @param int    $timeout
     * @param string $bindIp
     *
     * @return void
     */
    public function __construct(
        $userId,
        $apiKey,
        $testMode = false,
        $timeout = 0,
        $bindIp = '0'
    ) {
        $this->authentication = [
            'auth-userid' => $userId,
            'api-key'     => $apiKey,
        ];

        $guzzleConfig = [
            'base_uri'        => $testMode ? self::API_TEST_URL : self::API_URL,
            'defaults'        => ['query' => $this->authentication],
            'verify'          => false,
            'connect_timeout' => (float)$timeout,
            'timeout'         => (float)$timeout,
        ];

        if (!empty($bindIp)) {
            $guzzleConfig['curl'] = [CURLOPT_INTERFACE => $bindIp];
            $guzzleConfig['stream_context'] = ['socket' => ['bindto' => $bindIp]];
        }

        $this->guzzle = new Guzzle($guzzleConfig);
    }

    /**
     * @param $api
     *
     * @return mixed
     */
    private function _getAPI($api)
    {
        if (empty($this->apiList[$api])) {
            $class = 'habil\\ResellerClub\\APIs\\'.$api;
            $this->apiList[$api] = new $class(
                $this->guzzle,
                $this->authentication
            );
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
     * @return Billing
     */
    public function billing()
    {
        return $this->_getAPI('Billing');
    }

    /**
     * @return Actions
     */
    public function actions()
    {
        return $this->_getAPI('Actions');
    }
}
