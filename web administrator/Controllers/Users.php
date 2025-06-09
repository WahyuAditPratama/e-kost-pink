<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\UsersModel;

class Users extends BaseController
{
	private $models;
	private $appModel;
	function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->appModel = new AppModel();
		$this->models 	= new UsersModel($this->request);
	}

	function index()
	{
		$data["title"] 	= "Users";
		return view('pages/admin/settings/users_list', $data);
	}
	function create()
	{
		if ($this->request->getPost()) {
			$validasi = [
				'rolesid' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'username' => [
					'rules'  => 'required|is_unique[users.username]',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'nama' => [
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
				$in["rolesid"] 		= $this->request->getPost('rolesid');
				$in["nama"] 		= $this->request->getPost('nama');
				$in["email"] 		= $this->request->getPost('email');
				$in["username"] 	= $this->request->getPost('username');
				$in["token"] 		= sha1($this->request->getPost('email'));
				$in["password"] 	= password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
				$recid				= $this->appModel->simpanRecord("users", $in);

				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('users');
			}
		} else {
			$data = array();
			$data["title"]	= "Create Users";
			$data['mroles']	= $this->appModel->master("users_roles");
			return view('pages/admin/settings/users_create', $data);
		}
	}

	function edit($id = null)
	{
		if ($this->request->getPost()) {
			$validasi = [
				'rolesid' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'nama' => [
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
				$in["rolesid"] 	= $this->request->getPost('rolesid');
				$in["nama"] 	= $this->request->getPost('nama');
				$in["email"] 	= $this->request->getPost('email');
				$in["username"] = $this->request->getPost('username');
				$in["token"] 	= sha1($this->request->getPost('email'));
				if ($this->request->getPost('newpassword') != '') {
					$in["password"] = password_hash($this->request->getPost('newpassword'), PASSWORD_DEFAULT);
				}
				$this->appModel->updateRecord("users", $in, "id");


				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('users');
			}
		} else {
			$id = base64_decode($id);
			$data = array();
			$data["title"]		= "Edit Users";
			$data['mroles']		= $this->appModel->master("users_roles");
			$data["mdata"] 		= $this->appModel->editRecord("users", "id='" . $id . "'")->getRow();
			return view('pages/admin/settings/users_edit', $data);
		}
	}

	function remove($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->hapusRecord($id, "id", "users");
			$this->appModel->hapusRecord($id, "id_user", "users_bidang_jasa");
			$this->session->setFlashdata('info', 'Data berhasil dihapus');
			return redirect()->to('users');
		}
	}

	function activate($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update users set status='1' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('users');
		}
	}

	function inactive($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update users set status='0' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('users');
		}
	}

	function load()
	{
		$data = array();
		$no = $this->request->getPost('start');
		$list = $this->models->getDatatables();
		foreach ($list as $rows) {
			$no++;
			if ($rows->status == 1) {
				$button = '<a title="Inactive" class="btn btn-xs btn-warning btn-iconsolid" href="' . site_url('users/inactive/' . trim(base64_encode($rows->id), '=') . '') . '">
							<i class="fa fa-ban" aria-hidden="true"></i>
						</a>';
			} else {
				$button = '<a title="Activate" class="btn btn-xs btn-primary btn-iconsolid" href="' . site_url('users/activate/' . trim(base64_encode($rows->id), '=') . '') . '">
							<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						</a>';
			}
			$roles = $this->appModel->getRolesList($rows->rolesid);
			$row = array();
			$row[] = $no;
			// $row[] = '<img src="' . base_url('public/uploads/users/' . $rows->foto . '') . '" class="img-responsive" width="50px"></td>';
			$row[] = $rows->nama;
			$row[] = $rows->email;
			$row[] = $rows->username;
			$row[] = $roles;
			$row[] = ($rows->status) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">InActive</span>';
			$row[] =  $button . '
				<a id="Edit" type="button" class="btn btn-iconsolid btn-secondary btn-xs" href="' . site_url('users/edit/' . trim(base64_encode($rows->id), '=') . '') . '">
					<i class="fa fa-pencil"></i>
				</a>
				<a id="Remove" type="button" class="btn btn-iconsolid btn-danger btn-xs" href="' . site_url('users/remove/' . trim(base64_encode($rows->id), '=') . '') . '" data-toggle="modal">
					<i class="fa fa-trash-o"></i>
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
