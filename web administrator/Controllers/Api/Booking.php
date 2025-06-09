<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AppModel;

class Booking extends ResourceController
{
    use ResponseTrait;

    protected $db;
    private $appModel;
    protected $builder;

    public function __construct()
    {
        $this->appModel = new AppModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('booking');
    }

    // GET: List semua booking dengan status konfirmasi / proses
    public function list($id_customer = null)
    {
        $data = $this->db->table('booking a')
            ->select('a.*,
         b.nama_customer,
         b.email,
         b.telepon,
         b.alamat,
         b.nama_customer,
        c.nama_room,
        c.fitur,
        c.deskripsi,
        c.harga_bulanan
        ')
            ->join('customer b', 'b.id = a.id_customer', 'left')
            ->join('room c', 'c.id = a.id_room', 'left')
            // ->whereIn('a.status', ['draft', 'proses',''])
            ->where('id_customer', $id_customer)
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->getResult();

        return $this->respond([
            'status' => true,
            'message' => 'List Booking',
            'data' => $data
        ]);
    }





    // GET: Detail booking berdasarkan id
    public function show($id = null)
    {
        $booking = $this->db->table('booking a')
            ->select('a.*,
             b.nama_customer,
             b.email,
             b.telepon,
             b.alamat,
             b.nama_customer,
            c.nama_room,
            c.fitur,
            c.deskripsi
            c.harga_bulanan
            ')
            ->join('customer b', 'b.id = a.id_customer', 'left')
            ->join('room c', 'c.id = a.id_room', 'left')
            ->where('a.id', $id)
            ->get()
            ->getRow();

        if ($booking) {
            // Cari data tagihan bulanan
            $bulanan = $this->db->table('tagihan_bulanan')
                ->where('id_booking', $booking->id)
                ->get()
                ->getResult();

            $total = 0;
            foreach ($bulanan as $detail) {
                $total += $detail->nominal;
            }

            $booking->bulanan = $bulanan;
            $booking->total = $total;

            return $this->respond([
                'status' => true,
                'message' => 'Detail Booking',
                'data' => $booking
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }
    }

    public function insert()
    {
        $data = [
            'id_customer'    => $this->request->getVar('id_customer'),
            'id_room'        => $this->request->getVar('id_room'),
            'start_date'     => $this->request->getVar('start_date'),
            'end_date'       => $this->request->getVar('end_date'),
            'harga_bulanan'  => $this->request->getVar('harga_bulanan'),
            'deposit_amount' => $this->request->getVar('harga_bulanan'),
            'catatan' => $this->request->getVar('catatan'),
            'status'         => 'draft',
            'created_at'     => date('Y-m-d H:i:s'),
        ];

        $insert = $this->builder->insert($data);

        if ($insert) {
            return $this->respond([
                'status' => true,
                'message' => 'Booking berhasil disimpan!',
                'data' => $data
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Gagal menyimpan booking!'
            ], 500);
        }
    }
    public function confirm()
    {
        $id_booking = $this->request->getVar('id_booking');
        $catatan = $this->request->getVar('catatan');
        $data = [
            'catatan'    => $catatan,
            'status'     => 'proses', // Status yang diupdate
            'updated_at' => date('Y-m-d H:i:s') // Tanggal update
        ];
        $this->builder->where('id', $id_booking);
        $update = $this->builder->update($data);

        if ($update) {
            return $this->respond([
                'status' => true,
                'message' => 'Booking berhasil diperbarui!',
                'data' => $data
            ]);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Gagal memperbarui booking!'
            ], 500);
        }
    }


    public function listadm()
    {
        $data = $this->db->table('booking a')
            ->select('a.*,
         b.nama_customer,
         b.email,
         b.telepon,
         b.alamat,
         b.nama_customer,
         c.nama_room,
        c.fitur,
         c.deskripsi,
        c.harga_bulanan
        ')
            ->join('customer b', 'b.id = a.id_customer', 'left')
            ->join('room c', 'c.id = a.id_room', 'left')
            ->whereNotIn('a.status', ['draft'])
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->getResult();

        return $this->respond([
            'status' => true,
            'message' => 'List Booking',
            'data' => $data
        ]);
    }

    public function listtagihanadm()
    {
        $data = $this->db->table('booking a')
            ->select('a.*,
         b.nama_customer,
         b.email,
         b.telepon,
         b.alamat,
         b.nama_customer,
         c.nama_room,
        c.fitur,
         c.deskripsi,
        c.harga_bulanan
        ')
            ->join('customer b', 'b.id = a.id_customer', 'left')
            ->join('room c', 'c.id = a.id_room', 'left')
            ->whereNotIn('a.status', ['draft', 'proses', 'batal'])
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->getResult();

        return $this->respond([
            'status' => true,
            'message' => 'List Booking',
            'data' => $data
        ]);
    }


    public function konfirmasiadmin()
    {
        $id         = $this->request->getVar('id_booking');
        $stt     = $this->request->getVar('status');

        if ($stt == "terima") {
            $status = 'aktif';
        } else {
            $status = 'batal';
        }
        // $catatan    = $this->request->getVar('catatan');

        // Ambil data booking berdasarkan ID
        $booking = $this->appModel->detailRecord("booking", "id='" . $id . "'")->getRow();

        if (!$booking) {
            return $this->respond([
                'status' => false,
                'message' => 'Booking tidak tersedia',
            ]);
        }

        // Update status booking
        $this->appModel->manualQuery("UPDATE booking SET status = '$status' WHERE id = '$id'");
        $this->appModel->manualQuery("UPDATE room SET status = 'disewa' WHERE id = '" . $booking->id_room . "'");


        if ($status == "aktif") {

            // Generate Tagihan Bulanan
            $tglMulai = new \DateTime($booking->start_date);
            $tglSelesai = $booking->end_date ? new \DateTime($booking->end_date) : null;

            $jmlBulan = 0;
            if ($tglSelesai) {
                $interval = $tglMulai->diff($tglSelesai);
                $jmlBulan = ($interval->y * 12) + $interval->m + 1;
            } else {
                $jmlBulan = 1;
            }
            $hargaBulanan = $booking->harga_bulanan;
            for ($i = 0; $i < $jmlBulan; $i++) {
                $periode = clone $tglMulai;
                $periode->modify("+$i month");
                $bulan = $periode->format('m');
                $tahun = $periode->format('Y');

                $dataTagihan = [
                    'id_booking' => $booking->id,
                    'bulan'      => $bulan,
                    'tahun'      => $tahun,
                    'due_date'   => $periode->format('Y-m-d'),
                    'nominal'    => $hargaBulanan,
                    'status'     => 'pending',
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $idTagihan = $this->appModel->simpanRecord('tagihan_bulanan', $dataTagihan);
                $today = date('md');
                $no_invoice = 'INV-' . $today . str_pad($idTagihan, 4, '0', STR_PAD_LEFT);
                $this->appModel->manualQuery("UPDATE tagihan_bulanan SET no_invoice = '$no_invoice' WHERE id = '$idTagihan'");
            }

            // Insert Notifikasi
            $dataNotif = [
                'penerima'    => $booking->id_customer,
                'pengirim'    => 'Admin Ekost Pink',
                'booking_id'    => $booking->id,
                'parameter'    => 'booking',
                'ref_id'    => $booking->id,
                'judul'         => 'Konfirmasi Booking',
                'pesan'         => 'Booking Anda telah dikonfirmasi dengan status: ' . $status,
                'status'        => 'belum_dibaca',
                'created_at'    => date('Y-m-d H:i:s')
            ];

            $this->appModel->simpanRecord('notifikasi', $dataNotif);
            return $this->respond([
                'status' => true,
                'message' => 'Success',
            ]);
        } else {
            return $this->respond([
                'status' => true,
                'message' => 'pesanan dibatalkan',
            ]);
        }
    }
}
