<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Auth;

class AppModel extends Model
{
	var $auth;
	var $year;
	protected $table = 'proposal';

	public function __construct()
	{
		parent::__construct();
		$this->auth = new Auth();
		$this->year = date('Y');
	}

	function manualQuery($q)
	{
		return $this->db->query($q);
	}

	function master($master)
	{
		$q = $this->db->query("select * from $master");
		return $q;
	}

	function simpanRecord($tabel, $data)
	{
		$this->db->table($tabel)->insert($data);
		if ($this->db->affectedRows() == 1) {
			return $this->db->insertID();
		} else {
			return false;
		}
	}
	function editRecord($tabel, $seleksi)
	{
		return $this->db->query("select * from $tabel where $seleksi");
	}

	function detailRecord($tabel, $seleksi)
	{
		return $this->db->query("select * from $tabel where $seleksi");
	}

	function updateRecord($tabel, $isi, $seleksi)
	{
		$this->db->table($tabel)->where($seleksi, $isi[$seleksi])->update($isi);
		return ($this->db->affectedRows() != 1) ? false : true;
	}

	function hapusRecord($id, $seleksi, $tabel)
	{
		$this->db->table($tabel)->where($seleksi, $id)->delete();
		return ($this->db->affectedRows() != 1) ? false : true;
	}

	function recordDetail($tabel, $seleksi)
	{
		return $this->db->query("select * from $tabel where $seleksi limit 1");
	}

	function total_data($tabel)
	{
		$query = $this->db->query("SELECT * FROM $tabel");
		return $query->getNumRows();
	}

	function cekUsername($username = null)
	{
		$query = $this->db->query("SELECT a.id FROM users a WHERE a.username='" . $username . "'");
		$status = ($query->getNumRows() > 0) ? false : true;
		return $status;
	}

	function insert_batch($table, $data)
	{
		$this->builder = $this->db->table($table);
		$process = $this->builder->insertBatch($data);
		if ($process) {
			return true;
		} else {
			return false;
		}
	}

	function update_batch($table, $data, $key)
	{
		$this->builder = $this->db->table($table);
		$process = $this->builder->updateBatch($data, $key);
		if ($process) {
			return true;
		} else {
			return false;
		}
	}


	// Fungsi untuk membuat tagihan bulanan (bisa dijadwalkan lewat cron job)
	public function generateMonthlyInvoices()
	{
		// Ambil semua penyewaan aktif
		$activeBookings = $this->penyewaanModel->where('status', 'aktif')->findAll();

		$nextMonth = date('m', strtotime('+1 month'));
		$nextYear = date('Y', strtotime('+1 month'));
		$dueDate = date('Y-m-05', strtotime('+1 month')); // Jatuh tempo tiap tanggal 5

		$generatedCount = 0;

		foreach ($activeBookings as $booking) {
			// Cek apakah tagihan untuk bulan depan sudah ada
			$existingInvoice = $this->tagihanModel
				->where('id_penyewaan', $booking['id'])
				->where('bulan', $nextMonth)
				->where('tahun', $nextYear)
				->first();

			if (!$existingInvoice) {
				// Buat tagihan baru
				$invoiceData = [
					'id_penyewaan' => $booking['id'],
					'bulan' => $nextMonth,
					'tahun' => $nextYear,
					'tanggal_jatuh_tempo' => $dueDate,
					'jumlah' => $booking['harga_bulanan'],
					'status' => 'menunggu'
				];

				$this->tagihanModel->insert($invoiceData);
				$generatedCount++;

				// Kirim notifikasi ke pelanggan
				$notificationData = [
					'penerima' => $booking['id_pelanggan'],
					'judul' => 'Tagihan Bulanan',
					'pesan' => 'Tagihan sewa kamar untuk bulan ' . date('F Y', strtotime('+1 month')) . ' sudah tersedia. Jumlah: Rp ' . number_format($booking['harga_bulanan'], 0, ',', '.'),
					'id_penyewaan' => $booking['id'],
					'id_tagihan' => $this->tagihanModel->getInsertID()
				];

				$this->notifikasiModel->insert($notificationData);
			}
		}

		// Jika diakses via HTTP (bukan cron job)
		if ($this->request->getMethod() === 'get') {
			return redirect()->to('/admin/tagihan')->with('success', 'Berhasil membuat ' . $generatedCount . ' tagihan bulanan');
		}

		return $generatedCount;
	}

