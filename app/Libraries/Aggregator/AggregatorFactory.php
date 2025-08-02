<?php

namespace App\Libraries\Aggregator;

use App\Models\AggregatorSettingModel;

class AggregatorFactory
{
    public static function create(array $project): BaseAggregator
    {
        $aggregatorModel = new AggregatorSettingModel();

        // Ambil aggregator yang ENABLED dan PRIMARY
        $active = $aggregatorModel
            ->where('enabled', 1)
            ->where('is_primary', 1)
            ->first();

        if (!$active) {
            throw new \Exception('Tidak ada aggregator yang aktif dan diset sebagai primary.');
        }

        $name = strtolower($active['name']);

        return match ($name) {
            'cronos' => new CronosService($project),
            'midtrans' => new MidtransService($project),
            default => throw new \Exception("Aggregator {$name} tidak dikenali."),
        };
    }
}
