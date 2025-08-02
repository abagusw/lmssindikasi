<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterCourseAnalytic extends Model
{
    protected $table = 'tb_course_analytic';
    protected $allowedFields = ['*'];
    protected $useTimestamps = true;
    protected $order = ['id' => 'DESC'];


    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // hanya dipanggil satu kali
    }

    // public function getCourseByNotName($name){
    //     $builder = $this->db->table('tb_course');
    //     $builder->where('name !=', $name);
    //     $query = $builder->get();
    //     return $query;
    // }


}
