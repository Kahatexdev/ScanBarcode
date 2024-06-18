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
    protected $allowedFields    = ['id_data', 'barcode_cek', 'status', 'created_at', 'admin'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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
        return $this->select('master_po.*, master_pdk.id_pdk, master_pdk.pdk, master_pdk.no_order, master_input.*, detail_input.*')
            ->where('master_po.id_po', $id_po)
            ->join('master_input', 'master_input.id_data = detail_input.id_data')
            ->join('master_pdk', 'master_pdk.id_pdk = master_input.id_pdk')
            ->join('master_po', 'master_po.id_po = master_pdk.id_po')
            ->findAll();
    }

    //qty scan per po
    public function getQtyScan($id_po)
    {
        $query = $this->select('COUNT(detail_input.id_input) AS qty_scan')
            ->where('master_po.id_po', $id_po)
            ->join('master_input', 'master_input.id_data = detail_input.id_data')
            ->join('master_pdk', 'master_pdk.id_pdk = master_input.id_pdk')
            ->join('master_po', 'master_po.id_po = master_pdk.id_po')
            ->get();

        $result = $query->getRow(); // Assuming a single result per PO

        return $result ? $result->qty_scan : 0; // Return the quantity or 0 if no result      
    }

    //qty scan sesuai per po
    public function getQtySesuai($id_po)
    {
        $query = $this->select('COUNT(detail_input.id_input) AS qty_sesuai')
            ->where('master_po.id_po', $id_po)
            ->where('detail_input.status', 'Barcode Sesuai')
            ->join('master_input', 'master_input.id_data = detail_input.id_data')
            ->join('master_pdk', 'master_pdk.id_pdk = master_input.id_pdk')
            ->join('master_po', 'master_po.id_po = master_pdk.id_po')
            ->get();

        $result = $query->getRow(); // Assuming a single result per PO

        return $result ? $result->qty_sesuai : 0; // Return the quantity or 0 if no result 
    }

    //qty scan tidak sesuai per po
    public function getQtyTidakSesuai($id_po)
    {
        $query = $this->select('COUNT(detail_input.id_input) AS qty_tdk_sesuai')
            ->where('master_po.id_po', $id_po)
            ->like('detail_input.status', 'Barcode Tidak Sesuai')
            ->join('master_input', 'master_input.id_data = detail_input.id_data')
            ->join('master_pdk', 'master_pdk.id_pdk = master_input.id_pdk')
            ->join('master_po', 'master_po.id_po = master_pdk.id_po')
            ->get();

        $result = $query->getRow(); // Assuming a single result per PO

        return $result ? $result->qty_tdk_sesuai : 0; // Return the quantity or 0 if no result 

    }
}
