<?php

namespace Config;

use Midtrans\Config as MidtransConfig;

class Midtrans
{
    public static function init()
    {
        MidtransConfig::$serverKey = 'SB-Mid-server-CK5FEFJ9eLezZhEechTlVHso';
        MidtransConfig::$clientKey = 'SB-Mid-client-Tub-Ws0lTTNJ5LCa';
        MidtransConfig::$isProduction = false; // true jika live
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;
    }
}