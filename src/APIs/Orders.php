<?php

namespace habil\ResellerClub\APIs;

use habil\ResellerClub\Helper;

class Orders
{
    use Helper;

    /**
     * @var string
     */
    protected $api = 'orders';

    public function suspend($orderId, $reason)
    {
        return $this->post(
            'suspend',
            [
                'order-id' => $orderId,
                'reason'   => $reason,
            ]
        );
    }

    public function unsuspend($orderId, $reason)
    {
        return $this->post(
            'unsuspend',
            [
                'order-id' => $orderId,
                'reason'   => $reason,
            ]
        );
    }
}
