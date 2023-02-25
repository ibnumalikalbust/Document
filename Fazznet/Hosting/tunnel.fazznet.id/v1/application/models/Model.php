<?php

class model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	public function insert_batch($table,$data){
		$insert = $this->db->insert_batch($table, $data);
		if($insert){
			return true;
		}
	}
	public function gd($table,$select,$where,$status)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->from($table);
		if($status == 'result'){
			return $this->db->get()->result();
		}else{
			return $this->db->get()->row();
		}
	}
	public function join_data($table, $table_join, $on_join, $select, $where, $status)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->from($table);
		$this->db->join($table_join, $on_join);
		if ($status == 'result') {
			return $this->db->get()->result();
		} else {
			return $this->db->get()->row();
		}
	}
	public function join3table($table,$table1,$table2,$join1,$join2,$select,$where,$status)
	{
		$this->db->select($select);
		$this->db->from($table); 
		$this->db->join($table1, $join1, 'left');
		$this->db->join($table2, $join2, 'left');
		$this->db->where($where);
		if ($status == 'result') {
			return $this->db->get()->result();
		} else {
			return $this->db->get()->row();
		}
	}
	public function delete($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}
	function update($table, $where, $data)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}
	public function insert($table, $data)
	{
		$this->db->insert($table, $data);
	}
	public function truncate($table)
	{
		$this->db->truncate($table);
	}
}