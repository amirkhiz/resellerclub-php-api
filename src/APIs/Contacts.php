<?php

namespace habil\ResellerClub\APIs;

use Exception;
use habil\ResellerClub\Helper;
use SimpleXMLElement;

/**
 * Class Contacts
 *
 * @package habil\ResellerClub\APIs
 */
class Contacts
{
    use Helper;

    /**
     * @var string
     */
    protected $api = 'contacts';

    /**
     * @param string $name
     * @param string $company
     * @param string $email
     * @param string $address1
     * @param string $city
     * @param string $country
     * @param string $zipcode
     * @param string $phoneCC
     * @param string $phone
     * @param int    $customerId
     * @param string $type
     * @param string $address2
     * @param string $address3
     * @param string $state
     * @param string $faxCC
     * @param string $fax
     * @param array  $attrs
     *
     * @return Exception|mixed|SimpleXMLElement
     */
    public function add(
        $name,
        $company,
        $email,
        $address1,
        $city,
        $country,
        $zipcode,
        $phoneCC,
        $phone,
        $customerId,
        $type,
        $address2 = '',
        $address3 = '',
        $state = '',
        $faxCC = '',
        $fax = '',
        $attrs = []
    ) {
        return $this->post(
            'add',
            [
                'name'           => $name,
                'company'        => $company,
                'email'          => $email,
                'address-line-1' => $address1,
                'city'           => $city,
                'country'        => $country,
                'zipcode'        => $zipcode,
                'phone-cc'       => $phoneCC,
                'phone'          => $phone,
                'customer-id'    => $customerId,
                'type'           => $type,
                'address-line-2' => $address2,
                'address-line-3' => $address3,
                'state'          => $state,
                'fax-cc'         => $faxCC,
                'fax'            => $fax,
            ] + $this->processAttributes($attrs)
        );
    }

    /**
     * @param int    $contactId
     * @param string $name
     * @param string $company
     * @param string $email
     * @param string $address1
     * @param string $city
     * @param string $zipcode
     * @param string $phoneCC
     * @param string $phone
     * @param string $address2
     * @param string $address3
     * @param string $state
     * @param string $faxCC
     * @param string $fax
     * @param string $country
     *
     * @return mixed
     */
    public function modify(
        $contactId,
        $name,
        $company,
        $email,
        $address1,
        $city,
        $zipcode,
        $phoneCC,
        $phone,
        $address2 = '',
        $address3 = '',
        $state = '',
        $faxCC = '',
        $fax = '',
        $country = ''
    ) {
        return $this->post(
            'modify',
            [
                'contact-id'     => $contactId,
                'name'           => $name,
                'company'        => $company,
                'email'          => $email,
                'address-line-1' => $address1,
                'city'           => $city,
                'zipcode'        => $zipcode,
                'phone-cc'       => $phoneCC,
                'phone'          => $phone,
                'address-line-2' => $address2,
                'address-line-3' => $address3,
                'state'          => $state,
                'fax-cc'         => $faxCC,
                'fax'            => $fax,
                'country'        => $country,
            ]
        );
    }

    /**
     * @param int $contactId
     *
     * @return mixed
     */
    public function getContact($contactId)
    {
        return $this->get('details', ['contact-id' => $contactId]);
    }

    /**
     * @param int    $customerId
     * @param int    $records
     * @param int    $page
     * @param array  $contactIds
     * @param array  $status
     * @param string $name
     * @param string $company
     * @param string $email
     * @param string $type
     *
     * @return mixed
     */
    public function search(
        $customerId,
        $records = 10,
        $page = 1,
        $contactIds = [],
        $status = [],
        $name = '',
        $company = '',
        $email = '',
        $type = ''
    ) {
        $data = [
            'customer-id'   => $customerId,
            'no-of-records' => $records,
            'page-no'       => $page,
        ];

        if ( ! empty($contactIds)) {
            $data['contact-id'] = $contactIds;
        }

        if ( ! empty($status)) {
            // InActive, Active, Suspended, Deleted
            $data['status'] = $status;
        }

        if ( ! empty($name)) {
            $data['name'] = $name;
        }

        if ( ! empty($company)) {
            $data['company'] = $company;
        }

        if ( ! empty($email)) {
            $data['email'] = $email;
        }

        if ( ! empty($type)) {
            // Contact, CoopContact, UkContact, EuContact, Sponsor, CnContact, CoContact, CaContact, DeContact, EsContact
            $data['type'] = $type;
        }

        return $this->get('search', $data);
    }

    /**
     * @param int      $customerId
     * @param string[] $type
     *
     * @return mixed
     */
    public function getDefault($customerId, $type)
    {
        return $this->post(
            'default',
            ['customer-id' => $customerId, 'type' => $type]
        );
    }

    /**
     * @param int   $contactId
     * @param array $attributes
     *
     * @return mixed
     */
    public function setDetails($contactId, $attributes)
    {
        return $this->post(
            'set-details',
            ['contact-id' => $contactId] + $this->processAttributes($attributes)
        );
    }

    /**
     * @param int $contactId
     *
     * @return mixed
     */
    public function delete($contactId)
    {
        return $this->post('delete', ['contact-id' => $contactId]);
    }

    /**
     * @param string $name
     * @param string $company
     * @param string $email
     * @param string $address1
     * @param string $city
     * @param string $country
     * @param string $zipcode
     * @param string $phoneCC
     * @param string $phone
     * @param int    $customerId
     * @param string $address2
     * @param string $address3
     * @param string $state
     * @param string $faxCC
     * @param string $fax
     *
     * @return mixed
     */
    public function addSponsor(
        $name,
        $company,
        $email,
        $address1,
        $city,
        $country,
        $zipcode,
        $phoneCC,
        $phone,
        $customerId,
        $address2 = '',
        $address3 = '',
        $state = '',
        $faxCC = '',
        $fax = ''
    ) {
        return $this->post(
            'add-sponsor',
            [
                'name'           => $name,
                'company'        => $company,
                'email'          => $email,
                'address-line-1' => $address1,
                'city'           => $city,
                'country'        => $country,
                'zipcode'        => $zipcode,
                'phone-cc'       => $phoneCC,
                'phone'          => $phone,
                'customer-id'    => $customerId,
                'address-line-2' => $address2,
                'address-line-3' => $address3,
                'state'          => $state,
                'fax-cc'         => $faxCC,
                'fax'            => $fax,
            ],
            'coop'
        );
    }

    /**
     * @param int $customerId
     *
     * @return mixed
     */
    public function getSponsors($customerId)
    {
        return $this->get('sponsors', ['customer-id' => $customerId], 'coop');
    }

    /**
     * @return mixed
     */
    public function getCaRegistrantAgreement()
    {
        return $this->get('registrantagreement', [], 'dotca');
    }

    /**
     * @param int   $contactId
     * @param array $check
     *
     * @return mixed
     */
    public function validateContact(
        $contactId,
        $check
        = [
            'CED_ASIAN_COUNTRY',
            'CED_DETAILS',
            'CPR',
            'ES_CONTACT_IDENTIFICATION_DETAILS',
            'EUROPEAN_COUNTRY',
            'RU_CONTACT_INFO',
            'APP_PREF_NEXUS',
        ]
    ) {
        return $this->get(
            'validate-registrant',
            ['contact-id' => $contactId, 'eligibility-criteria' => $check]
        );
    }
}
