<?php

namespace App\Controllers;
use App\Models\ClanMembersModel;
use App\Models\ClansModel;

class HomeController extends BaseController
{
    protected $clan;
    protected $clanMembers;

    function __construct()
    {
        $this->clan = new ClansModel();
        $this->clanMembers = new ClanMembersModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Family Tree',
            'clanMembers' => $this->clanMembers->getFamilyTree(99)
        ];
        // echo json_encode($data['clanMembers']);die;
        return view('home', $data);
    }

    public function family($familySlug)
    {
        $clan = $this->clan->getClanBySlug($familySlug);
        
        if(!$clan) {
            return view('not_found', [
                'title' => 'Silsilah Ku',
                'message' => 'Family not found'
            ]);
        }

        $data = [
            'title' => 'Silsilah - ' . $clan['clan_name'],
            'clanMembers' => $this->clanMembers->getFamilyTree($clan['id'])
        ];
        // echo json_encode($data['clanMembers']);die;
        return view('home', $data);
    }
}
