<?php

namespace App\Libraries\Disbursement;

interface DisbursementInterface
{
    public function send(array $payload): array;
}