	// Fungsi untuk konfirmasi pembayaran (seperti contoh Anda, tapi untuk tagihan)
	public function konfirmasiPembayaran()
	{
		$id = $this->request->getPost('id');
		$status = $this->request->getPost('status');
		$catatan = $this->request->getPost('catatan');
		$metode = $this->request->getPost('metode_pembayaran');

		// Jika status lunas dan metode transfer, perlu bukti pembayaran
		if ($status === 'lunas' && $metode === 'Transfer Bank') {
			$file = $this->request->getFile('bukti_pembayaran');

			if ($file->isValid() && !$file->hasMoved()) {
				$newName = $file->getRandomName();
				$file->move(ROOTPATH . 'public/uploads/bukti_pembayaran', $newName);

				$data = [
					'status' => $status,
					'catatan' => $catatan,
					'metode_pembayaran' => $metode,
					'bukti_pembayaran' => $newName,
					'tanggal_pembayaran' => date('Y-m-d H:i:s')
				];
			}
		} else {
			$data = [
				'status' => $status,
				'catatan' => $catatan,
				'metode_pembayaran' => $metode,
				'tanggal_pembayaran' => ($status === 'lunas') ? date('Y-m-d H:i:s') : null
			];
		}

		$this->tagihanModel->update($id, $data);

		// Kirim notifikasi ke pelanggan
		$invoice = $this->tagihanModel->find($id);
		$notificationData = [
			'penerima' => $this->penyewaanModel->find($invoice['id_penyewaan'])['id_pelanggan'],
			'judul' => 'Konfirmasi Pembayaran',
			'pesan' => 'Pembayaran tagihan Anda telah dikonfirmasi sebagai ' . $status . '. Catatan: ' . $catatan,
			'id_tagihan' => $id
		];
		$this->notifikasiModel->insert($notificationData);

		return redirect()->to('/admin/tagihan')->with('success', 'Berhasil mengkonfirmasi pembayaran');
	}

	// Fungsi untuk mengecek tagihan terlambat (bisa dijadwalkan harian)
	public function checkOverdueInvoices()
	{
		$overdueInvoices = $this->tagihanModel
			->where('status', 'menunggu')
			->where('tanggal_jatuh_tempo <', date('Y-m-d'))
			->findAll();

		$updatedCount = 0;

		foreach ($overdueInvoices as $invoice) {
			$this->tagihanModel->update($invoice['id'], ['status' => 'terlambat']);
			$updatedCount++;

			// Kirim notifikasi ke pelanggan
			$notificationData = [
				'penerima' => $this->penyewaanModel->find($invoice['id_penyewaan'])['id_pelanggan'],
				'judul' => 'Tagihan Terlambat',
				'pesan' => 'Tagihan Anda untuk bulan ' . $invoice['bulan'] . '/' . $invoice['tahun'] . ' telah terlambat. Segera lakukan pembayaran.',
				'id_tagihan' => $invoice['id']
			];
			$this->notifikasiModel->insert($notificationData);
		}

		// Cek jika ada yang terlambat 2 bulan atau lebih
		$twoMonthsOverdue = $this->tagihanModel
			->select('id_penyewaan, COUNT(*) as jumlah_tagihan_terlambat')
			->where('status', 'terlambat')
			->where('tanggal_jatuh_tempo >=', date('Y-m-d', strtotime('-60 days')))
			->groupBy('id_penyewaan')
			->having('jumlah_tagihan_terlambat >=', 2)
			->findAll();

		foreach ($twoMonthsOverdue as $booking) {
			// Hentikan penyewaan
			$this->penyewaanModel->update($booking['id_penyewaan'], [
				'status' => 'dihentikan',
				'tanggal_berakhir' => date('Y-m-d')
			]);

			// Update status kamar menjadi tersedia
			$penyewaan = $this->penyewaanModel->find($booking['id_penyewaan']);
			$this->roomModel->update($penyewaan['id_kamar'], ['status' => 'tersedia']);

			// Kirim notifikasi
			$notificationData = [
				'penerima' => $penyewaan['id_pelanggan'],
				'judul' => 'Penyewaan Dihentikan',
				'pesan' => 'Penyewaan kamar Anda telah dihentikan karena keterlambatan pembayaran selama 2 bulan berturut-turut.',
				'id_penyewaan' => $booking['id_penyewaan']
			];
			$this->notifikasiModel->insert($notificationData);
		}

		// Jika diakses via HTTP (bukan cron job)
		if ($this->request->getMethod() === 'get') {
			return redirect()->to('/admin/tagihan')->with('info', 'Diperbarui ' . $updatedCount . ' tagihan terlambat');
		}

		return $updatedCount;
	}




	function getRolesList($params = null)
	{
		$roles = '';
		$query = $this->db->query("select * from users_roles where id in(" . $params . ")");
		if ($query->getNumRows() > 0) {
			foreach ($query->getResult() as $row) {
				$roles .= '<span class="badge bg-primary">' . $row->description . '</span>&nbsp;';
			}
		}
		return $roles;
	}

	public function insertNotifikasi($data = null, $param = NULL)
	{
		$this->db->table('notifikasi')->insert($data);
		return $this->db->insertID();
	}
}
