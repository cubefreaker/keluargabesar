<?php

namespace App\Models;
use App\Models\ClanMemberSpousesModel;

use CodeIgniter\Model;

class ClanMembersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'clan_members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'clan_id', 'father_id', 'mother_id', 'name', 'gender', 'phone', 'address', 'birth_date', 'death_date', 'status', 'avatar', 'created_at', 'created_by'];

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

    protected $clanMemberSpouses;

    function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
        $this->clanMembers = $this->db->table('clan_members');
        $this->clanMemberSpouses = new ClanMemberSpousesModel();
    }

    function getMembers($clanId)
    {
        $members = $this->clanMembers->where('clan_id', $clanId)->get()->getResultArray();
        foreach ($members as $key => $value) {
            $members[$key]['father_name'] = $this->getParentsName($value['father_id']);
            $members[$key]['mother_name'] = $this->getParentsName($value['mother_id']);
            $members[$key]['spouse_id']   = $this->getSpouseId($value['id']);
            $members[$key]['spouse_name'] = implode(', ', $this->getSpouseName($value['id']));
            $members[$key]['avatar_url']  = $value['avatar'] ? base_url("assets/img/avatar/foto/{$value['avatar']}") : base_url("assets/img/avatar/default_{$value['gender']}.png");
            $members[$key]['age']         = '-';

            if($value['birth_date']) {
                if($value['death_date'] && $value['status'] == 'D') {
                    $members[$key]['age'] = date_diff(date_create($value['birth_date']), date_create($value['death_date']))->y;
                } else if($value['status'] == 'A'){
                    $members[$key]['age'] = date_diff(date_create($value['birth_date']), date_create('now'))->y;
                }
            }
        }
        return $members;
    }

    function getParentsName($id)
    {
        $parent = $this->clanMembers->select('id, name')->where('id', $id)->get()->getRowArray();
        if(empty($parent)) {
            return '';
        }
        return $parent['name'];
    }

    function getMemberByID($id)
    {
        $member = $this->clanMembers->where('id', $id)->get()->getRowArray();
        return $member;
    }

    function getFamilyTreeByID($id)
    {
        $member = $this->clanMembers->where('id', $id)->get()->getRowArray();
        return $this->mapFamilyTreeFormat($member);
    }

    function getFamilyTree($clanId, $type='chart')
    {
        // $mapFamilyTreeFormat = [];
        $result = [];
        $family = $this->clanMembers->where('clan_id', $clanId)->get()->getResultArray();
        foreach ($family as $member) {
            // $mapFamilyTreeFormat[] = $this->mapFamilyTreeFormat($member);
            $result[] = $this->mapFamilyChartFormat($member);
        }

        // $result = $this->mapRelativeSpouse($mapFamilyTreeFormat);

        return $result;
    }

    function getChildrenId($memberId)
    {
        $children = $this->clanMembers->select('id')->where('father_id', $memberId)->orWhere('mother_id', $memberId)->get()->getResultArray();
        $childrenIds = [];
        foreach ($children as $child) {
            $childrenIds[] = $child['id'];
        }
        return $childrenIds;
    }
    
    function getSpouseId($memberId)
    {
        $spouses = $this->clanMemberSpouses->where('member_id', $memberId)->get()->getResultArray();
        $spouseIds = [];
        foreach ($spouses as $spouse) {
            $spouseIds[] = $spouse['spouse_id'];
        }
        return $spouseIds;
    }

    function getSpouseName($memberId)
    {
        $result = [];
        $spouse = $this->clanMembers->select('clan_member_spouses.member_id, clan_members.name as spouse_name')
                       ->join('clan_member_spouses', 'clan_members.id = clan_member_spouses.spouse_id')
                       ->where('clan_member_spouses.member_id', $memberId)->get()->getResultArray();
        foreach ($spouse as $member) {
            $result[] = $member['spouse_name'];
        }
        return $result;
    }

    function mapFamilyChartFormat($data) 
    {
        $result = [
            'id'    => $data['id'],
            'data'  => [
                'name'     => $data['name'],
                'gender'   => $data['gender'] == 'male' ? 'M' : 'F',
                'birthday' => $data['birth_date'],
                'avatar'   => base_url("assets/img/avatar/default_{$data['gender']}.png")
            ],
            'rels'  => [
                'father'   => $data['father_id'],
                'mother'   => $data['mother_id'],
                'spouses'  => $this->getSpouseId($data['id']),
                'children' => $this->getChildrenId($data['id'])
            ]
        ];
        
        if($data['avatar']) {
            $result['data']['avatar'] = base_url('assets/img/avatar/foto/'.$data['avatar']);
        }

        return $result; 
    }

    function mapFamilyTreeFormat($data)
    {
        $result = [
            'id'     => $data['id'],
            'name'   => $data['name'],
            'gender' => $data['gender'],
            'pids'   => $this->getSpouseId($data['id']),
            'fid'    => $data['father_id'],
            'mid'    => $data['mother_id'],
            'photo'    => base_url('assets/img/avatar/default.png')
        ];

        if($data['avatar']) {
            $result['photo'] = base_url('assets/img/avatar/'.$data['avatar']);
        }

        return $result;        
    }

    function mapRelativeSpouse($data)
    {
        $data = arrayGroupBy($data, 'id');
        $motherHasRelativeSpouse = [];
        foreach ($data as $id => $member) {
            foreach ($member[0]['pids'] as $key => $spouseId) {
                if(($member[0]['fid'] || $member[0]['mid']) && $this->isFamily($spouseId)) {
                    $newSpouse = $this->getFamilyTreeByID($spouseId);
                    $newSpouse['id'] = $spouseId.$id;
                    $newSpouse['fid'] = null;
                    $newSpouse['mid'] = null;

                    $data[$spouseId.$id][] = $newSpouse;
                    $data[$id][0]['pids'][$key] = $newSpouse['id'];

                    if($member[0]['gender'] == 'female') {
                        $motherHasRelativeSpouse[] = $id;
                    }
                }
            }
        }

        if(count($motherHasRelativeSpouse) > 0) {
            $childFromRelativeMother = $this->clanMembers->select('id, father_id')->whereIn('mother_id', array_unique($motherHasRelativeSpouse))->get()->getResultArray();
            foreach ($childFromRelativeMother as $key => $childData) {
                $motherIdBefore = $data[$childData['id']][0]['mid'];
                $data[$childData['id']][0]['mid'] = $motherIdBefore.$childData['father_id'];
            }
        }

        $result = [];
        foreach ($data as $key => $value) {
            $result[] = $value[0];
        }
        return $result;
    }

    function isFamily($memberId)
    {
        $member = $this->clanMembers->where('id', $memberId)->get()->getRowArray();
        return $member['father_id'] || $member['mother_id'];
    }

}
