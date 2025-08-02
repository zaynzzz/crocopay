<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Aggregator extends BaseConfig
{
    /**
     * Aggregator yang digunakan secara default.
     * Bisa diatur: 'cronos', 'midtrans', atau 'failover'
     */
    public string $defaultAggregator = 'failover';

    /**
     * Aktifkan / nonaktifkan aggregator tertentu.
     */
    public bool $useCronos = true;
    public bool $useMidtrans = true;
}
