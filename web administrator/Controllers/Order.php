<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\OrderModel;

class Order extends BaseController
{
	private $models;
	private $appModel;
	function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->appModel = new AppModel();
		$this->models 	= new OrderModel($this->request);
	}

	function index()
	{
		$data["title"] 	= "Order";
		return view('pages/admin/order/order_list', $data);
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
			return view('pages/admin/order/order_detail', $data);
		}
	}



	public function generatetagihan()
	{
		$db = db_connect();

		$currentMonth = date('m');
		$currentYear = date('Y');

		$nextMonth = $currentMonth + 1;
		$nextYear = $currentYear;

		if ($nextMonth > 12) {
			$nextMonth = 1;
			$nextYear++;
		}

		$activeBookings = $db->table('booking')
			->select('id, id_customer, id_room, harga_bulanan')
			->where('status', 'aktif')
			->get()->getResult();

		foreach ($activeBookings as $booking) {
			$existingTagihan = $db->table('tagihan_bulanan')
				->where('id_booking', $booking->id)
				->where('bulan', $nextMonth)
				->where('tahun', $nextYear)
				->get()->getRow();

			if (!$existingTagihan) {
				$dataTagihan = [
					'id_booking' => $booking->id,
					'no_invoice' => 'INV/' . strtoupper(uniqid()),
					'bulan' => $nextMonth,
					'tahun' => $nextYear,
					'due_date' => date('Y-m-d', strtotime("last day of +1 month")),
					'nominal' => $booking->harga_bulanan,
					'status' => 'pending',
					'payment_method' => null,
					'payment_date' => null,
				];

				$db->table('tagihan_bulanan')->insert($dataTagihan);
			}
		}

		$this->session->setFlashdata('info', 'Berhasil generate tagihan di bulan berikutnya!');
		return redirect()->to('order');
	}


	public function konfirmasi($id = null)
	{
		if ($id) {
			$db = db_connect();
			$db->table('tagihan_bulanan')->where('id', $id)->update(['status' => 'lunas']);
			$tagihan = $db->table('tagihan_bulanan')->where('id', $id)->get()->getRow();
			$this->session->setFlashdata('info', 'Tagihan berhasil dikonfirmasi!');
			return redirect()->to('order/detail/' . trim(base64_encode($tagihan->id_booking), '='));
		}
	}

	public function tolak($id = null)
	{
		if ($id) {
			$db = db_connect();
			$db->table('tagihan_bulanan')->where('id', $id)->update(['status' => 'batal']);
			$tagihan = $db->table('tagihan_bulanan')->where('id', $id)->get()->getRow();
			$this->session->setFlashdata('info', 'Tagihan berhasil ditolak!');
			return redirect()->to('order/detail/' . trim(base64_encode($tagihan->id_booking), '='));
		}
	}

	function remove($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->hapusRecord($id, "id", "booking");
			$this->appModel->hapusRecord($id, "id_user", "booking_bidang_jasa");
			$this->session->setFlashdata('info', 'Data berhasil dihapus');
			return redirect()->to('order');
		}
	}

	function activate($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update booking set status='1' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('order');
		}
	}



	function inactive($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update booking set status='0' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('order');
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
				<a id="Edit" type="button" class="btn btn-iconsolid btn-primary btn-xs" href="' . site_url('order/detail/' . trim(base64_encode($rows->id), '=') . '') . '">
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
