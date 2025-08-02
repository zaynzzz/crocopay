<?php

namespace App\Libraries\Aggregator;

use Config\Aggregator as AggregatorConfig;
use Exception;

class FailoverAggregator
{
    protected $project;
    protected $aggregators = [];

    public function __construct(array $project)
    {
        $this->project = $project;
        $config = new AggregatorConfig();

        // Mode default langsung satu aggregator saja
        if ($config->defaultAggregator === 'cronos' && $config->useCronos) {
            $this->aggregators = [new CronosService($project)];
        } elseif ($config->defaultAggregator === 'midtrans' && $config->useMidtrans) {
            $this->aggregators = [new MidtransService($project)];
        } else {
            // Failover: Cronos dulu, kalau gagal, Midtrans
            if ($config->useCronos) {
                $this->aggregators[] = new CronosService($project);
            }
            if ($config->useMidtrans) {
                $this->aggregators[] = new MidtransService($project);
            }
        }
    }

    public function createQris(string $orderId, float $amount, string $invoiceId): array
    {
        foreach ($this->aggregators as $aggregator) {
            try {
                $response = $aggregator->createQris($orderId, $amount, $invoiceId);
                $response['provider'] = get_class($aggregator) === CronosService::class ? 'cronos' : 'midtrans';
                return $response;
            } catch (\Throwable $e) {
                log_message('error', get_class($aggregator) . ' failed: ' . $e->getMessage());
                continue;
            }
        }

        throw new Exception('Semua aggregator gagal memproses QRIS');
    }
}
