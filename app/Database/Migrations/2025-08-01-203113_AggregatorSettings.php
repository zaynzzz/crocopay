<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AggregatorSettings extends Migration
{
   // app/Database/Migrations/2025-08-01-aggregator_settings.php
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 50],
            'enabled' => ['type' => 'BOOLEAN', 'default' => false],
            'is_primary' => ['type' => 'BOOLEAN', 'default' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('aggregator_settings');
    }

    public function down()
    {
        //
    }
}
