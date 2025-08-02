<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterCourseParticipant extends Model
{
    protected $table = 'tb_course_participant';
    protected $allowedFields = ['*'];
    protected $useTimestamps = true;
    protected $order = ['id' => 'DESC'];


    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // hanya dipanggil satu kali
    }

    public function countAllParticipant()
    {
        return $this->db->table($this->table)->countAllResults();
    }

    public function getParticipantWithMember($courseId = null)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, m.nama_lengkap, m.email, m.status_anggota, m.no_hp');
        $builder->join('tb_member m', 'm.id = p.user_id', 'left');

        if ($courseId !== null) {
            $builder->where('p.course_id', $courseId);
        }

        return $builder->get()->getResultArray();
    }

    // public function getCourseByNotName($name){
    //     $builder = $this->db->table('tb_course');
    //     $builder->where('name !=', $name);
    //     $query = $builder->get();
    //     return $query;
    // }


}
