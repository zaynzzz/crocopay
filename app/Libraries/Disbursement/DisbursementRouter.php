<?php

namespace App\Libraries\Disbursement;

use CodeIgniter\Database\BaseConnection;

class DisbursementRouter
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getChannels(?string $merchantId = null, ?string $projectId = null): array
    {
        // Get disbursement aggregator marked as primary
        $primary = $this->db->table('aggregator_settings')
            ->where('type', 'disbursement')
            ->where('is_primary', 1)
            ->where('enabled', 1)
            ->get()
            ->getRowArray();

        if ($primary) {
            return [
                'primary' => $primary['name'],
                'fallback' => null
            ];
        }

        return [
            'primary' => null,
            'fallback' => null
        ];
    }
}
