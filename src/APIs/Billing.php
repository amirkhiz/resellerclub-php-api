<?php

namespace habil\ResellerClub\APIs;

use Exception;
use habil\ResellerClub\Helper;

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
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/868
     */
    public function customerTransactions($customerId)
    {
        return $this->get(
            'customer-transactions',
            ['customer-id' => $customerId]
        );
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
     * @throws Exception
     * @link https://manage.logicboxes.com/kb/node/964
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
        $data = $this->fillParameters(
            [
                'no-of-records'           => $records,
                'page-no'                 => $page,
                'customer-id'             => $customerId,
                'username'                => $username,
                'transaction-type'        => $transactionType,
                'transaction-key'         => $transactionKey,
                'transaction-id'          => $transactionId,
                'transaction-description' => $transactionDescription,
                'balance-type'            => $balanceType,
                'amt-range-start'         => $amtRangeStart,
                'amt-range-end'           => $amtRangeEnd,
                'transaction-date-start'  => $transactionDateStart,
                'transaction-date-end'    => $transactionDateEnd,
                'order-by'                => $orderBy,
            ]
        );

        return $this->get('search', $data, 'customer-transactions/');
    }
}
