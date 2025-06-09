<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Auth extends ResourceController
{
    use ResponseTrait;

    protected $db;
    protected $builder;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('customer');
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $mdata = $this->builder
            ->where('username', $username)
            ->get()
            ->getRow();


        if ($mdata) {
            if (password_verify($password, $mdata->password)) {
                return $this->respond([
                    'status' => true,
                    'message' => 'success',
                    'data' => $mdata
                ]);
            } else {
                return $this->respond([
                    'status' => false,
                    'message' => 'Unauthorized 2'
                ], 401);
            }
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function loginUser()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $mdata = $this->db->table('users')
            ->where('username', $username)
            ->get()
            ->getRow();


        if ($mdata) {
            if (password_verify($password, $mdata->password)) {
                return $this->respond([
                    'status' => true,
                    'message' => 'success',
                    'data' => $mdata
                ]);
            } else {
                return $this->respond([
                    'status' => false,
                    'message' => 'Unauthorized 2'
                ], 401);
            }
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Unauthorized',
                'mdata' => $mdata
            ], 401);
        }
    }



    public function register()
    {
        $data = [
            'nama_customer' => $this->request->getVar('nama_customer'),
            'email' => $this->request->getVar('email', FILTER_SANITIZE_EMAIL),
            'telepon' => $this->request->getVar('telepon',),
            'username' => $this->request->getVar('username',),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'alamat' => $this->request->getVar('alamat',),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir',),
            'avatar' => 'user.png',
            'status' => 'Aktif',
        ];

        $insert = $this->builder->insert($data);

        if ($insert) {
            return $this->respond([
                'status' => true,
                'message' => 'success',
                'data' => $data
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Failed'
            ]);
        }
    }

    public function profile($id = null)
    {
        $data = $this->builder->where('id_customer', $id)->get()->getRow();

        if ($data) {
            return $this->respond([
                'status' => true,
                'message' => 'success',
                'data' => $data
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Failed'
            ]);
        }
    }

    public function updateprofile()
    {
        $id = $this->request->getVar('id_customer', FILTER_SANITIZE_STRING);

        $data = [
            'nama' => $this->request->getVar('nama', FILTER_SANITIZE_STRING),
            'email' => $this->request->getVar('email', FILTER_SANITIZE_EMAIL),
            'telepon' => $this->request->getVar('telepon', FILTER_SANITIZE_STRING),
            'username' => $this->request->getVar('username', FILTER_SANITIZE_STRING),
            'alamat' => $this->request->getVar('alamat', FILTER_SANITIZE_STRING),
            'tempat_lahir' => $this->request->getVar('tempat_lahir', FILTER_SANITIZE_STRING),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir', FILTER_SANITIZE_STRING),
        ];

        $update = $this->builder->where('id_customer', $id)->update($data);

        $mdata = $this->builder->where('id_customer', $id)->get()->getRow();

        if ($update) {
            return $this->respond([
                'status' => true,
                'message' => 'success',
                'data' => $mdata
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Failed'
            ]);
        }
    }

    public function updatepassword()
    {
        $id = $this->request->getVar('id_customer', FILTER_SANITIZE_STRING);

        $data = [
            'password' => $this->request->getVar('password', FILTER_SANITIZE_STRING),
        ];

        $update = $this->builder->where('id_customer', $id)->update($data);

        $mdata = $this->builder->where('id_customer', $id)->get()->getRow();

        if ($update) {
            return $this->respond([
                'status' => true,
                'message' => 'success',
                'data' => $mdata
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Failed'
            ]);
        }
    }

    public function updateavatar()
    {
        $id = $this->request->getVar('id_customer');
        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->isValid()) {
            $newName = $avatar->getRandomName();
            $path = WRITEPATH . '../public/uploads/customer/';
            if (!$avatar->move($path, $newName)) {
                return $this->respond([
                    'status' => false,
                    'message' => $avatar->getErrorString()
                ]);
            }
            $data = ['avatar' => $newName];
            $update = $this->builder->where('id_customer', $id)->update($data);
            $mdata = $this->builder->where('id_customer', $id)->get()->getRow();
            if ($update) {
                return $this->respond([
                    'status' => true,
                    'message' => 'success',
                    'data' => $mdata
                ]);
            } else {
                return $this->respond([
                    'status' => false,
                    'message' => 'Failed updating avatar'
                ]);
            }
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'No file uploaded'
            ]);
        }
    }
}
