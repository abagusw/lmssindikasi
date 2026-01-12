<?php

namespace App\Controllers;

use App\Models\PaymentNotificationModel;
use App\Models\MemberModel;
use App\Models\LogModel;
use Mailjet\Client;
use Mailjet\Resources;

/**
 * Email Notification Controller
 * Handles sending email notifications related to payments and member activities.
 * This controller will run as a scheduled task or cron job to ensure timely notifications.
 */
class EmailNotif extends BaseController
{
    public function __construct()
    {
        $this->paymentNotificationModel = new PaymentNotificationModel();
        $this->memberModel = new MemberModel();
    }

    public function index()
    {
        date_default_timezone_set("Asia/Jakarta");
        
        // Fetch first notifications that need to be sent
        $firstNotifyPayment = $this->paymentNotificationModel->getFirstNotification();
        // Insert first notifications into the notification table
        $firstNotifyData = array_map(function($item) {
            return [
                'payment_success_id' => $item['id'],
                'notification_type' => 1
            ];
        }, $firstNotifyPayment);
        if (!empty($firstNotifyData))
        {
            $this->paymentNotificationModel->insertBatch($firstNotifyData);
            $this->bulkSendEmail($firstNotifyPayment);
        }

        // Fetch second notifications that need to be sent
        $secondNotifyPayment = $this->paymentNotificationModel->getSecondNotification();
        // Insert second notifications into the notification table
        $secondNotifyData = array_map(function($item) {
            return [
                'payment_success_id' => $item['id'],
                'notification_type' => 2
            ];
        }, $secondNotifyPayment);
        if (!empty($secondNotifyData))
        {
            $this->paymentNotificationModel->insertBatch($secondNotifyData);
            $this->bulkSendEmail($secondNotifyPayment);
        }
        
        // Fetch third notifications that need to be sent
        $thirdNotifyPayment = $this->paymentNotificationModel->getThirdNotification();
        // Insert third notifications into the notification table
        $thirdNotifyData = array_map(function($item) {
            return [
                'payment_success_id' => $item['id'],
                'notification_type' => 3
            ];
        }, $thirdNotifyPayment);
        if (!empty($thirdNotifyData))
        {
            $this->paymentNotificationModel->insertBatch($thirdNotifyData);
            $this->bulkSendEmail($thirdNotifyPayment);
        }

        // Fetch final notifications that need to be sent
        $finalNotifyPayment = $this->paymentNotificationModel->getFinalNotification();
        // Insert final notifications into the notification table
        $finalNotifyData = array_map(function($item) {
            return [
                'payment_success_id' => $item['id'],
                'notification_type' => 4
            ];
        }, $finalNotifyPayment);
        if (!empty($finalNotifyData))
        {
            $this->paymentNotificationModel->insertBatch($finalNotifyData);
            $this->bulkSendEmail($finalNotifyPayment);
        }

        $response_data = [
            'firstNotifyPayment' => $firstNotifyPayment,
            'secondNotifyPayment' => $secondNotifyPayment,
            'thirdNotifyPayment' => $thirdNotifyPayment,
            'finalNotifyPayment' => $finalNotifyPayment,
            'message' => 'Notification emails processed.'
        ];
        return json_encode($response_data);
    }

    public function bulkSendEmail($notificationData)
    {
        foreach ($notificationData as $notify) {
            $this->sendEmailNotification(
                $notify['email_member'],
                $notify['nama_lengkap'],
                $notify['expired_date']
            );
        }
    }

    public function insertLog($desk){
        $logModel = new LogModel();
        $dataLog = [
            'description'   => $desk,
            'create_date'   => date('Y-m-d H:i:s'),
            'create_user'   => $this->session->get('nama')
        ];

        $logModel->insert($dataLog);
    }

    public function konfigEmail($toEmail,$toName,$subject,$view)
    {
        $apiKey = "ef002126f3ce08d048586f718b4cddd0";
        $apiSecret = "5bdfc6bd0cd33414c685c94b6c98567a";

        $mj = new Client($apiKey, $apiSecret, true, ['version' => 'v3.1']);
        
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "tech@sindikasi.org",
                        'Name' => "Admin Sindikasi"
                    ],
                    'To' => [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName
                        ]
                    ],
                    'Subject' => $subject,
                    'TextPart' => "Hi, Sindikasi Member",
                    'HTMLPart' => $view
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);

        if ($response->success()) {
            $desk = "Email berhasil dikirim ke : ".$toEmail." Subject : ".$subject." Tanggal ".date('Y-m-d H:i:s')."";
        } else {
            $desk = "Gagal mengirim email: ".$toEmail." Subject : ".$subject." Tanggal ".date('Y-m-d H:i:s')." error : ".json_encode($mj)."";
        }

        $this->insertLog($desk);
    }

    public function sendEmailNotification($email_member, $nama_lengkap, $expired_date)
    {
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'expired_date' => date('d-m-Y H:i', strtotime($expired_date))
        ];
        $vw = view('email/bg_email_payment_notification', $data);
        $this->konfigEmail($email_member,$nama_lengkap,'Iuran Membership Sindikasi',$vw);

    }

    function seeEmail(){
        $data = [
            'nama_lengkap' => 'Test Nama',
            'expired_date' => date('d-m-Y H:i', strtotime('2024-12-31 23:59:59'))
        ];
        echo view('email/bg_email_payment_notification', $data);
    }

}
