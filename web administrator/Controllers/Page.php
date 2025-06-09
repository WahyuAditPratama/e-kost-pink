<?php

namespace App\Controllers;

class Page extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		helper(['form', 'url']);
	}

	public function index($id = null)
	{
		if (!empty($id)) {

			$id3 = base64_decode($id);
			$data['id'] = $id3;
			$data['page'] = 'page';
			$data['title'] = 'title';
			echo view('tandatangan/tanda_tangan_iro', $data);
		}
	}
}
