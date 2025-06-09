<?php

namespace App\Controllers;

use \Config\App;
use App\Models\AppModel;

class Pengguna extends BasePenggunaController
{
	protected $appModel;
	public function __construct()
	{
		parent::__construct();
		$this->appModel = new AppModel();
	}


	function profile()
	{
		if ($this->request->getPost()) {
			$validasi = [
				'nama_customer' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'email' => [
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
				$in["nama_customer"] 		= $this->request->getPost('nama_customer');
				$in["email"] 		= $this->request->getPost('email');
				$in["telepon"] 		= $this->request->getPost('telepon');
				$in["tanggal_lahir"] 		= $this->request->getPost('tanggal_lahir');
				$in["jenis_kelamin"] 		= $this->request->getPost('jenis_kelamin');
				$in["alamat"] 	= $this->request->getPost('alamat');
				$in["username"] 		= $this->request->getPost('username');

				if (strlen($this->request->getPost('password')) > 0) {
					$in["password"] 	= password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
				}
				$in["updated_at"] 	= date('Y-m-d H:i:s');

				if (!empty($_FILES['avatar']['name'])) {
					$xfile = $this->request->getFile('avatar');
					$imagex = \Config\Services::image();
					$imagex->withFile($xfile);
					$imagex->resize(320, 320, true, 'height');
					$filename = $this->auth->userid . $xfile->getRandomName();
					$filepath = ROOTPATH . 'public/uploads/users/';
					$imagex->save($filepath . $filename);
					$in['avatar'] = $filename;
				}


				$this->appModel->updateRecord("customer", $in, "id");
				$this->session->setFlashdata('info', 'Berhasil Update Akun !');
				return redirect()->to('pengguna/profile');
			}
		} else {

			$data["title"] = "Dashboard";
			$data["muser"] = $this->appModel->master("customer where id='" . $this->auth->userid . "'")->getRow();
			$data["mjk"] = ['Laki-Laki', 'Perempuan'];

			return view('frontend/pengguna/profile', $data);
		}
	}



	function booking()
	{
		$data["title"] = "Dashboard";
		$data["roomdata"] = $this->appModel->master("room order by id")->getResult();
		$data["muser"] = $this->appModel->master("customer where id='" . $this->auth->userid . "'")->getRow();

		return view('frontend/pengguna/booking', $data);
	}

	public function addtocart()
	{
		$in["invoice"] 		= $this->generateInvoiceNumber();
		$in["tanggal"] 		= date('Y-m-d H:i:s');
		$in["id_customer"] 	= $this->auth->userid;
		$in["alamat"] 	= $this->request->getPost('alamat');
		$in["status"] 	= 'draft';
		$in["created_at"] 	= date('Y-m-d H:i:s');;

		$recid = $this->appModel->simpanRecord("booking", $in);
		$mbooking = $this->appModel->master("booking where id='" . $recid . "'")->getRow();

		if ($mbooking) {

			$invoice = $mbooking->invoice;
			$nama_barang = $this->request->getPost('nama_barang');
			$deskripsi = $this->request->getPost('deskripsi');
			$catatan = $this->request->getPost('catatan');
			$room = $this->request->getPost('room');

			for ($i = 0; $i < count($nama_barang); $i++) {
				$data = [
					'invoice' => $invoice,
					'nama_barang' => $nama_barang[$i],
					'deskripsi' => $deskripsi[$i],
					'catatan' => $catatan[$i],
				];

				$reciddetail = $this->appModel->simpanRecord("booking_detail", $data);

				if (isset($room[$i])) {
					foreach ($room[$i] as $id_room) {
						$mroom = $this->appModel->master("room where id='" . $id_room . "'")->getRow();
						$this->appModel->simpanRecord("booking_detail_room", [
							'invoice' => $invoice,
							'id_detail' => $reciddetail,
							'id_room' => $id_room,
							'nominal' => $mroom->harga_bulanan,
						]);
					}
				}
			}
		}
		$this->session->setFlashdata('info', 'Berhasil Tambah Ke Cart !');
		return redirect()->to('pengguna/cart');
	}

	function cart()
	{

		$db = db_connect();
		$bookings = $db->table('booking')->where('status', 'draft')->where('id_customer', $this->auth->userid)->get()->getResult();

		if ($bookings) {
			foreach ($bookings as $booking) {
				$total = 0;
				$details = $db->table('booking_detail')->where('invoice', $booking->invoice)->get()->getResult();

				foreach ($details as $detail) {
					$rooms = $db->table('booking_detail_room a')
						->select('a.*, b.nama_room')
						->join('room b', 'b.id = a.id_room', 'left')
						->where('a.invoice', $booking->invoice)
						->where('a.id_detail', $detail->id)
						->get()->getResult();

					$detailTotal = array_reduce($rooms, function ($carry, $item) {
						return $carry + $item->nominal;
					}, 0);

					$total += $detailTotal;
					$detail->room = $rooms;
				}

				$booking->detail = $details;
				$booking->total = $total;
			}
		}

		//	return json_encode($bookings);

		$data["title"] = "Dashboard";
		$data["bookings"] = $bookings;
		return view('frontend/pengguna/cart', $data);
	}

	function checkout($invoice = null)
	{

		$db = db_connect();
		$booking = $db->table('booking')->where('invoice', $invoice)->get()->getRow();
		if ($booking) {
			$total = 0;
			$details = $db->table('booking_detail')->where('invoice', $booking->invoice)->get()->getResult();

			foreach ($details as $detail) {
				$rooms = $db->table('booking_detail_room a')
					->select('a.*, b.nama_room')
					->join('room b', 'b.id = a.id_room', 'left')
					->where('a.invoice', $booking->invoice)
					->where('a.id_detail', $detail->id)
					->get()->getResult();

				$detailTotal = array_reduce($rooms, function ($carry, $item) {
					return $carry + $item->nominal;
				}, 0);

				$total += $detailTotal;
				$detail->room = $rooms;
			}

			$booking->detail = $details;
			$booking->total = $total;
		}

		//	return json_encode($bookings);

		$data["title"] = "Dashboard";
		$data["booking"] = $booking;
		$data["muser"] = $this->appModel->master("customer where id='" . $this->auth->userid . "'")->getRow();
		$data["mbank"] = $this->appModel->master("user_bank where status ='aktif'")->getResult();
		return view('frontend/pengguna/checkout', $data);
	}

	public function konfirmasi()
	{
		$invoice 		= $this->request->getPost('invoice');
		$total 		=  $this->request->getPost('total');
		$payment_method 		=  $this->request->getPost('payment_method');
		$mbank = $this->appModel->master("user_bank where status ='aktif' order by id desc limit 1")->getRow();


		$in["invoice"] 	= $invoice;
		$in["payment_method"] 	= $payment_method;
		$in["nominal"] 	= $total;
		$in["status"] 	= 'proses';
		$in["id_bank"] 	= $mbank->id;
		$in["created_at"] 	= date('Y-m-d H:i:s');

		$recid = $this->appModel->simpanRecord("booking_payment", $in);
		$this->appModel->manualQuery("update booking set status='proses',total='" . $total . "' where invoice='" . $invoice . "'");


		$pesan 			= "Pesanann masuk no . " . $invoice . ". Segera konfirmasi Booking dari pelanggan";
		$roles 			= 'administrator';
		$pengirim 		= $this->session->get('userid');
		$judul 			= "Pesanann masuk no . " . $invoice;
		$parameter 		= 'booking';
		$ref_id 		= $invoice;
		$by 			= $this->session->get('nama');

		$fieldsNotif 	= array(
			"pesan" 	 => $pesan,
			"roles" 	  => $roles,
			"penerima"   => 'Staff Toko',
			"pengirim" 	 => $pengirim,
			"judul" 	 => $judul,
			"parameter"  => $parameter,
			"ref_id" 	 => $ref_id,
			"created_at"	 => date("Y-m-d H:i:s"),
			"created_by" => $by,
		);

		$this->appModel->insertNotifikasi($fieldsNotif);


		$this->session->setFlashdata('info', 'Berhasil Tambah Konfirmasi Pembayaran !');
		return redirect()->to('pengguna/profile');
	}
	function removeitem($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->hapusRecord($id, "id", "booking_detail_room");
			$this->session->setFlashdata('info', 'Data berhasil dihapus');
			return redirect()->to('pengguna/cart');
		}
	}


