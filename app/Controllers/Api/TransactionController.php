<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\ProjectModel;
use App\Libraries\Aggregator\FailoverAggregator;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Aggregator\AggregatorFactory;

class TransactionController extends BaseController
{
    use ResponseTrait;

    protected $transactionModel;
    protected $projectModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->projectModel     = new ProjectModel();
    }

    public function createQris()
    {
        $request = $this->request->getJSON(true);

        $orderId = $request['order_id'] ?? null;
        $amount  = $request['amount'] ?? null;

        if (!$orderId || !$amount) {
            return $this->failValidationErrors('Missing order_id or amount.');
        }

        $apiKey    = $this->request->getHeaderLine('Api-Key');
        $apiToken  = $this->request->getHeaderLine('Api-Token');
        $signature = $this->request->getHeaderLine('Signature');

        $project = $this->projectModel
            ->where('api_key', $apiKey)
            ->where('api_token', $apiToken)
            ->first();

        if (!$project) {
            return $this->failUnauthorized('Invalid API credentials');
        }

        $secretKey = $project['secret_key'];
        $payload   = json_encode($request);
        $expectedSignature = hash_hmac('sha512', $payload, $secretKey);

        if ($signature !== $expectedSignature) {
            return $this->failUnauthorized('Invalid Signature');
        }

        // Gunakan Failover Aggregator
        try {
        $aggregator = AggregatorFactory::create($project);
            $result = $aggregator->createQris($orderId, $amount, $orderId);
        } catch (\Throwable $e) {
            log_message('error', 'Aggregator error: ' . $e->getMessage());
            return $this->failServerError('Aggregator error: ' . $e->getMessage());
        }

        log_message('info', 'AGGREGATOR RESULT: ' . print_r($result, true));

        $refId       = $result['reference'] ?? $this->generateUUID();
        $externalRef = $result['id'] ?? ($result['responseData']['id'] ?? null);
        $provider    = $result['provider'] ?? 'unknown';

        // Simpan transaksi ke database
        $this->transactionModel->insert([
            'project_id'        => $project['id'],
            'merchant_id'       => $project['merchant_id'],
            'order_id'          => $orderId,
            'reff_id'           => 'zpay' . bin2hex(random_bytes(16)),
            'external_ref'      => $externalRef,
            'amount'            => $amount,
            'status'            => 'pending',
            'payment_method'    => 'qris',
            'provider'          => $provider,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

        return $this->respond([
            'responseCode'    => 200,
            'responseMessage' => 'success',
            'responseData'    => $result,
        ]);
    }

    private function generateUUID(): string
    {
        return bin2hex(random_bytes(16));
    }
}
