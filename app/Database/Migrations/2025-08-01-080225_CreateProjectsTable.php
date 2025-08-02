<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'merchant_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'api_key'        => ['type' => 'VARCHAR', 'constraint' => 64],
            'api_token'      => ['type' => 'VARCHAR', 'constraint' => 64],
            'secret_key'     => ['type' => 'VARCHAR', 'constraint' => 64],
            'balance'        => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('merchant_id', 'merchants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('projects');
    }

    public function down()
    {
        $this->forge->dropTable('projects');
    }
}
