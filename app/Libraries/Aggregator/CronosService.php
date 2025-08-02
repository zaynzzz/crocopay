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
        parent::__construct($project);
        $this->key      = $project['cronos_key'] ?? 'CE-FR15JPKY8XPGFDXY';
        $this->token    = $project['cronos_token'] ?? 'p47s4f3gve57Pn60XLSNjbCFLDKWqGRs';
        $this->callback = $project['webhook_url'] ?? 'https://yourdomain.com/webhook/payment';
    }

    public function createTransaction(string $orderId, int $amount, string $description): array
    {
        return $this->createQris($orderId, $amount, $description);
    }

   public function createQris(string $orderId, int $amount, string $description): array
{
    $client = Services::curlrequest();

    if ($amount < 1000) {
        log_message('error', 'Amount too low: ' . $amount);
        return ['error' => 'Amount must be at least 1000'];
    }

    $body = [
        'reference' => $orderId,
        'amount' => $amount,
        'expiryMinutes' => 30,
        'viewName' => $description,
        'additionalInfo' => ['callback' => $this->callback]
    ];

    $bodyJson = json_encode($body, JSON_UNESCAPED_SLASHES);
    $escapedJson = str_replace('/', '\\/', $bodyJson);
    $signatureBase = $this->key . $escapedJson;
    $signature = hash_hmac('sha512', $signatureBase, $this->token);

    log_message('debug', 'Cronos Request: ' . $bodyJson . ' | Signature: ' . $signature);

    try {
        $response = $client->post('https://api.cronosengine.com/api/qris', [
            'headers' => [
                'Content-Type' => 'application/json',
                'On-Key' => $this->key,
                'On-Token' => $this->token,
                'On-Signature' => $signature,
            ],
            'body' => $bodyJson
        ]);

        $result = json_decode($response->getBody(), true);
        log_message('debug', 'Cronos Response: ' . print_r($result, true));

        return [
            'reference' => $orderId,
            'id' => $result['responseData']['id'] ?? null,
            'qris' => $result['responseData']['qris'] ?? null,
            'image' => $result['responseData']['image'] ?? null,
            'expired' => $result['responseData']['expired'] ?? null,
            'provider' => 'cronos'
        ];
    } catch (\Throwable $e) {
        log_message('error', 'Cronos API error: ' . $e->getMessage() . ' | Response: ' . $response->getBody());
        return [
            'error' => 'Cronos API request failed: ' . $e->getMessage()
        ];
    }
}
}
