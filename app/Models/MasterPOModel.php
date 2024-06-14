<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterPOModel extends Model
{
    protected $table            = 'master_po';
    protected $primaryKey       = 'id_po';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_po', 'po', 'buyer'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getPo()
    {
        return $this->select('id_po,po,buyer')
            ->orderBy('po')
            ->groupBy('id_po')
            ->findAll();
    }

    public function cekDuplikatPO($validate)
    {
        $query = $this->where('po', $validate['po'])
            ->where('buyer ', $validate['buyer'])
            ->first();
        return $query;
    }

    public function getDetailPO($id_po)
    {
        return $this->select('master_po.*, master_pdk.pdk, master_pdk.no_order')
            ->where('master_po.id_po', $id_po)
            ->join('master_pdk', 'master_pdk.id_po = master_po.id_po')
            ->findAll();
    }

    public function getNomorPO($id_po)
    {
        return $this->select('po')
            ->where('id_po', $id_po)
            ->get()
            ->getRowArray()['po'];
    }

    public function getIdPO($id_po)
    {
        return $this->select('id_po')
            ->where('id_po', $id_po)
            ->get()
            ->getRowArray()['id_po'];
    }
}
