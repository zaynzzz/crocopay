<?php

namespace App\Libraries\Disbursement;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

class MidtransDisbursement implements DisbursementInterface
{
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl;
    protected $accessToken;

    public function __construct()
    {
        $this->clientId     = 'ISn9G6FD-G874565528-SNAP';
        $this->clientSecret = '885ko4WuhRjmY1yBTChjZRFXa9j1gL1aYcRDmcvfB0tcNLdOwLp4FHIVGXM49Sdz8Hql24FlOIESjMKR8rSuK6xOfabPIYbE7walOKDaz4semrnuYQfQUGdDvg7Bhlnc';
        $this->baseUrl      = 'https://api.sandbox.midtrans.com/money-transfer/v2';
    }

    protected function requestToken()
    {
        $encodedAuth = base64_encode("{$this->clientId}:{$this->clientSecret}");

        $client = Services::curlrequest();
        $response = $client->post("{$this->baseUrl}/token", [
            'headers' => [
                'Authorization' => "Basic {$encodedAuth}",
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                'grantType' => 'client_credentials'
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $this->accessToken = $data['accessToken'] ?? null;
    }

    public function send(array $payload): array
    {
        try {
            if (!$this->accessToken) {
                $this->requestToken();
            }

            $client = Services::curlrequest();
            $response = $client->post("{$this->baseUrl}/transfers", [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type'  => 'application/json'
                ],
                'json' => [
                    'externalId' => $payload['reference'] ?? 'trx-' . time(),
                    'amount'     => $payload['amount'],
                    'beneficiary' => [
                        'bankCode'      => $payload['bankCode'],
                        'accountNumber' => $payload['recipientAccount'],
                        'name'          => $payload['recipientName'] ?? 'Recipient'
                    ],
                    'description' => $payload['description'] ?? 'Disbursement via Midtrans'
                ]
            ]);

            return [
                'status' => 'success',
                'data' => json_decode($response->getBody(), true)
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'message' => $e->getMessage(),
            ];
        }
    }
}
