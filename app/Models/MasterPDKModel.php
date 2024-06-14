<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterPDKModel extends Model
{
    protected $table            = 'master_pdk';
    protected $primaryKey       = 'id_pdk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pdk', 'id_po', 'pdk', 'no_order', 'created_at', 'admin'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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





























    public function cekDuplikatPDK($validate)
    {
        $query = $this->where('id_po', $validate['id_po'])
            ->where('pdk ', $validate['pdk'])
            ->where('no_order ', $validate['no_order'])
            ->first();
        return $query;
        return $query;
    }

    public function insertPDK($data)
    {
        return $this->insert($data);
    }
}
