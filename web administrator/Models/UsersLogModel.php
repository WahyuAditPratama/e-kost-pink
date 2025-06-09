<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Auth;
use CodeIgniter\HTTP\RequestInterface;

class UsersLogModel extends Model
{
	protected $table 			= 'users_log';
	protected $primaryKey 		= 'id';
	protected $useAutoIncrement = true;
	protected $returnType     	= 'array';
	protected $protectFields 	= false;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	protected $tahun;
	protected $bulan;
	protected $auth;
	protected $request;

	var $column_order = array('l.id', 'l.username', 'u.nama', 'l.log_ip', 'l.log_date', 'l.log_action', 'l.log_info', null);
	var $column_search = array('l.username', 'u.nama', 'l.log_ip', 'l.log_date', 'l.log_action', 'l.log_info');
	var $order = array('l.id' => 'desc', 'l.username' => 'desc');

	public function __construct(RequestInterface $request)
	{
		parent::__construct();
		$this->auth = new Auth();
		$this->request = $request;
		$this->tahun = $this->request->getPost('tahun');
		$this->bulan = $this->request->getPost('bulan');
	}

	private function getDatatablesQuery()
	{


		$this->select('l.*,u.nama');
		$this->from('users_log l', true);
		$this->join('users u', 'u.username =l.username', 'left');
		if ($this->tahun != 'All') {
			$this->where('l.tahun=', '' . $this->tahun . '');
		}
		if ($this->bulan != 'All') {
			$this->where('l.bulan=', '' . $this->bulan . '');
		}
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($this->request->getPost('search') && $this->request->getPost('search')['value']) {
				if ($i === 0) {
					$this->groupStart();
					$this->like($item, $this->request->getPost('search')['value']);
				} else {
					$this->orLike($item, $this->request->getPost('search')['value']);
				}
				if (count($this->column_search) - 1 == $i)
					$this->groupEnd();
			}
			$i++;
		}

		if ($this->request->getPost('order')) {
			$this->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->orderBy(key($order), $order[key($order)]);
		}
	}

	function getDatatables()
	{
		$this->getDatatablesQuery();
		if ($this->request->getPost('length') != -1)
			$this->limit((int) $this->request->getPost('length'), (int) $this->request->getPost('start'));
		$query = $this->get();
		return $query->getResult();
	}

	function countFiltered()
	{
		$this->getDatatablesQuery();
		$query = $this->get();
		return $query->getNumRows();
	}

	public function countAll()
	{
		$this->select('l.id');
		$this->from('users_log l', true);
		$this->join('users u', 'u.username =l.username', 'left');
		if ($this->tahun != 'All') {
			$this->where('l.tahun=', '' . $this->tahun . '');
		}
		if ($this->bulan != 'All') {
			$this->where('l.bulan=', '' . $this->bulan . '');
		}
		return $this->countAllResults();
	}
}
