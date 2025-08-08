<?php

namespace App\Libraries\Disbursement;

class CronosDisbursement implements DisbursementInterface
{
    protected $apiUrl = 'https://api.sandbox.hadesengine.com/api/disburse';
    protected $apiKey = 'SC-FPXXKHTNVRKTM8UJ';
    protected $apiToken = 'LijrMeLpGHfKSYrQNXEJPHQRNzilokKW';

    public function send(array $payload): array
    {
        $body = json_encode($payload); // keep escaped slash
        $message = $this->apiKey . $body;
        $signature = hash_hmac('sha512', $message, $this->apiToken);

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'On-Key: ' . $this->apiKey,
            'On-Token: ' . $this->apiToken,
            'On-Signature: ' . $signature
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['error' => true, 'message' => $error];
        }

        return json_decode($response, true);
    }
}
