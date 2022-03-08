<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jpschool_Model extends CI_Model
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
    
  public function getSchool()
	{
    $this->db->select('jpschool.id,jpschool.name,requirement,subject,photo,thumb,jpschool.created_by,jpschool.updated_by,jpschool.created_at,jpschool.updated_at,jpschool.status,tag.name as tag');
    $this->db->from($this->db2);  
    $this->db->join($this->db1, $this->db1.'.id = '.$this->db2.'.tag_id', 'left' );  
    $query=$this->db->get();
    return $query->result();
  }

  public function getjpschoolsDetail($id)
  {
    $this->db->select('jpschool.id,jpschool.name,subject,requirement,thumb,photo,address,phone,email,tag_id,jpschool.updated_at,jpschool.created_at,jpschool.status,tag.name as tag');
    $this->db->where($this->db2.'.id', $id);
    $this->db->join($this->db1, $this->db1.'.id = '.$this->db2.'.tag_id', 'left' );
    return $this->db->get($this->db2)->row();
  }

	public function schoolCheck($data, $id = null)
	{
    $this->db->select('name,email,phone,address,subject,requirement,tag_id,status');
    $this->db->from($this->db2);
    $this->db->where('name', $data['name']);
    $this->db->where('email', $data['email']);
    $this->db->where('phone', $data['phone']);
    $this->db->where('address', $data['address']);
    $this->db->where('subject', $data['subject']);
    $this->db->where('requirement', $data['requirement']);
    $this->db->where('tag_id', $data['tag_id']);
    $this->db->where('status', $data['status']);
    if($id != null) {
      $this->db->where('id !=', $id);  
    }
    $query=$this->db->get();
    return $query->result();
  }

	public function schoolInsert($data)
	{
    $this->db->insert($this->db2, $data);
    return true;
  }

  public function jpschoolsUpdate($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update($this->db2, $data);
    return true;
  }

	public function jpschoolsDelete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->db2);
		return true;
  }

}
