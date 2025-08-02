<?php
namespace App\Libraries;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransSnap
{
    public function __construct()
    {
        Config::$serverKey = 'Mid-server-35hryOFey-lmqJkzEnPuPETC';
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function create($params)
    {
        return Snap::createTransaction($params);
    }
}
