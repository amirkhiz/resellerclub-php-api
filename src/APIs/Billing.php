<?php

namespace habil\ResellerClub\APIs;

use habil\ResellerClub\Helper;
use SimpleXMLElement;

/**
 * Class Billing
 *
 * @package habil\ResellerClub\APIs
 */
class Billing
{
    use Helper;

    /**
     * @var string
     */
    protected $api = 'billing';

    /**
     * Gets the transaction details for the specified Customer Id.
     *
     * @param int $customerId
     *
     * @return array
     */
    public function customerTransactions($customerId)
    {
        return $this->get('customer-transactions', ['customer-id' => $customerId]);
    }

        /**
     * @param int    $records
     * @param int    $page
     * @param array  $customerId
     * @param array  $username
     * @param array  $transactionType
     * @param string $transactionKey
     * @param array  $transactionId
     * @param string $transactionDescription
     * @param string $balanceType
     * @param int    $amtRangeStart
     * @param int    $amtRangeEnd
     * @param string $transactionDateStart
     * @param string $transactionDateEnd
     * @param string $orderBy
     *
     * @return array
     */
    public function search(
        $records = 10,
        $page = 1,
        $customerId = [],
        $username = [],
        $transactionType = [],
        $transactionKey = '',
        $transactionId = [],
        $transactionDescription = '',
        $balanceType = '',
        $amtRangeStart = 0,
        $amtRangeEnd = 0,
        $transactionDateStart = '',
        $transactionDateEnd = '',
        $orderBy = ''
    ) {
        $data = [
            'no-of-records' => $records,
            'page-no'       => $page,
        ];

        if ( ! empty($customerId)) {
            $data['customer-id'] = $customerId;
        }

        if ( ! empty($username)) {
            $data['username'] = $username;
        }

        if ( ! empty($transactionType)) {
            $data['transaction-type'] = $transactionType;
        }

        if ( ! empty($transactionKey)) {
            $data['transaction-key'] = $transactionKey;
        }

        if ( ! empty($transactionId)) {
            $data['transaction-id'] = $transactionId;
        }

        if ( ! empty($transactionDescription)) {
            $data['transaction-description'] = $transactionDescription;
        }

        if ( ! empty($balanceType)) {
            $data['balance-type'] = $balanceType;
        }

        if ( ! empty($amtRangeStart)) {
            $data['amt-range-start'] = $amtRangeStart;
        }

        if ( ! empty($amtRangeEnd)) {
            $data['amt-range-end'] = $amtRangeEnd;
        }

        if ( ! empty($transactionDateStart)) {
            $data['transaction-date-start'] = $transactionDateStart;
        }

        if ( ! empty($transactionDateEnd)) {
            $data['transaction-date-end'] = $transactionDateEnd;
        }

        if ( ! empty($orderBy)) {
            $data['order-by'] = $orderBy;
        }

        return $this->get('search', $data,'customer-transactions/');
    }

}
