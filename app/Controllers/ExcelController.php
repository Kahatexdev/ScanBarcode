<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MasterPOModel;
use App\Models\MasterPDKModel;
use App\Models\MasterInputModel;
use App\Models\DetailInputModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\{Border, Alignment, Fill};


class ExcelController extends BaseController
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
        $data = [
            'title' => 'Report PO',
            'active1' => '',
            'active2' => '',
            'active3' => '',
            'active4' => '',
            'active5' => '',
            'active6' => '',
            'active7' => '',
        ];
        return view('Aksesoris/scanBarcode', $data);
    }

    public function export($id_po)
    {
        $data = $this->detailModel->getDataExcel($id_po);
        $scan = $this->detailModel->getQtyScan($id_po);
        $sesuai = $this->detailModel->getQtySesuai($id_po);
        $tdkSesuai = $this->detailModel->getQtyTidakSesuai($id_po);
        $po = $this->poModel->getNomorPO($id_po);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul
        $sheet->setCellValue('A1', 'REPORT SCAN BARCODE');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Informasi tambahan
        $sheet->setCellValue('A3', 'PO');
        $sheet->setCellValue('A4', 'Buyer');
        $sheet->setCellValue('B3', ': ' . $po['po']);
        $sheet->setCellValue('B4', ': ' . $po['buyer']);
        $sheet->setCellValue('E3', 'Qty Scan');
        $sheet->setCellValue('E4', 'Qty Sesuai');
        $sheet->setCellValue('E5', 'Qty Tidak Sesuai');
        $sheet->setCellValue('F3', ': ' . $scan);
        $sheet->setCellValue('F4', ': ' . $sesuai);
        $sheet->setCellValue('F5', ': ' . $tdkSesuai);

        // Set header
        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'PDK');
        $sheet->setCellValue('C6', 'No Order');
        $sheet->setCellValue('D6', 'Barcode Real');
        $sheet->setCellValue('E6', 'Barcode Scan');
        $sheet->setCellValue('F6', 'Status');

        // Gaya untuk header
        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A6:F6')->applyFromArray($headerStyle);

        // Gaya untuk data
        $dataStyle = [
            'font' => [
                'bold' => false,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        // Add data
        $row = 7;
        $no = 1;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $item['pdk']);
            $sheet->setCellValue('C' . $row, $item['no_order']);
            $sheet->setCellValue('D' . $row, $item['barcode_real']);
            $sheet->setCellValue('E' . $row, $item['barcode_cek']);
            $sheet->setCellValue('F' . $row, $item['status']);
            $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($dataStyle);
            $row++;
            $no++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Report_PO_' . $po['po'] . '.xlsx';

        // Save the file to the server and prompt download
        $writer->save(WRITEPATH . $filename);

        return $this->response->download(WRITEPATH . $filename, null)->setFileName($filename);
    }
}
