<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="space-y-6">
  <!-- Welcome Header -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
      <h2 class="text-2xl font-bold text-gray-800">Welcome back, <?= session('merchant_name') ?>!</h2>
      <p class="text-gray-500">Here's what's happening with your business today</p>
    </div>
    <div class="mt-4 md:mt-0">
      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
        <i class="fas fa-circle text-xs mr-2"></i> Active Merchant
      </span>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-medium text-gray-500">Total Projects</p>
          <p class="text-3xl font-bold mt-1"><?= $totalProjects ?></p>
        </div>
        <div class="h-12 w-12 rounded-full bg-green-50 flex items-center justify-center text-green-600">
          <i class="fas fa-project-diagram text-xl"></i>
        </div>
      </div>
      <div class="mt-4">
        <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-50 text-blue-600">
          <i class="fas fa-arrow-up mr-1"></i> 12% from last month
        </span>
      </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-medium text-gray-500">Total Transactions</p>
          <p class="text-3xl font-bold mt-1"><?= $totalTransactions ?></p>
        </div>
        <div class="h-12 w-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
          <i class="fas fa-exchange-alt text-xl"></i>
        </div>
      </div>
      <div class="mt-4">
        <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-50 text-blue-600">
          <i class="fas fa-arrow-up mr-1"></i> 8% from last month
        </span>
      </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-medium text-gray-500">Total Balance</p>
          <p class="text-3xl font-bold mt-1">Rp <?= number_format($balance, 0, ',', '.') ?></p>
        </div>
        <div class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
          <i class="fas fa-wallet text-xl"></i>
        </div>
      </div>
      <div class="mt-4">
        <a href="<?= base_url('transactions') ?>" class="text-xs font-medium px-2 py-1 rounded-full bg-green-50 text-green-600 hover:bg-green-100">
          <i class="fas fa-plus mr-1"></i> Withdraw funds
        </a>
      </div>
    </div>
  </div>

  <!-- Recent Activity Section -->
  <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Recent Transactions</h3>
      <a href="<?= base_url('transactions') ?>" class="text-sm text-primary hover:underline">View all</a>
    </div>
    
    <div class="space-y-4">
      <!-- Sample transaction - replace with dynamic data -->
      <?php foreach ($recentTransactions as $trx): ?>
    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
        <div class="flex items-center space-x-3">
            <div class="h-10 w-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                <i class="fas fa-check"></i>
            </div>
            <div>
                <p class="font-medium"><?= esc($trx['project_name']) ?> — <?= esc($trx['order_id']) ?></p>
                <p class="text-xs text-gray-500"><?= date('d M Y H:i', strtotime($trx['created_at'])) ?></p>
            </div>
        </div>
        <div class="text-right">
            <p class="font-medium text-green-600">+Rp <?= number_format($trx['amount'], 0, ',', '.') ?></p>
            <p class="text-xs text-gray-500"><?= timeAgo(strtotime($trx['created_at'])) ?></p>
        </div>
    </div>
<?php endforeach ?>

      
      <!-- Add more transaction items here -->
    </div>
  </div>
</div>

<?= $this->endSection() ?>