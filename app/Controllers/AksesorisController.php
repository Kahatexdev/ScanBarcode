<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MasterPOModel;
use App\Models\MasterPDKModel;

class AksesorisController extends BaseController
{
    protected $filters;
    protected $poModel;
    protected $pdkModel;
    public function __construct() {
        $this->poModel = new MasterPOModel();
        $this->pdkModel = new MasterPDKModel();
        if ($this->filters   = ['role' => ['aksesoris', session()->get('role') . '', 'acc', 'acc']] != session()->get('role')) {
            return redirect()->to(base_url('/login'));
        }
    }

    public function index()
    {
        $dataPo = $this->poModel->getPo();

        $data = [
            'role' => session()->get('role'),
            'title' => 'List PO & Buyer',
            'po' => $dataPo,
        ];
        return view(session()->get('role') . '/halamanUtama', $data);
    }

    // proses input PO
    public function inputPO()
    {
        $po     = $this->request->getPost("po");
        $buyer  = $this->request->getPost("buyer");

        $validate = [
            'po' => $po,
            'buyer' => $buyer,
        ];
        $check = $this->poModel->cekDuplikatPO($validate);
        if (!$check){
            $data = [
                'po' => $po,
                'buyer' => $buyer,
                'created_at' => "NOW()",
            ];
            $insert = $this->poModel->insert($data);
            if ($insert){
                return view(session()->get('role') . '/');
            }
        }else{
            echo "PO Sudah Ada di Database";
        }
    }

    // detail PO
    public function detailPO($id_po)
    {
        $detailPo = $this->poModel->getDetailPO($id_po);
        $idPo = $this->poModel->getIdPO($id_po);
        $noPo = $this->poModel->getNomorPO($id_po);

        $data = [
            'role' => session()->get('role'),
            'title' => 'List PDK PO ' . $noPo,
            'id_po' => $idPo,
            'no_po' => $noPo,
            'detailpo' => $detailPo,
        ];
        return view('Aksesoris/detailPO', $data);
    }

    // proses input PDK
    public function inputPDK()
    {
        $id_po     = $this->request->getPost("id_po");
        $pdk  = $this->request->getPost("pdk");
        $no_order  = $this->request->getPost("no_order");

        $validate = [
            'id_po' => $id_po,
            'pdk' => $pdk,
            'no_order' => $no_order,
        ];
        $check = $this->pdkModel->cekDuplikatPDK($validate);
        if (!$check){
            $data = [
                'id_po' => $id_po,
                'pdk' => $pdk,
                'no_order' => $no_order,
                'created_at' => "NOW()",
                'admin' => session()->get('username'),
            ];
            // $insert = $this->poModel->insertPDK($data);
            var_dump($check);
        }else{
            echo "PDK Sudah Ada di Database";
        }
    }

}
