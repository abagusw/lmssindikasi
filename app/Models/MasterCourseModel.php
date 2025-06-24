<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterCourseModel extends Model
{
    protected $table = 'tb_course';
    protected $allowedFields = ['id','cover','judul','kategori','deskripsi','status','start_date','end_date','topic','created_at','create_user','updated_at'];
    protected $useTimestamps = true;
    protected $order = ['id' => 'DESC'];


    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // hanya dipanggil satu kali
    }

    public function getCourseParticipantByCourseId($courseId)
    {
        return $this->db->table('tb_course_participant tcp')
            ->select('tcp.*, tm.*')
            ->join('tb_member tm', 'tm.id = tcp.user_id')
            ->get()
            ->getResultArray();
    }


    // public function getCourseByName($name){
    // 	$builder = $this->db->table('tb_course');
    //     $builder->where('name', $name);
    //     $query = $builder->get();
    //     return $query;
    // }

    // public function getCourseByNotName($name){
    //     $builder = $this->db->table('tb_course');
    //     $builder->where('name !=', $name);
    //     $query = $builder->get();
    //     return $query;
    // }


}
