<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Notifikasi extends ResourceController
{
    use ResponseTrait;

    protected $builder;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('notifikasi');
    }

    public function index()
    {
        $data = $this->builder
            ->where('dihapus', 0)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        return $this->respond([
            'status' => true,
            'message' => 'List Notifikasi',
            'data' => $data
        ]);
    }

    public function show($id = null)
    {
        $data = $this->builder
            ->where('id', $id)
            ->where('dihapus', 0)
            ->get()
            ->getRow();

        if ($data) {
            return $this->respond([
                'status' => true,
                'message' => 'Detail Notifikasi',
                'data' => $data
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Notifikasi tidak ditemukan'
            ], 404);
        }
    }
}
