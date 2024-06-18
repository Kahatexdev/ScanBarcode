<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailInputModel extends Model
{
    protected $table            = 'detail_input';
    protected $primaryKey       = 'id_input';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_input', 'id_data', 'barcode_cek', 'status', 'created_at', 'admin'];

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


    public function getAllData($id)
    {
        return $this->where('detail_input.id_data', $id)
            ->join('master_input', 'master_input.id_data = detail_input.id_data')
            ->findAll();
    }


















    //report excel
    public function getDataExcel($id_po)
    {
        return $this->select('master_po.*, master_pdk.id_pdk, master_pdk.pdk, master_input.*, detail_input.*')
            ->where('master_po.id_po', $id_po)
            ->join('master_input', 'master_input.id_data = detail_input.id_data')
            ->join('master_pdk', 'master_pdk.id_pdk = master_input.id_pdk')
            ->join('master_po', 'master_po.id_po = master_pdk.id_po')
            ->findAll();
    }
}
