<?php

namespace habil\ResellerClub\APIs;

use Exception;
use habil\ResellerClub\Helper;
use SimpleXMLElement;

/**
 * Class Products
 *
 * @package habil\ResellerClub\APIs
 * @todo    Add other endpoints
 */
class Products
{
    use Helper;

    protected $api = 'products';

    /**
     * Get customer prices
     *
     * @return array|Exception
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/864
     * @todo Add optional parameters
     */
    public function customerPrice()
    {
        return $this->get('customer-price');
    }
}
