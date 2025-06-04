<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterCityModel extends Model
{
    protected $table = 'ms_city';
    protected $allowedFields = ['name','branch_id'];
    protected $useTimestamps = false;
    protected $order = ['id' => 'DESC'];


    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // hanya dipanggil satu kali
    }


    public function getCityByNameAndByBranch($name,$branch){
    	$builder = $this->db->table('ms_city');
        $builder->where('branch_id', $branch);
        $builder->where('name', $name);
        $query = $builder->get();
        return $query;
    }

    public function getCityByNotName($name){
        $builder = $this->db->table('ms_city');
        $builder->where('name !=', $name);
        $query = $builder->get();
        return $query;
    }

    public function getAllCity()
    {
        return $this->db->table('ms_city')
            ->select('ms_city.*, ms_branch.name as branch_name')
            ->join('ms_branch', 'ms_branch.id = ms_city.branch_id', 'left')
            ->get()
            ->getResultArray();
    }
}

