<?php

namespace App\Models;

use CodeIgniter\Model;

class ClansModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'clans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'clan_name', 'created_at', 'created_by'];

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

    protected $clans;

    function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
        $this->clans = $this->db->table('clans');
    }

    function getClanByID($id)
    {
        $clan = $this->clans->where('id', $id)->get()->getRowArray();
        return $clan;
    }

    function getClanBySlug($clanSlug)
    {
        $clan = $this->clans->where('slug', $clanSlug)->get()->getRowArray();
        return $clan;
    }
}
