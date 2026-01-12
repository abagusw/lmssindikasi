<?php
namespace App\Models;

use CodeIgniter\Model;

class PaymentNotificationModel extends Model
{
    protected $table      = 'tb_payment_notification'; // Nama tabel
    protected $primaryKey = 'id'; // Primary Key
    protected $protectFields = false;
        //protected $allowedFields = ['name', 'email', 'age']; // Kolom yang boleh diisi
    protected $useTimestamps = true;
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

    public function getFirstNotification()
    {
        $builder = $this->db->table('tb_payment_success_member psm');
        $builder->select('psm.*,m.email as email_member, m.nama_lengkap');
        $builder->join('tb_member m', 'psm.user_id = m.id', 'join');
        $builder->join('tb_payment_notification nf', 'psm.id = nf.payment_success_id and nf.notification_type = 1', 'left');
        $builder->where('nf.id is null'); // Only get records without existing notifications
        $builder->where('psm.first_notify <', date('Y-m-d H:i:s'));
        $builder->where('psm.second_notify >', date('Y-m-d H:i:s')); // Not expired yet
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getSecondNotification()
    {
        $builder = $this->db->table('tb_payment_success_member psm');
        $builder->select('psm.*,m.email as email_member, m.nama_lengkap');
        $builder->join('tb_member m', 'psm.user_id = m.id', 'join');
        $builder->join('tb_payment_notification nf', 'psm.id = nf.payment_success_id and nf.notification_type = 2', 'left');
        $builder->where('nf.id is null'); // Only get records without existing notifications
        $builder->where('psm.second_notify <', date('Y-m-d H:i:s'));
        $builder->where('psm.third_notify >', date('Y-m-d H:i:s')); // Not expired yet
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getThirdNotification()
    {
        $builder = $this->db->table('tb_payment_success_member psm');
        $builder->select('psm.*,m.email as email_member, m.nama_lengkap');
        $builder->join('tb_member m', 'psm.user_id = m.id', 'join');
        $builder->join('tb_payment_notification nf', 'psm.id = nf.payment_success_id and nf.notification_type = 3', 'left');
        $builder->where('nf.id is null'); // Only get records without existing notifications
        $builder->where('psm.third_notify <', date('Y-m-d H:i:s'));
        $builder->where('psm.final_notify >', date('Y-m-d H:i:s')); // Not expired yet
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getFinalNotification()
    {
        $builder = $this->db->table('tb_payment_success_member psm');
        $builder->select('psm.*,m.email as email_member, m.nama_lengkap');
        $builder->join('tb_member m', 'psm.user_id = m.id', 'join');
        $builder->join('tb_payment_notification nf', 'psm.id = nf.payment_success_id and nf.notification_type = 4', 'left');
        $builder->where('nf.id is null'); // Only get records without existing notifications
        $builder->where('psm.final_notify <', date('Y-m-d H:i:s'));
        $builder->where('psm.expired_date >', date('Y-m-d H:i:s')); // Not expired yet
        $query = $builder->get();
        return $query->getResultArray();
    }
}

?>