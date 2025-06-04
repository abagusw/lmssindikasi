<?php

namespace App\Libraries;

use Config\Services;

class SendEmail
{
    protected $memberModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->memberModel = new \App\Models\MemberModel();
        $this->userModel   = new \App\Models\UserModel();
        $this->logModel   = new \App\Models\LogModel();
        $this->session     = Services::session();
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

    public function kirimEmailApprove($id){
        // $uri = service('uri');
        // $id = $uri->getSegment(3);
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

    public function kirimEmailReject($id){
        // $uri = service('uri');
        // $id = $uri->getSegment(3);
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

    public function insertLog($desk){
            $dataLog = [
                'description'   => $desk,
                'create_date'   => date('Y-m-d H:i:s'),
                'create_user'   => $this->session->get('nama')
            ];

            $this->logModel->insert($dataLog);

            // if ($logModel->insert($dataLog)) {
            //     //echo json_encode(array('msg'=>0,'desc'=>"Sukses Insert Data"));
            // }
    }
}