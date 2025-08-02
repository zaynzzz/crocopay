<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pengaturan Aggregator</h1>
            <p class="text-gray-600">Kelola penyedia pembayaran yang digunakan dalam sistem.</p>
        </div>

        <form action="/admin/aggregator/update" method="post">
            <?= csrf_field() ?>

            <div class="space-y-4">
                <?php foreach ($aggregators as $agg): ?>
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <label class="flex items-center gap-4 w-full cursor-pointer">
                        <!-- Radio untuk aggregator utama -->
                        <input type="radio" name="aggregator" value="<?= esc($agg['name']) ?>"
                            <?= $agg['is_primary'] ? 'checked' : '' ?>
                            class="h-5 w-5 text-primary border-gray-300 focus:ring-primary">

                        <div class="flex-1">
                            <div class="text-lg font-medium text-gray-800 capitalize"><?= esc($agg['name']) ?></div>
                            <div class="text-sm text-gray-500">Gunakan sebagai aggregator utama</div>
                        </div>
                    </label>

                    <!-- Toggle enable/disable -->
                    <div class="flex items-center gap-2">
                       <button type="button"
                            class="toggle-btn relative inline-flex items-center h-6 rounded-full w-11 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary <?= $agg['enabled'] ? 'bg-primary' : 'bg-gray-300' ?>"
                            data-name="<?= esc($agg['name']) ?>"
                            data-enabled="<?= $agg['enabled'] ? '1' : '0' ?>">
                        <span class="sr-only">Toggle</span>
                        <span class="toggle-indicator inline-block w-4 h-4 transform transition rounded-full bg-white <?= $agg['enabled'] ? 'translate-x-6' : 'translate-x-1' ?>"></span>
                    </button>
                    <span class="toggle-label text-sm font-medium text-gray-700 w-20">
                        <?= $agg['enabled'] ? 'Aktif' : 'Nonaktif' ?>
                    </span>

                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
<script>
document.querySelectorAll('.toggle-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
        const name = btn.getAttribute('data-name');

        // Optional: disable button while processing
        btn.disabled = true;

        try {
            const res = await fetch(`/admin/aggregator/toggle/${name}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>',
                }
            });

            const data = await res.json();
            if (data.status === 'success') {
                // Toggle class
                const enabled = data.enabled;
                btn.classList.toggle('bg-primary', enabled);
                btn.classList.toggle('bg-gray-300', !enabled);

                const indicator = btn.querySelector('.toggle-indicator');
                indicator.classList.toggle('translate-x-6', enabled);
                indicator.classList.toggle('translate-x-1', !enabled);

                // Update text
                const label = btn.nextElementSibling;
                label.textContent = enabled ? 'Aktif' : 'Nonaktif';

                // Update internal data-enabled
                btn.setAttribute('data-enabled', enabled ? '1' : '0');
            }
        } catch (err) {
            alert('Gagal mengubah status aggregator.');
            console.error(err);
        }

        btn.disabled = false;
    });
});
</script>

<?= $this->endSection() ?>
