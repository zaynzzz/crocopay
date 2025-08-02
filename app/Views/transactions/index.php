<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header and Filters -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Transaction History</h2>
            <p class="text-gray-600">Monitor and track all payment activities</p>
        </div>
        <form method="get" class="flex flex-col sm:flex-row gap-3 items-end">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Status</label>
                <select name="status" class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm">
                    <option value="">All</option>
                    <option value="completed" <?= $filters['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="pending" <?= $filters['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="failed" <?= $filters['status'] === 'failed' ? 'selected' : '' ?>>Failed</option>
                    <option value="expired" <?= $filters['status'] === 'expired' ? 'selected' : '' ?>>Expired</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Project</label>
                <select name="project" class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm">
                    <option value="">All</option>
                    <?php foreach ($projectList as $proj): ?>
                        <option value="<?= $proj['id'] ?>" <?= $filters['project'] == $proj['id'] ? 'selected' : '' ?>>
                            <?= esc($proj['name']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Search</label>
                <input type="text" name="search" value="<?= esc($filters['search']) ?>"
                       placeholder="Order ID or Project"
                       class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Start Date</label>
                <input type="date" name="start_date" value="<?= esc($filters['startDate']) ?>"
                       class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">End Date</label>
                <input type="date" name="end_date" value="<?= esc($filters['endDate']) ?>"
                       class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm">
            </div>
            
            <a href="<?= base_url('transactions') ?>" class="px-4 py-2 bg-red-200 text-gray-800 rounded hover:bg-red-300">
                Reset
            </a>
            <div>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg text-sm">Filter</button>
            </div>
        </form>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500 mb-1">Total Transactions</p>
            <div class="flex items-center justify-between">
                <p class="text-2xl font-bold"><?= $pagerData['total'] ?></p>
                <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fas fa-exchange-alt"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-green-100">
            <p class="text-sm font-medium text-gray-500 mb-1">Completed</p>
            <div class="flex items-center justify-between">
                <p class="text-2xl font-bold text-green-600"><?= $completedCount ?></p>
                <div class="h-10 w-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500 mb-1">Pending</p>
            <div class="flex items-center justify-between">
                <p class="text-2xl font-bold text-yellow-600"><?= $pendingCount ?></p>
                <div class="h-10 w-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500 mb-1">Total Value</p>
            <div class="flex items-center justify-between">
                <p class="text-2xl font-bold">Rp <?= number_format($totalAmount, 0, ',', '.') ?></p>
                <div class="h-10 w-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Provider</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($transactions as $i => $txn): ?>
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500"><?= $i + 1 ?></td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            <?= esc($txn['order_id']) ?>
                            <div class="text-xs text-gray-500"><?= esc($txn['project_name']) ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-green-600 font-bold">
                            Rp <?= number_format($txn['amount'], 0, ',', '.') ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                <?= match($txn['status']) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'failed' => 'bg-red-100 text-red-800',
                                    'expired' => 'bg-gray-100 text-gray-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } ?>">
                                <?= ucfirst($txn['status']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?= esc($txn['payment_method']) ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?= esc($txn['provider']) ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?= date('d M Y', strtotime($txn['created_at'])) ?>
                            <div class="text-xs text-gray-400"><?= date('H:i', strtotime($txn['created_at'])) ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="<?= base_url('transactions/' . $txn['id']) ?>" class="text-primary hover:text-primary-dark mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-sm text-gray-500 py-6">No transactions found.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <?php
                $totalPages = ceil($pagerData['total'] / $pagerData['perPage']);
                $currentPage = $pagerData['current'];
                $queryString = $_GET;
            ?>
            <div class="text-sm text-gray-600">
                Showing <?= ($pagerData['current'] - 1) * $pagerData['perPage'] + 1 ?> 
                to <?= min($pagerData['current'] * $pagerData['perPage'], $pagerData['total']) ?> 
                of <?= $pagerData['total'] ?> results
            </div>

            <div class="flex items-center space-x-2">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php $queryString['page'] = $i; ?>
                    <a href="?<?= http_build_query($queryString) ?>"
                        class="px-3 py-1 rounded text-sm border <?= $i === $currentPage ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 border-gray-300' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
