<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header with action button -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">My Projects</h2>
            <p class="text-gray-500">Manage your integration projects</p>
        </div>
        <a href="<?= base_url('projects/create') ?>" 
           class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fas fa-plus"></i>
            <span>Add New Project</span>
        </a>
    </div>

    <!-- Projects grid -->
    <?php if (empty($projects)): ?>
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
            <i class="fas fa-project-diagram text-4xl text-gray-300 mb-3"></i>
            <h3 class="text-lg font-medium text-gray-700 mb-2">No projects yet</h3>
            <p class="text-gray-500 mb-4">Get started by creating your first project</p>
            <a href="<?= base_url('projects/create') ?>" 
               class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg text-sm">
                <i class="fas fa-plus"></i>
                Create Project
            </a>
        </div>
    <?php else: ?>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($projects as $project): ?>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-800 truncate">
                            <?= esc($project['name']) ?>
                        </h3>
                        <div class="flex gap-2">
                            <!-- Copy -->
                            <button onclick="copyToClipboard('api-key-<?= $project['id'] ?>')" 
                                    class="text-gray-400 hover:text-primary p-1 rounded-full hover:bg-gray-50">
                                <i class="fas fa-copy text-sm"></i>
                            </button>

                            <!-- Edit -->
                            <a href="<?= base_url('projects/edit/' . $project['id']) ?>" 
                            class="text-gray-400 hover:text-blue-500 p-1 rounded-full hover:bg-gray-50">
                                <i class="fas fa-edit text-sm"></i>
                            </a>

                        </div>

                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs font-medium text-gray-400 mb-1">API Key</p>
                            <div class="flex items-center gap-2">
                                <code id="api-key-<?= $project['id'] ?>" 
                                      class="text-xs bg-gray-50 p-2 rounded break-all flex-1">
                                    <?= esc($project['api_key']) ?>
                                </code>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-400 mb-1">API Token</p>
                            <div class="flex items-center gap-2">
                                <code class="text-xs bg-gray-50 p-2 rounded break-all flex-1">
                                    <?= esc($project['api_token']) ?>
                                </code>
                                <button onclick="copyToClipboard('api-token-<?= $project['id'] ?>')" 
                                        class="text-gray-400 hover:text-primary p-1 rounded-full hover:bg-gray-50">
                                    <i class="fas fa-copy text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-xs text-gray-500">
                            Created: <?= date('d M Y', strtotime($project['created_at'])) ?>
                        </span>
                        <a href="<?= base_url('projects/show/' . $project['id']) ?>" 
                           class="text-xs text-primary hover:underline">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
</div>

<script>
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    const text = element.innerText;
    
    navigator.clipboard.writeText(text).then(() => {
        // Show temporary tooltip or alert
        alert('Copied to clipboard!');
    });
}
</script>

<?= $this->endSection() ?>