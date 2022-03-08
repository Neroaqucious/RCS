<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategory_Model extends CI_Model
{
	private $private_db = "subcategory";
	private $db1 = "category";
	private $db2 = "course";
	private $db3 = "level";
	
	public function getCategory($unselected = true)
  {
    if ($unselected === true) {
      $data = array( '' => 'Select Category');
    }
    $this->db->where('status', 1);
    $query = $this->db->get($this->db1);
    $result = $query->result();
    foreach ($result as $row) {
      $data[$row->id] = $row->name;
    }
    return $data;
  }

	public function categoryList()
	{
		$this->db->select('subcategory.id,cat_id,category.name as catname, subcategory.name,subcategory.created_at,subcategory.updated_at,subcategory.created_by,subcategory.updated_by,subcategory.status');
		$this->db->from($this->private_db);
		$this->db->join($this->db1, $this->db1.'.id = '.$this->private_db.'.cat_id', 'left');
		$query=$this->db->get();
		return $query->result();
	}

  public function detail($id)
  {
    $this->db->select('id,name,cat_id,created_at,updated_at,status');
    $this->db->where('id', $id);
		return $this->db->get($this->private_db)->row();
  }
  
	public function DataChecker($data)
	{
		$this->db->select('name,cat_id');
		$this->db->from($this->private_db);
		$this->db->where('name', $data['name']);
		$this->db->where('cat_id', $data['cat_id']);
		$query=$this->db->get();
		return $query->result();
  }
  
  public function categoryChecks($data)
	{
		$this->db->select('name,cat_id,status');
		$this->db->from($this->private_db);
		$this->db->where('name', $data['name']);
		$this->db->where('cat_id', $data['cat_id']);
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
	
	public function checkParentsubcategory($id)
	{
		$this->db->select('id');
		$this->db->from($this->db2);
		$this->db->where('subcat_id', $id);
		$query=$this->db->get();
		return $query->result();
	}

	public function checkParentsubcategory2($id)
	{
		$this->db->select('id');
		$this->db->from($this->db3);
		$this->db->where('subcat_id', $id);
		$query=$this->db->get();
		return $query->result();
	}
}
