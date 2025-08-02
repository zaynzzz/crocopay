<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactions extends Migration
{
public function up()
{
    $this->forge->addField([
        'id'              => ['type' => 'INT', 'auto_increment' => true],
        'merchant_id'     => ['type' => 'INT'],
        'order_id'        => ['type' => 'VARCHAR', 'constraint' => 100],
        'amount'          => ['type' => 'DECIMAL', 'constraint' => '12,2'],
        'status'          => ['type' => 'ENUM', 'constraint' => ['pending', 'paid', 'failed', 'expired'], 'default' => 'pending'],
        'payment_method'  => ['type' => 'VARCHAR', 'constraint' => 50],
        'provider'        => ['type' => 'VARCHAR', 'constraint' => 50],
        'created_at'      => ['type' => 'DATETIME', 'null' => true],
        'updated_at'      => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('transactions');
}

public function down()
{
    $this->forge->dropTable('transactions');
}



}
