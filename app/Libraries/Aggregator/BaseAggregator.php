<?php

namespace App\Libraries\Aggregator;

abstract class BaseAggregator
{
    protected $project;

    public function __construct(array $project)
    {
        $this->project = $project;
    }

    abstract public function createTransaction(string $orderId, int $amount, string $description): array;
}
