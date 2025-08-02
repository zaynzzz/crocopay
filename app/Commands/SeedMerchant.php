<?php
namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SeedMerchant extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'seed:merchant';
    protected $description = 'Seed satu data merchant ke database';

    public function run(array $params)
    {
        $pass = password_hash('123456', PASSWORD_DEFAULT);
        $db = \Config\Database::connect();
        $builder = $db->table('merchants');

        $builder->insert([
            'name' => 'Merchant Test',
            'email' => 'merchant@test.com',
            'password' => $pass,
            'api_key' => bin2hex(random_bytes(16)),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        CLI::write('✅ Merchant test berhasil dibuat.', 'green');
    }
}
