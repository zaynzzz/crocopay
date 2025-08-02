<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\TransactionModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $merchantId = session('merchant_id');

        // Total project milik merchant
        $projectModel = new ProjectModel();
        $totalProjects = $projectModel->where('merchant_id', $merchantId)->countAllResults();
        // Total transaksi (bisa difilter berdasarkan project milik merchant)
        $transactionModel = new TransactionModel();
        $totalTransactions = $transactionModel
        ->join('projects', 'transactions.project_id = projects.id')
        ->where('projects.merchant_id', $merchantId)
        ->countAllResults();


        // Total balance (jumlahkan saldo dari semua project milik merchant)
        $projects = $projectModel->where('merchant_id', $merchantId)->findAll();
        $balance = 0;
        foreach ($projects as $project) {
            $balance += $project['balance'];
        }

        // Transaksi terbaru
        $recentTransactions = $transactionModel
            ->select('transactions.*, projects.name as project_name')
            ->join('projects', 'transactions.project_id = projects.id')
            ->where('projects.merchant_id', $merchantId)
            ->orderBy('transactions.created_at', 'DESC')
            ->limit(5)
            ->find();

        return view('dashboard/index', [
            'totalProjects' => $totalProjects,
            'totalTransactions' => $totalTransactions,
            'balance' => $balance,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
