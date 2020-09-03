<?php
class M_query extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
     }
     
	    
	public function insert($table,$data)
	{
		$this->db->insert($table,$data);
		return true;
	}

	public function insert_id($table,$data)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}	

	public function update($table,$where,$data)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
		return true;
	}

	public function delete($table,$where)
	{
		$this->db->delete($table, $where);
		return true;
	}

	public function getData($value='') {
		$this->db->select($value['select']);
		$this->db->from($value['table']);

		if (isset($value['where'])) {
			$this->db->where($value['where']);
		}

		if (isset($value['join'])) {
			foreach ($value['join'] as $join) {
				$this->db->join($join['0'],$join['1'],'left');
			}
		}

		if (isset($value['group'])) {
			$this->db->group_by($value['group']);
		}

		if (isset($value['limit'])) {
			$this->db->limit($value['limit']);
		}
		if (isset($value['having'])) {
			$this->db->having($value['having']);
		}
		if (isset($value['order'])) {
			$this->db->order_by($value['order']);
		}
		
		$result = $this->db->get()->result();
		return $result;
	}

	public function getRow($value='')
	{
		$this->db->select($value['select']);
		$this->db->from($value['table']);

		if (isset($value['where'])) {
			$this->db->where($value['where']);
		}

		if (isset($value['join'])) {
			foreach ($value['join'] as $join) {
				$this->db->join($join['0'],$join['1'],'left');
			}
		}

		if (isset($value['group'])) {
			$this->db->group_by($value['group']);
		}

		if (isset($value['limit'])) {
			$this->db->limit($value['limit']);
		}
		if (isset($value['order'])) {
			$this->db->order_by($value['order']);
		}
		
		$result = $this->db->get()->row();
		return $result;
	}

	public function getNum($value='')
	{
		$this->db->select($value['select']);
		$this->db->from($value['table']);

		if (isset($value['where'])) {
			$this->db->where($value['where']);
		}

		if (isset($value['join'])) {
			foreach ($value['join'] as $join) {
				$this->db->join($join['0'],$join['1'],'left');
			}
		}

		if (isset($value['group'])) {
			$this->db->group_by($value['group']);
		}

		if (isset($value['limit'])) {
			$this->db->limit($value['limit']);
		}
		if (isset($value['order'])) {
			$this->db->order_by($value['order']);
		}
		
		$result = $this->db->get()->num_rows();
		return $result;
	}

	public function insert_multiple($table,$data){
     	$this->db->insert_batch($table, $data);
    	} 

	public function getID($value='')
	{
		if (isset($value['select'])) {
			$this->db->select($value['select']);
		}
		$this->db->from($value['table']);

		if (isset($value['where'])) {
			$this->db->where($value['where']);
		}

		$result = $this->db->get()->row();
		return $result;
	}
}