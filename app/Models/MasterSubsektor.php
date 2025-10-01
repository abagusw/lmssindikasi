<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSubsektor extends Model
{
    protected $table = 'ms_subsektor';
    //protected $allowedFields = ['*'];
    protected $protectFields = false;
    protected $useTimestamps = false;
    protected $order = ['id' => 'DESC'];


    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // hanya dipanggil satu kali
    }

    public function getSubsektorById($id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id', $id);
        $query = $builder->get();
        $result = $query->getRowArray();
        return $result ? $result['name'] : null;
    }


    public function getSubsektorByName($name){
            $builder = $this->db->table($this->table);
            $builder->where('name', $name);
            return $builder->get();
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

    // for upload CSV
    public function getSubsektorByNameCSV($name){
        $builder = $this->db->table($this->table);
        $builder->where('name like', '%' . $name . '%');
        $query = $builder->get();
        $result = $query->getRowArray();
        return $result ? $result['id'] : null;
    }

}
