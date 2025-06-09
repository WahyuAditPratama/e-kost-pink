<?php

namespace App\Controllers;

use App\Models\AppModel;

class Laporan extends BaseController
{
	private $appModel;
	function __construct()
	{
		parent::__construct();
		//	$this->auth->authenticate();
		$this->appModel = new AppModel();
	}

	function laporan_customer()
	{
		$data["title"] 	= "Booking";
		$data["customers"] 	= $this->appModel->master('customer')->getResult();
		return view('pages/admin/laporan/laporan_customer', $data);
	}


	function cetak_laporan_customer()
	{
		$data["customers"] 	= $this->appModel->master('customer')->getResult();
		return view('pages/admin/laporan/customer_print', $data);
	}


	public function laporan_tagihan()
	{
		$periode_awal = $this->request->getPost('periode_awal');
		$periode_akhir = $this->request->getPost('periode_akhir');
		$db = db_connect();
		$query = $db->table('tagihan_bulanan t')
			->select('t.*, c.nama_customer, r.nama_room')
			->join('booking b', 'b.id = t.id_booking')
			->join('room r', 'r.id = b.id_room')
			->join('customer c', 'c.id = b.id_customer');

		if (strlen($periode_awal) > 0 && strlen($periode_akhir) > 0) {
			$query->where('t.payment_date BETWEEN "' . date('Y-m-d', strtotime($periode_awal)) . '" and "' . date('Y-m-d', strtotime($periode_akhir)) . '"');
		}
		$query->where('t.status', 'lunas');
		$tagihan = $query->get()->getResult();

		$subtotal = 0;
		foreach ($tagihan as $item) {
			$subtotal += $item->nominal;
		}

		$data = array();
		$data['page_title'] = "Laporan Tagihan";
		$data['page'] = "reporttagihan";
		$data['periode_awal'] = $periode_awal;
		$data['periode_akhir'] = $periode_akhir;
		$data['mdata'] = $tagihan;
		$data['subtotal'] = $subtotal; // Menyimpan subtotal
		$data["title"] = "Tagihan";
		$data["tagihans"] = $tagihan;

		return view('pages/admin/laporan/laporan_tagihan', $data);
	}


	public function cetak_laporan_tagihan()
	{
		$periode_awal = $_GET['periode_awal'];
		$periode_akhir = $_GET['periode_akhir'];
		$db = db_connect();
		$query = $db->table('tagihan_bulanan t')
			->select('t.*, c.nama_customer, r.nama_room')
			->join('booking b', 'b.id = t.id_booking', 'left')
			->join('room r', 'r.id = b.id_room', 'left')
			->join('customer c', 'c.id = b.id_customer');


		if (strlen($periode_awal) > 0 && strlen($periode_akhir) > 0) {
			$query->where('t.payment_date BETWEEN "' . date('Y-m-d', strtotime($periode_awal)) . '" and "' . date('Y-m-d', strtotime($periode_akhir)) . '"');
		}
		$query->where('t.status', 'lunas');
		$tagihan = $query->get()->getResult();

		$subtotal = 0;
		foreach ($tagihan as $item) {
			$subtotal += $item->nominal;
		}

		$data = array();
		$data['page_title'] = "Laporan Tagihan";
		$data['page'] = "reporttagihan";
		$data['periode_awal'] = $periode_awal;
		$data['periode_akhir'] = $periode_akhir;
		$data['mdata'] = $tagihan;
		$data['subtotal'] = $subtotal; // Menyimpan subtotal
		$data["title"] = "Tagihan";
		$data["tagihans"] = $tagihan;

		return view('pages/admin/laporan/tagihan_print', $data);
	}
}
