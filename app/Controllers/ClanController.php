<?php

namespace App\Controllers;
use App\Models\ClansModel;
use App\Models\ClanMembersModel;
use App\Models\clanMemberSpousesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use CodeIgniter\HTTP\RequestInterface;

use App\Controllers\BaseController;

class ClanController extends BaseController
{
    protected $clans;
    protected $clanMembers;
    protected $clanMemberSpouses;

    function __construct()
    {
        helper(['form', 'url']);
        $this->clans = new ClansModel();
        $this->clanMembers = new ClanMembersModel();
        $this->clanMemberSpouses = new clanMemberSpousesModel();
    }

    public function index()
    {
        if(!logged_in()) {
            return redirect()->to('/login');
        }
        
        return redirect()->to('/memberTree');
    }

    public function clanMemberTree($slug = '')
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

        $clanMembers = $this->clanMembers->getMembers($clan['id']);

        $data = [
            'title' => 'Silsilah - ' . $clan['clan_name'],
            'slug'  => '/' . $clan['slug'],
            'clanName'  => $clan['clan_name'],
            'clanMembers' => $this->clanMembers->getFamilyTree($clan['id'])
        ];

        return view('admin/clan_tree', $data);
    }

    public function clanMember($slug = '')
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

        $clanMembers = $this->clanMembers->getMembers($clan['id']);

        $data = [
            'title' => 'Silsilah - ' . $clan['clan_name'],
            'slug'  => '/' . $clan['slug'],
            'clanName'  => $clan['clan_name'],
            'clanMembers' => mapDatatablesFormat($clanMembers)
        ];

        return view('admin/clan_member', $data);
    }

    public function insert()
    {
        $input = json_decode($this->request->getVar('data'), true);
        
        $dataInput = [
            'clan_id' => user()->clan_id,
            'name' => $input['name'],
            'gender' => $input['gender'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'birth_date' => $input['birth_date'] == '' || $input['birth_date'] == '0000-00-00' ? null : $input['birth_date'],
            'death_date' => $input['death_date'] == '' || $input['death_date'] == '0000-00-00' ? null : $input['death_date'],
            'status' => $input['status'],
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => user()->id
        ];

        if($input['father_id']) {
            $dataInput['father_id'] = $input['father_id'];
        }
        if($input['mother_id']) {
            $dataInput['mother_id'] = $input['mother_id'];
        }

        $memberId = $this->clanMembers->insert($dataInput);

        $imgUpload = $this->uploadImage($memberId);
        if($imgUpload['success']){
            $this->clanMembers->update($memberId, ['avatar' => $imgUpload['data']['random_name']]);
        }

        if($input['spouse_id']) {
            if($input['gender'] == 'male') {
                foreach($input['spouse_id'] as $key => $value) {
                    if(!$this->checkSpouse($memberId, $value)) {
                        $this->clanMemberSpouses->insert([
                            'member_id' => $memberId,
                            'spouse_id' => $value,
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => user()->id
                        ]);
                    }
                    if(!$this->checkSpouse($value, $memberId)) {
                        $this->clanMemberSpouses->insert([
                            'member_id' => $value,
                            'spouse_id' => $memberId,
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => user()->id
                        ]);
                    }
                }
            } else {
                if(!$this->checkSpouse($memberId, $input['spouse_id'])) {
                    $this->clanMemberSpouses->insert([
                        'member_id' => $memberId,
                        'spouse_id' => $input['spouse_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => user()->id
                    ]);
                }
                if(!$this->checkSpouse($input['spouse_id'], $memberId)) {
                    $this->clanMemberSpouses->insert([
                        'member_id' => $input['spouse_id'],
                        'spouse_id' => $memberId,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => user()->id
                    ]);
                }
            }
        }

        return $this->response->setJSON(['status' => 'success']);
    }

    public function update()
    {
        $input = json_decode($this->request->getVar('data'), true);
        
        $dataUpdate = $dataInput = [
            'clan_id' => user()->clan_id,
            'name' => $input['name'],
            'gender' => $input['gender'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'birth_date' => $input['birth_date'] == '' || $input['birth_date'] == '0000-00-00' ? null : $input['birth_date'],
            'death_date' => $input['death_date'] == '' || $input['death_date'] == '0000-00-00' ? null : $input['death_date'],
            'status' => $input['status'],
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => user()->id
        ];
        
        if($input['father_id']) {
            $dataUpdate['father_id'] = $input['father_id'];
        }
        if($input['mother_id']) {
            $dataUpdate['mother_id'] = $input['mother_id'];
        }

        $imgUpload = $this->uploadImage($input['id']);
        if($imgUpload['success']){            
            try {
                unlink(FCPATH . 'assets/img/avatar/foto/' . $input['avatar']);
            } catch (\Exception $e) {
                // do nothing
            }
            $dataUpdate['avatar'] = $imgUpload['data']['random_name'];
        }

        $this->clanMembers->update($input['id'], $dataUpdate);
        $this->clanMemberSpouses->where('member_id', $input['id'])->delete();
        $this->clanMemberSpouses->where('spouse_id', $input['id'])->delete();

        if($input['spouse_id']) {
            if($input['gender'] == 'male') {
                foreach($input['spouse_id'] as $key => $value) {
                    if(!$this->checkSpouse($input['id'], $value)) {
                        $this->clanMemberSpouses->insert([
                            'member_id' => $input['id'],
                            'spouse_id' => $value,
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => user()->id
                        ]);
                    }
                    if(!$this->checkSpouse($value, $input['id'])) {
                        $this->clanMemberSpouses->insert([
                            'member_id' => $value,
                            'spouse_id' => $input['id'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => user()->id
                        ]);
                    }
                }
            } else {
                if(!$this->checkSpouse($input['id'], $input['spouse_id'])) {
                    $this->clanMemberSpouses->insert([
                        'member_id' => $input['id'],
                        'spouse_id' => $input['spouse_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => user()->id
                    ]);
                }
                if(!$this->checkSpouse($input['spouse_id'], $input['id'])) {
                    $this->clanMemberSpouses->insert([
                        'member_id' => $input['spouse_id'],
                        'spouse_id' => $input['id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => user()->id
                    ]);
                }
            }
        }
        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete()
    {
        $id = $this->request->getVar('id');
        $member = $this->clanMembers->find($id);

        $result = [
            'status' => 'success',
            'message' => 'Member deleted successfully',
        ];

        if(!$this->clanMembers->delete($id)) {
            $result = [
                'status' => 'error',
                'message' => 'Failed to delete post',
            ];
        } else {
            try {
                unlink(FCPATH . 'assets/img/avatar/foto/' . $member['avatar']);
            } catch (\Exception $e) {
                // do nothing
            }
        }

        return $this->response->setJSON($result);
    }

    function checkSpouse($id, $spouseId) {
        return $this->clanMemberSpouses->where('member_id', $id)->where('spouse_id', $spouseId)->first();
    }
    
    function uploadImage($id)
    {
        $result = [
            'success' => false,
            'message' => '',
            'data' => [],
        ];
    
        $fileValidation = $this->validate([
            'avatar' => [
                'uploaded[avatar]',
                'mime_in[avatar,image/png,image/jpg,image/jpeg,image/gif]',
                'max_size[avatar,4096]',
            ]
        ]);
        
        if (!$fileValidation) {
            $result['message'] = $this->validator->getError('avatar');
        } else {
            $isFile = $this->request->getFile('avatar');
            if($isFile->getSize() > 0) {
                $randomName = $id . '_' . $isFile->getRandomName();
                $image = \Config\Services::image()
                    ->withFile($isFile)
                    ->resize(150, 150)
                    ->save(FCPATH . 'assets/img/avatar/foto/' . $randomName);

                $fileData = [
                    'file_name' =>  $isFile->getName(),
                    'file_type'  => $isFile->getClientMimeType(),
                    'file_size'  => $isFile->getSize(),
                    'random_name'  => $randomName,                    
                ];

                $result['success'] = true;
                $result['data'] = $fileData;
            }
        }

        return $result;
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

        $dataExport = $this->clanMembers->getMembers($clan['id']);

        $fileName = "Anggota Keluarga {$clan['clan_name']}.xlsx";
        $filePath = FCPATH . 'assets/export/excel/' . $fileName;
        $spreadsheet = new Spreadsheet();
    
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Jenis Kelamin');
        $sheet->setCellValue('D1', 'Suami/Istri');
        $sheet->setCellValue('E1', 'Tanggal Lahir');
        $sheet->setCellValue('F1', 'Ibu');
        $sheet->setCellValue('G1', 'Bapak');
        $sheet->setCellValue('H1', 'No. Telepon');
        $sheet->setCellValue('I1', 'Alamat');
        $sheet->setCellValue('J1', 'Status');
        $sheet->setCellValue('K1', 'Tanggal Meninggal');

        $rows = 2;
        foreach ($dataExport as $key => $value){
            $sheet->setCellValue('A' . $rows, $key+1);
            $sheet->setCellValue('B' . $rows, $value['name']);
            $sheet->setCellValue('C' . $rows, $value['gender'] == 'male' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('D' . $rows, $value['spouse_name']);
            $sheet->setCellValue('E' . $rows, $value['birth_date']);
            $sheet->setCellValue('F' . $rows, $value['mother_name']);
            $sheet->setCellValue('G' . $rows, $value['father_name']);
            $sheet->setCellValue('H' . $rows, $value['phone']);
            $sheet->setCellValue('I' . $rows, $value['address']);
            $sheet->setCellValue('J' . $rows, $value['status'] == 'D' ? 'Meninggal' : 'Hidup');
            $sheet->setCellValue('K' . $rows, $value['death_date']);
            $rows++;
        }

        $sheet->getStyle('A1:K1')->applyFromArray(
            [
                'font' => [
                    'bold' => true
                ]
            ]
        );

        $sheet->getStyle('A1:K' . $rows)->applyFromArray(
            [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ]
            ]
        );
        foreach(range('A','K') as $columnID) {
            if($columnID == 'A') {
                $sheet->getStyle($columnID)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

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
