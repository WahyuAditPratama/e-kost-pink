<?php

namespace App\Controllers;

use \Config\App;
use App\Models\AppModel;

class Exception extends BaseController
{
	protected $appModel;
	public function __construct()
	{
		parent::__construct();
		$this->auth->authenticate();
		$this->appModel = new AppModel();
	}

	public function notfound()
	{
		$data = array();
		$data["title"] 	= "ERROR 404";
		return view('errors/custom/notfound', $data);
	}

	public function forbidden()
	{
		$data = array();
		$data["title"] = "ERROR 403";
		return view('errors/custom/forbidden', $data);
	}
}
