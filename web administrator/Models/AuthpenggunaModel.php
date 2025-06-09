<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthpenggunaModel extends Model
{
	protected $session;
	function __construct()
	{
		parent::__construct();
		$this->session = \Config\Services::session();
	}

	function manualQuery($q)
	{
		return $this->db->query($q);
	}

	function master($master)
	{
		$q = $this->db->query("select * from $master");
		return $q;
	}

	function simpanRecord($tabel, $data)
	{
		return $this->db->table($tabel)->insert($data);
	}

	function editRecord($tabel, $seleksi)
	{
		return $this->db->query("select * from $tabel where $seleksi");
	}

	function updateRecord($tabel, $isi, $seleksi)
	{
		return $this->db->table($tabel)->where($seleksi, $isi[$seleksi])->update($isi);
	}

	function hapusRecord($id, $seleksi, $tabel)
	{
		return $this->db->table($tabel)->where($seleksi, $id)->delete();
	}

	function DetailRecord($tabel, $seleksi)
	{
		return $this->db->query("select * from $tabel where $seleksi limit 1");
	}



	function login($username = null)
	{
		$query = $this->db->query("SELECT a.*
									FROM customer a
										WHERE a.username=?", $username);
		return $query->getRow();
	}



	function resetPass($param = null)
	{
		$query = $this->db->query("SELECT a.*
									FROM customer a
									WHERE a.username='" . $param . "' OR a.email='" . $param . "'");
		return $query->getRow();
	}

	function resetPassDo($customer = null)
	{
		$status	= false;
		$userid	= $customer->userid;
		$rand	= rand(11111, 99999);
		$token	= md5($userid . $rand);
		$emailSent = $this->sendEmail($customer, $token);
		if ($emailSent['status']) {
			$query 	= $this->db->query("update customer a set a.token='$token' WHERE a.id='" . $customer->id . "'");
			$status	= true;
		}
		return $status;
	}

	function sendEmail($customer = null, $token = null)
	{
		$response		= [];
		$parser 		= \Config\Services::parser();
		$email 			= \Config\Services::email();
		$request 		= \Config\Services::request();
		$agent 			= $request->getUserAgent();
		if ($agent->isBrowser()) {
			$customerAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
		} elseif ($agent->isRobot()) {
			$customerAgent = $agent->getRobot();
		} elseif ($agent->isMobile()) {
			$customerAgent = $agent->getMobile();
		} else {
			$customerAgent = 'Unidentified User Agent';
		}
		$param['name']		= $customer->nama;
		$param['username']	= $customer->username;
		$param['ip']		= $request->getIPAddress();;
		$param['agent']		= $customerAgent;
		$param['link']		= base_url('resetpass/changePassword/' . $token . '');
		$message			= $parser->setData($param)->render('template-email/resetpass');

		$config = [
			"protocol"   => "smtp",
			"SMTPHost"   => "",
			"SMTPPort"   => 587,
			"SMTPCrypto" => "",
			"SMTPUser"   => "",
			"SMTPPass"   => "",
			"newline"    => "\r\n",
		];
		$email->initialize($config);
		$email->setFrom('info@domain.id', 'App');
		$email->setTo($customer->email);
		$email->setSubject('Permintaan Reset Password');
		$email->setMessage($message);
		if ($email->send(false)) {
			$response['status']	= true;
		} else {
			$response['status']	= false;
			$response['msg']	= $email->printDebugger(['headers']);
		}
		return $response;
	}



	function setActiveSession($username = null, $sessionid = null)
	{
		$this->db->query("UPDATE customer SET session='" . $sessionid . "' WHERE username='" . $username . "'");
	}

	function getActiveSession()
	{
		$query = $this->db->query("SELECT a.session FROM customer a WHERE a.username='" . $this->session->username . "'");
		if ($query->getNumRows() > 0) {
			return $query->getRow()->session;
		}
		return false;
	}

	function myaccount()
	{
		$query = $this->db->query("SELECT a.*,b.roles
									FROM customer a
									WHERE a.username='" . $this->session->username . "' LIMIT 1");
		return $query->getRow();
	}

	function validateToken($token = null)
	{
		$return = false;
		$query = $this->db->query("SELECT a.*,b.roles
									FROM customer a
									WHERE a.token='" . $token . "' LIMIT 1");
		if ($query->getNumRows() > 0) {
			$return = $query->getRow();
		}
		return $return;
	}
}
