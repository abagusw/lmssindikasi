<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\LogModel;
use App\Libraries\MyEncrypter;
use Mailjet\Client;
use Mailjet\Resources;



class SendEmailCon extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
    }

    public function templateEmail(){
        $data = [
            'title' => 'Member Registration Detail',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),

            'session' => \Config\Services::session()
        ];
        return view('email/bg_approve', $data);
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
            $desk = "Gagal mengirim email: ".$toEmail." Subject : ".$subject." Tanggal ".date('Y-m-d H:i:s')." error : ".$email->printDebugger(['headers'])."";
        }

        $this->insertLog($desk);
    }

    public function kirimEmailApprove(){
        $encrypter = new MyEncrypter();
        $uri = service('uri');
        $id = $uri->getSegment(3);
        $getData = $this->memberModel->find($id);

        $dataGenerate = json_encode([
            'id' => $getData['id'],
            'fullname' => $getData['nama_lengkap'],
            'email'    => $getData['email'],
            'generateDate' => date('Y-m-d H:i:s'),
        ]);
        $ciphertext = $encrypter->encrypt($dataGenerate);   

        $data = [
            'title' => 'resend Email',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->memberModel->find($id),
            'ciphertext' => $ciphertext,
            'session' => \Config\Services::session()
        ];
        $vw = view('email/bg_approve', $data);
        $this->konfigEmail($getData['email'],$getData['nama_lengkap'],'Akun Anda Telah Disetujui',$vw);

        return redirect()->to('/member/user/1');   
    }

    public function kirimEmailReject(){
        $uri = service('uri');
        $id = $uri->getSegment(3);
        $getData = $this->memberModel->find($id);
        $data = [
            'title' => 'Reject Email',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->memberModel->find($id),
            'session' => \Config\Services::session()
        ];
        $vw = view('email/bg_reject', $data);
        $this->konfigEmail($getData['email'],$getData['nama_lengkap'], 'Akun Anda ditolak / direject',$vw);

        return redirect()->to('member/registration');
    }

    public function kirimEmailResetPassword(){
        $uri = service('uri');
        $id = $uri->getSegment(3);
        $getData = $this->memberModel->find($id);
        $data = [
            'title' => 'Reset Password',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->memberModel->find($id),
            'session' => \Config\Services::session()
        ];
        $vw = view('email/bg_reset_password', $data);
        $this->konfigEmail($getData['email'],$getData['nama_lengkap'],'Reset Password akun anda',$vw);

        return redirect()->to('member/user/1');    
    }



}

?>