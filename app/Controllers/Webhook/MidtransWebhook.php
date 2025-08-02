<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TransactionModel;
use App\Models\ProjectModel;

class WebhookController extends ResourceController
{
    public function midtrans()
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        log_message('info', 'Midtrans Webhook Payload: ' . print_r($data, true));

        $serverKey = 'Mid-server-35hryOFey-lmqJkzEnPuPETC';
        $expectedSignature = hash('sha512',
            $data['order_id'] . $data['status_code'] . $data['gross_amount'] . $serverKey
        );

        if (($data['signature_key'] ?? '') !== $expectedSignature) {
            return $this->failUnauthorized('Invalid signature');
        }

        $transactionId = $data['order_id'];
        $status = $data['transaction_status'];

        // Update transaksi jika ditemukan dan belum completed
        $transactionModel = new TransactionModel();
        $transaction = $transactionModel->where('order_id', $transactionId)->first();

        if ($transaction && $transaction['status'] !== 'completed' && $status === 'settlement') {
            $transactionModel->update($transaction['id'], ['status' => 'completed']);

            // Tambahkan saldo ke project terkait
            $projectModel = new ProjectModel();
            $project = $projectModel->find($transaction['project_id']);
            if ($project) {
                $newBalance = $project['balance'] + (int)$transaction['amount'];
                $projectModel->update($project['id'], ['balance' => $newBalance]);
            }

            log_message('info', "Transaction {$transactionId} completed & balance updated.");
        }

        return $this->respond(['message' => 'Webhook processed']);
    }
}