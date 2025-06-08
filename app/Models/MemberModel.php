<?php
namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table      = 'tb_member'; // Nama tabel
    protected $primaryKey = 'id'; // Primary Key
    protected $protectFields = false;
        //protected $allowedFields = ['name', 'email', 'age']; // Kolom yang boleh diisi
    protected $useTimestamps = true;
    protected $columnOrder = [null, 'nama_lengkap','nama_panggilan','email','create_at','instansi']; // Fields for ordering
    protected $columnSearch = ['nama_lengkap','nama_panggilan','email','create_at','instansi']; // Fields for search
    protected $order = ['id' => 'DESC']; // Default order

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // hanya dipanggil satu kali
    }


    private function _getDatatablesQuery($flag)
    {
        $request = service('request'); // Get request instance
        $searchValue = $request->getPost('search')['value'] ?? null;
        $orderColumnIndex = $request->getPost('order')[0]['column'] ?? null;
        $orderDir = $request->getPost('order')[0]['dir'] ?? 'asc';

        $builder = $this->db->table($this->table);
        if($flag == 1){
           $builder->where('flag', $flag); 
        }
        

        // Search filter
        if (!empty($searchValue)) {
            $builder->groupStart();
            foreach ($this->columnSearch as $key => $item) {
                if ($key === 0) {
                    $builder->like($item, $searchValue);
                } else {
                    $builder->orLike($item, $searchValue);
                }
            }
            $builder->groupEnd();
        }

        // Ordering
        if ($orderColumnIndex !== null) {
            $builder->orderBy($this->columnOrder[$orderColumnIndex], $orderDir);
        } else {
            $builder->orderBy(key($this->order), $this->order[key($this->order)]);
        }

        return $builder;
    }

    public function getDatatables($flag)
    {
        $request = service('request');
        $length = $request->getPost('length') ?? 10;
        $start = $request->getPost('start') ?? 0;

        $builder = $this->_getDatatablesQuery($flag);
        $builder->limit($length, $start);

        return $builder->get()->getResult(); // Return data as objects
    }

    public function countFiltered($flag)
    {
        return $this->_getDatatablesQuery($flag)->countAllResults(false);
    }

    public function countAll()
    {
        
        return $this->db->table($this->table)->countAll();
    }

    public function countMemberByFlag($flag){
        $builder = $this->db->table('tb_member');
        $builder->where('flag', $flag);
        $query = $builder->get()->getNumRows();
        return $query;
    }

    public function countMemberUserByFlag($flag){
        $builder = $this->db->table('tb_member');
        $builder->where('flag_active', $flag);
        $query = $builder->get()->getNumRows();
        return $query;
    }

    public function countMemberAll(){
        $builder = $this->db->table('tb_member');
        $query = $builder->get()->getNumRows();
        return $query;
    }

}

?>