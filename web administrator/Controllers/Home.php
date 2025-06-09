<?php

namespace App\Controllers;

use \Config\App;
use App\Models\AppModel;

class Home extends BasePenggunaController
{
	protected $appModel;
	public function __construct()
	{
		parent::__construct();
		$this->appModel = new AppModel();
	}
	function index()
	{
		$data["title"] = "Dashboard";
		$data["roomdata"] = $this->appModel->master("room order by id desc limit 4")->getResult();
		return view('frontend/home', $data);
	}


	function room()
	{
		$data["title"] = "Dashboard";
		$data["roomdata"] = $this->appModel->master("room order by id")->getResult();
		return view('frontend/room', $data);
	}


	function tentang()
	{
		$data["title"] = "Tentang";
		return view('frontend/tentang', $data);
	}


	function lokasi()
	{
		$data["title"] = "Lokasi";
		return view('frontend/lokasi', $data);
	}


	function faq()
	{
		$data["title"] = "FAQ";
		return view('frontend/faq', $data);
	}
}
