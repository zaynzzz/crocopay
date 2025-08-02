<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AggregatorSettingsSeeder extends Seeder
{
   // app/Database/Seeds/AggregatorSettingsSeeder.php
public function run()
{
    $data = [
        ['name' => 'cronos', 'enabled' => true, 'is_primary' => true],
        ['name' => 'midtrans', 'enabled' => true, 'is_primary' => false],
    ];
    $this->db->table('aggregator_settings')->insertBatch($data);
}

}
