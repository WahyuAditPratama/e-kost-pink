<?php

namespace App\Controllers;

use \Config\App;
use App\Models\AppModel;

class Dashboard extends BaseController
{
	protected $appModel;
	public function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->appModel = new AppModel();
	}

	function index()
	{


		$countcustomer = $this->appModel->total_data('customer');
		$countnotifikasi = $this->appModel->total_data('notifikasi');
		$countroom = $this->appModel->total_data('room');
		$db = db_connect();

		$countbooking = $db->table('booking a')->whereNotIn('a.status', ['draft', 'konfirmasi', 'proses', 'selesai', 'batal'])->get()->getNumRows();

		$query = $db->table('booking a')
			->select('a.*,b.nama_customer,b.telepon,b.alamat,b.email,c.nama_room')
			->join('customer b', 'b.id=a.id_customer', 'left')
			->join('room c', 'c.id=a.id_room', 'left');
		$query->whereNotIn('a.status', ['draft', 'selesai', 'batal']);
		$query->orderBy('id', 'desc');
		$query->limit(0, 10);
		$booking = $query->get()->getResult();

		$data["title"] = "Dashboard";
		$data["countcustomer"] = $countcustomer;
		$data["countnotifikasi"] = $countnotifikasi;
		$data["countroom"] = $countroom;
		$data["countbooking"] = $countbooking;
		$data["bookings"] = $booking;
		return view('dashboard', $data);
	}
}
