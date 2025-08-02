<?php

namespace App\Controllers\Webhook;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\ProjectModel;

class PaymentWebhook extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $transactionModel = new TransactionModel();
        $projectModel = new ProjectModel();

        // Ambil raw body
        $rawInput = $this->request->getBody() ?: file_get_contents('php://input');
        log_message('info', 'Webhook RAW Input: ' . $rawInput);

        // Validasi Content-Type
        $contentType = $this->request->getHeaderLine('Content-Type');
        if (strpos($contentType, 'application/json') === false) {
            log_message('error', 'Invalid Content-Type: ' . $contentType);
            return $this->response->setJSON(['message' => 'Invalid Content-Type'])->setStatusCode(400);
        }

        // Decode JSON
        $payload = json_decode($rawInput, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'JSON Decode Error: ' . json_last_error_msg());
            return $this->response->setJSON(['message' => 'Invalid JSON'])->setStatusCode(400);
        }

        // Validasi payload
        if (!isset($payload['responseCode']) || $payload['responseCode'] != 200 || !isset($payload['responseData'])) {
            log_message('error', 'Invalid or incomplete webhook payload');
            return $this->response->setJSON(['message' => 'Invalid payload'])->setStatusCode(400);
        }

        $data = $payload['responseData'];
        $status = $data['status'] ?? '';
        $merchantRef = $data['merchantRef'] ?? null;
        $externalId = $data['id'] ?? null;
        $totalAmount = $data['totalAmount'] ?? 0;
        $paidDate = $data['paidDate'] ?? null;

        if ($status !== 'success' || !$merchantRef) {
            log_message('error', 'Invalid status or missing merchantRef');
            return $this->response->setJSON(['message' => 'Invalid transaction'])->setStatusCode(400);
        }

        // Cari transaksi berdasarkan order_id (merchantRef)
        $transaction = $transactionModel->where('order_id', $merchantRef)->first();
        log_message('info', 'Transaction result: ' . print_r($transaction, true));

        if (!$transaction) {
            log_message('error', 'Transaction not found, retrying in 5 seconds...');
            sleep(5);
            $transaction = $transactionModel->where('order_id', $merchantRef)->first();

            if (!$transaction) {
                log_message('error', 'Transaction still not found');
                return $this->response->setJSON(['message' => 'Transaction not found'])->setStatusCode(404);
            }
        }

        if ($transaction['status'] === 'completed') {
            log_message('info', 'Transaction already completed: ' . $merchantRef);
            return $this->response->setJSON(['message' => 'Already completed']);
        }

        try {
            $db->transStart();

            // Update transaksi
            $transactionModel->update($transaction['id'], [
                'status' => 'completed',
                'external_ref' => $externalId,
                'paid_at' => $paidDate ? date('Y-m-d H:i:s', strtotime($paidDate)) : date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            // Tambah saldo ke project terkait
            $projectModel->incrementBalance($transaction['project_id'], $totalAmount);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new DataException('Database transaction failed');
            }

            log_message('info', 'Transaction & balance updated for merchantRef: ' . $merchantRef);
            return $this->response->setJSON(['message' => 'Webhook processed']);
        } catch (\Throwable $e) {
            log_message('critical', 'Error in webhook processing: ' . $e->getMessage());
            return $this->response->setJSON(['message' => 'Internal Server Error'])->setStatusCode(500);
        }
    }
}
