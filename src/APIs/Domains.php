<?php

namespace habil\ResellerClub\APIs;

use Exception;
use habil\ResellerClub\Helper;
use SimpleXMLElement;

/**
 * Class Domains
 *
 * @package habil\ResellerClub\APIs
 * @todo    Check all the APIs parameters there are some changes.
 */
class Domains
{
    use Helper;

    /**
     * @var string
     */
    protected $api = 'domains';

    /**
     * @param string[] $slds
     * @param string[] $tlds
     * @param bool     $suggestAlternative
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/764
     * @todo It seems "suggest-alternative" parameter removed.
     */
    public function available(
        $slds,
        $tlds = ['com', 'org', 'net'],
        $suggestAlternative = false
    ) {
        return $this->get(
            'available',
            [
                'domain-name'         => $slds,
                'tlds'                => $tlds,
                'suggest-alternative' => $suggestAlternative,
            ]
        );
    }

    /**
     * @param string[] $slds
     * @param string   $tld
     * @param string   $languageCode
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/1429
     */
    public function idnAvailable($slds, $tld, $languageCode)
    {
        return $this->get(
            'idn-available',
            [
                'domain-name'     => $slds,
                'tld'             => $tld,
                'idnLanguageCode' => $languageCode,
            ]
        );
    }

    /**
     * @param string   $keyword
     * @param string[] $tlds
     * @param int      $results
     * @param int      $priceHigh
     * @param int      $priceLow
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/1948
     */
    public function premiumAvailable(
        $keyword,
        $tlds,
        $results = 10,
        $priceHigh = 999999999,
        $priceLow = 0
    ) {
        return $this->get(
            'available',
            [
                'key-word'      => $keyword,
                'tlds'          => $tlds,
                'no-of-results' => $results,
                'price-high'    => $priceHigh,
                'price-low'     => $priceLow,
            ],
            'premium/'
        );
    }

    /**
     * Checks if the Contact information provided by the user is valid for Registration of a 2nd Level .UK domain name.
     *
     * @param string $domain
     * @param string $name
     * @param string $company
     * @param string $email
     * @param string $address1
     * @param string $city
     * @param string $state
     * @param string $zipCode
     * @param string $country
     * @param string $address2
     * @param string $address3
     * @param string $phoneCC
     * @param string $phone
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2187
     */
    public function ukAvailable(
        $domain,
        $name,
        $company,
        $email,
        $address1,
        $city,
        $state,
        $zipCode,
        $country,
        $address2 = '',
        $address3 = '',
        $phoneCC = '',
        $phone = ''
    ) {
        return $this->post(
            'available',
            [
                'domain-name'    => $domain,
                'name'           => $name,
                'company'        => $company,
                'email'          => $email,
                'address-line-1' => $address1,
                'city'           => $city,
                'state'          => $state,
                'zipcode'        => $zipCode,
                'country'        => $country,
                'address-line-2' => $address2,
                'address-line-3' => $address3,
                'phone-cc'       => $phoneCC,
                'phone'          => $phone,
            ],
            'uk/'
        );
    }

    /**
     * @param string $keyword
     * @param string $tld
     * @param bool   $exactMatch
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link     https://manage.logicboxes.com/kb/node/1085
     */
    public function suggestNames($keyword, $tld = '', $exactMatch = false)
    {
        return $this->get(
            'suggest-names',
            [
                'keyword'     => $keyword,
                'tld'         => $tld,
                'exact-match' => $exactMatch,
            ],
            'v5/'
        );
    }

    /**
     * @param string   $domain
     * @param int      $years
     * @param string[] $ns
     * @param int      $customer
     * @param int      $reg
     * @param int      $admin
     * @param int      $tech
     * @param int      $billing
     * @param string   $invoice Available options [NoInvoice, PayInvoice, KeepInvoice, OnlyAdd]
     * @param bool     $purchasePrivacy
     * @param bool     $protectPrivacy
     * @param array    $additional
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/752
     */
    public function register(
        $domain,
        $years,
        $ns,
        $customer,
        $reg,
        $admin,
        $tech,
        $billing,
        $invoice,
        $purchasePrivacy = false,
        $protectPrivacy = false,
        $additional = []
    ) {
        $params = [
                'domain-name'        => $domain,
                'years'              => $years,
                'ns'                 => $ns,
                'customer-id'        => $customer,
                'reg-contact-id'     => $reg,
                'admin-contact-id'   => $admin,
                'tech-contact-id'    => $tech,
                'billing-contact-id' => $billing,
                'invoice-option'     => $invoice,
                'purchase-privacy'   => $purchasePrivacy,
                'protect-privacy'    => $protectPrivacy,
            ] + $this->processAttributes($additional);

        $params = http_build_query($params);

        return $this->postArgString('register', $params);
    }

