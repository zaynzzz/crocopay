<?php

namespace App\Libraries\Aggregator;

use CodeIgniter\HTTP\CURLRequest;

class CronosService extends BaseAggregator
{
    protected $key;
    protected $token;
    protected $callback;

    public function __construct(array $project)
    {
        parent::__construct($project); // simpan $project jika perlu
        $this->key = $project['cronos_key'] ?? 'CE-FR15JPKY8XPGFDXY';
        $this->token = $project['cronos_token'] ?? 'p47s4f3gve57Pn60XLSNjbCFLDKWqGRs';
        $this->callback = $project['webhook_url'] ?? 'https://yourdomain.com/webhook/payment';
    }

    // Ini method dari abstract class BaseAggregator
    public function createTransaction(string $orderId, int $amount, string $description): array
    {
        return $this->createQris($orderId, $amount, $orderId);
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

    try {
        $response = CoreApi::charge($params);

        return [
            'reference' => $orderId,
            'id'        => $response->transaction_id ?? null,
            'qris'      => $response->actions[0]->url ?? null,
            'image'     => null, // Midtrans tidak menyediakan QR base64
            'expired'   => $response->expiry_time ?? null, // kalau tidak ada, isi null
            'provider'  => 'midtrans'
        ];

    } catch (\Exception $e) {
        return [
            'error' => 'Midtrans API request failed: ' . $e->getMessage()
        ];
    }
}

}
