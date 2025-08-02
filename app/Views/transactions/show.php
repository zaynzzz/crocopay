<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
        <!-- Header with status bar -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Transaction Details</h2>
                <p class="text-sm text-gray-500 mt-1">Transaction ID: <?= esc($transaction['id']) ?></p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                <?= match($transaction['status']) {
                    'completed', 'paid' => 'bg-green-100 text-green-800',
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'failed' => 'bg-red-100 text-red-800',
                    'expired' => 'bg-gray-100 text-gray-800',
                    default => 'bg-gray-100 text-gray-800'
                } ?>">
                <i class="fas fa-circle text-xs mr-1.5"></i>
                <?= ucfirst($transaction['status']) ?>
            </span>
        </div>

        <div class="p-6">
            <!-- Payment Summary -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Payment Summary</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 mb-1">Amount</p>
                        <p class="text-2xl font-bold text-green-600">
                            Rp <?= number_format($transaction['amount'], 0, ',', '.') ?>
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 mb-1">Payment Method</p>
                        <p class="text-lg font-medium">
                            <?= esc(ucfirst($transaction['payment_method'] ?? '—')) ?>
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 mb-1">Provider</p>
                        <p class="text-lg font-medium">
                            <?= esc(ucfirst($transaction['provider'] ?? '—')) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Transaction Details</h3>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-500 w-1/3">Order ID</td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?= esc($transaction['order_id']) ?></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-500">Merchant</td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?= esc($transaction['merchant_name'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-500">Project</td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?= esc($transaction['project_name'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-500">Created At</td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?= date('d M Y H:i:s', strtotime($transaction['created_at'])) ?></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-500">Updated At</td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?= date('d M Y H:i:s', strtotime($transaction['updated_at'])) ?></td>
                            </tr>

                            <?php if (!empty($transaction['reff_id'])): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-500">Ref ID (Crocopay)</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 break-all"><?= esc($transaction['reff_id']) ?></td>
                                </tr>
                            <?php endif; ?>

                            <?php if (!empty($transaction['aggregator_ref_id'])): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-500">Aggregator Ref ID</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 break-all"><?= esc($transaction['aggregator_ref_id']) ?></td>
                                </tr>
                            <?php endif; ?>

                            <?php if (!empty($transaction['expired_at'])): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-500">Expired At</td>
                                    <td class="px-4 py-3 text-sm text-gray-900"><?= date('d M Y H:i:s', strtotime($transaction['expired_at'])) ?></td>
                                </tr>
                            <?php endif; ?>

                            <?php if (!empty($transaction['qris_content'])): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-500">QRIS Code</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        <div class="flex flex-col items-start space-y-2">
                                            <img class="w-40 h-40 border border-gray-300 rounded" 
                                                src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?= urlencode($transaction['qris_content']) ?>" 
                                                alt="QR Code">
                                            <code class="text-xs text-gray-500 break-all"><?= esc($transaction['qris_content']) ?></code>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-center border-t border-gray-200 pt-6">
                <a href="/transactions" class="flex items-center text-gray-600 hover:text-green-600 mb-4 sm:mb-0">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Transactions
                </a>
                <div class="space-x-3">
                    <?php if ($transaction['status'] === 'pending'): ?>
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600">
                            <i class="fas fa-sync-alt mr-2"></i> Refresh Status
                        </button>
                    <?php endif; ?>
                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-print mr-2"></i> Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>