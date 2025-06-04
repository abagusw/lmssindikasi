<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\MasterBranchModel;
use App\Models\MasterCityModel;
use App\Models\LogModel;

class Master extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
        $this->masterBranchModel = new MasterBranchModel();
        $this->masterCityModel = new MasterCityModel();
    }

    /*function master//
        ***** create by devanda andre ******
        devandaandresmg@gmail.com
        30 mei 2025
    */


    //function master branch//

    public function branch(){
    	$data = [
            'title' => 'Master Branch',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->masterBranchModel->orderBy('id', 'DESC')->findAll(),
            'session' => \Config\Services::session()
        ];

        return view('master/branch/bg_index', $data);
    }

    public function add_branch(){
    	$data = [
            'title' => 'Add Master Branch',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'session' => \Config\Services::session()
        ];

        return view('master/branch/bg_add', $data);    	
    }

    public function edit_branch(){
    	$uri = service('uri');
        $id = $uri->getSegment(3);
    	$data = [
            'title' => 'Edit Master Branch',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->masterBranchModel->find($id),

            'session' => \Config\Services::session()
        ];

        return view('master/branch/bg_edit', $data);      	
    }

    public function simpanBranch(){
    	$nama = $this->request->getPost('nama');

    	$data = [
            'name'   => $nama
        ];

        $getBranchByName = $this->masterBranchModel->getBranchByName($nama)->getNumRows();

        if($getBranchByName > 0){
        	$jsonResp = json_encode(array('msg'=>2,'desc'=>"Gagal Duplikasi Data ! Branch ".$nama." sudah ada"));
        }else{

        	$insert = $this->masterBranchModel->insert($data);

        	//if($insert){
	       	$jsonResp = json_encode(array('msg'=>0,'desc'=>"Sukses Insert Data"));
	       		

        	//}
    	}
    	echo $jsonResp;
    	$desk = "Insert data master branch ".$jsonResp;
	    $this->insertLog($desk);

    }


    public function simpanEditBranch(){
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');

        $data = [
            'name'   => $nama
        ];

        //$getBranchByNotName = $this->masterBranchModel->getBranchByNotName($nama)->getNumRows();

        //if($getBranchByNotName > 0){
           // $jsonResp = json_encode(array('msg'=>2,'desc'=>"Gagal Duplikasi Data ! Branch ".$nama." sudah ada"));
        //}else{

            $update = $this->masterBranchModel->update($id,$data);

            //if($insert){
            $jsonResp = json_encode(array('msg'=>0,'desc'=>"Sukses Update Data"));
                

            //}
        //}
        echo $jsonResp;
        $desk = "Update data master branch ".$jsonResp;
        $this->insertLog($desk);        
    }

    public function hapusDataBranch(){
        $id = $this->request->getPost('id');
        $getData = $this->masterBranchModel->find($id);
        $desk = "Branch ".$getData['name']." telah dihapus tanggal : ".date("Y-m-d H:i:s")."";

        $this->masterBranchModel->delete($id);

        echo json_encode(array('msg'=>0,'desc'=>"Sukses Delete Data Master Branch"));
        $this->insertLog($desk);  


    }


    //end function master branch//

    //function master city

    public function city(){
        $data = [
            'title' => 'Master City',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->masterCityModel->getAllCity(),
            'session' => \Config\Services::session()
        ];

        return view('master/city/bg_index', $data);
    }

    public function add_city(){
        $data = [
            'title' => 'Add Master City',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getDataBranch' => $this->masterBranchModel->orderBy('id', 'DESC')->findAll(),
            'session' => \Config\Services::session()
        ];

        return view('master/city/bg_add', $data);     
    }

    public function edit_city(){
        $uri = service('uri');
        $id = $uri->getSegment(3);
        $data = [
            'title' => 'Edit Master City',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->masterCityModel->find($id),
            'getDataBranch' => $this->masterBranchModel->orderBy('id', 'DESC')->findAll(),
            'session' => \Config\Services::session()
        ];

        return view('master/city/bg_edit', $data);        
    }

    public function simpanCity(){
        $nama = $this->request->getPost('nama');
        $cmbBranch = $this->request->getPost('cmbBranch');


        $data = [
            'branch_id' => $cmbBranch,
            'name'   => $nama
        ];

        //         print_r($data);
        // die;

        $getCityByNameAndByBranch = $this->masterCityModel->getCityByNameAndByBranch($nama,$cmbBranch)->getNumRows();

        if($getCityByNameAndByBranch > 0){
            $jsonResp = json_encode(array('msg'=>2,'desc'=>"Gagal Duplikasi Data ! Branch dan nama city sudah ada"));
        }else{

            $insert = $this->masterCityModel->insert($data);

            //if($insert){
            $jsonResp = json_encode(array('msg'=>0,'desc'=>"Sukses Insert Data"));
                

            //}
        }
        echo $jsonResp;
        $desk = "Insert data master City ".json_encode($data)." ".$jsonResp;
        $this->insertLog($desk);        
    }

    public function simpanEditCity(){
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');
        $cmbBranch = $this->request->getPost('cmbBranch');

        $data = [
            'branch_id' => $cmbBranch,
            'name'   => $nama
        ];

        //$getBranchByNotName = $this->masterBranchModel->getBranchByNotName($nama)->getNumRows();

        //if($getBranchByNotName > 0){
           // $jsonResp = json_encode(array('msg'=>2,'desc'=>"Gagal Duplikasi Data ! Branch ".$nama." sudah ada"));
        //}else{

            $update = $this->masterCityModel->update($id,$data);

            //if($insert){
            $jsonResp = json_encode(array('msg'=>0,'desc'=>"Sukses Update Data"));
                

            //}
        //}
        echo $jsonResp;
        $desk = "Update data master city ".$jsonResp;
        $this->insertLog($desk);            
    }

    public function hapusDataCity(){
        $id = $this->request->getPost('id');
        $getData = $this->masterCityModel->find($id);
        $desk = "City ".$getData['name']." telah dihapus tanggal : ".date("Y-m-d H:i:s")."";

        $this->masterCityModel->delete($id);

        echo json_encode(array('msg'=>0,'desc'=>"Sukses Delete Data Master City"));
        $this->insertLog($desk);         
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


}
