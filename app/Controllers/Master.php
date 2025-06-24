<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\MasterBranchModel;
use App\Models\MasterCityModel;
use App\Models\MasterCourseModel;
use App\Models\MasterCourseLesson;
use App\Models\MasterLesson;

use App\Models\LogModel;
use App\Libraries\GlobalFunc;

class Master extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
        $this->masterBranchModel = new MasterBranchModel();
        $this->masterCityModel = new MasterCityModel();
        $this->MasterCourseModel = new MasterCourseModel();
        $this->masterCourseLesson = new MasterCourseLesson();
        $this->masterLesson = new MasterLesson();

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


    public function course(){
        $data = [
            'title' => 'Master Course',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->MasterCourseModel->orderBy('id', 'DESC')->findAll(),
            'session' => \Config\Services::session()
        ];

        return view('master/course/bg_index', $data);
    }

    public function getDatalessonX()
    {
        $client = \Config\Services::curlrequest();

        $ghostApiUrl = URLGhost.'/ghost/api/content/posts/';
        $ghostApiKey = ApiKeyGhost;

        $response = $client->get($ghostApiUrl, [
            'query' => [
                'key' => $ghostApiKey,
                'limit' => 100
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        $posts = $body['posts'] ?? [];

        $data = [];
        $no = 1;

        foreach ($posts as $post) {
            $data[] = [
                'check'  => '<input type="checkbox" class="form-check-input lesson-check" data-uuid="' . esc($post['uuid']) . '">',
                'title'  => '<strong>' . esc($post['title']) . '</strong>',
                'image'  => $post['feature_image']
                    ? '<img src="' . esc($post['feature_image']) . '" width="100" height="60" style="border-radius:8px;">'
                    : '<span class="text-muted fst-italic">Tidak ada</span>',
                'status' => $post['visibility'] === 'public'
                    ? '<span class="badge bg-success">Public</span>'
                    : '<span class="badge bg-secondary">Private</span>',
                'url'    => '<a href="' . esc($post['url']) . '" target="_blank" class="btn btn-sm btn-outline-primary">🔗 Lihat</a>',
            ];
        }

        return $this->response->setJSON([
            'data' => $data
        ]);
    }

    public function getDatalesson()
    {
        $posts = $this->masterLesson->where('flag',1)->findAll();
        $id = $this->request->getGet('id');
        $data = [];
        $no = 1;
        $db = \Config\Database::connect();

        foreach ($posts as $post) {
                $builder = $db->table('tb_course_lesson')
                  ->where('course_id', $id)
                  ->where('uuid', $post['uuid']);

                    //echo "<pre>" . $builder->getCompiledSelect() . "</pre>";
                $exists = $builder->countAllResults();
                 //->countAllResults();
            
            if($exists == 0){


                $data[] = [
                    'check'  => '<input type="checkbox" class="form-check-input lesson-check" data-uuid="' . esc($post['uuid']) . '">',
                    'title'  => '<strong>' . esc($post['title']) . '</strong>',
                    'image'  => $post['feature_image']
                        ? '<img src="' . esc($post['feature_image']) . '" width="100" height="60" style="border-radius:8px;">'
                        : '<span class="text-muted fst-italic">Tidak ada</span>',
                    'status' => $post['visibility'] === 'public'
                        ? '<span class="badge bg-success">Public</span>'
                        : '<span class="badge bg-secondary">Private</span>',
                    'url'    => '<a href="' . esc($post['url']) . '" target="_blank" class="btn btn-sm btn-outline-primary">🔗 Lihat</a>',
                ];
            }
            
        }

        return $this->response->setJSON([
            'data' => $data
        ]);
    }

    public function add_course(){
        $curl = curl_init();
        $data = [
            'title' => 'Add Master Course',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getDataBranch' => $this->MasterCourseModel->orderBy('id', 'DESC')->findAll(),
            'session' => \Config\Services::session()
        ];

        return view('master/course/bg_add', $data);     
    }

    public function detailCourse(){
        $uri = service('uri');
        $id = $uri->getSegment(3);
        $getLesson = $this->masterCourseLesson->where('course_id',$id)->findAll();
        $data = [
            'title' => 'Preview Course',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->MasterCourseModel->find($id),
            'getLesson' => $getLesson,
            'session' => \Config\Services::session()
        ];

        return view('master/course/bg_view', $data);         
    }

    public function editCourse(){
        $uri = service('uri');
        $id = $uri->getSegment(3);
        $getLesson = $this->masterCourseLesson->where('course_id',$id)->findAll();
        $data = [
            'title' => 'Preview Course',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->MasterCourseModel->find($id),
            'getLesson' => $getLesson,
            'session' => \Config\Services::session()
        ];

        return view('master/course/bg_edit', $data);         
    }

    public function getDataCourse()
    {
        $db = \Config\Database::connect();

    $request = service('request');
    $model = new MasterCourseModel();

    $draw = $request->getPost('draw');
    $start = $request->getPost('start');
    $length = $request->getPost('length');
    $searchValue = $request->getPost('search')['value'];
    $orderColIndex = $request->getPost('order')[0]['column'];
    $orderColName = $request->getPost('columns')[$orderColIndex]['data'];
    $orderDir = $request->getPost('order')[0]['dir'];

    // Filters
    $category = $request->getPost('filterCategory');
    $status = $request->getPost('filterStatus');
    $cari = $request->getPost('filterCari');
    $dateRange = $request->getPost('date_range');

    $query = $model;

    if (!empty($searchValue)) {
        $query = $query->groupStart()
            ->like('judul', $searchValue)
            ->orLike('deskripsi', $searchValue)
            ->orLike('topic', $searchValue)
            ->groupEnd();
    }

    if (!empty($cari)) {
        $query = $query->groupStart()
            ->like('judul', $cari)
            ->orLike('deskripsi', $cari)
            ->orLike('topic', $cari)
            ->groupEnd();
    }

    if ($category !== null && $category !== '') {
        $query = $query->where('kategori', $category); // Assign kembali!
    }

    if ($status !== null && $status !== '') {
        $query = $query->where('status', $status);
    }

    if (!empty($dateRange)) {
        $range = explode(' - ', $dateRange);
        if (count($range) === 2) {
            $startDate = date('Y-m-d', strtotime($range[0]));
            $endDate = date('Y-m-d', strtotime($range[1]));
            $query = $query->where('created_date >=', $startDate);
            $query = $query->where('created_date <=', $endDate);
        }
    }

    $total = (new MasterCourseModel())->countAll();
    $filtered = $query->countAllResults(false);
    $data = $query->orderBy($orderColName, $orderDir)->findAll($length, $start);
        $results = [];  
        $no = $start;
        foreach ($data as $row) {
            $no++;
            if($row['kategori'] == 0){
                $kategoriRow = "Foundational";
            }else{
                $kategoriRow = "Advance Course";

            }

            if($row['status'] == 0){
                $statusRow = "<span class='badge text-bg-light'>Draft</span>";
                $btnPubl = "<li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(".$row['id'].",1) class='dropdown-item'><i class='bi bi-send'></i> Publish</a></li>";
                $btnWthdr = "";
            }elseif($row['status'] == 1){
                $statusRow = "<span class='badge text-bg-primary'>Published</span>";
                $btnPubl = "";
                $btnWthdr = "<li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(".$row['id'].",2) class='dropdown-item'><i class='bi bi-stop-circle'></i> Withdraw</a></li>";
            }else{
                $statusRow = "<span class='badge text-bg-danger'>Withdrawn</span>";
                $btnPubl = "";
                $btnWthdr = "";

            }

            $exists = $db->table('tb_course_lesson')
                 ->where('course_id', $row['id'])
                 ->countAllResults();

            $totalPart = $db->table('tb_course_participant')
                 ->where('course_id', $row['id'])
                 ->countAllResults();
            $results[] = [
                'no' => $no,
                'judul' => $row['judul'] . '<br><small class="text-muted">' . $row['start_date'] . ' - ' . $row['end_date'] . '</small>',
                'category' => '<span class="badge bg-dark">' . $kategoriRow . '</span>',
                'assigned_lesson' => "<a href='".base_url("master/detail_course_lesson/".$row['id']."")."'>".$exists." View</a>",
                'participant' => "<a href='".base_url("master/detail_course_participant/".$row['id']."")."'>". $totalPart." View</a>",
                'created_date' => date('d/m/Y', strtotime($row['created_at'])),
                'status' => $statusRow,
                // 'action' => '<button class="btn btn-sm btn-outline-primary">✏️</button> <div class="dropdown">
                //                       <a class="btn btn-outline-secondary btn-hover-outline" data-bs-toggle="dropdown" aria-expanded="false">
                //                         <i class="bi bi-three-dots-vertical"></i>
                //                       </a>
                //                       <ul class="dropdown-menu">
                                        
                //                       </ul>
                //                     </div>',

                'action'  => "<div class='d-flex gap-2 mb-3'>
                                    <a title='Edit Course' href='".base_url("master/edit_course/".$row['id']."")."' class='btn btn-outline-secondary btn-hover-outline'>
                                      <i class='bi bi-pencil'></i>
                                    </a>

                                    <a title='Assign Lesson' href='#!' data-bs-toggle='modal' data-bs-target='#lessonModal' onclick=javascript:confirmAddLesson(".$row['id'].") class='btn btn-outline-secondary btn-hover-outline'>
                                      <i class='bi bi-book'></i>
                                    </a>

                                    <!-- Dropdown tombol titik tiga -->
                                    <div class='dropdown'>
                                      <a title='Others Action' class='btn btn-outline-secondary btn-hover-outline' data-bs-toggle='dropdown' aria-expanded='false'>
                                        <i class='bi bi-three-dots-vertical'></i>
                                      </a>
                                      <ul class='dropdown-menu'>
                                        <li><a href='" . base_url("master/detail_course/" . $row['id']) . "' class='dropdown-item'><i class='bi bi-eye'></i> Preview</a></li>
                                        $btnPubl
                                        $btnWthdr
                                        
                                      </ul>
                                    </div>
                                </div>",
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $results
        ]);
    }

    public function simpanCourse(){
        $path = 'uploads/course/';
        $flag = $this->request->getPost('flag');
        $gambar_default_cover = $this->request->getPost('gambar_default_cover');
        $judul = $this->request->getPost('judul');
        $cmbCategory = $this->request->getPost('cmbCategory');
        $deskripsi = $this->request->getPost('deskripsi');
        $topic = $this->request->getPost('topic');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $image_high_cover = $this->request->getPost('image_high_cover');
        $image_tumb_cover = $this->request->getPost('image_tumb_cover');

        $GlobalFunc = new GlobalFunc();
        if($gambar_default_cover == 0){
            $gambar_cover = $GlobalFunc->upload_picture_not_resize($path,$image_high_cover,$image_tumb_cover);
            $link_cover = "uploads/course/".$gambar_cover;
        }else{
            $gambar_cover = "";
            $link_cover = "";
        }
        $dataCourse = [
                'cover'         => $gambar_cover,
                'judul'         => $judul,
                'kategori'      => $cmbCategory, 
                'deskripsi'     => $deskripsi,
                'status'        => $flag,
                'start_date'    => $start_date,
                'end_date'      => $end_date,
                'topic'         => $topic,
                'created_at'    => date('Y-m-d H:i:s'),
                'create_user'   => $this->session->get('nama'),
                'updated_at'    => date('Y-m-d H:i:s')

        ];

        $insert = $this->MasterCourseModel->insert($dataCourse);

        if($insert){
             $jsonResp = json_encode(array('msg'=>0,'desc'=>"Sukses Insert Data"));
             echo $jsonResp;
             $this->insertLog($jsonResp);
        }

    }

    public function simpanCourseEdit(){
        $id = $this->request->getPost('id');
        $path = 'uploads/course/';
        $gambar_default_cover = $this->request->getPost('gambar_default_cover');
        $judul = $this->request->getPost('judul');
        $cmbCategory = $this->request->getPost('cmbCategory');
        $deskripsi = $this->request->getPost('deskripsi');
        $topic = $this->request->getPost('topic');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $image_high_cover = $this->request->getPost('image_high_cover');
        $image_tumb_cover = $this->request->getPost('image_tumb_cover');

        $GlobalFunc = new GlobalFunc();
        if($gambar_default_cover == 0){
            $gambar_cover = $GlobalFunc->upload_picture_not_resize($path,$image_high_cover,$image_tumb_cover);
            $link_cover = "uploads/course/".$gambar_cover;
        }else{
            $gambar_cover = "";
            $link_cover = "";
        }
        $dataCourse = [
                'cover'         => $gambar_cover,
                'judul'         => $judul,
                'kategori'      => $cmbCategory, 
                'deskripsi'     => $deskripsi,
                'start_date'    => $start_date,
                'end_date'      => $end_date,
                'topic'         => $topic,
                'created_at'    => date('Y-m-d H:i:s'),
                'create_user'   => $this->session->get('nama'),
                'updated_at'    => date('Y-m-d H:i:s')

        ];

        $update = $this->MasterCourseModel->update($id,$dataCourse);

        if($update){
             $jsonResp = json_encode(array('msg'=>0,'desc'=>"Sukses Update Data"));
             echo $jsonResp;
             $this->insertLog($jsonResp);
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

            // if ($logModel->insert($dataLog)) {
            //     //echo json_encode(array('msg'=>0,'desc'=>"Sukses Insert Data"));
            // }
    }

    public function simpanLessonCourse(){
        $id = $this->request->getPost('id');
        $uuidString = $this->request->getPost('uuidString');
        $uuids = explode(',', $uuidString);

        $db = \Config\Database::connect();

        foreach ($uuids as $uuid) {
            $uuid = trim($uuid);

            $exists = $db->table('tb_course_lesson')
                 ->where('course_id', $id)
                 ->where('uuid', $uuid)
                 ->countAllResults();

            if ($exists == 0) {
                $data = [
                    'course_id' => $id,
                    'uuid' => $uuid,
                    'create_user'   => $this->session->get('nama'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $insert = $db->table('tb_course_lesson')->insert($data);
            }
        }

        if($insert){
            echo json_encode(array('msg'=>0,'desc'=>"Sukses Insert Data"));
            $desk = $this->session->get('nama')." menambahkan master course";
            $this->insertLog($desk);

        }

    }

   public function hapusCourseLesson(){
        $id = $this->request->getPost('id');
        $getData = $this->masterCourseLesson->find($id);
        $desk = "Course Lesson ".$getData['uuid']." telah dihapus tanggal : ".date("Y-m-d H:i:s")."";

        $this->masterCourseLesson->delete($id);

        echo json_encode(array('msg'=>0,'desc'=>"Sukses Delete Data Lesson Course"));
        $this->insertLog($desk);  


    }

    public function ubahStatusCourse(){
        $flag = $this->request->getPost('flag');
        $id = $this->request->getPost('id');

        if($flag == 1){
            $dtApr = date('Y-m-d H:i:s');
            $desk = "".$this->session->get('nama')." sukses publish course tanggal : ".date('Y-m-d H:i:s')."";
            //$sendEmail->kirimEmailApprove($id);
        }else{
            $dtApr = "";
            $desk = "".$this->session->get('nama')." sukses withdraw course tanggal : ".date('Y-m-d H:i:s')."";
            //$sendEmail->kirimEmailReject($id);
        }

        $data = [
            'status'   => $flag,
            'update_at'  => $dtApr,
        ];

        // Lakukan update berdasarkan ID
        $update = $this->MasterCourseModel->update($id, $data);
        $jsonResp =  json_encode(array('msg'=>0,'desc'=>"Sukses Update Data"));

        echo $jsonResp;

    }

    public function lesson(){
        $data = [
            'title' => 'Master Lesson',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->masterLesson->orderBy('id', 'DESC')->findAll(),
            'session' => \Config\Services::session()
        ];

        return view('master/lesson/bg_index', $data);
    }

    public function sinkronLesson()
    {
        $db = \Config\Database::connect();
        $db->table('ms_lesson')->truncate();
        $masterLesson = new masterLesson();
        $client = \Config\Services::curlrequest();

        $ghostApiUrl = URLGhost.'/ghost/api/content/posts/';
        $ghostApiKey = ApiKeyGhost;

        $response = $client->get($ghostApiUrl, [
            'query' => [
                'key' => $ghostApiKey,
                'limit' => 100
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        $posts = $body['posts'] ?? [];


        $data = [];
        $no = 1;

        foreach ($posts as $post) {

            $dataLesson = [
                'id_ghost'      => $post['id'],
                'uuid'          => $post['uuid'],
                'title'         => $post['title'],
                'slug'          => $post['slug'],
                'content'       => $post['html'],
                'feature_image' => $post['feature_image'],
                'visibility'    => $post['visibility'],
                'created_at'    => $post['created_at'],
                'updated_at'    => $post['updated_at'],
                'published_at'  => $post['published_at'],
                'url'           => $post['url'],
                'excerpt'       => $post['excerpt'],
                'sinkron_date'  => date('Y-m-d H:i:s')
            ];

            $this->masterLesson->insert($dataLesson);

        }

        return redirect()->to('master/lesson');

    }

    public function getDatalessonByCourse()
    {
        $id = $this->request->getPost('id');
        $data = [];
        $no = 1;
        $db = \Config\Database::connect();
        $builder = $db->table('tb_course_lesson');
        $builder->select('tb_course_lesson.*, ms_lesson.title, ms_lesson.excerpt'); // sesuaikan kolom
        $builder->join('ms_lesson', 'tb_course_lesson.uuid = ms_lesson.uuid');
        $builder->where('course_id',$id);
        $query = $builder->get();
        $posts = $query->getResultArray();

        $html = "<table id='lessonTable' class='table table-hover align-middle table-bordered rounded shadow-sm'>
                  <thead class='table-light'>
                    <tr>
                      <th>Judul</th>
                      <th>Gambar</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  ";
                  foreach ($posts as $post) {
                    echo"
                        <tr>
                            <td>".esc($post['title'])."</td>
                            <td>".esc($post['excerpt'])."</td>
                        </tr>";
                    }echo"
                  </tbody>
                </table>";


        return json_encode(array('msg'=>0,'html'=>$html));
    }

    public function detail_course_lesson(){
        $uri = service('uri');
                
        $id = $uri->getSegment(3);

        $db = \Config\Database::connect();
        $builder = $db->table('tb_course_lesson');
        $builder->select('tb_course_lesson.*, ms_lesson.title, ms_lesson.excerpt , ms_lesson.feature_image, ms_lesson.visibility, ms_lesson.url'); // sesuaikan kolom
        $builder->join('ms_lesson', 'tb_course_lesson.uuid = ms_lesson.uuid');
        $builder->where('course_id',$id);

        //echo $builder->getCompiledSelect();
        $query = $builder->get();
        $posts = $query->getResultArray();

        $data = [
            'title' => 'Data Lesson By Course',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $posts,
            'session' => \Config\Services::session()
        ];

        return view('master/course/bg_detail_lesson', $data);
    }

    public function detail_course_participant(){
        $uri = service('uri');
                
        $id = $uri->getSegment(3);
        $posts = $this->MasterCourseModel->getCourseParticipantByCourseId($id);

        $data = [
            'title' => 'Data Participant By Course',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $posts,
            'session' => \Config\Services::session()
        ];

        return view('master/course/bg_detail_participant', $data);
    }

    public function ubahStatusLesson(){
        $flag = $this->request->getPost('flag');
        $id = $this->request->getPost('id');

        if($flag == 1){
            $dtApr = date('Y-m-d H:i:s');
            $desk = "".$this->session->get('nama')." sukses activated lesson tanggal : ".date('Y-m-d H:i:s')."";
            //$sendEmail->kirimEmailApprove($id);
        }else{
            $dtApr = "";
            $desk = "".$this->session->get('nama')." sukses archived lesson tanggal : ".date('Y-m-d H:i:s')."";
            //$sendEmail->kirimEmailReject($id);
        }

        $data = [
            'flag'   => $flag,
        ];

        // Lakukan update berdasarkan ID
        $update = $this->masterLesson->update($id, $data);
        $jsonResp =  json_encode(array('msg'=>0,'desc'=>"Sukses Update Data"));

        echo $jsonResp;        
    }





}
