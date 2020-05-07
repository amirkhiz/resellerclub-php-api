<?php

namespace habil\ResellerClub\APIs;

use habil\ResellerClub\Helper;
use SimpleXMLElement;

class Products
{
    use Helper;

    protected $api = 'products';

    /**
     * Get customer prices
     *
     * @return mixed|SimpleXMLElement
     */
    public function customerPrice()
    {
        return $this->get('customer-price');
    }
}
