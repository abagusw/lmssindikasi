<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\LogModel;

class Member extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Member Registration',
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
                        $row[] = $field->create_at;
                        $row[] = $field->approval_date;
                        if($field->flag == 0){
                            $st = "<span class='badge rounded-pill text-bg-secondary'>Pending</span>";
                        }elseif($field->flag == 1){
                            $st = "<span class='badge rounded-pill text-bg-primary'>Approved</span>";
                        }else{
                            $st = "<span class='badge rounded-pill text-bg-danger'>Reject</span>";
                        }
                        $row[] = $st;
                        $row[] = "<a href=".base_url("member/getDataMemberDetail/".$field->id."")." class='btn btn-link mb-2'>View</a>
                        <button type='button' class='btn btn-link mb-2'>Approval</button>";
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


        if($flag == 1){
            $dtApr = date('Y-m-d H:i:s');
            $desk = "".$this->session->get('nama')." sukses mengapprove data member ID : ".$id." tanggal : ".date('Y-m-d H:i:s')."";
        }else{
            $dtApr = "";
            $desk = "".$this->session->get('nama')." sukses mereject data member ID : ".$id." tanggal : ".date('Y-m-d H:i:s')."";
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
        $desk = $desk. $jsonResp;

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

    //--------------------------------------------------------------------

}
