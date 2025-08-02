<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMerchants extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => ['type' => 'INT', 'auto_increment' => true],
        'name' => ['type' => 'VARCHAR', 'constraint' => 100],
        'email' => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
        'password' => ['type' => 'VARCHAR', 'constraint' => 255],
        'api_key' => ['type' => 'VARCHAR', 'constraint' => 255],
        'created_at' => ['type' => 'DATETIME', 'null' => true],
        'updated_at' => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('merchants');
}



    public function down()
    {
        //
    }
}
