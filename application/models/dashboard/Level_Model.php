<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level_Model extends CI_Model
{
  private $private_db = "level";
	private $db1 = "course";
	private $db2 = "subcategory";

	public function getSubCategory($unselected = true)
  {
    if ($unselected === true) {
      $data = array( '' => 'Select Type');
    }
    $this->db->where('status', 1);
    $query = $this->db->get($this->db2);
    $result = $query->result();
    foreach ($result as $row) {
      $data[$row->id] = $row->name;
    }
    return $data;
  }

	public function levelList()
	{
		$this->db->select('level.id,level.name,description,level.created_at,level.updated_at,level.status,level.created_by,level.updated_by,subcategory.name as subcategory');
		$this->db->from($this->private_db);
		$this->db->join($this->db2, $this->db2.'.id = '.$this->private_db.'.subcat_id', 'left');
		$query=$this->db->get();
		return $query->result();
	}

  public function detail($id)
  {
    $this->db->select('*');
    $this->db->where('id', $id);
		return $this->db->get($this->private_db)->row();
  }
  
  public function levelChecks($data, $id)
	{
		$this->db->select('name,subcat_id,status');
		$this->db->from($this->private_db);
    $this->db->where('name', $data['name']);
		$this->db->where('subcat_id', $data['subcat_id']);
    $this->db->where('status', $data['status']);
		$this->db->where('id !=', $id);
		$query=$this->db->get();
		return $query->result();
	}

	public function insert($data)
	{
		$this->db->insert($this->private_db, $data);
		return true;
	}

	public function levelUpdate($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->private_db, $data);
		return true;
	}

	public function levelDelete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->private_db);
		return true;
	}
	
	public function checkParentlevel($id){
		$this->db->select('cos_title');
		$this->db->from($this->db1);
		$this->db->where('level_id', $id);
		$query=$this->db->get();
		return $query->result();
	}
}
