<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Project</h2>
            <a href="<?= base_url('projects') ?>" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                <p><?= session()->getFlashdata('error') ?></p>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
                <p><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('projects/update/' . $project['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    value="<?= esc($project['name']) ?>" 
                    required
                >
            </div>

            <div class="mb-6">
                <label for="webhook_url" class="block text-sm font-medium text-gray-700 mb-1">Webhook URL</label>
                <input 
                    type="url" 
                    name="webhook_url" 
                    id="webhook_url"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    value="<?= esc($project['webhook_url']) ?>"
                    placeholder="https://example.com/webhook"
                >
                <p class="mt-1 text-sm text-gray-500">Optional webhook URL for project notifications</p>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea 
                    name="description" 
                    id="description"
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                ><?= esc($project['description']) ?></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="<?= base_url('projects') ?>" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                >
                    Update Project
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>