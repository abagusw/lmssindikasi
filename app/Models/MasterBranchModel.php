<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterBranchModel extends Model
{
    protected $table = 'ms_branch';
    protected $allowedFields = ['name'];
    protected $useTimestamps = false;
    protected $order = ['id' => 'DESC'];


    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // hanya dipanggil satu kali
    }


    public function getBranchByName($name){
    	$builder = $this->db->table('ms_branch');
        $builder->where('name', $name);
        $query = $builder->get();
        return $query;
    }

    public function getBranchByNotName($name){
        $builder = $this->db->table('ms_branch');
        $builder->where('name !=', $name);
        $query = $builder->get();
        return $query;
    }


}
