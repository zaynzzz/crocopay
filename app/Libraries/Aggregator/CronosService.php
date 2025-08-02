<?php

namespace App\Libraries\Aggregator;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

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
        return $this->createQris($orderId, $amount, $description);
    }

    public function createQris(string $orderId, int $amount, string $description): array
{
    $client = Services::curlrequest();

    $body = [
        'order_id' => $orderId,
        'amount'   => $amount
    ];

    // Signature = HMAC_SHA512(order_id + amount + api_token, secret_key)
    $signatureBase = $orderId . $amount . $this->token;
    $signature     = hash_hmac('sha512', $signatureBase, $this->project['cronos_secret'] ?? '');

    try {
        $response = $client->post('http://110.238.104.88/api/transaction/createQris', [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Api-Key'       => $this->key,
                'Api-Token'     => $this->token,
                'Signature'     => $signature,
            ],
            'body' => json_encode($body),
        ]);

        $result = json_decode($response->getBody(), true);

        return [
            'reference' => $orderId,
            'id'        => $result['responseData']['id'] ?? null,
            'qris'      => $result['responseData']['qris'] ?? null,
            'image'     => $result['responseData']['image'] ?? null,
            'expired'   => $result['responseData']['expired'] ?? null,
            'provider'  => 'cronos'
        ];

    } catch (\Throwable $e) {
        return [
            'error' => 'Cronos API request failed: ' . $e->getMessage()
        ];
    }
}

}
