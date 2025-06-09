<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Auth;
use CodeIgniter\HTTP\RequestInterface;

class ReviewModel extends Model
{
	protected $table 			= 'review';
	protected $primaryKey 		= 'id';
	protected $useAutoIncrement = true;
	protected $returnType     	= 'array';
	protected $protectFields 	= false;
	protected $auth;
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
	protected $request;

	var $column_order = array('a.id', 'a.id_customer', 'a.comments', 'a.review', 'a.status', null);
	var $column_search = array('a.id_customer', 'a.comments', 'a.review', 'a.status');
	var $order = array('a.id' => 'asc', 'a.id_customer' => 'asc');

	private $reqBu;

	public function __construct(RequestInterface $request)
	{
		parent::__construct();
		$this->request 	= $request;
		$this->reqBu	= $this->request->getPost('bu');
		$this->auth 	= new Auth();
	}

	private function getDatatablesQuery()
	{
		$filter = $this->request->getPost('filter');
		$this->select('a.*');
		$this->from('review a', true);

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
			$this->limit((int)$this->request->getPost('length'), (int)$this->request->getPost('start'));
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
		$this->select('a.id');
		$this->from('review a', true);
		return $this->countAllResults();
	}
}
