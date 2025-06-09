<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Auth;

class AuthModel extends Model
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



	public function getModule()
	{
		$items = array();
		$query = $this->db->query("select a.modul
									from users_roles_menu a
									left join users_roles b on b.id=a.rolesid
									where a.rolesid='" . $this->session->rolesid . "'
									order by a.sorting asc");
		if ($query->getNumRows() > 0) {
			$items = $query->getResultArray();
		}

		return $items;
	}

	function login($username = null)
	{
		$query = $this->db->query("SELECT a.*,b.roles
									FROM users a
									LEFT JOIN users_roles b ON b.id=a.rolesid
									WHERE a.username=?", $username);
		return $query->getRow();
	}

	function loginRoles($params)
	{
		$roles = false;

		$query = $this->db->query("select * from users_roles where id in(" . $params . ")");
		if ($query->getNumRows() > 0) {
			$roles = $query->getResult();
		}
		return $roles;
	}

	function resetPass($param = null)
	{
		$query = $this->db->query("SELECT a.*,b.roles
									FROM users a
									LEFT JOIN users_roles b ON b.id=a.rolesid
									WHERE a.username='" . $param . "' OR a.email='" . $param . "'");
		return $query->getRow();
	}

	function resetPassDo($users = null)
	{
		$status	= false;
		$userid	= $users->userid;
		$rand	= rand(11111, 99999);
		$token	= md5($userid . $rand);
		$emailSent = $this->sendEmail($users, $token);
		if ($emailSent['status']) {
			$query 	= $this->db->query("update users a set a.token='$token' WHERE a.id='" . $users->id . "'");
			$status	= true;
		}
		return $status;
	}

	function sendEmail($users = null, $token = null)
	{
		$response		= [];
		$parser 		= \Config\Services::parser();
		$email 			= \Config\Services::email();
		$request 		= \Config\Services::request();
		$agent 			= $request->getUserAgent();
		if ($agent->isBrowser()) {
			$usersAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
		} elseif ($agent->isRobot()) {
			$usersAgent = $agent->getRobot();
		} elseif ($agent->isMobile()) {
			$usersAgent = $agent->getMobile();
		} else {
			$usersAgent = 'Unidentified User Agent';
		}
		$param['name']		= $users->nama;
		$param['username']	= $users->username;
		$param['ip']		= $request->getIPAddress();;
		$param['agent']		= $usersAgent;
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
		$email->setTo($users->email);
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

	function logDetail($id)
	{
		$query = $this->db->query("SELECT a.* FROM users_log a WHERE a.id='" . $id . "'");
		return $query;
	}

	function setActiveSession($username = null, $sessionid = null)
	{
		$this->db->query("UPDATE users SET session='" . $sessionid . "' WHERE username='" . $username . "'");
	}

	function getActiveSession()
	{
		$query = $this->db->query("SELECT a.session FROM users a WHERE a.username='" . $this->session->username . "'");
		if ($query->getNumRows() > 0) {
			return $query->getRow()->session;
		}
		return false;
	}

	function myaccount()
	{
		$query = $this->db->query("SELECT a.*,b.roles
									FROM users a
									LEFT JOIN users_roles b on b.id=a.rolesid
									WHERE a.username='" . $this->session->username . "' LIMIT 1");
		return $query->getRow();
	}

	function validateToken($token = null)
	{
		$return = false;
		$query = $this->db->query("SELECT a.*,b.roles
									FROM users a
									LEFT JOIN users_roles b on b.id=a.rolesid
									WHERE a.token='" . $token . "' LIMIT 1");
		if ($query->getNumRows() > 0) {
			$return = $query->getRow();
		}
		return $return;
	}
}
