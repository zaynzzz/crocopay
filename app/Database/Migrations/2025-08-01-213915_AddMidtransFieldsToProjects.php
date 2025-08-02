<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMidtransFieldsToProjects extends Migration
{
    public function up()
{
    $this->forge->addColumn('projects', [
        'midtrans_merchant_id' => [
            'type' => 'VARCHAR',
            'constraint' => 64,
            'null' => true,
            'after' => 'secret_key',
        ],
        'midtrans_client_key' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => true,
        ],
        'midtrans_server_key' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => true,
        ],
    ]);
}

public function down()
{
    $this->forge->dropColumn('projects', [
        'midtrans_merchant_id',
        'midtrans_client_key',
        'midtrans_server_key',
    ]);
}

}
