<?php

namespace App\Libraries\Aggregator;

use Midtrans\Config;
use Midtrans\CoreApi;

class MidtransService extends BaseAggregator
{
    public function __construct(array $project)
    {
        parent::__construct($project);

        // Pastikan field ini ada di tabel `projects`
        Config::$serverKey = 'Mid-server-35hryOFey-lmqJkzEnPuPETC';
        Config::$isProduction = false; // true untuk live
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function createQris(string $orderId, int $amount, string $description): array
    {
        $params = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $amount, // HARUS int
            ],
            'qris' => [
                'acquirer' => 'gopay', // opsional
            ]
        ];

        $response = CoreApi::charge($params);

        return [
            'reference' => $orderId,
            'id'        => $response->transaction_id ?? null,
            'qris'      => $response->actions[0]->url ?? null,
            'provider'  => 'midtrans',
        ];
    }

    public function createTransaction(string $orderId, int $amount, string $description): array
    {
        // Gunakan QRIS sebagai fallback/default
        return $this->createQris($orderId, $amount, $description);
    }
}