    /**
     * @param string   $domain
     * @param int      $customer
     * @param int      $reg
     * @param int      $admin
     * @param int      $tech
     * @param int      $billing
     * @param string   $invoice Available options [NoInvoice, PayInvoice, KeepInvoice, OnlyAdd]
     * @param string   $code
     * @param string[] $ns
     * @param bool     $purchasePrivacy
     * @param bool     $protectPrivacy
     * @param array    $additional
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/758
     */
    public function transfer(
        $domain,
        $customer,
        $reg,
        $admin,
        $tech,
        $billing,
        $invoice,
        $code,
        $ns = [],
        $purchasePrivacy = false,
        $protectPrivacy = false,
        $additional = []
    ) {
        return $this->post(
            'transfer',
            [
                'domain-name'        => $domain,
                'auth-code'          => $code,
                'ns'                 => $ns,
                'customer-id'        => $customer,
                'reg-contact-id'     => $reg,
                'admin-contact-id'   => $admin,
                'tech-contact-id'    => $tech,
                'billing-contact-id' => $billing,
                'invoice-option'     => $invoice,
                'purchase-privacy'   => $purchasePrivacy,
                'protect-privacy'    => $protectPrivacy,
            ] + $this->processAttributes($additional)
        );
    }

    /**
     * Submit the Domain Secret (also known as Authorization Code) for a domain name that is currently being transferred in to reseller.
     *
     * @param int    $orderId
     * @param string $code Domain Secret or Authorization Code, for the domain name being transferred.
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2446
     */
    public function submitAuthCode($orderId, $code)
    {
        return $this->post(
            'submit-auth-code',
            [
                'order-id'  => $orderId,
                'auth-code' => $code,
            ],
            'transfers/'
        );
    }

    /**
     * @param string $domain
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/1150
     */
    public function validateTransfer($domain)
    {
        return $this->get(
            'validate-transfer',
            [
                'domain-name' => $domain,
            ]
        );
    }

    /**
     * @param int     $orderId
     * @param int     $years
     * @param int     $exp
     * @param boolean $purchasePrivacy
     * @param string  $invoice Available options [NoInvoice, PayInvoice, KeepInvoice, OnlyAdd]
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/746
     */
    public function renew($orderId, $years, $exp, $purchasePrivacy, $invoice)
    {
        return $this->postArgString(
            'renew',
            http_build_query(
                [
                    'order-id'         => $orderId,
                    'years'            => $years,
                    'exp-date'         => strtotime($exp),
                    'purchase-privacy' => $purchasePrivacy,
                    'invoice-option'   => $invoice,
                ]
            )
        );
    }

    /**
     * @param int      $records
     * @param int      $page
     * @param string[] $order
     * @param int[]    $orderIds
     * @param int[]    $resellers
     * @param int[]    $customers
     * @param bool     $showChild
     * @param string[] $productKeys
     * @param string[] $statuses Available options [InActive, Active, Suspended, Pending Delete Restorable, Deleted, Archived, Pending Verification, Failed Verification]
     * @param string   $domain
     * @param string   $privacy  Available options [true, false, na]
     * @param string   $createdStart
     * @param string   $createdEnd
     * @param string   $expireStart
     * @param string   $expireEnd
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/771
     */
    public function search(
        $records = 10,
        $page = 1,
        $order = [],
        $orderIds = [],
        $resellers = [],
        $customers = [],
        $showChild = false,
        $productKeys = [],
        $statuses = [],
        $domain = '',
        $privacy = '',
        $createdStart = '',
        $createdEnd = '',
        $expireStart = '',
        $expireEnd = ''
    ) {
        $dates = [];
        if ( ! empty($createdStart)) {
            $dates['creation-date-start'] = strtotime($createdStart);
        }

        if ( ! empty($createdEnd)) {
            $dates['creation-date-end'] = strtotime($createdEnd);
        }

        if ( ! empty($expireStart)) {
            $dates['expiry-date-start'] = strtotime($expireStart);
        }

        if ( ! empty($expireEnd)) {
            $dates['expiry-date-end'] = strtotime($expireEnd);
        }

        return $this->get(
            'search',
            [
                'no-of-records'     => $records,
                'page-no'           => $page,
                'order-by'          => $order,
                'order-id'          => $orderIds,
                'reseller-id'       => $resellers,
                'customer-id'       => $customers,
                'show-child-orders' => $showChild,
                'product-key'       => $productKeys,
                'status'            => $statuses,
                'domain-name'       => $domain,
                'privacy-enabled'   => $privacy,
            ] + $dates
        );
    }

