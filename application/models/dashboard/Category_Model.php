<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_Model extends CI_Model
{
// for globals header

  private $private_db = "category";
	private $db1 = "subcategory";

	public function categoryList()
	{
		$this->db->select('id,name,created_at,updated_at,status,created_by,updated_by');
		$this->db->from($this->private_db);
		$query=$this->db->get();
		return $query->result();
	}
	
	public function checkParentcategory($id)
	{
		$this->db->select('name');
		$this->db->from($this->db1);
		$this->db->where('cat_id', $id);
		$query=$this->db->get();
		return $query->result();
	}
	
	public function detail($id)
  {
    $this->db->select('id,name,created_at,updated_at,status');
    $this->db->where('id', $id);
		return $this->db->get($this->private_db)->row();
  }
  
  public function categoryCheck($data, $id)
	{
		$this->db->select('id,name,status');
		$this->db->from($this->private_db);
		$this->db->where('id !=', $id);
    $this->db->where('name', $data['name']);
    $this->db->where('status', $data['status']);
		$query=$this->db->get();
		return $query->result();
	}

	public function insert($data)
	{
		$this->db->insert($this->private_db, $data);
		return true;
	}

	public function categoryUpdate($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->private_db, $data);
		return true;
	}

	public function categoryDelete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->private_db);
		return true;
	}
}
