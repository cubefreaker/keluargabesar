<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClanCashJournalModel;
use App\Models\ClansModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ClanFinanceController extends BaseController
{
    protected $clans;
    protected $clanCash;

    function __construct() {
        helper(['form', 'url']);
        $this->clans = new ClansModel();
        $this->clanCash = new ClanCashJournalModel();
    }

    public function index($slug = '')
    {
        if($slug && !logged_in()) {
            $clan = $this->clans->getClanBySlug($slug);
        } else {
            $clan = $this->clans->getClanById(user()->clan_id);
        }
        
        if(!$clan) {
            return view('not_found', [
                'title' => 'Silsilah Ku',
                'message' => 'Silsilah tidak ditemukan'
            ]);
        }

        
        $clanCash = $this->clanCash->where('clan_id', $clan['id'])->findAll();
        $kasDebit = $this->clanCash->where('type', 'kas')->where('DBCR', 'DB')->where('clan_id', $clan['id'])->select('sum(amount) as total')->first();
        $kasKredit = $this->clanCash->where('type', 'kas')->where('DBCR', 'CR')->where('clan_id', $clan['id'])->select('sum(amount) as total')->first();
        $zisDebit = $this->clanCash->where('type', 'zis')->where('DBCR', 'DB')->where('clan_id', $clan['id'])->select('sum(amount) as total')->first();
        $zisKredit = $this->clanCash->where('type', 'zis')->where('DBCR', 'CR')->where('clan_id', $clan['id'])->select('sum(amount) as total')->first();
        
        $data = [
            'title' => 'Silsilah - ' . $clan['clan_name'],
            'slug'  => '/' . $clan['slug'],
            'clanName'  => $clan['clan_name'],
            'clanCashJournal' => mapDatatablesFormat($clanCash),
            'saldoKas' => $kasDebit['total'] - $kasKredit['total'],
            'saldoZis' => $zisDebit['total'] - $zisKredit['total']
        ];

        return view('admin/clan_cash_journal', $data);
    }

    public function search($slug = '')
    {
        if($slug && !logged_in()) {
            $clan = $this->clans->getClanBySlug($slug);
        } else {
            $clan = $this->clans->getClanById(user()->clan_id);
        }
        
        if(!$clan) {
            return view('not_found', [
                'title' => 'Silsilah Ku',
                'message' => 'Silsilah tidak ditemukan'
            ]);
        }

        $input = $this->request->getVar();
        
        $dateFrom = $input->dateFrom == '' ? '0000-00-00' : $input->dateFrom;
        $dateTo = $input->dateTo == '' ? '9999-12-31' : $input->dateTo;

        if($input->typeCash != 'all') {
            $clanCash = $this->clanCash->where('clan_id', $clan['id'])
                                       ->where('trx_date >=', $dateFrom)
                                       ->where('trx_date <=', $dateTo)
                                       ->where('type', $input->typeCash)->findAll();
        } else {
            $clanCash = $this->clanCash->where('clan_id', $clan['id'])
                                       ->where('trx_date >=', $dateFrom)
                                       ->where('trx_date <=', $dateTo)->findAll();
        }

        echo json_encode(mapDatatablesFormat($clanCash));
    }

    public function insert()
    {
        $input = json_decode($this->request->getVar('data'), true);
        
        $dataInput = [
            'trx_date' => $input['trxDate'] == '' || $input['trxDate'] == '0000-00-00' ? null : $input['trxDate'],
            'amount' => $input['amount'],
            'DBCR' => $input['DBCR'],
            'type' => $input['typeCash'],
            'description' => $input['description'],
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => user()->id
        ];

        $cashId = $this->clanCash->insert($dataInput);
        $status = $cashId ? 'success' : 'failed';
        return $this->response->setJSON(['status' => $status]);
    }

    public function update()
    {
        $input = json_decode($this->request->getVar('data'), true);
        
        $dataUpdate = [
            'trx_date' => $input['trxDate'] == '' || $input['trxDate'] == '0000-00-00' ? null : $input['trxDate'],
            'amount' => $input['amount'],
            'DBCR' => $input['DBCR'],
            'type' => $input['typeCash'],
            'description' => $input['description'],
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => user()->id
        ];

        $update = $this->clanCash->update($input['id'], $dataUpdate);
        $status = $update ? 'success' : 'failed';
        return $this->response->setJSON(['status' => $status]);
    }

    public function delete()
    {
        $id = $this->request->getVar('id');

        $result = [
            'status' => 'success',
            'message' => 'Transaksi berhasil dihapus',
        ];

        if(!$this->clanCash->delete($id)) {
            $result = [
                'status' => 'error',
                'message' => 'Transaksi gagal dihapus',
            ];
        }

        return $this->response->setJSON($result);
    }

    public function exportExcel($slug)
    {
        if($slug && !logged_in()) {
            $clan = $this->clans->getClanBySlug($slug);
        } else {
            $clan = $this->clans->getClanById(user()->clan_id);
        }
        
        if(!$clan) {
            return view('not_found', [
                'title' => 'Silsilah Ku',
                'message' => 'Silsilah tidak ditemukan'
            ]);
        }

        $dataKas = $this->clanCash->where('clan_id', $clan['id'])->where('type', 'kas')->findAll();
        $dataZis = $this->clanCash->where('clan_id', $clan['id'])->where('type', 'zis')->findAll();

        $dataExport = [
            [
                'type' => 'kas',
                'data' => $dataKas
            ],
            [
                'type' => 'zis',
                'data' => $dataZis
            ]
        ];

        $fileName = "Data Kas dan ZIS Keluarga {$clan['clan_name']}.xlsx";
        $filePath = FCPATH . 'assets/export/excel/' . $fileName;
        $spreadsheet = new Spreadsheet();

        foreach($dataExport as $k => $data) {
            if($k > 0) $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex($k);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle(strtoupper($data['type']));

            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'No. Jurnal');
            $sheet->setCellValue('C1', 'Tanggal');
            $sheet->setCellValue('D1', 'Tipe');
            $sheet->setCellValue('E1', 'Note');
            $sheet->setCellValue('F1', 'Debit');
            $sheet->setCellValue('G1', 'Kredit');

            $rows = 2;
            $total = 0;
            foreach ($data['data'] as $key => $value){
                if($value['DBCR'] == 'DB') {
                    $total += $value['amount'];
                } else {
                    $total -= $value['amount'];
                }

                $sheet->setCellValue('A' . $rows, $key+1);
                $sheet->setCellValue('B' . $rows, $value['journal_id']);
                $sheet->setCellValue('C' . $rows, $value['trx_date']);
                $sheet->setCellValue('D' . $rows, strtoupper($value['type']));
                $sheet->setCellValue('E' . $rows, $value['description']);
                $sheet->setCellValue('F' . $rows, $value['DBCR'] == 'DB' ? $value['amount'] : '0');
                $sheet->setCellValue('G' . $rows, $value['DBCR'] == 'CR' ? $value['amount'] : '0');
                $rows++;
            }

            $sheet->mergeCells("B{$rows}:E{$rows}");
            $sheet->mergeCells("F{$rows}:G{$rows}");
            $sheet->setCellValue("B{$rows}", 'Total');
            $sheet->setCellValue("F{$rows}", $total);

            $sheet->getStyle('A1:G1')->applyFromArray(
                [
                    'font' => [
                        'bold' => true
                    ]
                ]
            );

            $sheet->getStyle("A{$rows}:G{$rows}")->applyFromArray(
                [
                    'font' => [
                        'bold' => true
                    ]
                ]
            );

            $sheet->getStyle('A1:G' . $rows)->applyFromArray(
                [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ]
                ]
            );
            

            $sheet->getStyle('F2:G'.$rows)->getNumberFormat()->setFormatCode('"Rp. "#,##0.00_-');

            foreach(range('A','G') as $columnID) {
                if($columnID == 'A') {
                    $sheet->getStyle($columnID)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                } else if(in_array($columnID, ['F', 'G'])) {
                    $sheet->getStyle($columnID)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                }
                
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            $sheet->getStyle('F'.$rows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize($filePath));
		flush();
		readfile($filePath);
		exit;        
    }
}