    /**
     * @param int $customerId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/788
     */
    public function getDefaultNameservers($customerId)
    {
        return $this->get(
            'customer-default-ns',
            ['customer-id' => $customerId]
        );
    }

    /**
     * @param string $domain
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/763
     */
    public function getOrderId($domain)
    {
        return $this->get('orderid', ['domain-name' => $domain]);
    }

    /**
     * @param int   $orderId
     * @param array $options Available options [All, OrderDetails, ContactIds, RegistrantContactDetails, AdminContactDetails, TechContactDetails, BillingContactDetails, NsDetails, DomainStatus, DNSSECDetails, StatusDetails]
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/770
     */
    public function getDetailsByOrderId($orderId, $options = ['All'])
    {
        return $this->get(
            'details',
            [
                'order-id' => $orderId,
                'options'  => $options,
            ]
        );
    }

    /**
     * @param string $domain
     * @param array  $options Available options [All, OrderDetails, ContactIds, RegistrantContactDetails, AdminContactDetails, TechContactDetails, BillingContactDetails, NsDetails, DomainStatus, DNSSECDetails]
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/1755
     */
    public function getDetailsByDomain($domain, $options = ['All'])
    {
        return $this->get(
            'details-by-name',
            [
                'domain-name' => $domain,
                'options'     => $options,
            ]
        );
    }

    /**
     * @param int      $orderId
     * @param string[] $ns
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/776
     */
    public function modifyNameServers($orderId, $ns)
    {
        return $this->postArgString(
            'modify-ns',
            http_build_query(
                [
                    'order-id' => $orderId,
                    'ns'       => $ns,
                ]
            )
        );
    }

    /**
     * @param int      $orderId
     * @param string   $cns
     * @param string[] $ip
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/780
     */
    public function addChildNameServer($orderId, $cns, $ip)
    {
        return $this->post(
            'add-cns',
            [
                'order-id' => $orderId,
                'cns'      => $cns,
                'ip'       => $ip,
            ]
        );
    }

    /**
     * @param int    $orderId
     * @param string $oldCNS
     * @param string $newCNS
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/781
     */
    public function renameChildNameServer($orderId, $oldCNS, $newCNS)
    {
        return $this->post(
            'modify-cns-name',
            [
                'order-id' => $orderId,
                'old-cns'  => $oldCNS,
                'new-cns'  => $newCNS,
            ]
        );
    }

    /**
     * @param int    $orderId
     * @param string $cns
     * @param string $oldIP
     * @param string $newIP
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/782
     */
    public function modifyChildNameServer($orderId, $cns, $oldIP, $newIP)
    {
        return $this->post(
            'modify-cns-ip',
            [
                'order-id' => $orderId,
                'cns'      => $cns,
                'old-ip'   => $oldIP,
                'new-ip'   => $newIP,
            ]
        );
    }

    /**
     * @param int      $orderId
     * @param string   $cns
     * @param string[] $ip
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/934
     */
    public function deleteChildNameServer($orderId, $cns, $ip)
    {
        return $this->post(
            'delete-cns-ip',
            [
                'order-id' => $orderId,
                'cns'      => $cns,
                'ip'       => $ip,
            ]
        );
    }

    /**
     * @param int $orderId
     * @param int $regContactId
     * @param int $adminContactId
     * @param int $techContactId
     * @param int $billingContactId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/777
     */
    public function modifyContact(
        $orderId,
        $regContactId,
        $adminContactId,
        $techContactId,
        $billingContactId
    ) {
        return $this->post(
            'modify-contact',
            [
                'order-id'           => $orderId,
                'reg-contact-id'     => $regContactId,
                'admin-contact-id'   => $adminContactId,
                'tech-contact-id'    => $techContactId,
                'billing-contact-id' => $billingContactId,
            ]
        );
    }

