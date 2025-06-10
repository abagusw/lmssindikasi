<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\LogModel;
use App\Models\PaymentModel;
use CodeIgniter\Email\Email;
use App\Controllers\SendEmailCon;
use App\Libraries\SendEmail;

class Member extends BaseController
{
    protected $userModel;
    protected $memberModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
        $this->paymentModel = new PaymentModel();
    }

    public function index()
    {
        $uri = service('uri');
        $flag = $uri->getSegment(2);
        if($flag == 0){
            $tit = "Member Registration";
        }else{
            $tit = "Member User";
        }
        $data = [
            'title' => $tit,
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'memberActive' => $this->memberModel->countMemberUserByFlag(1),
            'memberAll' => $this->memberModel->countMemberAll(),
            'getData' => $this->memberModel->where('flag', '1')->findAll(),
        ];

        return view('member/bg_index', $data);
    }

    public function indexReg(){
        log_message('debug', 'Route /admin matched');

        $uri = service('uri');
        $flag = $uri->getSegment(2);

        $data = [
            'title' => 'Member Registration',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'memberActive' => $this->memberModel->countMemberUserByFlag(1),
            'memberAll' => $this->memberModel->countMemberAll(),
            'getData' => $this->memberModel->where('flag', '1')->findAll(),
        ];

        return view('member/bg_reg', $data);        
    }

    public function getDataMember(){
                $uri = service('uri');
                $flag = $uri->getSegment(3);

                // print_r("disini");
                // die;
               //$list = $this->User_model->get_datatables();
                $memberModel = new MemberModel();
                $list = $memberModel->getDatatables($flag);
                $data = array();
                $no = $_POST['start'];
                foreach ($list as $field) {
                        $no++;
                        $row = array();
                        $row[] = $no;
                        $row[] = $field->nama_lengkap;
                        $row[] = $field->email;
                        $row[] = $field->domisili;
                        $row[] = $field->profesi;
                        $row[] = $field->approval_date;
                        $row[] = $field->updated_at;
                        if($field->flag_active == 0){
                            $st = "<span class='badge rounded-pill text-bg-secondary'>Pending</span>";
                        }elseif($field->flag_active == 1){
                            $st = "<span class='badge rounded-pill text-bg-primary'>Active</span>";
                        }else{
                            $st = "<span class='badge rounded-pill text-bg-danger'>Deactivated</span>";
                        }

                        if($field->flag_active == 0){
                            $btnResend = "<a href=".base_url("email/kirimEmailApprove/".$field->id."")." class='btn btn-link mb-2'>Resend</a>";
                        }else{
                            $btnResend = "";
                        }

                        if($field->flag_active == 0){
                            $drBtn = "<li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(".$field->id.",".$field->flag_active.") class='dropdown-item'>Resend Activation</a></li>";
                        }elseif($field->flag_active == 1){
                            $drBtn = "<li><a href='".base_url("member/member_user_detail/".$field->id."")."?payment_history=true' class='dropdown-item'><i class='bi bi-clock'></i>Payment History</a></li>
                                <li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalResetPassword' onclick=confirmResetPassword(".$field->id.") class='dropdown-item'><i class='bi bi-clock'></i>Reset Password</a></li>
                                <li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(".$field->id.",".$field->flag_active.") class='dropdown-item'><i class='bi bi-clock'></i>Deactivate</a></li>
                            ";
                        }else{
                            $drBtn = "<li><a href='".base_url("member/member_user_detail/".$field->id."")."?payment_history=true' class='dropdown-item'><i class='bi bi-clock'></i>Payment History</a></li>
                                <li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(".$field->id.",".$field->flag_active.")  class='dropdown-item'><i class='bi bi-clock'></i>Reactive</a></li>
                            ";
                        }
                        $row[] = $st;
                        // $row[] = "<a href=".base_url("member/member_detail/".$field->id."")." class='btn btn-link mb-2'>View</a>
                        // ".$btnResend."";
                        $row[] = "<div class='d-flex gap-2 mb-3'>
                                    <a href='".base_url("member/member_user_detail/".$field->id."")."' class='btn btn-outline-secondary btn-hover-outline'>
                                      <i class='bi bi-eye'></i>
                                    </a>

                                    <!-- Dropdown tombol titik tiga -->
                                    <div class='dropdown'>
                                      <a class='btn btn-outline-secondary btn-hover-outline' data-bs-toggle='dropdown' aria-expanded='false'>
                                        <i class='bi bi-three-dots-vertical'></i>
                                      </a>
                                      <ul class='dropdown-menu'>
                                        ".$drBtn."
                                      </ul>
                                    </div>
                                </div>";
                        $data[] = $row;
                }
 
                $output = array(
                        'draw' => intval($this->request->getPost('draw')),
                        'recordsTotal' => $memberModel->countAll(),
                        'recordsFiltered' => $memberModel->countFiltered($flag),
                        "data" => $data,
                );

               // return $output;
                //output dalam format JSON
                echo json_encode($output);
    }

    public function getDataMemberReg(){
                //$uri = service('uri');
                $flag = 0;

                // print_r("disini");
                // die;
               //$list = $this->User_model->get_datatables();
                $memberModel = new MemberModel();
                $list = $memberModel->getDatatables($flag);
                $data = array();
                $no = $_POST['start'];
                foreach ($list as $field) {
                        $no++;
                        $row = array();
                        $row[] = $no;
                        $row[] = $field->nama_lengkap;
                        $row[] = $field->email;
                        $row[] = $field->domisili;
                        $row[] = $field->profesi;
                        $row[] = $field->create_at;
                        if($field->flag == 0){
                            $st = "<span class='badge rounded-pill text-bg-secondary'>Pending</span>";
                            $btnAppr = "<a href='#!' onclick='ubahStatus(1,".$field->id.")' class='btn btn-link mb-2'>Approve</a>
                            <a href='#!' onclick='ubahStatus(2,".$field->id.")' class='btn btn-link mb-2'>Reject</a>";
                        }elseif($field->flag == 1){
                            $st = "<span class='badge rounded-pill text-bg-success'>Approved</span>";
                            $btnAppr = "";
                        }else{
                            $st = "<span class='badge rounded-pill text-bg-danger'>Rejected</span>";
                            //$btnAppr = "<a type='a' class='btn btn-link mb-2'>Approve</a>";
                            $btnAppr = "";
                        }

                        // if($field->flag == 1){
                        //     $btnResend = "<a href=".base_url("email/kirimEmailApprove/".$field->id."")." class='btn btn-link mb-2'>Resend</a>";
                        // }else{
                        //     $btnResend = "";
                        // }
                        $btnResend = "";
                        $row[] = $st;
                        $row[] = "<a href=".base_url("member/member_detail/".$field->id."")." class='btn btn-link mb-2'>View</a>
                        ".$btnAppr." ".$btnResend."";
                        $data[] = $row;
                }
 
                $output = array(
                        'draw' => intval($this->request->getPost('draw')),
                        'recordsTotal' => $memberModel->countAll(),
                        'recordsFiltered' => $memberModel->countFiltered($flag),
                        "data" => $data,
                );

               // return $output;
                //output dalam format JSON
                echo json_encode($output);
    }        


    public function getDataMemberDetail(){
        $uri = service('uri');
        $flag = $uri->getSegment(3);
        $data = [
            'title' => 'Member Registration Detail',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),

            'getData' => $this->memberModel->find($flag),
            'session' => \Config\Services::session()
        ];
        return view('member/bg_detail', $data);
    }


    public function getDataUserDetail(){
        $uri = service('uri');
        $flag = $uri->getSegment(3);
        $paymentHistory = $this->request->getGet('payment_history');
        $data = [
            'title' => 'Member User Detail',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),

            'getData' => $this->memberModel->find($flag),
            'session' => \Config\Services::session(),
            'paymentHistory' => $paymentHistory
        ];
        return view('member/bg_detail_user', $data);
    }

    public function ubahStatus(){
        $flag = $this->request->getPost('flag');
        $id = $this->request->getPost('id');
        $sendEmail = new SendEmail();

        if($flag == 1){
            $dtApr = date('Y-m-d H:i:s');
            $desk = "".$this->session->get('nama')." sukses mengapprove data member ID : ".$id." tanggal : ".date('Y-m-d H:i:s')."";
            $url = base_url("email/kirimEmailApprove/".$id."");
            //$sendEmail->kirimEmailApprove($id);
        }else{
            $dtApr = "";
            $desk = "".$this->session->get('nama')." sukses mereject data member ID : ".$id." tanggal : ".date('Y-m-d H:i:s')."";
            $url = base_url("email/kirimEmailReject/".$id."");
            //$sendEmail->kirimEmailReject($id);
        }

        


        $memberModel = new MemberModel();

        $data = [
            'flag'   => $flag,
            'approval_date'  => $dtApr,
        ];

        // Lakukan update berdasarkan ID
        $update = $memberModel->update($id, $data);


        if($update){
            
            $jsonResp =  json_encode(array('msg'=>0,'desc'=>"Sukses Update Data"));


        }else{
            $jsonResp =  json_encode(array('msg'=>1,'desc'=>"Gagal Update Data"));

        }

        $this->sendAsyncRequest($url);



        $desk = $desk. $jsonResp;




        // if($flag == 1){
        //     redirect()->to("email/kirimEmailApprove/".$id."");
        // }else{
        //     redirect()->to("email/kirimEmailReject/".$id."");
        // }


        $this->getLog($desk);

    }


    public function getLog($desk){
            $logModel = new LogModel();
            $dataLog = [
                'description'   => $desk,
                'create_date'   => date('Y-m-d H:i:s'),
                'create_user'   => $this->session->get('nama')
            ];

            if ($logModel->insert($dataLog)) {
                echo json_encode(array('msg'=>0,'desc'=>"Sukses Insert Data"));
            }
    }

    public function kirimEmail(){
        $url = $this->request->getPost('url');
        $id = $this->request->getPost('id');

        $this->sendAsyncRequest($url);
    }

    public function sendAsyncRequestX($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1); // quick timeout
        curl_exec($ch);
        curl_close($ch);
    }

    private function sendAsyncRequest($url)
    {

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => false,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 1,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Cookie: ci_session=d2a85455fb30a393a0468e1279bd453c'
              ),
            ));

            //$response = curl_exec($curl);
            curl_exec($curl);
            curl_close($curl);
            //echo $response;
            //$this->getLog($response);
    }

    public function confirmStatusData(){
        $id = $this->request->getPost('id');
        $getData = $this->memberModel->find($id);
        //$flag = $this->request->getPost('flag');
        if($getData['flag_active'] == 0){
            $message = "<p>Are you sure you want to resend the activation link to this user?</p><p class='fw-semibold'>They will receive a new email with instructions to activate their account.</p>";
            $url = "'".base_url('email/kirimEmailApprove/'.$getData['id'])."\"'";

        
        }elseif($getData['flag_active'] == 1){
            $message = "<p>Are you sure you want to deactivate this users account?</p><p class='fw-semibold'>The user will no longer be able to access the system until reactivated</p>";
            $url = "'".base_url("email/kirimEmailReject/".$getData['id'])."\"'";

        }else{
            $message = "<p>Are you sure you want to reactive this users account?</p><p class='fw-semibold'>They will regain access to the system immediately after activation</p>";
            $url = "";
        }


        $contentNama = "<div class='form-group mt-3'>
                <label class='form-label text-muted' for='userName'>Nama</label>
                <div class='form-control bg-light' id='userName'>".$getData['nama_lengkap']."</div>
              </div>";



        echo json_encode(array('msg'=>$message.$contentNama,'url'=>$url));

    }

    public function confirmResetPassword(){
        $id = $this->request->getPost('id');
        $getData = $this->memberModel->find($id);

        echo json_encode(array('msg'=>$getData['nama_lengkap']));

    }

    public function getpaymentDetailUser(){
        // print_r("disini");
        // die;
       //$list = $this->User_model->get_datatables();
        $paymentModel = new PaymentModel();
        $list = $paymentModel->getDatatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
                $no++;
                $row = array();
                $row[] = $field->type;
                $row[] = $field->amount;
                $row[] = $field->method;
                if($field->status == 0){
                    $st = "<span class='badge rounded-pill text-bg-secondary'>Pending</span>";
                }else{
                    $st = "<span class='badge rounded-pill text-bg-primary'>Paid</span>";
                }
                $row[] = $st;
                $row[] = $field->created_at;
                $row[] = "<div class='icon-container'><a href='#' class='icon-link'><i class='fa-solid fa-file-lines'></i></a>
    <a href='#' class='icon-link'><i class='fa-regular fa-file-lines'></i></a>
    <a href='#' class='icon-link'><i class='fa-solid fa-hand-holding-dollar'></i></a></div>";
                $data[] = $row;
        }

        $output = array(
                'draw' => intval($this->request->getPost('draw')),
                'recordsTotal' => $paymentModel->countAll(),
                'recordsFiltered' => $paymentModel->countFiltered(),
                "data" => $data,
        );

       // return $output;
        //output dalam format JSON
        echo json_encode($output);
    }

    public function ubahStatusDataUser(){
        $flag = $this->request->getPost('flag');
        $id = $this->request->getPost('id');
        $sendEmail = new SendEmail();

        if($flag == 1){
            $dtApr = date('Y-m-d H:i:s');
            $desk = "".$this->session->get('nama')." sukses mengapprove data member user ID : ".$id." tanggal : ".date('Y-m-d H:i:s')."";
            //$url = base_url("email/kirimEmailApprove/".$id."");
            //$sendEmail->kirimEmailApprove($id);
        }else{
            $dtApr = "";
            $desk = "".$this->session->get('nama')." sukses mereject data member user ID : ".$id." tanggal : ".date('Y-m-d H:i:s')."";
            //$url = base_url("email/kirimEmailReject/".$id."");
            //$sendEmail->kirimEmailReject($id);
        }

        


        $memberModel = new MemberModel();

        $data = [
            'flag_active'   => $flag,
            'approval_date'  => $dtApr,
        ];

        // Lakukan update berdasarkan ID
        $update = $memberModel->update($id, $data);


        if($update){
            
            $jsonResp =  json_encode(array('msg'=>0,'desc'=>"Sukses Update Data"));


        }else{
            $jsonResp =  json_encode(array('msg'=>1,'desc'=>"Gagal Update Data"));

        }

        //$this->sendAsyncRequest($url);



        $desk = $desk. $jsonResp;




        // if($flag == 1){
        //     redirect()->to("email/kirimEmailApprove/".$id."");
        // }else{
        //     redirect()->to("email/kirimEmailReject/".$id."");
        // }


        $this->getLog($desk);
    }

    public function resetPassword(){
        $id = $this->request->getPost('id');

         $url = base_url("email/kirimEmailResetPassword/".$id."");
        //         print_r($url);
        // die;
        $this->sendAsyncRequest($url);

        $desk =  json_encode(array('msg'=>0,'desc'=>"Sukses Reset Password"));

        $this->getLog($desk);

    }



    //--------------------------------------------------------------------

}
