<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateTransactionProjectId extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Ambil semua transaksi yang belum punya project_id
        $transactions = $db->table('transactions')
            ->where('project_id IS NULL', null, false)
            ->get()
            ->getResultArray();

        foreach ($transactions as $transaction) {
            // Asumsikan transaksi punya kolom api_key
            $apiKey = $transaction['api_key'] ?? null;

            if (!$apiKey) {
                continue;
            }

            // Cari project yang cocok
            $project = $db->table('projects')
                ->where('api_key', $apiKey)
                ->get()
                ->getRowArray();

            if ($project) {
                $db->table('transactions')
                    ->where('id', $transaction['id'])
                    ->update(['project_id' => $project['id']]);
            }
        }

        echo "Done updating project_id for transactions.\n";
    }
}
