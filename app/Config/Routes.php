<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =================== AUTH ===================
$routes->get('/', 'AuthController::login'); // root redirect ke login
$routes->get('login', 'AuthController::login');
$routes->get('auth/login', 'AuthController::login');
$routes->post('auth/doLogin', 'AuthController::doLogin');
$routes->get('logout', 'AuthController::logout');

$routes->get('register', 'AuthController::register');
$routes->post('auth/doRegister', 'AuthController::doRegister');

// =================== DASHBOARD ===================
$routes->get('dashboard', 'DashboardController::index');
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'merchantAuth']);
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']); // duplikat? pastikan hanya salah satu

// =================== TRANSACTIONS ===================
$routes->get('transactions', 'TransactionController::index');
$routes->get('/transactions', 'TransactionController::index', ['filter' => 'auth']); // duplikat?
$routes->get('transactions/create', 'TransactionController::create');
$routes->post('transactions/store', 'TransactionController::store');
$routes->get('/transactions/(:num)', 'TransactionController::detail/$1');

// =================== PROJECTS ===================
$routes->get('projects', 'ProjectsController::index');
$routes->get('/projects', 'ProjectsController::index', ['filter' => 'merchantAuth']);
$routes->get('projects/create', 'ProjectsController::create');
$routes->post('projects/store', 'ProjectsController::store');

// =================== API ===================
$routes->post('api/transaction/createQris', 'Api\TransactionController::createQris');
$routes->post('webhook/payment', 'Webhook\PaymentWebhook::index');

// =================== ADMIN ===================
// Merchant Admin
$routes->get('admin/merchant/register', 'Admin\MerchantAdminController::registerForm');
$routes->post('admin/merchant/register', 'Admin\MerchantAdminController::registerSubmit');
$routes->post('admin/merchant/create', 'Admin\MerchantAdminController::create');

// Client Admin
$routes->get('admin/client/register', 'Admin\ClientAdminController::registerForm');
$routes->post('admin/client/register-submit', 'Admin\ClientAdminController::registerSubmit');

// User Admin
$routes->get('/admin/users/create', 'Admin\UserAdminController::createForm');
$routes->post('/admin/users/create-submit', 'Admin\UserAdminController::createSubmit');

// =================== USER ===================
$routes->post('/user/register', 'UserController::register'); // jika tidak dipakai, hapus saja


$routes->post('/webhook/payment', 'WebhookController::payment');


$routes->get('/admin/aggregator', 'Admin\AggregatorSettingController::index');
$routes->post('/admin/aggregator/update', 'Admin\AggregatorSettingController::update');
$routes->get('/admin/aggregator/toggle/(:segment)', 'Admin\AggregatorSettingController::toggle/$1');

$routes->post('webhook/midtrans', 'Webhook\MidtransWebhook::index');
$routes->post('admin/aggregator/toggle/(:segment)', 'Admin\AggregatorSettingController::toggle/$1');
$routes->get('admin/aggregator/toggle/(:segment)', 'Admin\AggregatorSettingController::toggle/$1');

// Routes untuk ProjectsController
$routes->get('projects', 'ProjectsController::index');                    // List semua project
$routes->get('projects/create', 'ProjectsController::create');            // Form tambah project
$routes->post('projects/store', 'ProjectsController::store');             // Simpan project baru
$routes->get('projects/show/(:num)', 'ProjectsController::show/$1');      // Lihat detail project
$routes->get('projects/edit/(:num)', 'ProjectsController::edit/$1');      // Form edit project
$routes->post('projects/update/(:num)', 'ProjectsController::update/$1'); // Simpan hasil edit
$routes->get('projects/delete/(:num)', 'ProjectsController::delete/$1');  // Hapus project
$routes->post('projects/delete/(:num)', 'ProjectsController::delete/$1');
