<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_Model extends CI_Model
{
  private $db1 = "tag";
  private $db2 = "jpschool";

  public function getTagsData($unselected = true)
  {
    if ($unselected === true) {
      $data = array( '' => 'Select Tags');
    }
    $this->db->select('*');
    $this->db->where('status', 1);
    $query = $this->db->get($this->db1);
    $result = $query->result();
    foreach ($result as $row) {
      $data[$row->id] = $row->name;
    }
    return $data;
  }
    
  public function getTags()
  {
    $this->db->select('*');
    $this->db->from($this->db1);
    $query=$this->db->get();
    return $query->result();
  }

  public function getTagsDetail($id)
  {
    $this->db->select('*');
    $this->db->where('id', $id);
    return $this->db->get($this->db1)->row();
  }
    
  public function tagsCheck($data)
  {
    $this->db->select('name,status');
    $this->db->from($this->db1);
    $this->db->where('name', $data['name']);
    $this->db->where('status', $data['status']);
    $query=$this->db->get();
    return $query->result();
  }

  public function tagsNameCheck($data, $id)
  {
    $this->db->select('name');
    $this->db->from($this->db1);
    $this->db->where('name', $data['name']);
    $this->db->where('id !=', $id);
    $query=$this->db->get();
    return $query->result();
  }
  
  public function getTotalNewDetail($id)
	{
		$this->db->select('*');
		$this->db->from($this->db2);
		$this->db->where("tag_id", $id);
		$query=$this->db->get();
		return $query->result();
	}

  public function tagsInsert($data)
  {
    $this->db->insert($this->db1, $data);
    return true;
  }
  
  public function tagsUpdate($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update($this->db1, $data);
    return true;
  }
    
  public function tagsDelete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->db1);
    return true;
  }

}
