<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Create New Project</h2>
        <p class="text-gray-600">Set up a new project to start integrating with CrocoPay</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="post" action="/projects/store">
            <!-- Form Group -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Project Name
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 transition"
                    placeholder="e.g. My E-commerce Website">
                <p class="mt-1 text-sm text-gray-500">This will help you identify your project in the dashboard</p>
            </div>

            <!-- Advanced Options (Collapsible) -->
            <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden">
                <button type="button" onclick="toggleAdvanced()"
                    class="w-full flex justify-between items-center p-4 text-left text-gray-700 hover:bg-gray-50 transition">
                    <span class="font-medium">Advanced Options</span>
                    <i id="advanced-arrow" class="fas fa-chevron-down transition-transform"></i>
                </button>
                <div id="advanced-options" class="hidden px-4 pb-4 space-y-4">
                    <div>
                        <label for="webhook_url" class="block text-sm font-medium text-gray-700 mb-2">
                            Webhook URL
                        </label>
                        <input type="url" id="webhook_url" name="webhook_url"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400"
                            placeholder="https://example.com/webhook">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400"
                            placeholder="Optional project description"></textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="/projects" 
                    class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-center transition">
                    Cancel
                </a>
                <button type="submit"
                    class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg shadow-sm transition-colors">
                    <i class="fas fa-save"></i>
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleAdvanced() {
    const options = document.getElementById('advanced-options');
    const arrow = document.getElementById('advanced-arrow');
    options.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');
}
</script>

<?= $this->endSection() ?>