<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\roomModel;

class Room extends BaseController
{
	private $models;
	private $appModel;
	function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->appModel = new AppModel();
		$this->models 	= new roomModel($this->request);
	}
	function index()
	{
		$data["title"] 	= "room";
		return view('pages/admin/room/room_list', $data);
	}
	function create()
	{
		if ($this->request->getPost()) {
			$validasi = [

				'nama_room' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'fitur' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'deskripsi' => [
					'rules'  => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
			];
			if (!$this->validate($validasi)) {
				return redirect()->back()->withInput();
			} else {
				$in["nama_room"] 		= $this->request->getPost('nama_room');
				$in["fitur"] 		= $this->request->getPost('fitur');
				$in["deskripsi"] 	= $this->request->getPost('deskripsi');
				$in["harga_bulanan"] 		= $this->request->getPost('harga_bulanan');




				if (!empty($_FILES['gambar']['name'])) {
					$xfile = $this->request->getFile('gambar');
					$imagex = \Config\Services::image();
					$imagex->withFile($xfile);
					$imagex->resize(320, 320, true, 'height');
					$filename = $this->auth->userid . $xfile->getRandomName();
					$filepath = ROOTPATH . 'public/uploads/room/';
					$imagex->save($filepath . $filename);
					$in['gambar'] = $filename;
				}


				$recid				= $this->appModel->simpanRecord("room", $in);
				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('room');
			}
		} else {
			$data = array();
			$data["title"]	= "Create room";
			return view('pages/admin/room/room_create', $data);
		}
	}
	function edit($id = null)
	{
		if ($this->request->getPost()) {
			$validasi = [
				'nama_room' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'fitur' => [
					'rules' => 'required',
					'errors' => [
						'required' => '{field} Harus diisi',
					]
				],
				'deskripsi' => [
					'rules'  => 'required',
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
				$in["nama_room"] 	= $this->request->getPost('nama_room');
				$in["fitur"] 	= $this->request->getPost('fitur');
				$in["deskripsi"] = $this->request->getPost('deskripsi');
				$in["harga_bulanan"] 	= $this->request->getPost('harga_bulanan');



				if (!empty($_FILES['gambar']['name'])) {
					$xfile = $this->request->getFile('gambar');
					$imagex = \Config\Services::image();
					$imagex->withFile($xfile);
					$imagex->resize(320, 320, true, 'height');
					$filename = $this->auth->userid . $xfile->getRandomName();
					$filepath = ROOTPATH . 'public/uploads/room/';
					$imagex->save($filepath . $filename);
					$in['gambar'] = $filename;
				}


				$this->appModel->updateRecord("room", $in, "id");
				$this->session->setFlashdata('info', 'Data berhasil disimpan !');
				return redirect()->to('room');
			}
		} else {
			$id = base64_decode($id);
			$data = array();
			$data["title"]		= "Edit room";
			$data["mdata"] 		= $this->appModel->detailRecord("room", "id='" . $id . "'")->getRow();
			return view('pages/admin/room/room_edit', $data);
		}
	}
	function remove($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->hapusRecord($id, "id", "room");
			$this->appModel->hapusRecord($id, "id_user", "room_bidang_jasa");
			$this->session->setFlashdata('info', 'Data berhasil dihapus');
			return redirect()->to('room');
		}
	}
	function activate($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update room set status='1' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('room');
		}
	}
	function inactive($id = null)
	{
		if ($id != null) {
			$id = base64_decode($id);
			$this->appModel->manualQuery("update room set status='0' where id='" . $id . "'");
			$this->session->setFlashdata('info', 'Update status data berhasil !');
			return redirect()->to('room');
		}
	}
	function load()
	{
		$data = array();
		$no = $this->request->getPost('start');
		$list = $this->models->getDatatables();
		foreach ($list as $rows) {
			$no++;
			$path = "public/uploads/room/";
			$file_path = ROOTPATH . $path . $rows->gambar;
			$gambar_url = base_url() . '/' . $path . $rows->gambar;
			if (file_exists($file_path)) {
				$pathfile = "<a href='" . $gambar_url . "' class='btn btn-sm btn-success' target='_blank'>Lihat File</a>";
			} else {
				$pathfile = "<span class='badge bg-danger'>Tidak Ada File</span>";
			}


			if ($rows->status == 'tersedia') {
				$status = '<span class="badge bg-success">Tersedia</span>';
			} elseif ($rows->status == 'disewa') {
				$status = '<span class="badge bg-primary">Disewa</span>';
			} else {
				$status = '<span class="badge bg-warning">Maintenance</span>';
			}

			$row = array();
			$row[] = $no;
			$row[] = $rows->nama_room;
			$row[] = $rows->fitur;
			$row[] = $rows->deskripsi;
			$row[] = $rows->harga_bulanan;
			$row[] = $pathfile;
			$row[] = $status;
			$row[] = '
				<a id="Edit" type="button" class="btn btn-iconsolid btn-secondary btn-xs" href="' . site_url('room/edit/' . trim(base64_encode($rows->id), '=') . '') . '">
					<i class="fa fa-pencil"></i>
				</a>
				<a id="Remove" type="button" class="btn btn-iconsolid btn-danger btn-xs" href="' . site_url('room/remove/' . trim(base64_encode($rows->id), '=') . '') . '" data-toggle="modal">
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


	public function getRoom()
	{
		$id = $this->request->getPost('id');
		$room = $this->appModel->master("room where id='$id'")->getRow();
		return $this->response->setJSON($room);
	}
}
