<?php

namespace App\Controllers;

use \Mailjet\Resources;

class MailjetMailController extends BaseController
{
    protected $mailjet;

    public function __construct()
    {
        $apiKey = getenv('mailjet.apiKey');
        $apiSecret = getenv('mailjet.apiSecret');

        $this->mailjet = new \Mailjet\Client($apiKey, $apiSecret, true, ['version' => 'v3.1']);
    }

    public function sendEmail($toEmail, $toName, $subject, $htmlContent, $textContent)
    {
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => getenv('mailjet.senderEmail'),
                        'Name' => getenv('mailjet.senderName')
                    ],
                    'To' => [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName
                        ]
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => $htmlContent,
                    'TextPart' => $textContent
                ]
            ]
        ];

        $response = $this->mailjet->post(Resources::$Email, ['body' => $body]);

        if ($response->success()) {
            return true;
        } else {
            return false;
        }
    }

    public function testSendEmailByMailjet()
    {
        $toEmail = 'bagusandreas13@gmail.com';
        $toName = 'Bagus Andreas';
        $subject = 'Test Email from Mailjet';
        $htmlContent = '<h3>This is a test email sent using Mailjet API</h3><p>Hello, this is a sample email body in HTML format.</p>';
        $textContent = 'This is a test email sent using Mailjet API. Hello, this is a sample email body in plain text format.';
        $sendMail = $this->sendEmail($toEmail, $toName, $subject, $htmlContent, $textContent);
        if ($sendMail) {
            echo 'Email sent successfully via Mailjet!';
        } else {
            echo 'Failed to send email via Mailjet.';
        }
    }
}