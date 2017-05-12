<?php

namespace afbora\ResellerClub\APIs;

use afbora\ResellerClub\Helper;

class Domains
{
    use Helper;

    /**
     * @var string
     */
    protected $api = 'domains';

    public function available($slds, $tlds = ['com', 'org', 'net'], $suggestAlternative = FALSE)
    {
        return $this->get(
            'available',
            [
                'domain-name'         => $slds,
                'tlds'                => $tlds,
                'suggest-alternative' => $suggestAlternative,
            ]
        );
    }

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

    public function premiumAvailable($keyword, $tlds, $results = 10, $priceHigh = 999999999, $priceLow = 0)
    {
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
    )
    {
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

    public function suggestNames($keyword, $tld = '', $exactMatch = FALSE)
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
        $purchasePrivacy = FALSE,
        $protectPrivacy = FALSE,
        $additional = []
    )
    {
        return $this->post(
            'register',
            [
                'domain-name'        => $domain,
                'years'              => $years,
                'ns'                 => $ns,
                'customer-id'        => $customer,
                'reg-contact-id'     => $reg,
                'admin-contact-id'   => $admin,
                'tech-contact-id'    => $tech,
                'billing-contact-id' => $billing,
                'invoice-option'     => $invoice, // Options: NoInvoice, PayInvoice, KeepInvoice
                'purchase-privacy'   => $purchasePrivacy,
                'protect-privacy'    => $protectPrivacy,
            ] + $this->processAttributes($additional)
        );
    }

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
        $purchasePrivacy = FALSE,
        $protectPrivacy = FALSE,
        $additional = []
    )
    {
        return $this->post(
            'register',
            [
                'domain-name'        => $domain,
                'auth-code'          => $code,
                'ns'                 => $ns,
                'customer-id'        => $customer,
                'reg-contact-id'     => $reg,
                'admin-contact-id'   => $admin,
                'tech-contact-id'    => $tech,
                'billing-contact-id' => $billing,
                'invoice-option'     => $invoice, // Options: NoInvoice, PayInvoice, KeepInvoice
                'purchase-privacy'   => $purchasePrivacy,
                'protect-privacy'    => $protectPrivacy,
            ] + $this->processAttributes($additional)
        );
    }

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

    public function validateTransfer($domain)
    {
        return $this->get(
            'validate-transfer',
            [
                'domain-name' => $domain,
            ]
        );
    }

    public function renew($orderId, $years, $exp, $purchasePrivacy, $invoice)
    {
        return $this->post(
            'renew',
            [
                'order-id'         => $orderId,
                'years'            => $years,
                'exp-date'         => strtotime($exp),
                'purchase-privacy' => $purchasePrivacy,
                'invoice-option'   => $invoice // Options: NoInvoice, PayInvoice, KeepInvoice, OnlyAdd
            ]
        );
    }

    public function search(
        $records = 10,
        $page = 0, // this might need to be 1 but API docs are lacking that information
        $order = [],
        $orderIds = [],
        $resellers = [],
        $customers = [],
        $showChild = FALSE,
        $productKeys = [],
        $statuses = [],
        $domain = '',
        $privacy = '',
        $createdStart = '',
        $createdEnd = '',
        $expireStart = '',
        $expireEnd = ''
    )
    {
        $dates = [];
        if (!empty($createdStart)) {
            $dates['creation-date-start'] = strtotime($createdStart);
        }

        if (!empty($createdEnd)) {
            $dates['creation-date-end'] = strtotime($createdEnd);
        }

        if (!empty($expireStart)) {
            $dates['expiry-date-start'] = strtotime($expireStart);
        }

        if (!empty($expireEnd)) {
            $dates['expiry-date-end'] = strtotime($expireEnd);
        }

        return $this->get(
            'search',
            [
                'no-of-results'     => $records,
                'page-no'           => $page,
                'order-by'          => $order,
                'order-id'          => $orderIds,
                'reseller-id'       => $resellers,
                'customer-id'       => $customers,
                'show-child-orders' => $showChild,
                'product-key'       => $productKeys,
                'status'            => $statuses, // InActive, Active, Suspended, Pending Delete Restorable, Deleted, Archived, Pending Verification, Failed Verification
                'domain-name'       => $domain,
                'privacy-enabled'   => $privacy // true, false, na
            ] + $dates
        );
    }

    public function getDefaultNameservers($customerId)
    {
        return $this->get('customer-default-ns', ['customer-id' => $customerId]);
    }

    public function getOrderId($domain)
    {
        return $this->get('orderid', ['domain-name' => $domain]);
    }

    public function getDetailsByOrderId($orderId, $options = ['All'])
    {
        return $this->get(
            'details',
            [
                'order-id' => $orderId,
                'options'  => $options // All, OrderDetails, ContactIds, RegistrantContactDetails, AdminContactDetails, TechContactDetails, BillingContactDetails, NsDetails, DoaminStatus, DNSSECDetails, StatusDetails
            ]
        );
    }

    public function getDetailsByDomain($domain, $options = ['All'])
    {
        return $this->get(
            'details-by-name',
            [
                'domain-name' => $domain,
                'options'     => $options // All, OrderDetails, ContactIds, RegistrantContactDetails, AdminContactDetails, TechContactDetails, BillingContactDetails, NsDetails, DoaminStatus, DNSSECDetails, StatusDetails
            ]
        );
    }

    public function modifyNameServers($orderId, $ns)
    {
        return $this->post('modify-ns', ['order-id' => $orderId, 'ns' => $ns]);
    }

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

    public function modifyContact($orderId, $regContactId, $adminContactId, $techContactId, $billingContactId)
    {
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

    public function purchasePrivacy($orderId, $invoiceOption)
    {
        return $this->post(
            'modify-contact',
            [
                'order-id'       => $orderId,
                'invoice-option' => $invoiceOption // NoInvoice, PayInvoice, KeepInvoice, OnlyAdd
            ]
        );
    }

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

    public function enableTheftProtection($orderId)
    {
        return $this->post('enable-theft-protection', ['order-id' => $orderId]);
    }

    public function disableTheftProtection($orderId)
    {
        return $this->post('disable-theft-protection', ['order-id' => $orderId]);
    }

    public function getLocks($orderId)
    {
        return $this->get('locks', ['order-id' => $orderId]);
    }

    public function getCthDetails($orderId)
    {
        return $this->get('cth-details', ['order-id' => $orderId], 'tel/');
    }

    public function modifyTelWhoisPreference($orderId, $type, $publish)
    {
        return $this->post(
            'modify-whois-pref',
            [
                'order-id'   => $orderId,
                'whois-type' => $type, // Natural, Legal
                'publish'    => $publish,
            ],
            'tel/'
        );
    }

    public function resendRfa($orderId)
    {
        return $this->post('resend-rfa', ['order-id' => $orderId]);
    }

    public function releaseUk($orderId, $tag)
    {
        return $this->post('release', ['order-id' => $orderId, 'new-tag' => $tag], 'uk/');
    }

    public function cancelTransfer($orderId)
    {
        return $this->post('cancel-transfer', ['order-id' => $orderId]);
    }

    public function delete($orderId)
    {
        return $this->post('delete', ['order-id' => $orderId]);
    }

    public function restore($orderId, $invoice)
    {
        return $this->post('restore', ['order-id' => $orderId, 'invoice-option' => $invoice]);
    }

    public function recheckNsDe($orderId)
    {
        return $this->post('recheck-ns', ['order-id' => $orderId], 'de/');
    }

    public function setXXXAssociation($orderId, $id = '')
    {
        return $this->post('association-details', ['order-id' => $orderId, 'association-id' => $id], 'dotxxx/');
    }

    public function getXXXAssociation($orderId)
    {
        return $this->post('association-details', ['order-id' => $orderId], 'dotxxx/');
    }

    public function addDNSSEC($orderId, $attributes)
    {
        $attributes = $this->processAttributes($attributes);

        return $this->post('add-dnssec', ['orderId' => $orderId] + $attributes);
    }

    public function delDNSSEC($orderId, $attributes)
    {
        $attributes = $this->processAttributes($attributes);

        return $this->post('del-dnssec', ['orderId' => $orderId] + $attributes);
    }

    public function resendVerificationEmail($orderId)
    {
        return $this->post('resend-verification', ['order-id' => $orderId], 'raa/');
    }

    public function addWishList($customerId, $domains)
    {
        return $this->post('add', ['customerid' => $customerId, 'domain' => $domains], 'preordering/');
    }

    public function deleteWishList($customerId, $domain)
    {
        return $this->post('delete', ['customerid' => $customerId, 'domain' => $domain], 'preordering/');
    }

    public function fetchWishList(
        $records = 10,
        $page = 0,
        $customerId = -1,
        $resellerId = -1,
        $slds = [],
        $tlds = [],
        $createdStart = FALSE,
        $createdEnd = FALSE
    )
    {
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

        if (!empty($slds)) {
            $data['domain'] = $slds;
        }

        if (!empty($tlds)) {
            $data['tld'] = $tlds;
        }

        if ($createdStart !== FALSE) {
            $data['creation-date-start'] = strtotime($createdStart);
        }

        if ($createdEnd !== FALSE) {
            $data['creation-date-end'] = strtotime($createdEnd);
        }

        return $this->get('fetch', $data, 'preordering/');
    }

    public function fetchTLDs($category)
    {
        return $this->get('fetchtldlist', ['category' => $category], 'preordering/');
    }

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

    public function fetchTMClaim($claimKey)
    {
        return $this->get('get-tm-notice', ['lookup-key' => $claimKey]);
    }

    public function getPreOrderTLDs($phase = 'sunrise')
    {
        return $this->get('tlds-in-phase', ['phase' => $phase]);
    }

    public function getTLDs()
    {
        return $this->get('tld-info');
    }
}