	function cancel($invoice = null)
	{
		$this->appModel->manualQuery("update booking set status='batal' where invoice='" . $invoice . "'");
		$this->session->setFlashdata('info', 'Update status data berhasil !');
		return redirect()->to('pengguna/cart');
	}

	function order()
	{

		$db = db_connect();
		$bookings = $db->table('booking')->whereNotIn('status', ['draft', 'batal', 'selesai'])->where('id_customer', $this->auth->userid)->get()->getResult();
		if ($bookings) {
			foreach ($bookings as $booking) {
				$total = 0;
				$details = $db->table('booking_detail')->where('invoice', $booking->invoice)->get()->getResult();

				foreach ($details as $detail) {
					$rooms = $db->table('booking_detail_room a')
						->select('a.*, b.nama_room')
						->join('room b', 'b.id = a.id_room', 'left')
						->where('a.invoice', $booking->invoice)
						->where('a.id_detail', $detail->id)
						->get()->getResult();

					$detailTotal = array_reduce($rooms, function ($carry, $item) {
						return $carry + $item->nominal;
					}, 0);

					$total += $detailTotal;
					$detail->room = $rooms;
				}

				$booking->detail = $details;
				$booking->total = $total;
			}
		}

		//	return json_encode($bookings);

		$data["title"] = "Dashboard";
		$data["bookings"] = $bookings;
		$data["muser"] = $this->appModel->master("customer where id='" . $this->auth->userid . "'")->getRow();
		return view('frontend/pengguna/order', $data);
	}



