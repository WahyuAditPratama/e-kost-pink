<?php

namespace App\Controllers\api;

use App\Models\AppModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Tagihan extends ResourceController
{
    use ResponseTrait;
    private $appModel;
    protected $db;
    protected $builder;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->appModel = new AppModel();

        $this->builder = $this->db->table('booking');
    }

    public function list($id_customer)
    {
        $tagihan = $this->db->table('tagihan_bulanan a')
            ->select(
                'a.id,
             a.no_invoice,
             a.bulan,
             a.tahun,
             a.due_date,
             a.nominal, 
             a.status,
             a.payment_method,
             a.payment_date,
             a.payment_proof,
             a.created_at,
             a.updated_at,
             b.id_customer,
             b.id_room,
             b.start_date,
             b.end_date,
             b.harga_bulanan,
             b.deposit_amount,
             c.nama_customer,
             c.email,
             c.telepon,
             c.tanggal_lahir,
             c.jenis_kelamin,
             c.alamat,
             d.nama_room,
             d.fitur,
             d.deskripsi'
            )
            ->join('booking b', 'b.id = a.id_booking')
            ->join('customer c', 'c.id = b.id_customer')
            ->join('room d', 'd.id = b.id_room')
            ->where('b.id_customer', $id_customer)
            ->whereIn('a.status', ['pending'])
            ->where('a.due_date <= DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH)', null, false)
            ->get()
            ->getResult();


        if ($tagihan) {
            return $this->respond([
                'status' => true,
                'message' => 'Tagihan ditemukan',
                'data' => $tagihan
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Tidak ada tagihan untuk customer ini'
            ], 404);
        }
    }

    public function listadm($id_customer)
    {
        $tagihan = $this->db->table('tagihan_bulanan a')
            ->select(
                'a.id,
             a.no_invoice,
             a.bulan,
             a.tahun,
             a.due_date,
             a.nominal, 
             a.status,
             a.payment_method,
             a.payment_date,
             a.payment_proof,
             a.created_at,
             a.updated_at,
             b.id_customer,
             b.id_room,
             b.start_date,
             b.end_date,
             b.harga_bulanan,
             b.deposit_amount,
             c.nama_customer,
             c.email,
             c.telepon,
             c.tanggal_lahir,
             c.jenis_kelamin,
             c.alamat,
             d.nama_room,
             d.fitur,
             d.deskripsi'
            )
            ->join('booking b', 'b.id = a.id_booking')
            ->join('customer c', 'c.id = b.id_customer')
            ->join('room d', 'd.id = b.id_room')
            ->where('b.id_customer', $id_customer)
            ->get()
            ->getResult();


        if ($tagihan) {
            return $this->respond([
                'status' => true,
                'message' => 'Tagihan ditemukan',
                'data' => $tagihan
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Tidak ada tagihan untuk customer ini'
            ], 404);
        }
    }

    public function lunas($id_customer)
    {
        $tagihan = $this->db->table('tagihan_bulanan a')
            ->select(
                'a.id,
             a.no_invoice,
             a.bulan,
             a.tahun,
             a.due_date,
             a.nominal, 
             a.status,
             a.payment_method,
             a.payment_date,
             a.payment_proof,
             a.created_at,
             a.updated_at,
             b.id_customer,
             b.id_room,
             b.start_date,
             b.end_date,
             b.harga_bulanan,
             b.deposit_amount,
             c.nama_customer,
             c.email,
             c.telepon,
             c.tanggal_lahir,
             c.jenis_kelamin,
             c.alamat,
             d.nama_room,
             d.fitur,
             d.deskripsi'
            )
            ->join('booking b', 'b.id = a.id_booking')
            ->join('customer c', 'c.id = b.id_customer')
            ->join('room d', 'd.id = b.id_room')
            ->where('b.id_customer', $id_customer)
            ->whereIn('a.status', ['paid'])
            ->get()
            ->getResult();


        if ($tagihan) {
            return $this->respond([
                'status' => true,
                'message' => 'Tagihan ditemukan',
                'data' => $tagihan
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Tidak ada tagihan untuk customer ini'
            ], 404);
        }
    }



    public function histori($id_customer)
    {
        $tagihan = $this->db->table('tagihan_bulanan a')
            ->select(
                'a.id,
             a.no_invoice,
             a.bulan,
             a.tahun,
             a.due_date,
             a.nominal, 
             a.status,
             a.payment_method,
             a.payment_date,
             a.payment_proof,
             a.created_at,
             a.updated_at,
             b.id_customer,
             b.id_room,
             b.start_date,
             b.end_date,
             b.harga_bulanan,
             b.deposit_amount,
             c.nama_customer,
             c.email,
             c.telepon,
             c.tanggal_lahir,
             c.jenis_kelamin,
             c.alamat,
             d.nama_room,
             d.fitur,
             d.deskripsi'
            )
            ->join('booking b', 'b.id = a.id_booking')
            ->join('customer c', 'c.id = b.id_customer')
            ->join('room d', 'd.id = b.id_room')
            ->where('b.id_customer', $id_customer)
            ->whereNotIn('a.status', ['pending'])
            ->get()
            ->getResult();

        if ($tagihan) {
            return $this->respond([
                'status' => true,
                'message' => 'Tagihan ditemukan',
                'data' => $tagihan
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Tidak ada tagihan untuk customer ini'
            ], 404);
        }
    }


    public function confirmPayment()
    {
        $id_tagihan = $this->request->getVar('id');
        $payment_method = $this->request->getVar('payment_method');
        $payment_date = date("Y-m-d H:i:s");
        $payment_proof = $this->request->getFile('payment_proof');
        $kode_voucher = $this->request->getFile('kode_voucher');

        if (!$id_tagihan || !$payment_method) {
            return $this->respond([
                'status' => false,
                'message' => 'Missing required fields'
            ]);
        }
        $data = [
            'status' => 'proses',
            'payment_method' => $payment_method,
            'payment_date' => $payment_date,
        ];

        if ($payment_proof && $payment_proof->isValid()) {
            $newName = $payment_proof->getRandomName();
            $path = WRITEPATH . '../public/uploads/bukti_bayar/';
            if (!$payment_proof->move($path, $newName)) {
                return $this->respond([
                    'status' => false,
                    'message' => $payment_proof->getErrorString()
                ]);
            }
            $data['payment_proof'] = $newName;
        }
        $update = $this->db->table('tagihan_bulanan')->where('id', $id_tagihan)->update($data);
        if ($update) {
            return $this->respond([
                'status' => true,
                'message' => 'Payment confirmed successfully'
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Failed to confirm payment'
            ]);
        }
    }


    public function konfirmasitagihan()
    {
        $id         = $this->request->getVar('id_tagihan');
        $stt     = $this->request->getVar('status');

        if ($stt == "terima") {
            $status = 'lunas';
        } else {
            $status = 'batal';
        }
        $tagihan = $this->appModel->detailRecord("tagihan_bulanan", "id='" . $id . "'")->getRow();

        if (!$tagihan) {
            return $this->respond([
                'status' => false,
                'message' => 'Tagihan tidak tersedia',
            ]);
        }

        $this->appModel->manualQuery("UPDATE tagihan_bulanan SET status = '$status' WHERE id = '$id'");
        return $this->respond([
            'status' => true,
            'message' => 'Success',
        ]);
    }
}
