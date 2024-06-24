<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\DetailInput;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MasterPOModel;
use App\Models\MasterPDKModel;
use App\Models\MasterInputModel;
use App\Models\DetailInputModel;


class AksesorisController extends BaseController
{
    protected $filters;
    protected $poModel;
    protected $pdkModel;
    protected $inputModel;
    protected $detailModel;
    public function __construct()
    {
        $this->poModel = new MasterPOModel();
        $this->pdkModel = new MasterPDKModel();
        $this->inputModel = new MasterInputModel();
        $this->detailModel = new DetailInputModel();
        if ($this->filters = ['role' => ['aksesoris', session()->get('role')]] !== session()->get('role')) {
            return redirect()->to(base_url('/'));
        }
    }

    public function index()
    {
        $dataPo = $this->poModel->getPo();

        $data = [
            'role'  => session()->get('role'),
            'title' => 'List PO & Buyer',
            'po'    => $dataPo,
        ];
        return view(session()->get('role') . '/halamanUtama', $data);
    }

    // proses input PO
    public function inputPO()
    {
        $po     = $this->request->getPost("po");
        $buyer  = $this->request->getPost("buyer");

        $validate = [
            'po'    => $po,
            'buyer' => $buyer,
        ];
        $check = $this->poModel->cekDuplikatPO($validate);
        if (!$check) {
            $data = [
                'po'            => $po,
                'buyer'         => $buyer,
                'created_at'    => date('Y-m-d H:i:s'),
            ];
            $insert = $this->poModel->insert($data);
            if ($insert) {
                return redirect()->to(base_url(session()->get('role') . ''))->withInput()->with('success', 'Data Berhasil Di Input');
            } else {
                return redirect()->to(base_url(session()->get('role')))->withInput()->with('error', 'Terjadi Kesalahan Saat Menginput Data.');
            }
        } else {
            return redirect()->to(base_url(session()->get('role') . ''))->withInput()->with('error', 'Data PO Sudah Ada!');;
        }
    }
    // proses edit PO
    public function editPO($id_po)
    {
        $id_po  = $this->request->getPost("id_po");
        $po     = $this->request->getPost("po");
        $buyer  = $this->request->getPost("buyer");
        $data = [
            'po'    => $po,
            'buyer' => $buyer
        ];
        $update = $this->poModel->update($id_po, $data);
        if ($update) {
            return redirect()->to(base_url(session()->get('role') . ''))->withInput()->with('success', 'Data Berhasil Di Update');
        } else {
            return redirect()->to(base_url(session()->get('role')))->withInput()->with('error', 'Terjadi Kesalahan Saat Mengupdate Data');
        }
    }
    // proses input PO
    public function hapusPO($id_po)
    {
        $delete = $this->poModel->delete($id_po);
        if ($delete) {
            return redirect()->to(base_url(session()->get('role') . ''))->withInput()->with('success', 'Data PO Berhasil Di Input');
        } else {
            return redirect()->to(base_url(session()->get('role') . ''))->withInput()->with('error', 'Data Gagal Dihapus');
        }
    }


    // detail PO
    public function detailPO($id_po, $po)
    {
        $detailPo   = $this->pdkModel->getDetailPO($id_po);

        $data = [
            'role'      => session()->get('role'),
            'title'     => 'List PDK PO ' . $po,
            'id_po'     => $id_po,
            'po'        => $po,
            'detailpo'  => $detailPo,
        ];
        return view('aksesoris/detailPO', $data);
    }

    // proses input PDK
    public function inputPDK()
    {
        $id_po      = $this->request->getPost("id_po");
        $po         = $this->request->getPost("po");
        $pdk        = $this->request->getPost("pdk");
        $no_order   = $this->request->getPost("no_order");

        $validate = [
            'id_po'     => $id_po,
            'pdk'       => $pdk,
            'no_order'  => $no_order,
        ];
        $check = $this->pdkModel->cekDuplikatPDK($validate);
        if (!$check) {
            $data = [
                'id_po'         => $id_po,
                'pdk'           => $pdk,
                'no_order'      => $no_order,
                'created_at'    => date('Y-m-d H:i:s'),
                'admin'         => session()->get('username'),
            ];
            $insert = $this->pdkModel->insert($data);
            if ($insert) {
                return redirect()->to(base_url(session()->get('role') . '/dataPO/' . $id_po . '/' . $po))->withInput()->with('success', 'Data PDK Berhasil Di Input');
            } else {
                return redirect()->to(base_url(session()->get('role') . '/dataPO/' . $id_po . '/' . $po))->withInput()->with('error', 'Terjadi Kesalahan Saat Menginput Data');
            }
            // var_dump($data);
        } else {
            return redirect()->to(base_url(session()->get('role') . '/dataPO/' . $id_po . '/' . $po))->withInput()->with('error', 'Data PDK Sudah Ada!');
            // echo "bbbb";
        }
    }