	function detail($invoice = null)
	{
		$db = db_connect();
		$booking = $db->table('booking')->where('invoice', $invoice)->get()->getRow();
		$bookingpayment = $db->table('booking_payment')->where('invoice', $invoice)->get()->getRow();
		if ($booking) {
			$total = 0;
			$details = $db->table('booking_detail')->where('invoice', $booking->invoice)->get()->getResult();

			foreach ($details as $detail) {
				$rooms = $db->table('booking_detail_room a')
					->select('a.*, b.nama_room')
					->join('room b', 'b.id = a.id_room', 'left')
					->where('a.invoice', $booking->invoice)
					->where('a.id_detail', $detail->id)
					->get()->getResult();

				$detailTotal = array_reduce($rooms, function ($carry, $item) {
					return $carry + $item->nominal;
				}, 0);

				$total += $detailTotal;
				$detail->room = $rooms;
			}

			$booking->detail = $details;
			$booking->total = $total;
		}

		//	return json_encode($bookings);

		$data["title"] = "Dashboard";
		$data["booking"] = $booking;
		$data["bookingpayment"] = $bookingpayment;
		$data["muser"] = $this->appModel->master("customer where id='" . $this->auth->userid . "'")->getRow();
		if ($bookingpayment) {
			$data["mbank"] = $this->appModel->master("user_bank where id='" . $bookingpayment->id_bank . "'")->getRow();
		}
		return view('frontend/pengguna/detail', $data);
	}


	function cetak_invoice($invoice = null)
	{
		$db = db_connect();
		$booking = $db->table('booking')->where('invoice', $invoice)->get()->getRow();
		$bookingpayment = $db->table('booking_payment')->where('invoice', $invoice)->get()->getRow();
		if ($booking) {
			$total = 0;
			$details = $db->table('booking_detail')->where('invoice', $booking->invoice)->get()->getResult();

			foreach ($details as $detail) {
				$rooms = $db->table('booking_detail_room a')
					->select('a.*, b.nama_room')
					->join('room b', 'b.id = a.id_room', 'left')
					->where('a.invoice', $booking->invoice)
					->where('a.id_detail', $detail->id)
					->get()->getResult();

				$detailTotal = array_reduce($rooms, function ($carry, $item) {
					return $carry + $item->nominal;
				}, 0);

				$total += $detailTotal;
				$detail->room = $rooms;
			}

			$booking->detail = $details;
			$booking->total = $total;
		}

		//	return json_encode($bookings);

		$data["title"] = "Dashboard";
		$data["booking"] = $booking;
		$data["bookingpayment"] = $bookingpayment;
		$data["muser"] = $this->appModel->master("customer where id='" . $this->auth->userid . "'")->getRow();
		if ($bookingpayment) {

			$data["mbank"] = $this->appModel->master("user_bank where id='" . $bookingpayment->id_bank . "'")->getRow();
		}
		return view('frontend/pengguna/cetak_invoice', $data);
	}


	function histori()
	{

		$db = db_connect();
		$bookings = $db->table('booking')->whereIn('status', ['batal', 'selesai'])->where('id_customer', $this->auth->userid)->get()->getResult();
		if ($bookings) {
			foreach ($bookings as $booking) {
				$total = 0;
				$details = $db->table('booking_detail')->where('invoice', $booking->invoice)->get()->getResult();

				foreach ($details as $detail) {
					$rooms = $db->table('booking_detail_room a')
						->select('a.*, b.nama_room')
						->join('room b', 'b.id = a.id_room', 'left')
						->where('a.invoice', $booking->invoice)
						->where('a.id_detail', $detail->id)
						->get()->getResult();

					$detailTotal = array_reduce($rooms, function ($carry, $item) {
						return $carry + $item->nominal;
					}, 0);

					$total += $detailTotal;
					$detail->room = $rooms;
				}

				$booking->detail = $details;
				$booking->total = $total;
			}
		}

		//	return json_encode($bookings);

		$data["title"] = "Dashboard";
		$data["bookings"] = $bookings;
		$data["muser"] = $this->appModel->master("customer where id='" . $this->auth->userid . "'")->getRow();
		return view('frontend/pengguna/histori', $data);
	}



	public function generateInvoiceNumber()
	{
		$currentMonth = date('m');
		$currentYear = date('Y');
		$db = db_connect();
		$builder = $db->table('booking');
		$builder->where('MONTH(created_at)', $currentMonth);
		$builder->where('YEAR(created_at)', $currentYear);
		$invoiceCount = $builder->countAllResults();
		$invoiceNumber = sprintf('INV%s%s%03d', $currentMonth, $currentYear, $invoiceCount + 1);
		return $invoiceNumber;
	}
}
