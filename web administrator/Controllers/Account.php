<?php

namespace App\Controllers;

use \Config\App;
use App\Models\AppModel;

class Account extends BaseController
{
	protected $appModel;
	protected $session;
	public function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->auth->activity($this->request);
		$this->appModel = new AppModel();
		$this->session = \Config\Services::session();
	}

	function index()
	{
		$data = array();
		$data["title"] 	= "User Account";
		$data['mroles']	= $this->appModel->master("users_roles");
		$data['mdata'] 	= $this->authmodel->myaccount($this->auth->username);
		return view('pages/admin/settings/account', $data);
	}


	public function update()
	{
		if ($this->request->getPost()) {
			$in["userid"] 	= $this->auth->userid;
			$in["email"] 	= $this->request->getPost('email');
			if ($this->request->getPost('newpassword') != '') {
				$in["password"] = password_hash($this->request->getPost('newpassword'), PASSWORD_DEFAULT);
			}
			$this->appModel->updateRecord("users", $in, "userid");
			$this->session->set('email', $in["email"]);
			$this->session->setFlashdata('info', 'Update data akun berhasil !');
			return redirect()->to('account');
		}
	}

	function roles($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			if ($this->checkRolesExist($id)) {
				$mdata = $this->appModel->recordDetail("users_roles", "id='" . $id . "'")->getRow();
				$this->session->set('rolesid', $mdata->id);
				$this->session->set('roles', $mdata->roles);
				$this->session->set('rolesdesc', $mdata->description);
				$this->session->setFlashdata('info', 'Switch ke Roles ' . $mdata->description . '');
			}
			return redirect()->to('home');
		}
	}

	private function checkRolesExist($id)
	{
		foreach ($this->auth->roleslist as $key => $val) {
			if ($val->id == $id) {
				return true;
			}
		}
		return false;
	}
}
