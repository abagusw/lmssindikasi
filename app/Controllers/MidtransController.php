<?php

namespace App\Controllers;

use Config\Midtrans;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransController extends BaseController
{

    public function index(){
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-CK5FEFJ9eLezZhEechTlVHso';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $param = [
             'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            )
        ];

        $data = [
            'snapToken' => \Midtrans\Snap::getSnapToken($param)
        ];

        return view('payment/pay',$data);
    }

    // public function token()
    // {
    //     try {
    //         \Config\Midtrans::init();

    //         $params = [
    //             'transaction_details' => [
    //                 'order_id' => uniqid(),
    //                 'gross_amount' => 100000,
    //             ],
    //             'customer_details' => [
    //                 'first_name' => 'Budi',
    //                 'last_name' => 'Setiawan',
    //                 'email' => 'budi@example.com',
    //                 'phone' => '08111222333',
    //             ],
    //         ];

    //         $snapToken = \Midtrans\Snap::getSnapToken($params);
    //         return $this->response->setJSON(['token' => $snapToken]);

    //     } catch (\Throwable $e) {
    //         // Log dan kirim ke browser
    //         log_message('error', 'Midtrans Error: ' . $e->getMessage());
    //         return $this->response->setJSON(['error' => $e->getMessage()])->setStatusCode(500);
    //     }
    // }
}