<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Mailjet\Client;
use Mailjet\Resources;

class MailjetController extends Controller
{
    public function sendMailjetEmail()
    {
        $apiKey = "";
        $apiSecret = "";

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
                            'Email' => "bagusandreas13@gmail.com",
                            'Name' => "Bagus Andreas"
                        ]
                    ],
                    'Subject' => "Your Mailjet Email Subject",
                    'TextPart' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
                    'HTMLPart' => "<h3>Dear passenger, welcome to Mailjet!</h3><br />May the delivery force be with you!"
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);

        if ($response->success()) {
            echo "Email sent successfully!";
            // Optionally, log the response data
            // print_r($response->getData());
        } else {
            echo "Email sending failed!";
            // Optionally, log the error details
            // print_r($response->getData());
        }
    }
}