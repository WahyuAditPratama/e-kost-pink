<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\BookingModel;

class Booking extends BaseController
{
	private $models;
	private $appModel;
	function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->appModel = new AppModel();
		$this->models 	= new BookingModel($this->request);
	}

	function index()
	{
		$data["title"] 	= "Booking";
		return view('pages/admin/booking/booking_list', $data);
	}


	function detail($id = null)
	{

		if ($id != null) {
			$id = base64_decode($id);
			$db = db_connect();
			$booking = $db->table('booking a')
				->select('a.*,b.nama_customer,c.nama_room')
				->join('customer b', 'b.id=a.id_customer', 'left')
				->join('room c', 'c.id=a.id_room', 'left')
				->where('a.id', $id)->get()->getRow();
			if ($booking) {
				$total = 0;
				$bulanan = $db->table('tagihan_bulanan')->where('id_booking', $booking->id)->get()->getResult();
				foreach ($bulanan as $detail) {
					$total += $detail->nominal;
				}
				$booking->bulanan = $bulanan;
				$booking->total = $total;
			}

			$data["title"] = "Booking";
			$data["booking"] = $booking;
			return view('pages/admin/booking/booking_detail', $data);
		}
	}


	public function konfirmasi()
	{
		$id         = $this->request->getPost('id');
		$status     = $this->request->getPost('status');
		$catatan    = $this->request->getPost('catatan');
		$booking = $this->appModel->detailRecord("booking", "id='" . $id . "'")->getRow();

		if (!$booking) {
			$this->session->setFlashdata('error', 'Data booking tidak ditemukan!');
			return redirect()->to('booking');
		}

		$this->appModel->manualQuery("UPDATE booking SET status = '$status', catatan = '$catatan' WHERE id = '$id'");
		$this->appModel->manualQuery("UPDATE room SET status = 'disewa' WHERE id = '" . $booking->id_room . "'");

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

		$this->session->setFlashdata('info', 'Berhasil Konfirmasi Pesanan dan Generate Tagihan!');
		return redirect()->to('booking');
	}



	// function on_treatment($id = null)
	// {
	// 	$this->appModel->manualQuery("update booking set status='on_treatment' where id='" . $id . "'");
	// 	$this->session->setFlashdata('info', 'Update status data berhasil !');
	// 	return redirect()->to('booking');
	// }

	// function delivery($id = null)
	// {
	// 	$this->appModel->manualQuery("update booking set status='delivery' where id='" . $id . "'");
	// 	$this->session->setFlashdata('info', 'Update status data berhasil !');
	// 	return redirect()->to('booking');
	// }

	public function selesai($id = null)
	{

		$db = db_connect();
		$bookingUpdate = [
			'id' => $id,
			'status' => 'selesai'
		];
		$this->appModel->updateRecord('booking', $bookingUpdate, 'id');
		$db->table('tagihan_bulanan')->where(['id_booking' => $id, 'status' => 'pending'])->update(['status' => 'batal']);
		$booking = $db->table('booking')->where('id', $id)->get()->getRow();
		if ($booking) {
			$id_room = $booking->id_room;

			$roomUpdate = [
				'id' => $id_room,
				'status' => 'tersedia'
			];
			$this->appModel->updateRecord('room', $roomUpdate, 'id');
		}
		$this->session->setFlashdata('info', 'Update status data berhasil !');
		return redirect()->to('order');
	}




	function create()
	{
		if ($this->request->getPost()) {
			$validasi = [
				'id_customer' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'id_room' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
			];

			if (!$this->validate($validasi)) {
				return redirect()->back()->withInput();
			} else {
				$in["id_customer"] 		= $this->request->getPost('id_customer');
				$in["id_room"] 		= $this->request->getPost('id_room');
				$in["start_date"] 		= $this->request->getPost('start_date');
				$in["end_date"] 		= $this->request->getPost('end_date');
				$in["harga_bulanan"] 		= $this->request->getPost('harga_bulanan');
				$in["deposit_amount"] 	= $this->request->getPost('deposit_amount');
				$in["status"] 	= 'proses';
				$in["created_at"] 	= date('Y-m-d H:i:s');


				$recid				= $this->appModel->simpanRecord("booking", $in);
				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('booking');
			}
		} else {
			$data = array();
			$data["title"]	= "Create Booking";
			$data['customerdata']	= $this->appModel->master("customer");
			$data['roomdata']	= $this->appModel->master("room where status='tersedia'");


			return view('pages/admin/booking/booking_create', $data);
		}
	}

	function edit($id = null)
	{
		if ($this->request->getPost()) {
			$validasi = [
				'id_customer' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'id_room' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
			];
			if (!$this->validate($validasi)) {
				return redirect()->back()->withInput();
			} else {
				$recid			= $this->request->getPost('id');
				$in["id"]		= $recid;
				$in["id_customer"] 		= $this->request->getPost('id_customer');
				$in["id_room"] 		= $this->request->getPost('id_room');
				$in["start_date"] 		= $this->request->getPost('start_date');
				$in["end_date"] 		= $this->request->getPost('end_date');
				$in["harga_bulanan"] 		= $this->request->getPost('harga_bulanan');
				$in["deposit_amount"] 	= $this->request->getPost('deposit_amount');
				$in["updated_at"] 	= date('Y-m-d H:i:s');

				$this->appModel->updateRecord("booking", $in, "id");
				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('booking');
			}
		} else {
			$id = base64_decode($id);
			$data = array();
			$data["title"]		= "Edit Booking";
			$data["mjk"] = ['Laki-Laki', 'Perempuan'];
			$data["mdata"] 		= $this->appModel->detailRecord("booking", "id='" . $id . "'")->getRow();
			return view('pages/admin/booking/booking_edit', $data);
		}
	}


	function remove($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->hapusRecord($id, "id", "booking");
			$this->session->setFlashdata('info', 'Data berhasil dihapus');
			return redirect()->to('booking');
		}
	}

	function activate($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update booking set status='1' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('booking');
		}
	}



	function inactive($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update booking set status='0' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('booking');
		}
	}

	function load()
	{
		$data = array();
		$no = $this->request->getPost('start');
		$list = $this->models->getDatatables();
		foreach ($list as $rows) {

			if ($rows->status == "draft") {
				$status = '<span class="badge bg-primary">Draft</span>';
			} elseif ($rows->status == "konfirmasi") {
				$status = '<span class="badge bg-warning">Menunggu Konfirmasi</span>';
			} elseif ($rows->status == "proses") {
				$status = '<span class="badge bg-warning">Menunggu Konfirmasi</span>';
			} elseif ($rows->status == "aktif") {
				$status = '<span class="badge bg-success">Aktif</span>';
			} elseif ($rows->status == "batal") {
				$status = '<span class="badge bg-danger">Batal</span>';
			} elseif ($rows->status == "selesai") {
				$status = '<span class="badge bg-secondary">Selesai</span>';
			} else {
				$status = '<span class="badge bg-danger">Error...</span>';
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $rows->nama_customer;
			$row[] = $rows->nama_room;
			$row[] = $rows->start_date;
			$row[] = $rows->end_date;
			$row[] = 'Rp ' . number_format($rows->harga_bulanan);
			$row[] = $status;
			$row[] = '
				<a id="Edit" type="button" class="btn btn-iconsolid btn-primary btn-xs" href="' . site_url('booking/detail/' . trim(base64_encode($rows->id), '=') . '') . '">
					<i class="fa fa-search"></i>
				</a>
				';
			$data[] = $row;
		}
		$output = array(
			"draw" => $this->request->getPost('draw'),
			"recordsTotal" => $this->models->countAll(),
			"recordsFiltered" => $this->models->countFiltered(),
			"data" => $data,
		);
		return $this->response->setJSON($output);
	}
}
