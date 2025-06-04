<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\LogModel;
use CodeIgniter\Email\Email;
use App\Controllers\SendEmailCon;
use App\Libraries\SendEmail;

class Member extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
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
            'memberActive' => $this->memberModel->countMemberByFlag(1),
            'memberAll' => $this->memberModel->countMemberAll(),
            'getData' => $this->memberModel->where('flag', '1')->findAll(),
            'session' => \Config\Services::session()
        ];

        return view('member/bg_index', $data);
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
                        if($field->flag == 0){
                            $st = "<span class='badge rounded-pill text-bg-secondary'>Pending</span>";
                        }elseif($field->flag == 1){
                            $st = "<span class='badge rounded-pill text-bg-primary'>Active</span>";
                        }else{
                            $st = "<span class='badge rounded-pill text-bg-danger'>Deactivated</span>";
                        }

                        if($field->flag == 1){
                            $btnResend = "<a href=".base_url("email/kirimEmailApprove/".$field->id."")." class='btn btn-link mb-2'>Resend</a>";
                        }else{
                            $btnResend = "";
                        }
                        $row[] = $st;
                        $row[] = "<a href=".base_url("member/getDataMemberDetail/".$field->id."")." class='btn btn-link mb-2'>View</a>
                        <a type='a' class='btn btn-link mb-2'>Approval</a> ".$btnResend."";
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



    //--------------------------------------------------------------------

}
