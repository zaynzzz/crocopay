<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =================== AUTH ===================
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->get('auth/login', 'AuthController::login');
$routes->post('auth/doLogin', 'AuthController::doLogin');
$routes->get('logout', 'AuthController::logout');

$routes->get('register', 'AuthController::register');
$routes->post('auth/doRegister', 'AuthController::doRegister');

// =================== DASHBOARD ===================
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('dashboard', 'DashboardController::index');
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'merchantAuth']);
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']); // duplikat? pastikan hanya salah satu
// =================== TRANSACTIONS ===================
$routes->get('transactions', 'TransactionController::index', ['filter' => 'auth']);
$routes->get('transactions/create', 'TransactionController::create');
$routes->post('transactions/store', 'TransactionController::store');
$routes->get('transactions/(:num)', 'TransactionController::detail/$1');

// =================== PROJECTS ===================
$routes->get('projects', 'ProjectsController::index', ['filter' => 'merchantAuth']);
$routes->get('projects/create', 'ProjectsController::create');
$routes->post('projects/store', 'ProjectsController::store');
$routes->get('projects/show/(:num)', 'ProjectsController::show/$1');
$routes->get('projects/edit/(:num)', 'ProjectsController::edit/$1');
$routes->post('projects/update/(:num)', 'ProjectsController::update/$1');
$routes->match(['get', 'post'], 'projects/delete/(:num)', 'ProjectsController::delete/$1');

// =================== API ===================
$routes->post('api/transaction/createQris', 'Api\TransactionController::createQris');
$routes->post('api/transaction/createDisburse', 'TransactionController::createDisbursement');

// =================== WEBHOOK ===================
$routes->post('webhook/payment', 'WebhookController::payment');
$routes->post('webhook/midtrans', 'Webhook\MidtransWebhook::index');

// =================== ADMIN ===================

// ---- Merchant Admin
$routes->get('admin/merchant/register', 'Admin\MerchantAdminController::registerForm');
$routes->post('admin/merchant/register', 'Admin\MerchantAdminController::registerSubmit');
$routes->post('admin/merchant/create', 'Admin\MerchantAdminController::create');

// ---- Client Admin
$routes->get('admin/client/register', 'Admin\ClientAdminController::registerForm');
$routes->post('admin/client/register-submit', 'Admin\ClientAdminController::registerSubmit');

// ---- User Admin
$routes->get('admin/users/create', 'Admin\UserAdminController::createForm');
$routes->post('admin/users/create-submit', 'Admin\UserAdminController::createSubmit');

// ---- Aggregator Settings
$routes->group('admin/aggregator', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // QRIS
    $routes->get('qris', 'AggregatorSettingController::index');
    $routes->post('qris/update', 'AggregatorSettingController::update');
    $routes->post('qris/toggle/(:segment)', 'AggregatorSettingController::toggle/$1');

    // Disbursement
    $routes->get('disbursement', 'AggregatorSettingController::disbursement');
    $routes->post('disbursement/update', 'AggregatorSettingController::updateDisbursement');
    $routes->post('disbursement/toggle/(:segment)', 'AggregatorSettingController::toggleDisbursement/$1');
});


// =================== USER ===================
$routes->post('user/register', 'UserController::register');

// =================== ALIAS REDIRECTS ===================
// Optional alias if user tries to access these directly
$routes->get('admin/disbursement', function () {
    return redirect()->to('/admin/aggregator/disbursement');
});
$routes->get('admin/qris', function () {
    return redirect()->to('/admin/aggregator/qris');
});
