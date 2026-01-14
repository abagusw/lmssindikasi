<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\LogModel;
use App\Models\PaymentModel;
use App\Models\MasterCityModel;
use CodeIgniter\Email\Email;
use App\Controllers\SendEmailCon;
use App\Libraries\SendEmail;
use App\Libraries\MyEncrypter;
use App\Models\MasterSubsektor;
use Mailjet\Client;
use Mailjet\Resources;

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
        if ($flag == 0) {
            $tit = "Member Registration";
        } else {
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

    public function indexReg()
    {
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

    public function getDataMember()
    {
        $encrypter = new MyEncrypter();
        $uri = service('uri');
        $flag = $uri->getSegment(3);

        // print_r("disini");
        // die;
        //$list = $this->User_model->get_datatables();
        $memberModel = new MemberModel();
        $cityModel = new MasterCityModel();
        $subSektor = new MasterSubsektor();
        $list = $memberModel->getDatatables($flag);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            if ($field->flag_active == 0 || (int)$field->issetuppassword === 0) {
                $row[] = '<input type="checkbox" class="row-check" data-id="' . $field->id . '" data-nama="' . htmlspecialchars($field->nama_lengkap, ENT_QUOTES) . '" />';
            } else {
                $row[] = '<input type="checkbox" class="row-check" disabled />';
            }
            $row[] = $no;
            $row[] = $field->nomor_anggota;
            $row[] = $field->nama_lengkap;
            $row[] = $field->email;
            $row[] = $cityModel->getCityById($field->domisili);
            $row[] = $subSektor->getSubsektorById($field->profesi);
            $row[] = $field->activation_date;
            $row[] = $field->updated_at;
            if ($field->flag_active == 0) {
                $st = "<span class='badge rounded-pill text-bg-secondary'>Pending</span>";
            } elseif ($field->flag_active == 1) {
                $st = "<span class='badge rounded-pill text-bg-primary'>Active</span>";
            } else {
                $st = "<span class='badge rounded-pill text-bg-danger'>Deactivated</span>";
            }

            $dataGenerate = json_encode([
                'id' => $field->id,
                'fullname' => $field->nama_lengkap,
                'email'    => $field->email,
                'generateDate' => date('Y-m-d H:i:s'),
            ]);
            $ciphertext = $encrypter->encrypt($dataGenerate);

            if ($field->flag_active == 0 || $field->issetuppassword == 0) {
                $drBtn = "<li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(" . $field->id . ",3) class='dropdown-item'>Resend Activation</a>
                            <input type='hidden' id='setupPasswordLink_" . $field->id . "' value='" . fe . "set-password?accountregister=" . $ciphertext . "'>
                            <button type='button' onclick=copySetupPasswordLink(" . $field->id . ") class='dropdown-item'>Copy Member Setup Password Link</button></li>";
            } elseif ($field->flag_active == 1) {
                $drBtn = "<li><a href='" . base_url("member/member_user_detail/" . $field->id . "") . "?payment_history=true' class='dropdown-item'><i class='bi bi-clock'></i>Payment History</a></li>
                                <li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalResetPassword' onclick=confirmResetPassword(" . $field->id . ") class='dropdown-item'><i class='bi bi-clock'></i>Reset Password</a></li>
                                <li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(" . $field->id . "," . $field->flag_active . ") class='dropdown-item'><i class='bi bi-clock'></i>Deactivate</a></li>
                            ";
            } else {
                $drBtn = "<li><a href='" . base_url("member/member_user_detail/" . $field->id . "") . "?payment_history=true' class='dropdown-item'><i class='bi bi-clock'></i>Payment History</a></li>
                                <li><a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(" . $field->id . "," . $field->flag_active . ")  class='dropdown-item'><i class='bi bi-clock'></i>Reactive</a></li>
                            ";
            }

            if ($field->issetuppassword == 0) {
                $lblsSetupPass = "<i class='bi bi-x'></i>";
            } else {
                $lblsSetupPass = "<i class='bi bi-check'></i>";
            }

            if ($field->isregisterpaid == 0) {
                $lblsRegPaid = "<i class='bi bi-x'></i>";
            } else {
                $lblsRegPaid = "<i class='bi bi-check'></i>";
            }

            if ($field->isfoundationalcoursecomplete == 0) {
                $lblsFoundational = "<i class='bi bi-x'></i>";
            } else {
                $lblsFoundational = "<i class='bi bi-check'></i>";
            }



            $row[] = $st;
            $row[] = $lblsSetupPass;
            $row[] = $lblsRegPaid;
            $row[] = $lblsFoundational;
            // $row[] = "<a href=".base_url("member/member_detail/".$field->id."")." class='btn btn-link mb-2'>View</a>
            // ".$btnResend."";
            $row[] = "<div class='d-flex gap-2 mb-3'>
                                    <a href='" . base_url("member/member_user_detail/" . $field->id . "") . "' class='btn btn-outline-secondary btn-hover-outline'>
                                      <i class='bi bi-eye'></i>
                                    </a>

                                    <!-- Dropdown tombol titik tiga -->
                                    <div class='dropdown'>
                                      <a class='btn btn-outline-secondary btn-hover-outline' data-bs-toggle='dropdown' aria-expanded='false'>
                                        <i class='bi bi-three-dots-vertical'></i>
                                      </a>
                                      <ul class='dropdown-menu'>
                                        " . $drBtn . "
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
        return $this->response->setJSON($output);
    }

    public function getDataMemberReg()
    {
        //$uri = service('uri');
        $encrypter = new MyEncrypter();
        $flag = 0;

        // print_r("disini");
        // die;
        //$list = $this->User_model->get_datatables();
        $memberModel = new MemberModel();
        $cityModel = new MasterCityModel();
        $subSektor = new MasterSubsektor();
        $list = $memberModel->getDatatables($flag);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {

            // $dataGenerate = json_encode([
            //     'id' => $field->id,
            //     'fullname' => $field->nama_lengkap,
            //     'email'    => $field->email,
            //     'generateDate' => date('Y-m-d H:i:s'),
            // ]);
            // $ciphertext = $encrypter->encrypt($dataGenerate); 

            $no++;

            $row = array();
            if ((int)$field->flag === 0) {
                $row[] = '<input type="checkbox" class="row-check" data-id="' . $field->id . '" data-nama="' . htmlspecialchars($field->nama_lengkap, ENT_QUOTES) . '" />';
            } else {
                $row[] = '<input type="checkbox" class="row-check" disabled />';
            }
            $row[] = $no;
            $row[] = $field->nama_lengkap;
            $row[] = $field->email;
            $row[] = $cityModel->getCityById($field->domisili);
            $row[] = $subSektor->getSubsektorById($field->profesi);
            $row[] = $field->create_at;
            if ($field->flag == 0) {
                $st = "<span class='badge rounded-pill text-bg-secondary'>Pending</span>";
                $btnAppr = "<a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(" . $field->id . ",1) class='btn btn-link mb-2'>Approve</a>
                            <a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(" . $field->id . ",2) class='btn btn-link mb-2'>Reject</a>";
            } elseif ($field->flag == 1) {
                $st = "<span class='badge rounded-pill text-bg-success'>Approved</span>";
                $btnAppr = "";
            } else {
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
            $row[] = $field->create_by_sistem == 1 ? 'Yes' : 'No';
            $row[] = "<a href=" . base_url("member/member_detail/" . $field->id . "") . " class='btn btn-link mb-2'>View</a>
                        " . $btnAppr . " " . $btnResend . "";
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
        return $this->response->setJSON($output);
    }

    public function bulkApprove()
    {
        // --- Ambil payload ---
        $payload = $this->request->getJSON(true);
        if (!is_array($payload) || empty($payload)) {
            $payload = $this->request->getPost();
        }
        if (!is_array($payload) || empty($payload)) {
            $raw = $this->request->getBody();
            if ($raw) {
                $tmp = json_decode($raw, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($tmp)) {
                    $payload = $tmp;
                }
            }
        }

        $ids = $payload['ids'] ?? null;

        // Validasi & sanitasi ids
        if (!is_array($ids) || empty($ids)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['ok' => false, 'message' => 'No selection']);
        }
        $ids = array_values(array_unique(array_map('intval', $ids)));
        $ids = array_filter($ids, static fn($v) => $v > 0);
        if (empty($ids)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['ok' => false, 'message' => 'No selection']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tb_member');

        $db->transBegin();
        try {
            // Approve hanya yang masih Pending (flag=0)
            $builder->whereIn('id', $ids)
                ->where('flag', 0)
                ->update([
                    'flag'        => 1,
                    'approval_date' => date('Y-m-d H:i:s'),
                ]);

            $updated = $db->affectedRows();

            // Catatan aktivitas
            $namaUser = session()->get('nama') ?? 'SYSTEM';
            $dtApr    = date('Y-m-d H:i:s');
            $idList   = implode(',', $ids);
            $desk     = "{$namaUser} sukses meng-approve data member ID: {$idList} tanggal: {$dtApr}";
            // TODO: simpan $desk ke tabel log jika perlu

            // Kirim email satu persatu
            foreach ($ids as $id) {                
                $this->kirimEmailApprove($id);
            }

            $db->transCommit();
            return $this->response->setJSON([
                'ok'      => true,
                'message' => 'Approved',
                'updated' => $updated,
                'ids'     => $ids,
            ]);
        } catch (\Throwable $e) {
            $db->transRollback();
            return $this->response->setStatusCode(500)
                ->setJSON(['ok' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function bulkResend()
    {
        // --- Ambil payload ---
        $payload = $this->request->getJSON(true);
        if (!is_array($payload) || empty($payload)) {
            $payload = $this->request->getPost();
        }
        if (!is_array($payload) || empty($payload)) {
            $raw = $this->request->getBody();
            if ($raw) {
                $tmp = json_decode($raw, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($tmp)) {
                    $payload = $tmp;
                }
            }
        }

        $ids = $payload['ids'] ?? null;

        // Validasi & sanitasi ids
        if (!is_array($ids) || empty($ids)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['ok' => false, 'message' => 'No selection']);
        }
        $ids = array_values(array_unique(array_map('intval', $ids)));
        $ids = array_filter($ids, static fn($v) => $v > 0);
        if (empty($ids)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['ok' => false, 'message' => 'No selection']);
        }

        try {
            // Kirim email satu persatu
            $updated = '';
            foreach ($ids as $id) {
                // proses resend email untuk yang sudah di approve (flag=1) dan belum membuat password (issetuppassword=0)
                if ($this->memberModel->where('id', $id)->where('flag', 1)->where('issetuppassword', 0)->countAllResults() === 0) {
                    continue;
                }
                $isemailsent = $this->kirimEmailApprove($id);
                // $url = base_url('email/kirimEmailApprove/' . $id);
                if ($isemailsent) {
                    $updated = $updated == '' ? $id : $updated . ',' . $id;
                }
            }
            return $this->response->setJSON([
                'ok'      => true,
                'message' => 'Approved',
                'updated' => $updated,
                'ids'     => $ids,
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)
                ->setJSON(['ok' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getDataMemberDetail()
    {
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


    public function getDataUserDetail()
    {
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

    public function ubahStatus()
    {
        $flag = $this->request->getPost('flag');
        $id = $this->request->getPost('id');

        $memberModel = new MemberModel();

        $dtApr = "";
        if ($flag == 1) {
            $dtApr = date('Y-m-d H:i:s');
        }
        $data = [
            'flag'   => $flag,
            'approval_date'  => $dtApr,
        ];

        // Lakukan update berdasarkan ID
        $update = $memberModel->update($id, $data);

        if ($update) {
            $jsonResp =  json_encode(array('msg' => 0, 'desc' => "Sukses Update Data"));
        } else {
            $jsonResp =  json_encode(array('msg' => 1, 'desc' => "Gagal Update Data"));
        }

        if ($flag == 1) {
            $desk = "" . $this->session->get('nama') . " sukses mengapprove data member ID : " . $id . " tanggal : " . date('Y-m-d H:i:s') . "";
            $this->kirimEmailApprove($id);
        } else {
            $dtApr = "";
            $desk = "" . $this->session->get('nama') . " sukses mereject data member ID : " . $id . " tanggal : " . date('Y-m-d H:i:s') . "";
            $this->kirimEmailReject($id);
        }

        $desk = $desk . $jsonResp;

        $this->getLog($desk);
    }


    public function getLog($desk)
    {
        $logModel = new LogModel();
        $dataLog = [
            'description'   => $desk,
            'create_date'   => date('Y-m-d H:i:s'),
            'create_user'   => $this->session->get('nama')
        ];

        if ($logModel->insert($dataLog)) {
            return $this->response->setJSON(array('msg' => 0, 'desc' => "Sukses Insert Data"));
        } else {
            return $this->response->setJSON(array('msg' => 1, 'desc' => "Gagal Insert Data"));
        }
    }

    public function kirimEmail()
    {
        $url = $this->request->getPost('url');
        $id = $this->request->getPost('id');

        $this->sendAsyncRequest($url);
    }
    
    public function konfigEmail($toEmail,$toName,$subject,$view)
    {
        $apiKey = "ef002126f3ce08d048586f718b4cddd0";
        $apiSecret = "60bba545ef781de4a3635885bdc12f29";
        try {
            $mj = new Client($apiKey, $apiSecret, true, ['version' => 'v3.1', 'timeout' => 100, 'connect_timeout' => 10]);
            
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

            // Debug logging
            $this->insertLog("Mailjet Response Debug: " . print_r($response, true));
                
            if ($response->success()) {
                $desk = "Email berhasil dikirim ke : ".$toEmail." Subject : ".$subject." Tanggal ".date('Y-m-d H:i:s')." Response: ".json_encode($response->getBody())."";
            } else {
                $statusCode = method_exists($response, 'getStatus') ? $response->getStatus() : 'N/A';
                $reasonPhrase = method_exists($response, 'getReasonPhrase') ? $response->getReasonPhrase() : 'N/A';
                $bodyContent = method_exists($response, 'getBody') ? $response->getBody() : 'N/A';
                $desk = "Gagal mengirim email: ".$toEmail." Subject : ".$subject." Tanggal ".date('Y-m-d H:i:s')." Status: {$statusCode} Reason: {$reasonPhrase} Body: ".json_encode($bodyContent)."";
            }

            $this->insertLog($desk);
            return true;
        } catch (Exception $e) {
            $message = 'Mailjet error: ' . $e->getMessage();
            $this->insertLog($message);
            return false;
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
    }

    public function kirimEmailApprove($id){
        $encrypter = new MyEncrypter();
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
        return $this->konfigEmail($getData['email'],$getData['nama_lengkap'],'Akun Anda Telah Disetujui',$vw);
    }

    public function kirimEmailReject($id){
        $getData = $this->memberModel->find($id);
        $data = [
            'title' => 'Reject Email',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->memberModel->find($id),
            'session' => \Config\Services::session()
        ];
        $vw = view('email/bg_reject', $data);
        return $this->konfigEmail($getData['email'],$getData['nama_lengkap'], 'Akun Anda ditolak / direject',$vw);
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

        curl_exec($curl);
        curl_close($curl);
    }

    public function confirmStatusData()
    {
        $id = $this->request->getPost('id');
        $getData = $this->memberModel->find($id);
        //$flag = $this->request->getPost('flag');
        if ($getData['flag_active'] == 0 || $getData['issetuppassword'] == 0) {
            $message = "<p>Are you sure you want to resend the activation link to this user?</p><p class='fw-semibold'>They will receive a new email with instructions to activate their account.</p>";
            $url = "'" . base_url('email/kirimEmailApprove/' . $getData['id']) . "\"'";
        } elseif ($getData['flag_active'] == 1) {
            $message = "<p>Are you sure you want to deactivate this users account?</p><p class='fw-semibold'>The user will no longer be able to access the system until reactivated</p>";
            $url = "'" . base_url("email/kirimEmailReject/" . $getData['id']) . "\"'";
        } else {
            $message = "<p>Are you sure you want to reactive this users account?</p><p class='fw-semibold'>They will regain access to the system immediately after activation</p>";
            $url = "";
        }


        $contentNama = "<div class='form-group mt-3'>
                <label class='form-label text-muted' for='userName'>Nama</label>
                <div class='form-control bg-light' id='userName'>" . $getData['nama_lengkap'] . "</div>
              </div>";



        return $this->response->setJSON(array('msg' => $message . $contentNama, 'url' => $url));
    }

    public function confirmResetPassword()
    {
        $id = $this->request->getPost('id');
        $getData = $this->memberModel->find($id);

        return $this->response->setJSON(array('msg' => $getData['nama_lengkap']));
    }

    public function getpaymentDetailUser()
    {
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
            if ($field->status == 0) {
                $st = "<span class='badge rounded-pill text-bg-secondary'>Pending</span>";
            } else {
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
        return $this->response->setJSON($output);
    }

    public function ubahStatusDataUser()
    {
        $flag = $this->request->getPost('flag');
        $id = $this->request->getPost('id');
        $sendEmail = new SendEmail();

        if ($flag == 1) {
            $dtApr = date('Y-m-d H:i:s');
            $desk = "" . $this->session->get('nama') . " sukses mengapprove data member user ID : " . $id . " tanggal : " . date('Y-m-d H:i:s') . "";
            //$url = base_url("email/kirimEmailApprove/".$id."");
            //$sendEmail->kirimEmailApprove($id);
        } else {
            $dtApr = "";
            $desk = "" . $this->session->get('nama') . " sukses mereject data member user ID : " . $id . " tanggal : " . date('Y-m-d H:i:s') . "";
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


        if ($update) {

            $jsonResp =  json_encode(array('msg' => 0, 'desc' => "Sukses Update Data"));
        } else {
            $jsonResp =  json_encode(array('msg' => 1, 'desc' => "Gagal Update Data"));
        }

        $desk = $desk . $jsonResp;

        $this->getLog($desk);
    }

    public function resetPassword()
    {
        $id = $this->request->getPost('id');

        $isemailsent = $this->kirimEmailResetPassword($id);

        if ($isemailsent) {
            $desk = "" . $this->session->get('nama') . " sukses mereset password member user ID : " . $id . " tanggal : " . date('Y-m-d H:i:s') . "";
        } else {
            $desk = "" . $this->session->get('nama') . " gagal mereset password member user ID : " . $id . " tanggal : " . date('Y-m-d H:i:s') . "";
            return $this->response->setJSON(array('msg' => 1, 'desc' => "Gagal mengirim email reset password"));
        }
        $desk = json_encode($desk);

        return $this->getLog($desk);
    }

    public function kirimEmailResetPassword($id){
        $getData = $this->memberModel->find($id);
        $data = [
            'title' => 'Reset Password',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'getData' => $this->memberModel->find($id),
            'session' => \Config\Services::session()
        ];
        $vw = view('email/bg_reset_password', $data);
        return $this->konfigEmail($getData['email'],$getData['nama_lengkap'],'Reset Password akun anda',$vw);
    }

}
