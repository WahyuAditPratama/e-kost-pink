<?php

namespace App\Controllers;

use \Config\App;
use Config\Services;
use App\Models\AuthModel;
use App\Models\usersrolesModel;

class Usersroles extends BaseController
{
	private $models;
	private $authModel;
	private $appModel;
	protected $session;
	function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->authModel = new AuthModel();
		$this->models 	= new usersrolesModel($this->request);
	}

	function index()
	{
		$data = array();
		$data["title"] 	= "Users Roles";
		return view('pages/admin/settings/users_roles_list', $data);
	}
	function create()
	{
		if ($this->request->getPost()) {
			$validasi = [
				'roles' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
			];
			if (!$this->validate($validasi)) {
				return redirect()->back()->withInput();
			} else {
				$in["roles"]		= $this->request->getPost('roles');
				$in["description"] 	= $this->request->getPost('description');
				$this->authModel->simpanRecord("users_roles", $in);
				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('usersroles');
			}
		} else {
			$data = array();
			$data["title"]	= "Crete Users Roles";
			return view('pages/admin/settings/users_roles_create', $data);
		}
	}

	function edit($id = null)
	{
		if ($this->request->getPost()) {
			$validasi = [
				'roles' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
			];
			if (!$this->validate($validasi)) {
				return redirect()->back()->withInput();
			} else {
				$in["id"]			= $this->request->getPost('id');
				$in["roles"]		= $this->request->getPost('roles');
				$in["description"] 	= $this->request->getPost('description');
				$this->authModel->updateRecord("users_roles", $in, "id");
				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('usersroles');
			}
		} else {
			$id = base64_decode($id);
			$data = array();
			$data["title"] = "Edit Users Roles";
			$data["mdata"] = $this->authModel->editRecord("users_roles", "id='" . $id . "'")->getRow();
			return view('pages/admin/settings/users_roles_edit', $data);
		}
	}

	function remove($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->authModel->hapusRecord($id, "id", "users_roles");
			$this->session->setFlashdata('info', 'Data berhasil dihapus');
			return redirect()->to('usersroles');
		}
	}

	function menu($rolesid = null)
	{
		if ($rolesid != null) {
			$data = array();
			$data["title"] 	= "User Role Menu";
			$data['page'] 	= 'users_roles_menu';
			$data['rolesid'] = $rolesid;
			$data['mdata']	= $this->authModel->getMenu($rolesid);
			return view('pages/admin/settings/users_roles_menu', $data);
		}
	}

	function menu_save()
	{
		$arr = array();
		if ($this->request->getPost()) {
			$in["id"]			= isset($_POST['id']) ? $_POST['id'] : "";
			$in["rolesid"]		= isset($_POST['rolesid']) ? $_POST['rolesid'] : "";
			$in["modul"]		= isset($_POST['modul']) ? $_POST['modul'] : "";
			$in["label"]		= isset($_POST['label']) ? $_POST['label'] : "";
			$in["deskripsi"]	= isset($_POST['deskripsi']) ? $_POST['deskripsi'] : "";
			$in["icon"]			= isset($_POST['icon']) ? $_POST['icon'] : "";
			$in["status_menu"]			= isset($_POST['status_menu']) ? $_POST['status_menu'] : "";
			if ($in["id"] != '') {
				$this->authModel->updateRecord("users_roles_menu", $in, "id");
				$arr['type']  	= 'edit';
				$arr['label'] 	= $_POST['label'];
				$arr['modul'] 	= $_POST['modul'];
				$arr['rolesid']	= $_POST['rolesid'];
				$arr['status_menu']	= $_POST['status_menu'];
				$arr['id']    	= $_POST['id'];
			} else {
				if ($in['modul'] != '' && $in['label'] != '') {
					$this->authModel->simpanRecord("users_roles_menu", $in);
					$arr['type'] = 'add';
				}
			}
			print json_encode($arr);
		}
	}


	function menu_update()
	{
		if ($this->request->getPost()) {
			$data = json_decode($_POST['data']);
			$readbleArray = $this->parseJsonArray($data);
			$i = 0;
			foreach ($readbleArray as $row) {
				$i++;
				$this->authModel->manualQuery("update users_roles_menu set parent = '" . $row['parentID'] . "', sorting = '" . $i . "' where id = '" . $row['id'] . "' ");
			}
		}
	}

	function menu_remove()
	{
		if ($this->request->getPost('id')) {
			$id = $this->request->getPost('id');
			$this->authModel->hapusRecord($id, "id", "users_roles_menu");
			$this->authModel->hapusRecord($id, "parent", "users_roles_menu");
		}
	}

	function get_moduls()
	{
		if ($this->request->getGet('roles')) {
			$roles = $this->request->getGet('roles');
			$mmodul = $this->authModel->get_modul($roles);
			if ($mmodul->getNumRows() > 0) {
				echo '<option value="">Pilih Modul</option>';
				foreach ($mmodul->getResult() as $row) {
					echo '<option value="' . $row->modul . '">' . $row->label . '</option>';
				}
			}
		}
	}

	function parseJsonArray($jsonArray, $parentID = 0)
	{
		$return = array();
		foreach ($jsonArray as $subArray) {
			$returnSubSubArray = array();
			if (isset($subArray->children)) {
				$returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
			}
			$return[] = array('id' => $subArray->id, 'parentID' => $parentID);
			$return = array_merge($return, $returnSubSubArray);
		}
		return $return;
	}

	function activate($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->authModel->manualQuery("update users_roles set status='1' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Record set active successfully');
			return redirect()->to('usersroles');
		}
	}

	function inactive($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->authModel->manualQuery("update users_roles set status='0' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Record set inactive successfully');
			return redirect()->to('usersroles');
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
			$row[] = $rows->roles;
			$row[] = $rows->description;
			$row[] = ($rows->status) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">InActive</span>';
			$row[] = '<a id="Edit" type="button" class="btn btn-iconsolid btn-secondary btn-xs" href="' . site_url('usersroles/edit/' . trim(base64_encode($rows->id), '=') . '') . '">
					<i class="fa fa-pencil"></i>
				</a>
				<a id="Remove" type="button" class="btn btn-iconsolid btn-danger btn-xs" href="' . site_url('usersroles/remove/' . trim(base64_encode($rows->id), '=') . '') . '" data-toggle="modal">
					<i class="fa fa-trash-o"></i>
				</a>';
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
