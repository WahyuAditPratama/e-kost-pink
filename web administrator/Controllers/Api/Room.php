<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Room extends ResourceController
{
    use ResponseTrait;

    protected $builder;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('room');
    }

    // Ambil semua room
    public function list()
    {
        $data = $this->builder
            ->orderBy('id', 'ASC')
            ->get()
            ->getResult();

        return $this->respond([
            'status' => true,
            'message' => 'List Room',
            'data' => $data
        ]);
    }

    // Ambil detail room berdasarkan id
    public function show($id = null)
    {
        $data = $this->builder
            ->where('id', $id)
            ->get()
            ->getRow();

        if ($data) {
            return $this->respond([
                'status' => true,
                'message' => 'Detail Room',
                'data' => $data
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Room tidak ditemukan'
            ], 404);
        }
    }
}
