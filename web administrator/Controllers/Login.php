<?php

namespace App\Controllers;

use App\Models\AppModel;
use \Config\App;
use \Libraries\Auth;

class Login extends BaseController
{

	protected $session;
	protected $appModel;
	protected $validation;
	public function __construct()
	{
		parent::__construct();
		helper(['form', 'url']);


		$this->validation =  \Config\Services::validation();
		$this->appModel = new AppModel();
	}

	public function index()
	{
		if ($this->auth->loginStatus() && $this->auth->validSession()) {
			if ($this->auth->roles() == "customer") {
				header('location: ' . base_url());
			} else {
				header('location: ' . base_url() . '/dashboard');
			}
			exit;
		} else {
			$data = array();
			if ($this->request->getPost()) {
				$username = $this->request->getPost('username');
				$password = $this->request->getPost('password');
				$data = $this->auth->login($username, $password);
			}
			return $this->auth->showLoginForm($data);
		}
	}


	function register()
	{
		if ($this->request->getPost()) {
			$validasi = [
				'username' => [
					'rules'  => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
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
				$in["nama_customer"]	= $this->request->getPost('nama_customer');
				$in["email"] 			= $this->request->getPost('email');
				$in["telepon"] 			= $this->request->getPost('telepon');
				$in["tanggal_lahir"] 	= $this->request->getPost('tanggal_lahir');
				$in["jenis_kelamin"] 	= $this->request->getPost('jenis_kelamin');
				$in["alamat"] 			= $this->request->getPost('alamat');
				$in["username"] 		= $this->request->getPost('username');
				$in["password"] 		= password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
				$in["status"] 			= 'aktif';
				$in["created_at"] 		= date('Y-m-d H:i:s');

				$recid = $this->appModel->simpanRecord("customer", $in);
				$this->session->setFlashdata('info', 'Sukses Register akun !');
				return redirect()->to('login');
			}
		} else {
			$data = array();
			$data["title"]	= "Create Customer";
			$data["mjk"] = ['Laki-Laki', 'Perempuan'];
			return view('register', $data);
		}
	}

	public function logout()
	{
		$this->auth->logout();
		$this->session->setFlashdata('error_login', 'You are logout !');
		header('location: ' . base_url() . '/login');
		exit;
	}
}
