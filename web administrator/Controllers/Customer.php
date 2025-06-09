<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\CustomerModel;

class Customer extends BaseController
{
	private $models;
	private $appModel;
	function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->appModel = new AppModel();
		$this->models 	= new CustomerModel($this->request);
	}

	function index()
	{
		$data["title"] 	= "Customer";
		return view('pages/admin/customer/customer_list', $data);
	}
	function create()
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
				$in["nama_customer"] 		= $this->request->getPost('nama_customer');
				$in["email"] 		= $this->request->getPost('email');
				$in["telepon"] 		= $this->request->getPost('telepon');
				$in["tanggal_lahir"] 		= $this->request->getPost('tanggal_lahir');
				$in["jenis_kelamin"] 		= $this->request->getPost('jenis_kelamin');
				$in["alamat"] 	= $this->request->getPost('alamat');
				$in["username"] 		= $this->request->getPost('username');
				$in["password"] 	= password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
				$in["status"] 	= 'aktif';
				$in["created_at"] 	= date('Y-m-d H:i:s');


				$recid				= $this->appModel->simpanRecord("customer", $in);
				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('customer');
			}
		} else {
			$data = array();
			$data["title"]	= "Create Customer";
			$data["mjk"] = ['Laki-Laki', 'Perempuan'];

			return view('pages/admin/customer/customer_create', $data);
		}
	}

	function edit($id = null)
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


				$this->appModel->updateRecord("customer", $in, "id");

				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('customer');
			}
		} else {
			$id = base64_decode($id);
			$data = array();
			$data["title"]		= "Edit Customer";
			$data["mjk"] = ['Laki-Laki', 'Perempuan'];
			$data["mdata"] 		= $this->appModel->detailRecord("customer", "id='" . $id . "'")->getRow();
			return view('pages/admin/customer/customer_edit', $data);
		}
	}

	function remove($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->hapusRecord($id, "id", "customer");
			$this->session->setFlashdata('info', 'Data berhasil dihapus');
			return redirect()->to('customer');
		}
	}

	function activate($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update customer set status='aktif' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('customer');
		}
	}

	function inactive($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update customer set status='tidak aktif' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('customer');
		}
	}

	function load()
	{
		$data = array();
		$no = $this->request->getPost('start');
		$list = $this->models->getDatatables();
		foreach ($list as $rows) {
			$no++;



			if ($rows->status == 'aktif') {
				$button = '<a title="Inactive" class="btn btn-xs btn-warning btn-iconsolid" href="' . site_url('customer/inactive/' . trim(base64_encode($rows->id), '=') . '') . '">
							<i class="fa fa-ban" aria-hidden="true"></i>
						</a>';
			} else {
				$button = '<a title="Activate" class="btn btn-xs btn-primary btn-iconsolid" href="' . site_url('customer/activate/' . trim(base64_encode($rows->id), '=') . '') . '">
							<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						</a>';
			}

			$row = array();
			$row[] = $no;
			$row[] = $rows->nama_customer;
			$row[] = $rows->email;
			$row[] = $rows->telepon;
			$row[] = $rows->jenis_kelamin;
			$row[] = $rows->username;
			$row[] = ($rows->status == 'aktif') ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>';
			$row[] = $button . '
				<a id="Edit" type="button" class="btn btn-iconsolid btn-secondary btn-xs" href="' . site_url('customer/edit/' . trim(base64_encode($rows->id), '=') . '') . '">
					<i class="fa fa-pencil"></i>
				</a>
				<a id="Remove" type="button" class="btn btn-iconsolid btn-danger btn-xs" href="' . site_url('customer/remove/' . trim(base64_encode($rows->id), '=') . '') . '" data-toggle="modal">
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
