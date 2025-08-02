<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRefIdsToTransactions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transactions', [
            'aggregator_ref_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'order_id'
            ],
            'reff_id' => [ // Crocopay internal reference
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'after'      => 'aggregator_ref_id'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', ['aggregator_ref_id', 'reff_id']);
    }
}
