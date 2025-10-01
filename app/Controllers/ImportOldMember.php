<?php

namespace App\Controllers;

use App\Models\MasterCityModel;
use App\Models\MasterSubsektor;
use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\PaymentModel;
use App\Models\PaymentCallBackModel;
use App\Models\PaymentSuccessModel;

class ImportOldMember extends BaseController
{
    public function __construct()
    {
        $this->memberModel = new MemberModel();
        $this->masterCityModel = new MasterCityModel();
        $this->masterSubsector = new MasterSubsektor();
        $this->paymentModel = new PaymentModel();
        $this->paymentCallbackModel = new PaymentCallBackModel();
        $this->paymentSuccessModel = new PaymentSuccessModel();
    }

    public function uploadOldMemberCSV()    
    {       
        $validationRules = [
            'csv_file' => 'uploaded[csv_file]|mime_in[csv_file,text/csv]|max_size[csv_file,2048]',
        ];
        
        if ($this->validate($validationRules)) {
            $file = $this->request->getFile('csv_file');

            if ($file->isValid() && !$file->hasMoved()) {
                // Generate a unique name for the file to prevent overwrites
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newName); // Store in writable directory

                // Process the CSV file
                $filePath = WRITEPATH . 'uploads/' . $newName;
                $csvData = array_map('str_getcsv', file($filePath));

                $dataToSave = [];
                $dataCannotProcess = [];
                $isheader = true;
                foreach ($csvData as $row) {
                    if ($isheader) {
                        $isheader = false;
                    } else {
                        if (empty($row[1])) {
                            // Skip rows with empty 'nama_lengkap' or 'nomor_anggota'
                            array_push($dataCannotProcess, $row);
                            continue;
                        }
                        $mapdata = [
                            'nama_lengkap' => !empty($row[4]) ? $row[4] : null,
                            'nama_panggilan' => !empty($row[4]) ? explode(' ', $row[4])[count(explode(' ', $row[4])) - 1] : null,
                            'status_anggota' => 0,
                            'email' => !empty($row[8]) ? $row[8] : null,
                            'no_hp' => !empty($row[7]) ? $row[7] : null,
                            'jenis_kelamin' => !empty($row[4]) ?  ( $row[10] == 'Laki-laki' ? 1 : ($row[10] == 'Perempuan' ? 0 : null) ) : null,
                            'jenis_kelamin_lainnya' => null,
                            'tempat_lahir' => !empty($row[5]) ? $this->masterCityModel->getCityByName($row[5]) : null,
                            'tanggal_lahir' => !empty($row[6]) ? $this->stringToDateTime($row[6]) : null,
                            'pendidikan_terakhir' => $row[21] ?? null,
                            'nama_instansi_pendidikan' => null,
                            'pengalaman_organisasi' => $row[22] ?? null,
                            'referensi' => null,
                            'domisili' => !empty($row[11]) ? $this->masterCityModel->getCityByName($row[11]) : null,
                            'subsektor' => !empty($row[12]) ? $this->masterSubsector->getSubsektorByNameCSV($row[12]) : 22,
                            'instansi' => $row[13] ?? null,
                            'profesi' => $row[14] ?? null,
                            'status_ketenagakerjaan' => !empty($row[17]) ? $this->getStatusKetenagakerjaan($row[17]) : null,
                            'deskripsi_pekerjaan' => $row[23] ?? null,
                            'jenis_masalah_lainnya' => null,
                            'alasan_bergabung_sindikasi' => $row[9] ?? null,
                            'bpjstk' => null,
                            'bpjsks' => null,
                            'status_anggota_bpjstk' => !empty($row[16]) ? $this->getYesNo($row[16]) : null,
                            'status_anggota_bpjsks' => !empty($row[15]) ? $this->getYesNo($row[15]) : null,
                            'link_instagram' => null,
                            'link_twitter' => null,
                            'link_facebook' => null,
                            'link_linkedin' => null,
                            'flag' => 0,
                            'flag_active' => 1,
                            'create_at' => date('Y-m-d H:i:s'),
                            'approval_date' => null,
                            'issetuppassword' => 0,
                            'isregisterpaid' => 1,
                            'isfoundationalcoursecomplete' => 1,
                            'create_by_sistem' => 1,
                            'create_user' => 1,
                            'updated_at' => null,
                            'created_at' => date('Y-m-d H:i:s'),
                            'disabilitas' => null,
                            'disabilitas_lainnya' => null,
                            'masalah_ketenagakerjaan' => $row[20] ?? null,
                            'masalah_ketenagakerjaan_lain' => null,
                            'pakta_integritas' => 'Point 1, Point 2, Point 3, Point 4, Point 5, Point 6',
                            'pernyataan_keanggotaan' => 'bersedia_mematui_art,bersedia_mematuhi_kode_etik,bersedia_mengikuti_pendidikan,statement_keaslian_data,bersedia_bergabung_grup,memberikan_konsen',
                            'password' => null,
                            'token' => null,
                            'token_expired' => null,
                            'nomor_anggota' => $row[1] ?? null,
                            'activation_date' => !empty($row[18]) ? $this->getDateByMonth($row[18]) : null,
                            'keahlian' => null,
                            'bahasa' => null,
                            'biografi' => null,
                        ];
                        array_push($dataToSave, $mapdata);
                    }
                }
                if (!empty($dataCannotProcess)) {
                    return $this->response->setJSON(['status' => 'failed', 'message' => 'Some data cannot processed.', 'dataToSave' => $dataToSave, 'dataCannotProcess' => $dataCannotProcess]);
                }
                if (!empty($dataToSave)) {
                    $this->memberModel->insertBatch($dataToSave);
                }

                return $this->response->setJSON(['status' => 'success', 'message' => 'CSV uploaded and processed successfully.', 'dataToSave' => $dataToSave, 'dataCannotProcess' => $dataCannotProcess]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => $file->getErrorString()]);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => $this->validator->getErrors()]);
        }
    }

    public function uploadLatestPaymentCSV() {        
        $validationRules = [
            'csv_file' => 'uploaded[csv_file]|mime_in[csv_file,text/csv]|max_size[csv_file,2048]',
        ];
        if ($this->validate($validationRules)) {
            $file = $this->request->getFile('csv_file');

            if ($file->isValid() && !$file->hasMoved()) {
                // Generate a unique name for the file to prevent overwrites
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newName); // Store in writable directory

                // Process the CSV file
                $filePath = WRITEPATH . 'uploads/' . $newName;
                $csvData = array_map('str_getcsv', file($filePath));

                $paymentToSave = [];
                $paymentCallbackToSave = [];
                $paymentSuccessToSave = [];
                $paymentNoMemberData = [];
                $dataCannotProcess = [];
                $isheader = true;
                foreach ($csvData as $row) {
                    if ($isheader) {
                        $isheader = false;
                    } else {
                        if (empty($row[1])) {
                            array_push($dataCannotProcess, $row);
                            continue;
                        }
                        // get member by email
                        $member = $this->memberModel->where('email', $row[3])->first();
                        if (!$member) {
                            array_push($paymentNoMemberData, $row);
                            continue;
                        }
                        $paymentData = [
                            'type' => !empty($row[5]) ? $row[5] : null,
                            'user_id' => $member['id'],
                            'user' => $member['email'],
                            'fullname' => $member['nama_lengkap'],
                            'amount' => !empty($row[5]) ? $this->getAmountByTrxType($row[5]) : null,
                            'method' => 'bank_transfer', // default bank_transfer
                            'status' => 'settlement', // default settlement
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                        array_push($paymentToSave, $paymentData);
                        
                        $paymentCallbackData = [
                            'user_id' => $member['id'],
                            'transaction_id' => null,
                            'transaction_time' => !empty($row[4]) ? $this->stringToDateTime($row[4]) : null,
                            'transaction_status' => 'settlement', // default settlement
                            'payment_type' => 'bank_transfer', // default bank_transfer
                            'order_id' => null, 
                            'gross_amount' => !empty($row[5]) ? $this->getAmountByTrxType($row[5]) : null,
                            'fraud_status' => 'accept', // default accept
                            'settlement_time' => !empty($row[4]) ? $this->stringToDateTime($row[4]) : null,
                            'status_code' => '200', // default 200
                            'status_message' => 'this data is imported by system',
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                        array_push($paymentCallbackToSave, $paymentCallbackData);
                        
                        $expiredDateEtc = !empty($row[4]) && !empty($row[5]) ? $this->calculateExpiredEtc($row[4], $row[5]) : null;
                        $paymentSuccessData = [
                            'jenis' => 0,
                            'user_id' => $member['id'],
                            'jenis_transaksi' => 3,
                            'transaction_id' => null,
                            'transaction_status' => 'settlement', // default settlement
                            'gross_amount' => !empty($row[5]) ? $this->getAmountByTrxType($row[5]) : null,
                            'expired_date' => $expiredDateEtc ? $expiredDateEtc['expired_date']: null,
                            'first_notify' => $expiredDateEtc ? $expiredDateEtc['first_notify']: null,
                            'second_notify' => $expiredDateEtc ? $expiredDateEtc['second_notify']: null,
                            'third_notify' => $expiredDateEtc ? $expiredDateEtc['third_notify']: null,
                            'final_notify' => $expiredDateEtc ? $expiredDateEtc['final_notify']: null,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                        array_push($paymentSuccessToSave, $paymentSuccessData);
                    }
                } 
                
                $response = [
                    'status' => 'failed', 
                    'message' => 'Some data cannot processed.', 
                    'paymentToSave' => $paymentToSave, 
                    'paymentCallbackToSave' => $paymentCallbackToSave, 
                    'paymentSuccessToSave' => $paymentSuccessToSave, 
                    'paymentNoMemberData' => $paymentNoMemberData, 
                    'dataCannotProcess' => $dataCannotProcess
                ];
                if (!empty($dataCannotProcess) || !empty($paymentNoMemberData)) {
                    return $this->response->setJSON($response);
                }
                if (!empty($paymentToSave)) {
                    $this->paymentModel->insertBatch($paymentToSave);
                }
                if (!empty($paymentCallbackToSave)) {
                    $this->paymentCallbackModel->insertBatch($paymentCallbackToSave);
                }
                if (!empty($paymentSuccessToSave)) {
                    $this->paymentSuccessModel->insertBatch($paymentSuccessToSave);
                }
                $response['status'] = 'success';
                $response['message'] = 'CSV uploaded and processed successfully.';
                return $this->response->setJSON($response);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => $file->getErrorString()]);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => $this->validator->getErrors()]);
        }
    }

    public function getStatusKetenagakerjaan($status): int|string|null {
        if (stripos($status, 'Lepas') !== false || stripos($status, 'Freelance') !== false) {
            return 'Lepas';
        } elseif (stripos($status, 'Kontrak') !== false) {
            return 2;
        } elseif (stripos($status, 'Magang') !== false) {
            return 3;
        } elseif (stripos($status, 'Lepas') !== false) {
            return 4;
        } else {
            return null;
        }
    }
    
    public function getYesNo($yesNo): int|string|null {
        if (stripos($yesNo, 'ya')) {
            return 'aktif';
        } elseif (stripos($yesNo, 'tidak')) {
            return 'tidak aktif';
        } else {
            return null;
        }
    }

    public function stringToDateTime($dateStr)
    {
        $time = strtotime($dateStr);
        $newformat = date('Y-m-d H:i:s',$time);

        return $newformat;
    }

    public function getDateByMonth($monthYear)
    {
        list($month, $year) = explode(' ', $monthYear);
        $indonesianMonths = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $numberOfMonth = array_search(ucfirst(strtolower($month)), $indonesianMonths) + 1;
        $time = strtotime(''.$year.'-'.$numberOfMonth.'-01');
        $newformat = date('Y-m-d H:i:s',$time);

        return $newformat;
    }

    public function getAmountByTrxType($trxType) {
        $map = [
            'Iuran Awal' => 50000,
            '3 Bulan' => 75000,
            '6 Bulan' => 150000,
            '12 Bulan' => 300000,
            '24 Bulan' => 600000,
        ];
        if (array_key_exists($trxType, $map)) {
            return $map[$trxType];
        } else {
            return null;
        }
    }
    public function calculateExpiredEtc($latestPaymentDate, $trxType) {
        $map = [
            'Iuran Awal' => 2,
            '3 Bulan' => 3,
            '6 Bulan' => 6,
            '12 Bulan' => 12,
            '24 Bulan' => 24,
        ];
        $numberOfMonth = array_key_exists($trxType, $map) ? $map[$trxType] : 0;
        if ($numberOfMonth > 0) {
            $expired_date = date('Y-m-d', strtotime("+$numberOfMonth months", strtotime($latestPaymentDate)));

            // Notifikasi H-7, H-3, H-1, H
            $first_notify  = date('Y-m-d', strtotime('-7 days', strtotime($expired_date)));
            $second_notify = date('Y-m-d', strtotime('-3 days', strtotime($expired_date)));
            $third_notify  = date('Y-m-d', strtotime('-1 day', strtotime($expired_date)));
            $final_notify  = $expired_date; // sama dengan expired
            return [
                'expired_date' => $expired_date,
                'first_notify' => $first_notify,
                'second_notify' => $second_notify,
                'third_notify' => $third_notify,
                'final_notify' => $final_notify,
            ];
        } else {
            return null;
        }
        if (array_key_exists($trxType, $map)) {
            return $map[$trxType];
        } else {
            return null;
        }
    }
}