    /**
     * @param int    $orderId
     * @param string $invoiceOption Available options [NoInvoice, PayInvoice, KeepInvoice, OnlyAdd]
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2085
     */
    public function purchasePrivacy($orderId, $invoiceOption)
    {
        return $this->post(
            'purchase-privacy',
            [
                'order-id'       => $orderId,
                'invoice-option' => $invoiceOption,
            ]
        );
    }

    /**
     * @param int     $orderId
     * @param boolean $protectPrivacy
     * @param string  $reason
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/778
     */
    public function modifyPrivacyProtection($orderId, $protectPrivacy, $reason)
    {
        return $this->post(
            'modify-privacy-protection',
            [
                'order-id'        => $orderId,
                'protect-privacy' => $protectPrivacy,
                'reason'          => $reason,
            ]
        );
    }

    /**
     * @param int    $orderId
     * @param string $authCode
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/779
     */
    public function modifyAuthCode($orderId, $authCode)
    {
        return $this->post(
            'modify-auth-code',
            [
                'order-id'  => $orderId,
                'auth-code' => $authCode,
            ]
        );
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/902
     */
    public function enableTheftProtection($orderId)
    {
        return $this->post('enable-theft-protection', ['order-id' => $orderId]);
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/903
     */
    public function disableTheftProtection($orderId)
    {
        return $this->post(
            'disable-theft-protection',
            ['order-id' => $orderId]
        );
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/897
     */
    public function getLocks($orderId)
    {
        return $this->get('locks', ['order-id' => $orderId]);
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     */
    public function getCthDetails($orderId)
    {
        return $this->get('cth-details', ['order-id' => $orderId], 'tel/');
    }

    /**
     * @param int    $orderId
     * @param string $type    Available options [Natural, Legal]
     * @param string $publish This parameter is required if whois-type parameter is Natural, otherwise is it Optional.
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/773
     */
    public function modifyTelWhoisPreference($orderId, $type, $publish)
    {
        return $this->post(
            'modify-whois-pref',
            [
                'order-id'   => $orderId,
                'whois-type' => $type,
                'publish'    => $publish,
            ],
            'tel/'
        );
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/775
     */
    public function resendRfa($orderId)
    {
        return $this->post('resend-rfa', ['order-id' => $orderId]);
    }

    /**
     * @param int    $orderId
     * @param string $tag Tag of the new Registrar. For a two character tag, it is necessary to prepend the tag with a # character.
     *                    Example: The tag VI needs to be mentioned as #VI.
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/785
     */
    public function releaseUk($orderId, $tag)
    {
        return $this->post(
            'release',
            ['order-id' => $orderId, 'new-tag' => $tag],
            'uk/'
        );
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/759
     */
    public function cancelTransfer($orderId)
    {
        return $this->post('cancel-transfer', ['order-id' => $orderId]);
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/745
     */
    public function delete($orderId)
    {
        return $this->post('delete', ['order-id' => $orderId]);
    }

    /**
     * @param int    $orderId
     * @param string $invoice Available options [NoInvoice, PayInvoice, KeepInvoice]
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/760
     */
    public function restore($orderId, $invoice)
    {
        return $this->post(
            'restore',
            ['order-id' => $orderId, 'invoice-option' => $invoice]
        );
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/1138
     */
    public function recheckNsDe($orderId)
    {
        return $this->post('recheck-ns', ['order-id' => $orderId], 'de/');
    }

    /**
     * @param int    $orderId
     * @param string $id
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/1309
     */
    public function setXXXAssociation($orderId, $id = '')
    {
        return $this->post(
            'association-details',
            ['order-id' => $orderId, 'association-id' => $id],
            'dotxxx/'
        );
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     */
    public function getXXXAssociation($orderId)
    {
        return $this->post(
            'association-details',
            ['order-id' => $orderId],
            'dotxxx/'
        );
    }

    /**
     * @param int   $orderId
     * @param array $attributes
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/1910
     */
    public function addDNSSEC($orderId, $attributes)
    {
        $attributes = $this->processAttributes($attributes);

        return $this->post('add-dnssec', ['orderId' => $orderId] + $attributes);
    }

    /**
     * @param int   $orderId
     * @param array $attributes
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/1911
     */
    public function delDNSSEC($orderId, $attributes)
    {
        $attributes = $this->processAttributes($attributes);

        return $this->post('del-dnssec', ['orderId' => $orderId] + $attributes);
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2010
     */
    public function resendVerificationEmail($orderId)
    {
        return $this->post(
            'resend-verification',
            ['order-id' => $orderId],
            'raa/'
        );
    }

    /**
     * @param int      $customerId
     * @param string[] $domains
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2012
     */
    public function addWishList($customerId, $domains)
    {
        return $this->post(
            'add',
            ['customerid' => $customerId, 'domain' => $domains],
            'preordering/'
        );
    }

    /**
     * @param int      $customerId
     * @param string[] $domain
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2013
     */
    public function deleteWishList($customerId, $domain)
    {
        return $this->post(
            'delete',
            ['customerid' => $customerId, 'domain' => $domain],
            'preordering/'
        );
    }

    /**
     * @param int   $records
     * @param int   $page
     * @param int   $customerId
     * @param int   $resellerId
     * @param array $slds
     * @param array $tlds
     * @param bool  $createdStart
     * @param bool  $createdEnd
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2014
     */
    public function fetchWishList(
        $records = 10,
        $page = 0,
        $customerId = -1,
        $resellerId = -1,
        $slds = [],
        $tlds = [],
        $createdStart = false,
        $createdEnd = false
    ) {
        $data = [
            'no-of-records' => $records,
            'page-no'       => $page,
        ];

        if ($customerId !== -1) {
            $data['customerid'] = $customerId;
        }

        if ($resellerId !== -1) {
            $data['resellerId'] = $resellerId;
        }

        if ( ! empty($slds)) {
            $data['domain'] = $slds;
        }

        if ( ! empty($tlds)) {
            $data['tld'] = $tlds;
        }

        if ($createdStart !== false) {
            $data['creation-date-start'] = strtotime($createdStart);
        }

        if ($createdEnd !== false) {
            $data['creation-date-end'] = strtotime($createdEnd);
        }

        return $this->get('fetch', $data, 'preordering/');
    }

    /**
     * @param string $category Available options [adult, arts and media, beauty and fashion, business and commerce, education, finance, food and drink, generic, geo cultural, government and politics, health, idn, news and information, novelty, people and lifestyle, real estate, religion, services, sports and games, technology, travel]
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2015
     */
    public function fetchTLDs($category)
    {
        return $this->get(
            'fetchtldlist',
            ['category' => $category],
            'preordering/'
        );
    }

    /**
     * @param string   $sld
     * @param string[] $tlds
     * @param string   $smd
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2016
     * @todo "sld" parameter should change to "domainname"
     */
    public function checkSunrise($sld, $tlds, $smd)
    {
        return $this->get(
            'available-sunrise',
            [
                'sld' => $sld,
                'tld' => $tlds,
                'smd' => $smd,
            ]
        );
    }

    /**
     * @param string $claimKey
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2029
     */
    public function fetchTMClaim($claimKey)
    {
        return $this->get('get-tm-notice', ['lookup-key' => $claimKey]);
    }

    /**
     * @param string $phase
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2039
     */
    public function getPreOrderTLDs($phase = 'sunrise')
    {
        return $this->get('tlds-in-phase', ['phase' => $phase]);
    }

    /**
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/2466
     */
    public function getTLDs()
    {
        return $this->get('tld-info');
    }

    /**
     * @param string $slds
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/3053
     */
    public function getPremium($slds)
    {
        return $this->get(
            'premium-check',
            [
                'domain-name' => $slds,
            ]
        );
    }

    /**
     * @param int    $orderId
     * @param string $reason
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     */
    public function lock($orderId, $reason)
    {
        return $this->get(
            'add',
            [
                'order-id' => $orderId,
                'reason'   => $reason,
            ],
            'reseller-lock/'
        );
    }

    /**
     * @param int $orderId
     *
     * @return Exception|mixed|SimpleXMLElement
     * @throws Exception
     */
    public function unlock($orderId)
    {
        return $this->get(
            'remove',
            [
                'order-id' => $orderId,
            ],
            'reseller-lock/'
        );
    }
}
