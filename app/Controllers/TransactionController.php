<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Libraries\Disbursement\CronosDisbursement;
use App\Libraries\Disbursement\MidtransDisbursement;
use App\Libraries\Disbursement\DisbursementInterface;
use App\Libraries\Disbursement\DisbursementRouter;

class TransactionController extends BaseController
{
    protected $db;
    protected $transactionModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->transactionModel = new TransactionModel();
    }

   public function index()
{
    $merchantId = session()->get('merchant_id');

    // Ambil filter dari URL
    $status = $this->request->getGet('status');
    $search = $this->request->getGet('search');
    $project = $this->request->getGet('project');
    $startDate = $this->request->getGet('start_date');
    $endDate = $this->request->getGet('end_date');

    $page = (int) ($this->request->getGet('page') ?? 1);
    if ($page < 1) $page = 1;

    $perPage = 10;

    // Bangun query builder
    $builder = $this->transactionModel
        ->select('transactions.*, projects.name as project_name')
        ->join('projects', 'projects.id = transactions.project_id', 'left')
        ->where('transactions.merchant_id', $merchantId);

    if (!empty($status)) {
        $builder->where('transactions.status', $status);
    }

    if (!empty($search)) {
        $builder->groupStart()
            ->like('transactions.order_id', $search)
            ->orLike('projects.name', $search)
            ->groupEnd();
    }

    if (!empty($project)) {
        $builder->where('transactions.project_id', $project);
    }

    if (!empty($startDate)) {
        $builder->where('DATE(transactions.created_at) >=', $startDate);
    }

    if (!empty($endDate)) {
        $builder->where('DATE(transactions.created_at) <=', $endDate);
    }

    $totalCount = $builder->countAllResults(false); // tanpa reset query

    $transactions = $builder
        ->orderBy('transactions.created_at', 'DESC')
        ->findAll($perPage, ($page - 1) * $perPage);

    // Statistik
    $completedCount = 0;
    $pendingCount = 0;
    $totalAmount = 0;

    foreach ($transactions as $txn) {
        if ($txn['status'] === 'completed') {
            $completedCount++;
        } elseif ($txn['status'] === 'pending') {
            $pendingCount++;
        }
        $totalAmount += (float) $txn['amount'];
    }

    // Daftar project untuk dropdown filter
    $projectList = $this->db->table('projects')
        ->where('merchant_id', $merchantId)
        ->get()
        ->getResultArray();

    return view('transactions/index', [
        'transactions' => $transactions,
        'completedCount' => $completedCount,
        'pendingCount' => $pendingCount,
        'totalAmount' => $totalAmount,
        'pagerData' => [
            'current' => $page,
            'perPage' => $perPage,
            'total' => $totalCount
        ],
        'filters' => compact('status', 'search', 'project', 'startDate', 'endDate'),
        'projectList' => $projectList,
    ]);
}
public function detail($id)
    {
        $merchantId = session()->get('merchant_id');

        $transaction = $this->db->table('transactions')
            ->select('transactions.*, projects.name as project_name, merchants.name as merchant_name')
            ->join('projects', 'projects.id = transactions.project_id', 'left')
            ->join('merchants', 'merchants.id = transactions.merchant_id', 'left')
            ->where('transactions.id', $id)
            ->where('transactions.merchant_id', $merchantId)
            ->get()
            ->getRowArray();

        if (!$transaction) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Transaction not found.');
        }

        return view('transactions/show', compact('transaction'));
    }
public function createDisbursement()
{
    $payload = $this->request->getJSON(true);

    $merchantId = session()->get('merchant_id');
    $projectId = $payload['project_id'] ?? null;

    $router = new DisbursementRouter();
    $channels = $router->getChannels($merchantId, $projectId);

    $primaryDisburser = $this->getDisburser($channels['primary']);
    $fallbackDisburser = $channels['fallback'] ? $this->getDisburser($channels['fallback']) : null;

    if (!$primaryDisburser) {
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid disbursement channel']);
    }

    // Kirim via primary
    $result = $primaryDisburser->send($payload);
    // Jika gagal dan ada fallback

    if ($result['status'] !== 'success' && $fallbackDisburser) {
    return $this->response->setJSON($result);
        $result['used_fallback'] = true;
    }

    return $this->response->setJSON($result);
}

private function getDisburser(string $channel): ?DisbursementInterface
{
     return match ($channel) {
        'cronos'   => new \App\Libraries\Disbursement\CronosDisbursement(),
        'midtrans' => new \App\Libraries\Disbursement\MidtransDisbursement(),
        'brick'    => new \App\Libraries\Disbursement\BrickDisbursement(),
        default    => null,
    };
}


}