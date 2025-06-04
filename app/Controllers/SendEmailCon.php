<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\LogModel;
use CodeIgniter\Email\Email;

class SendEmailCon extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
    }

    public function testEmail()
    {
        $email = \Config\Services::email();

        $email->setTo('devandaandresmg@gmail.com');
        $email->setSubject('Tes Email SMTP');
        $email->setMessage('<p>Ini adalah email <strong>tes</strong> menggunakan SMTP.</p>');
        $email->setMailType('html'); // wajib kalau isinya HTML

        if ($email->send()) {
            echo 'Email berhasil dikirim!';
        } else {
            echo 'Gagal mengirim email:<br>';
            print_r($email->printDebugger(['headers']));
        }
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

            // if ($logModel->insert($dataLog)) {
            //     //echo json_encode(array('msg'=>0,'desc'=>"Sukses Insert Data"));
            // }
    }

    public function konfigEmail($to,$subject,$view)
    {
        $email = \Config\Services::email();

        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($view);
        $email->setMailType('html'); // wajib kalau isinya HTML

        if ($email->send()) {
            //echo 'Email berhasil dikirim!';
            $desk = "Email berhasil dikirim ke : ".$to." Subject : ".$subject." Tanggal ".date('Y-m-d H:i:s')."";
        } else {
            $desk = "Gagal mengirim email: ".$to." Subject : ".$subject." Tanggal ".date('Y-m-d H:i:s')." error : ".$email->printDebugger(['headers'])."";
        }

        $this->insertLog($desk);


        // if ($email->send()) {
        //     echo 'Email berhasil dikirim!';
        // } else {
        //     echo 'Gagal mengirim email:<br>';
        //     print_r($email->printDebugger(['headers']));
        // }
    }

    public function kirimEmailApprove(){
        $uri = service('uri');
        $id = $uri->getSegment(3);
        $getData = $this->memberModel->find($id);
        $data = [
            'title' => 'resend Email',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->memberModel->find($id),
            'session' => \Config\Services::session()
        ];
        $vw = view('email/bg_approve', $data);
        $this->konfigEmail($getData['email'],'Akun Anda Telah Disetujui',$vw);

        return redirect()->to('/member/1');

        //print_r($getData)

        //return view('email/bg_approve', $data);        
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
        $this->konfigEmail($getData['email'],'Akun Anda ditolak / direject',$vw);

        return redirect()->to('/member/0');

        //print_r($getData)

        //return view('email/bg_approve', $data);        
    }



}

?>