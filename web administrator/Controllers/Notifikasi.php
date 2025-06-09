<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\NotifikasiModel;

class Notifikasi extends BaseController
{
	private $models;
	private $appModel;
	function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->appModel = new AppModel();
		$this->models 	= new NotifikasiModel($this->request);
	}

	function index()
	{
		$data["title"] 	= "Notifikasi";
		return view('pages/admin/notifikasi/notifikasi_list', $data);
	}


	function remove($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->hapusRecord($id, "id", "notifikasi");
			$this->session->setFlashdata('info', 'Data berhasil dihapus');
			return redirect()->to('notifikasi');
		}
	}


	function load()
	{
		$data = array();
		$no = $this->request->getPost('start');
		$list = $this->models->getDatatables();
		foreach ($list as $rows) {
			$no++;


			$row = array();
			$row[] = $no;
			$row[] = $rows->penerima;
			$row[] = $rows->pengirim;
			$row[] = '<b>' . $rows->pesan . '</b><br>' . $rows->pesan;
			$row[] = $rows->parameter;
			$row[] = $rows->ref_id;
			$row[] = ($rows->status == 'aktif') ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>';
			$row[] = '
				<a id="Remove" type="button" class="btn btn-iconsolid btn-primary btn-xs" href="' . site_url('notifikasi/detail/' . trim(base64_encode($rows->id), '=') . '') . '" data-toggle="modal">
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
