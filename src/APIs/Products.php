<?php

namespace habil\ResellerClub\APIs;

use Exception;
use habil\ResellerClub\Helper;

/**
 * Class Products
 *
 * @package habil\ResellerClub\APIs
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

    /**
     * @param string $domainName
     * @param int $existingCustomerId
     * @param int $newCustomerId
     * @param string $defaultContact
     *
     * @return array|Exception
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/904
     */
    public function move($domainName, $existingCustomerId, $newCustomerId, $defaultContact = 'oldcontact')
    {
        return $this->post(
            'move',
            [
                'domain-name'          => $domainName,
                'existing-customer-id' => $existingCustomerId,
                'new-customer-id'      => $newCustomerId,
                'default-contact'      => $defaultContact,
            ]
        );
    }
}
