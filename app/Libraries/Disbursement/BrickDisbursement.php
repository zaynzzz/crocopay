<?php

namespace App\Libraries\Disbursement;

use CodeIgniter\HTTP\CURLRequest;

class BrickDisbursement implements DisbursementInterface
{
    protected string $clientId = 'e585cd84-ac09-4f37-b080-4c2292820dff';
    protected string $clientSecret = 'vNyfLdiuQqMmHyx4tWBWSi01zBCNSY';
    protected string $tokenUrl = 'https://sandbox.onebrick.io/v2/payments/auth/token';
    protected string $baseUrl = 'https://sandbox.onebrick.io/v2/payments/gs';

    protected string $accessToken;

    public function __construct()
    {
        $this->accessToken = $this->getAccessToken();
    }

    protected function getAccessToken(): string
    {
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', $this->tokenUrl, [
            'auth' => [$this->clientId, $this->clientSecret],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['data']['accessToken'] ?? '';
    }

    public function verifyAccount(string $accountNumber, string $bankShortCode): array
    {
        $client = \Config\Services::curlrequest();

        $response = $client->get("{$this->baseUrl}/bank-account-validation", [
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'publicAccessToken' => 'Bearer ' . $this->accessToken,
            ],
            'query' => [
                'accountNumber' => $accountNumber,
                'bankShortCode' => $bankShortCode,
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function send(array $payload): array
    {
        $client = \Config\Services::curlrequest();

        $body = [
            'referenceId' => $payload['reference'] ?? uniqid('ref-'),
            'description' => $payload['description'] ?? $payload['reference'] ?? 'Disbursement',
            'amount' => (int)($payload['amount'] ?? 0),
            'disbursementMethod' => [
                'type' => 'bank_transfer',
                'bankShortCode' => $payload['bankCode'] ?? 'MANDIRI',
                'bankAccountNo' => $payload['recipientAccount'] ?? '',
                'bankAccountHolderName' => $payload['accountHolder'] ?? 'UNKNOWN',
            ]
        ];

       try {
        $response = $client->post("{$this->baseUrl}/disbursements", [
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'publicAccessToken' => 'Bearer ' . $this->accessToken,
            ],
            'json' => $body
        ]);

        $result = json_decode($response->getBody(), true);

        return [
            'status' => $result['data']['attributes']['status'] ?? 'unknown',
            'trx_id' => $result['data']['id'] ?? null,
            'message' => $result['data']['message'] ?? 'No message',
            'raw' => $result
        ];
    } catch (\CodeIgniter\HTTP\Exceptions\HTTPException $e) {
        // Get response body from exception
       return [
            'status' => 'failed',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'trace' => $e->getTraceAsString(),
        ];

    }

    }

}
