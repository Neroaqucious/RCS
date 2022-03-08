<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * # VIEW CHECK POINT #
 */
  class Instructor_Model extends CI_Model
  {
    private $privatedb = "instructor";
    
		private $db1 = "instructorsession";
    private $db2 = "instructorbills";
    private $db3 = "class";
    private $db4 = "course";
    private $db5 = "room";
    private $db6 = "calendar";


    public function getInstructorList()
    {
      $this->db->select("*");
      $this->db->from($this->privatedb);
      $query=$this->db->get();
      return $query->result();
    }

    public function getLastID()
    {
      $this->db->select('id')->order_by('id',"desc")->limit(1);
      return $this->db->get($this->privatedb)->row();
    }

    public function insertInstructor($data)
    {
      $this->db->insert($this->privatedb, $data);
      return true;
    }

    public function getInstructorData($id)
    {
      $this->db->select("*");
      $this->db->where('id', $id);
      return $this->db->get($this->privatedb)->row();
    }
    
    public function checkInstructorData($data, $id)
    {
      $this->db->select('name,phone,birthday,address,nrc,education,lecture,status');
      $this->db->from($this->privatedb);
      $this->db->where('name', $data['name']);
      $this->db->where('phone', $data['phone']);
      $this->db->where('birthday', $data['birthday']);
      $this->db->where('address', $data['address']);
      $this->db->where('nrc', $data['nrc']);
      $this->db->where('education', $data['education']);
      $this->db->where('lecture', $data['lecture']);
      $this->db->where('status', $data['status']);
      $this->db->where('id !=', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function checkInstructor($email, $id)
    {
      $this->db->select('email');
      $this->db->from($this->privatedb);
      $this->db->where('email', $email);
      $this->db->where('id !=', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function updateInstructorData($data, $id)
    {
      $this->db->where('id', $id);
      $this->db->update($this->privatedb, $data);
      return true;
    }
    
    public function getParentInstrcutor($id){
      $this->db->select("*");
      $this->db->from($this->db6);
      $this->db->where('inst_id', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function instructorDelete($id)
    {
      $this->db->where('id', $id);
      $this->db->delete($this->privatedb);
      return true;
    }

  }

