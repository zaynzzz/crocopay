<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"><?= esc($project['name']) ?></h2>
            <p class="text-gray-500">Project detail and credentials</p>
        </div>
        <a href="<?= base_url('projects') ?>" class="text-sm text-primary hover:underline">
            ← Back to Projects
        </a>
    </div>

    <!-- Detail Card -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <p class="text-xs font-medium text-gray-400 mb-1">Webhook URL</p>
            <p class="text-sm text-gray-700"><?= esc($project['webhook_url']) ?: '<em class="text-gray-400">Not set</em>' ?></p>
        </div>

        <div>
            <p class="text-xs font-medium text-gray-400 mb-1">Description</p>
            <p class="text-sm text-gray-700"><?= esc($project['description']) ?: '<em class="text-gray-400">No description</em>' ?></p>
        </div>

        <div>
            <p class="text-xs font-medium text-gray-400 mb-1">API Key</p>
            <code class="block text-xs bg-gray-50 p-2 rounded break-all">
                <?= esc($project['api_key']) ?>
            </code>
        </div>

        <div>
            <p class="text-xs font-medium text-gray-400 mb-1">API Token</p>
            <code class="block text-xs bg-gray-50 p-2 rounded break-all">
                <?= esc($project['api_token']) ?>
            </code>
        </div>

        <div>
            <p class="text-xs font-medium text-gray-400 mb-1">Secret Key</p>
            <code class="block text-xs bg-gray-50 p-2 rounded break-all">
                <?= esc($project['secret_key']) ?>
            </code>
        </div>

        <div class="pt-4 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                Created at: <?= date('d M Y H:i', strtotime($project['created_at'])) ?>
            </p>
        </div>
        <!-- Tombol Hapus -->
        <button onclick="openDeleteModal()" 
            class="text-red-600 hover:underline text-sm mt-4">
            Delete this Project
        </button>
    </div>
</div>
<!-- Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg space-y-4">
        <h3 class="text-lg font-semibold text-red-600">Confirm Project Deletion</h3>
        <p class="text-sm text-gray-600">Please type the project name and your password to confirm deletion.</p>

        <form action="<?= base_url('projects/delete/' . $project['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
                <input type="text" name="project_name_confirmation" placeholder="<?= esc($project['name']) ?>"
                    class="w-full border border-gray-300 p-2 rounded-lg text-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Your Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border border-gray-300 p-2 rounded-lg text-sm" required>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closeDeleteModal()" class="text-gray-600 hover:underline text-sm">
                    Cancel
                </button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 text-sm rounded-lg hover:bg-red-700">
                    Confirm Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
<?= $this->endSection() ?>
