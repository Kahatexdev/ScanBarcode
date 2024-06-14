<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MasterPOModel;
use App\Models\MasterPDKModel;
use App\Models\MasterInputModel;


class AksesorisController extends BaseController
{
    protected $filters;
    protected $poModel;
    protected $pdkModel;
    protected $inputModel;
    public function __construct()
    {
        $this->poModel = new MasterPOModel();
        $this->pdkModel = new MasterPDKModel();
        $this->inputModel = new MasterInputModel();
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
        if (!$check) {
            $data = [
                'po' => $po,
                'buyer' => $buyer,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $insert = $this->poModel->insert($data);
            if ($insert) {
                return redirect()->to(base_url(session()->get('role') . ''))->withInput()->with('success', 'Data Berhasil Di Input');
            }else{
                return redirect()->to(base_url(session()->get('role')))->withInput()->with('error', 'Terjadi kesalahan saat menginput data.');
            }
        } else {
            return redirect()->to(base_url(session()->get('role') . ''))->withInput()->with('error', 'Data PO Sudah Ada!');;
        }
    }














    // detail PO
    public function detailPO($id_po)
    {
        $detailPo = $this->pdkModel->getDetailPO($id_po);
        $noPo = $this->poModel->getNomorPO($id_po);

        $data = [
            'role' => session()->get('role'),
            'title' => 'List PDK PO ' . $noPo,
            'id_po' => $id_po,
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
        if (!$check) {
            $data = [
                'id_po' => $id_po,
                'pdk' => $pdk,
                'no_order' => $no_order,
                'created_at' => date('Y-m-d H:i:s'),
                'admin' => session()->get('username'),
            ];
            $insert = $this->pdkModel->insert($data);
            if ($insert) {
                return redirect()->to(base_url(session()->get('role') . '/dataPO/'. $id_po))->withInput()->with('success', 'Data PDK Berhasil Di Input');
            }   
            // var_dump($data);
        } else {
            return redirect()->to(base_url(session()->get('role') . '/dataPO/'. $id_po))->withInput()->with('error', 'Data PDK Sudah Ada!');
            // echo "bbbb";
        }
    }













































    // detail PDK
    public function detailPDK($id_pdk)
    {
        $detailPdk = $this->inputModel->getDetailPDK($id_pdk);
        $pdk = $this->pdkModel->getPDK($id_pdk);

        $data = [
            'role' => session()->get('role'),
            'title' => 'Detail PDK ' . $pdk,
            'id_pdk' => $id_pdk,
            'pdk' => $pdk,
            'detailpdk' => $detailPdk,
        ];
        return view('Aksesoris/detailPDK', $data);
    }

    // proses input Master Barcode
    public function inputMasterBarcode()
    {
        $id_pdk     = $this->request->getPost("id_pdk");
        $barcode_real  = $this->request->getPost("barcode_real");

        $validate = [
            'id_pdk' => $id_pdk,
            'barcode_real' => $barcode_real,
        ];
        $check = $this->inputModel->cekDuplikatBarcode($validate);
        if (!$check){
            $data = [
                'id_pdk' => $id_pdk,
                'barcode_real' => $barcode_real,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $insert = $this->inputModel->insert($data);
            if ($insert) {
                return redirect()->to(base_url(session()->get('role') . '/dataPDK/'. $id_pdk))->withInput()->with('success', 'Barcode Berhasil Di Input');
            }
            // var_dump($data);
        }else{
            return redirect()->to(base_url(session()->get('role') . '/dataPDK/'. $id_pdk))->withInput()->with('error', 'PDK dengan Barcode tersebut Sudah Ada!');;
        // echo "bbb";
        }
    }





































































































































    
}
