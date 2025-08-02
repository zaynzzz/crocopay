<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Client | CrocoPay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 bg-[url('https://www.transparenttextures.com/patterns/subtle-white-feathers.png')] p-5">
    <div class="relative bg-white rounded-xl shadow-lg max-w-md w-full p-10 border border-gray-200 overflow-hidden">
        <!-- Gradient Top Border -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-300"></div>

        <!-- Logo Header -->
        <div class="text-center mb-6">
            <div class="flex items-center justify-center mb-4 text-green-500">
                <i class="fas fa-crocodile text-3xl mr-2"></i>
                <h1 class="text-2xl font-bold">CrocoPay</h1>
            </div>
        </div>

        <!-- Form Title -->
        <h2 class="text-xl font-semibold text-gray-800 text-center mb-6 relative">
            Form Pendaftaran Client
            <span class="block w-12 h-1 bg-green-500 rounded mx-auto mt-2"></span>
        </h2>

        <!-- Error Alert -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="flex items-center justify-center bg-red-100 border border-red-200 text-red-600 rounded-lg p-3 mb-5 text-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Success Alert -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="flex items-center justify-center bg-green-100 border border-green-200 text-green-600 rounded-lg p-3 mb-5 text-sm">
                <i class="fas fa-check-circle mr-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="post" action="<?= base_url('/admin/users/create-submit') ?>">
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-green-500 text-lg"></i>
                    <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap" required
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition duration-300">
                </div>
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-green-500 text-lg"></i>
                    <input type="email" id="email" name="email" placeholder="Masukkan alamat email" required
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition duration-300">
                </div>
            </div>

            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-green-500 text-lg"></i>
                    <input type="password" id="password" name="password" placeholder="Buat password" required
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition duration-300">
                </div>
            </div>

            <button type="submit"
                    class="w-full flex items-center justify-center py-3 bg-gradient-to-r from-green-500 to-green-300 text-white rounded-lg font-semibold text-base hover:from-green-600 hover:to-green-400 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <i class="fas fa-user-plus mr-2"></i> Daftarkan Client
            </button>
        </form>
    </div>
</body>
</html>