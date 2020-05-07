<?php

namespace habil\ResellerClub\APIs;

use Exception;
use habil\ResellerClub\Helper;

/**
 * Class Actions
 *
 * @package habil\ResellerClub\APIs
 */
class Actions
{
    use Helper;

    /**
     * @var string
     */
    protected $api = 'actions';

    /**
     * @param array|null $eaqIds        Array of Integers
     * @param array|null $orderIds      Array of Integers
     * @param array|null $entityTypeIds Array of Integers
     * @param array|null $actionStatus  Array of Strings
     * @param array|null $actionType    Array of Strings
     * @param int        $noOfRecords
     * @param int        $pageNo
     *
     * @return Exception|array
     */
    public function current(
        array $eaqIds = [],
        array $orderIds = [],
        array $entityTypeIds = [],
        array $actionStatus = [],
        array $actionType = [],
        $noOfRecords = 10,
        $pageNo = 1
    ) {
        $dataToSend = $this->formatData(
            $eaqIds,
            $orderIds,
            $entityTypeIds,
            $actionStatus,
            $actionType,
            $noOfRecords,
            $pageNo
        );

        return $this->get('search-current', $dataToSend);
    }

    /**
     * @param array $eaqIds
     * @param array $orderIds
     * @param array $entityTypeIds
     * @param array $actionStatus
     * @param array $actionType
     * @param       $noOfRecords
     * @param       $pageNo
     *
     * @return array
     */
    private function formatData(
        array $eaqIds,
        array $orderIds,
        array $entityTypeIds,
        array $actionStatus,
        array $actionType,
        $noOfRecords,
        $pageNo
    ) {
        $dataToSend = [
            'no-of-records' => $noOfRecords,
            'page-no'       => $pageNo,
        ];

        if ( ! empty($eaqIds)) {
            $dataToSend['eaq-id'] = $eaqIds;
        }

        if ( ! empty($orderIds)) {
            $dataToSend['order-id'] = $orderIds;
        }

        if ( ! empty($entityTypeIds)) {
            $dataToSend['entity-type-id'] = $entityTypeIds;
        }

        if ( ! empty($actionStatus)) {
            $dataToSend['action-status'] = $actionStatus;
        }

        if ( ! empty($actionType)) {
            $dataToSend['action-type'] = $actionType;
        }

        return $dataToSend;
    }

    /**
     * @param array|null $eaqIds        Array of Integers
     * @param array|null $orderIds      Array of Integers
     * @param array|null $entityTypeIds Array of Integers
     * @param array|null $actionStatus  Array of Strings
     * @param array|null $actionType    Array of Strings
     * @param int        $noOfRecords
     * @param int        $pageNo
     *
     * @return Exception|array
     */
    public function archived(
        array $eaqIds = [],
        array $orderIds = [],
        array $entityTypeIds = [],
        array $actionStatus = [],
        array $actionType = [],
        $noOfRecords = 10,
        $pageNo = 1
    ) {
        $dataToSend = $this->formatData(
            $eaqIds,
            $orderIds,
            $entityTypeIds,
            $actionStatus,
            $actionType,
            $noOfRecords,
            $pageNo
        );

        return $this->get('search-archived', $dataToSend);
    }
}