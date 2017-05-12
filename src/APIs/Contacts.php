<?php

namespace afbora\ResellerClub\APIs;

use afbora\ResellerClub\Helper;

class Contacts
{
    use Helper;

    protected $api = 'contacts';

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
    )
    {
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
        $fax = ''
    )
    {
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
            ]
        );
    }

    public function getContact($contactId)
    {
        return $this->get('details', ['contact-id' => $contactId]);
    }

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
    )
    {
        $data = [
            'customer-id'   => $customerId,
            'no-of-records' => $records,
            'page-no'       => $page,
        ];

        if (!empty($contactIds)) {
            $data['contact-id'] = $contactIds;
        }

        if (!empty($status)) {
            // InActive, Active, Suspended, Deleted
            $data['status'] = $status;
        }

        if (!empty($name)) {
            $data['name'] = $name;
        }

        if (!empty($company)) {
            $data['company'] = $company;
        }

        if (!empty($email)) {
            $data['email'] = $email;
        }

        if (!empty($type)) {
            // Contact, CoopContact, UkContact, EuContact, Sponsor, CnContact, CoContact, CaContact, DeContact, EsContact
            $data['type'] = $type;
        }

        return $this->get('search', $data);
    }

    public function getDefault($customerId, $type)
    {
        return $this->post('default', ['customer-id' => $customerId, 'type' => $type]);
    }

    public function setDetails($contactId, $attributes)
    {
        return $this->post('set-details', ['contact-id' => $contactId] + $this->processAttributes($attributes));
    }

    public function delete($contactId)
    {
        return $this->post('delete', ['contact-id' => $contactId]);
    }

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
    )
    {
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
            ], 'coop'
        );
    }

    public function getSponsors($customerId)
    {
        return $this->get('sponsors', ['customer-id' => $customerId], 'coop');
    }

    public function getCaRegistrantAgreement()
    {
        return $this->get('registrantagreement', [], 'dotca');
    }

    public function validateContact(
        $contactId,
        $check = [
            'CED_ASIAN_COUNTRY',
            'CED_DETAILS',
            'CPR',
            'ES_CONTACT_IDENTIFICATION_DETAILS',
            'EUROPEAN_COUNTRY',
            'RU_CONTACT_INFO',
            'APP_PREF_NEXUS',
        ]
    )
    {
        return $this->get('validate-registrant', ['contact-id' => $contactId, 'eligibility-criteria' => $check]);
    }
}
