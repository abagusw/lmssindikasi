<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterCourseLesson extends Model
{
    protected $table = 'tb_course_lesson';
    protected $allowedFields = ['course_id','judul','uuid','created_at','create_user','updated_at','sort'];
    protected $useTimestamps = true;
    protected $order = ['id' => 'DESC'];


    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // hanya dipanggil satu kali
    }


    public function getCourseLessonByCourseId($course_id){
    	$builder = $this->db->table('tb_course_lesson');
        $builder->where('course_id', $course_id);
        $query = $builder->get();
        return $query;
    }

    // public function getCourseByNotName($name){
    //     $builder = $this->db->table('tb_course');
    //     $builder->where('name !=', $name);
    //     $query = $builder->get();
    //     return $query;
    // }


}
