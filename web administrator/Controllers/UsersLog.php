<?php

namespace App\Controllers;

use \Config\App;
use Config\Services;
use App\Models\AppModel;
use App\Models\UsersLogModel;

class UsersLog extends BaseController
{
	protected $session;
	private $models;
	private $appModel;

	function __construct()
	{
		parent::__construct();

		$this->auth->authenticate();
		$this->appModel	= new AppModel();
		$this->models 	= new UsersLogModel($this->request);
		ini_set('memory_limit', '-1');
	}

	function index()
	{
		$data = array();
		$data["title"] 	= "Users Log";
		$data['page'] 	= 'users_log_list';
		$data["mbulan"] = get_month();
		$data["mtahun"] = get_year();
		return view('pages/admin/settings/users_log_list', $data);
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
			$row[] = $rows->username;
			$row[] = $rows->nama;
			$row[] = $rows->log_ip;
			$row[] = $rows->log_date;
			$row[] = '<code>' . $rows->log_action . '</code>';
			$row[] = '<div class="action-buttons">
						<div class="btn-group-justified">
							<a id="Detail" title="Detail" type="button" class="btn btn-warning btn-sm btn-round" href="' . site_url('usersLog/detail/' . trim(base64_encode($rows->id), '=') . '') . '">
								<i class="ri-search-line"></i>
							</a>
							<a id="Remove" type="button" class="btn btn-sm btn-danger btn-round" href="#" data-href="' . site_url('usersLog/remove/' . trim(base64_encode($rows->id), '=') . '') . '" data-toggle="modal">
								<i class="ri-delete-bin-line"></i>
							</a>
						</div>
					</div>';
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

	function detail($id = null)
	{
		if ($id != null) {
			$data = array();
			$id = base64_decode($id);
			$data["title"] = "Logs Detail";
			$data['mdata'] = $this->appModel->recordDetail("users_log", "id='" . $id . "'")->getRow();
			return view('pages/admin/settings/users_log_detail', $data);
		}
	}

	function remove($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->hapusRecord($id, "id", "users_log");
			$this->session->setFlashdata('info', 'Data berhasil dihapus !');
			return redirect()->to('usersLog');
		}
	}
}
