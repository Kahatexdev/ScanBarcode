<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterInputModel extends Model
{
    protected $table            = 'master_input';
    protected $primaryKey       = 'id_data';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_data', 'id_pdk', 'barcode_real', 'created_at'];

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

    public function getDetailPDK($id_pdk)
    {
        return $this->select('master_pdk.id_pdk, master_pdk.pdk, master_input.*')
            ->where('master_pdk.id_pdk', $id_pdk)
            ->join('master_pdk', 'master_pdk.id_pdk = master_input.id_pdk')
            ->groupBy('master_input.id_data')
            ->findAll();
    }

    public function cekDuplikatBarcode($validate)
    {
        $query = $this->where('id_pdk', $validate['id_pdk'])
            ->where('barcode_real ', $validate['barcode_real'])
            ->first();
        return $query;
    }

    public function getData($id_data)
    {
        return $this->where('master_input.id_data', $id_data)
            ->join('master_pdk', 'master_input.id_pdk = master_input.id_pdk')
            ->join('master_po', 'master_po.id_po = master_pdk.id_po')
            ->first();
    }
}
