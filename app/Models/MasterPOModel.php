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
    protected $allowedFields    = ['id_po', 'po', 'buyer', 'created_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = false;
    protected $deletedField  = false;

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

    public function getNomorPO($id_po)
    {
        return $this->select('po')
            ->where('id_po', $id_po)
            ->get()
            ->getRowArray()['po'];
    }
}
