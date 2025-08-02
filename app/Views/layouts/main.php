<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'Dashboard' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#2ecc71',
            'primary-dark': '#27ae60',
            'primary-light': '#58d68d',
            crocogreen: {
              50: '#f0fdf4',
              100: '#dcfce7',
              200: '#bbf7d0',
              300: '#86efac',
              400: '#4ade80',
              500: '#22c55e',
              600: '#16a34a',
              700: '#15803d',
              800: '#166534',
              900: '#14532d',
            }
          },
          fontFamily: {
            poppins: ['Poppins', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    body {
      font-family: 'Poppins', sans-serif;
    }
    .sidebar-link.active {
      background-color: #f0fdf4;
      color: #166534;
      border-left: 4px solid #22c55e;
    }
    .sidebar-link:hover:not(.active) {
      background-color: #f8fafc;
    }
  </style>
</head>
<body class="bg-gray-50 font-poppins">

  <!-- Navbar -->
  <header class="bg-white shadow-sm sticky top-0 z-10 border-b border-gray-200">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center space-x-2">
          <i class="fas fa-crocodile text-primary text-xl"></i>
          <h1 class="text-xl font-semibold text-gray-800">CrocoPay Merchant</h1>
        </div>
        <div class="flex items-center space-x-4">
          <div class="relative">
            <i class="fas fa-bell text-gray-500 hover:text-primary cursor-pointer"></i>
            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
          </div>
          <a href="<?= base_url('logout') ?>" class="flex items-center text-gray-600 hover:text-primary">
            <i class="fas fa-sign-out-alt mr-2"></i>
            <span>Logout</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-sm hidden md:block border-r border-gray-200">
      <div class="p-4 border-b border-gray-200 flex items-center space-x-2">
        <div class="h-10 w-10 rounded-full bg-primary-light flex items-center justify-center text-white">
          <i class="fas fa-user"></i>
        </div>
        <div>
          <p class="font-medium text-gray-800">Merchant Name</p>
          <p class="text-xs text-gray-500">Admin</p>
        </div>
      </div>
      <nav class="p-4 space-y-1">
        <a href="<?= base_url('dashboard') ?>" class="sidebar-link flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:text-primary-dark">
          <i class="fas fa-tachometer-alt mr-3 text-gray-500"></i>
          Dashboard
        </a>
        <a href="<?= base_url('projects') ?>" class="sidebar-link flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:text-primary-dark">
          <i class="fas fa-project-diagram mr-3 text-gray-500"></i>
          Projects
        </a>
        <a href="<?= base_url('transactions') ?>" class="sidebar-link flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:text-primary-dark">
          <i class="fas fa-exchange-alt mr-3 text-gray-500"></i>
          Transactions
        </a>
        <a href="<?= base_url('settings') ?>" class="sidebar-link flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:text-primary-dark">
          <i class="fas fa-cog mr-3 text-gray-500"></i>
          Settings
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <?= $this->renderSection('content') ?>
      </div>
    </main>
  </div>

</body>
</html>