<?php
namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table      = 'tb_payment'; // Nama tabel
    protected $primaryKey = 'id'; // Primary Key
    protected $protectFields = false;
        //protected $allowedFields = ['name', 'email', 'age']; // Kolom yang boleh diisi
    protected $useTimestamps = true;
    protected $columnOrder = [null, 'type','user','amount','method','status']; // Fields for ordering
    protected $columnSearch = ['type','user','amount','method','status']; // Fields for search
    protected $order = ['id' => 'DESC']; // Default order

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // hanya dipanggil satu kali
    }


    private function _getDatatablesQuery()
    {
        $request = service('request'); // Get request instance
        $searchValue = $request->getPost('search')['value'] ?? null;
        $orderColumnIndex = $request->getPost('order')[0]['column'] ?? null;
        $orderDir = $request->getPost('order')[0]['dir'] ?? 'asc';

        $builder = $this->db->table($this->table);
        

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

    public function getDatatables()
    {
        $request = service('request');
        $length = $request->getPost('length') ?? 10;
        $start = $request->getPost('start') ?? 0;

        $builder = $this->_getDatatablesQuery();
        $builder->limit($length, $start);

        return $builder->get()->getResult(); // Return data as objects
    }

    public function countFiltered()
    {
        return $this->_getDatatablesQuery()->countAllResults(false);
    }

    public function countAll()
    {
        
        return $this->db->table($this->table)->countAll();
    }

    public function countMemberByFlag(){
        $builder = $this->db->table('tb_payment');
        $query = $builder->get()->getNumRows();
        return $query;
    }

    public function countMemberAll(){
        $builder = $this->db->table('tb_payment');
        $query = $builder->get()->getNumRows();
        return $query;
    }

}

?>