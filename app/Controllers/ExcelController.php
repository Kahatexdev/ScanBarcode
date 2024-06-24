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
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Informasi tambahan
        $sheet->setCellValue('A3', 'PO');
        $sheet->setCellValue('A4', 'Buyer');
        $sheet->setCellValue('B3', ': ' . $po['po']);
        $sheet->setCellValue('B4', ': ' . $po['buyer']);
        $sheet->setCellValue('G3', 'Qty Scan');
        $sheet->setCellValue('G4', 'Qty Sesuai');
        $sheet->setCellValue('G5', 'Qty Tidak Sesuai');
        $sheet->setCellValue('H3', ': ' . $scan);
        $sheet->setCellValue('H4', ': ' . $sesuai);
        $sheet->setCellValue('H5', ': ' . $tdkSesuai);

        // Set header
        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Tanggal Scan');
        $sheet->setCellValue('C6', 'PDK');
        $sheet->setCellValue('D6', 'No Order');
        $sheet->setCellValue('E6', 'Barcode Real');
        $sheet->setCellValue('F6', 'Barcode Scan');
        $sheet->setCellValue('G6', 'Status');
        $sheet->setCellValue('H6', 'Admin');

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
        $sheet->getStyle('A6:H6')->applyFromArray($headerStyle);

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
            $sheet->setCellValue('B' . $row, $item['created_date']);
            $sheet->setCellValue('C' . $row, $item['pdk']);
            $sheet->setCellValue('D' . $row, $item['no_order']);
            $sheet->setCellValue('E' . $row, $item['barcode_real']);
            $sheet->setCellValue('F' . $row, $item['barcode_cek']);
            $sheet->setCellValue('G' . $row, $item['status']);
            $sheet->setCellValue('H' . $row, $item['admin']);
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray($dataStyle);
            $row++;
            $no++;
        }

        // Set response headers
        $filename = 'Report_PO_' . $po['po'] . '.xlsx';

        // Send the file to browser for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
