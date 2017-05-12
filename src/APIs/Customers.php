<?php

namespace afbora\ResellerClub\APIs;

use afbora\ResellerClub\Helper;

class Customers
{
    use Helper;

    /**
     * @var string
     */
    protected $api = 'customers';

    /**
     * Changes the password for the specified Customer.
     * @param $customerId
     * @param $newPassword
     * @return mixed|\SimpleXMLElement
     */
    public function changePassword($customerId, $newPassword)
    {
        return $this->post('change-password', ['customer-id' => $customerId, 'new-passwd' => $newPassword]);
    }

    /**
     * Gets the Customer details for the specified Customer Username.
     * @param $username
     * @return mixed|\SimpleXMLElement
     */
    public function details($username)
    {
        return $this->get('details', ['username' => $username]);
    }

    /**
     * Gets the Customer details for the specified Customer Id.
     * @param $customerId
     * @return mixed|\SimpleXMLElement
     */
    public function detailsById($customerId)
    {
        return $this->get('details-by-id', ['customer-id' => $customerId]);
    }

    /**
     * Modifies the Account details of the specified Customer.
     * @param $customerId
     * @param $username
     * @param $name
     * @param $company
     * @param $address
     * @param $city
     * @param $state
     * @param $country
     * @param $zipCode
     * @param $phoneCC
     * @param $phone
     * @param $lang
     * @return mixed|\SimpleXMLElement
     */
    public function modify(
        $customerId,
        $username,
        $name,
        $company,
        $address,
        $city,
        $state,
        $country,
        $zipCode,
        $phoneCC,
        $phone,
        $lang
    )
    {
        return $this->post(
            'modify',
            [
                'customer-id'    => $customerId,
                'username'       => $username,
                'name'           => $name,
                'company'        => $company,
                'address-line-1' => $address,
                'city'           => $city,
                'state'          => $state,
                'country'        => $country,
                'zipcode'        => $zipCode,
                'phone-cc'       => $phoneCC,
                'phone'          => $phone,
                'lang-pref'      => $lang,
            ]
        );
    }

    /**
     * Creates a Customer Account using the details provided.
     * @param $username
     * @param $passwd
     * @param $name
     * @param $company
     * @param $address
     * @param $city
     * @param $state
     * @param $country
     * @param $zipCode
     * @param $phoneCC
     * @param $phone
     * @param $lang
     * @return mixed|\SimpleXMLElement
     */
    public function signup(
        $username,
        $passwd,
        $name,
        $company,
        $address,
        $city,
        $state,
        $country,
        $zipCode,
        $phoneCC,
        $phone,
        $lang
    )
    {
        return $this->post(
            'signup',
            [
                'username'       => $username,
                'passwd'         => $passwd,
                'name'           => $name,
                'company'        => $company,
                'address-line-1' => $address,
                'city'           => $city,
                'state'          => $state,
                'country'        => $country,
                'zipcode'        => $zipCode,
                'phone-cc'       => $phoneCC,
                'phone'          => $phone,
                'lang-pref'      => $lang,
            ]
        );
    }

    /**
     * Generates a temporary password for the specified Customer. The generated password is valid only for 3 days.
     * @param $customerId
     * @return mixed|\SimpleXMLElement
     */
    public function tempPassword($customerId)
    {
        return $this->get('temp-password', ['customer-id' => $customerId]);
    }
}
