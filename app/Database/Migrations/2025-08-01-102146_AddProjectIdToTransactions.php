<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProjectIdToTransactions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transactions', [
            'project_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id', // atau sesuaikan dengan posisi yang diinginkan
            ],
        ]);

        // Optional: tambahkan foreign key
        $this->db->query('ALTER TABLE transactions ADD CONSTRAINT fk_project_transaction FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL');
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', 'project_id');
    }
}