    // detail PDK
    public function detailPDK($id_po, $id_pdk)
    {
        $po  = $this->poModel->getNomorPO($id_po);
        $detailPdk  = $this->inputModel->getDetailPDK($id_pdk);
        $pdk        = $this->pdkModel->getPDK($id_pdk);

        // Inisialisasi array untuk menyimpan hasil qtyScan
        $qtyScanResults = [];

        if (!empty($detailPdk)) {
            // Iterasi melalui setiap item dalam $detailPdk
            foreach ($detailPdk as $item) {
                // Mengambil id_data dari item
                $id_data = $item['id_data'];

                // Mendapatkan jumlah scan barcode berdasarkan id_data
                $qtyScan = $this->detailModel->getQtyScanBarcode($id_data);

                // Menyimpan hasil qtyScan ke dalam array dengan id_data sebagai key
                $qtyScanResults[$id_data] = $qtyScan;
            }
        }

        $data = [
            'id_po'     => $id_po,
            'role'      => session()->get('role'),
            'title'     => 'Detail PDK ' . $pdk,
            'id_pdk'    => $id_pdk,
            'pdk'       => $pdk,
            'po'        => $po['po'],
            'detailpdk' => $detailPdk,
            'qtyScanResults' => $qtyScanResults // Menyimpan hasil qtyScan ke dalam data
        ];
        return view('aksesoris/detailPDK', $data);
    }

    // proses input Master Barcode
    public function inputMasterBarcode()
    {
        $id_po          = $this->request->getPost("id_po");
        $id_pdk         = $this->request->getPost("id_pdk");
        $barcode_real   = $this->request->getPost("barcode_real");

        $validate = [
            'id_pdk'        => $id_pdk,
            'barcode_real'  => $barcode_real,
        ];
        $check = $this->inputModel->cekDuplikatBarcode($validate);
        if (!$check) {
            $data = [
                'id_pdk'        => $id_pdk,
                'barcode_real'  => $barcode_real,
                'created_at'    => date('Y-m-d H:i:s'),
            ];
            $insert = $this->inputModel->insert($data);
            if ($insert) {
                return redirect()->to(base_url(session()->get('role') . '/dataPDK/' . $id_po . '/' . $id_pdk))->withInput()->with('success', 'Barcode Berhasil Di Input');
            } else {
                return redirect()->to(base_url(session()->get('role') . '/dataPDK/' . $id_po . '/' . $id_pdk))->withInput()->with('error', 'Barcode Gagal Di Input');
            }
        } else {
            return redirect()->to(base_url(session()->get('role') . '/dataPDK/' . $id_po . '/' . $id_pdk))->withInput()->with('error', 'PDK dengan Barcode tersebut Sudah Ada!');;
        }
    }

    public function scanbarcode($id_data)
    {
        $pdk            = $this->inputModel->getData($id_data);
        $barcodedata    = $this->detailModel->getAllData($id_data);
        $data = [
            'role'          => session()->get('role'),
            'title'         => 'Scan Barcode',
            'master'        => $pdk,
            'barcodeData'   => $barcodedata
        ];
        return view(session()->get('role') . '/scanBarcode', $data);
    }

    public function inputCheckBarcode()
    {
        $barcode_check  = $this->request->getPost("barcode_check");
        $id_data        = $this->request->getPost("id_data");
        $status         = $this->request->getPost("status");
        $data = [
            'id_data'       => $id_data,
            'barcode_cek'   => $barcode_check,
            'status'        => $status,
            'created_at'    => date('Y-m-d H:i:s'),
            'admin'         => session()->get('username'),
        ];
        $insert = $this->detailModel->insert($data);
        if ($insert) {
            return redirect()->to(base_url(session()->get('role') . '/scanBarcode/' . $id_data));
        } else {
            return redirect()->to(base_url(session()->get('role') . '/scanBarcode/' . $id_data))->withInput()->with('error', 'Terjadi Kesalahan Saat Menginput Data');
        }
    }

    //halaman report
    public function report()
    {
        $dataPo = $this->poModel->getPo();

        $data = [
            'role'  => session()->get('role'),
            'title' => 'Report Scan Barcode Per PO',
            'po'    => $dataPo,
        ];
        return view(session()->get('role') . '/reportBarcode', $data);
    }
}
