<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * # VIEW CHECK POINT #
 */
  class Room_Model extends CI_Model
  {
    private $privatedb = "room";
    private $db1 = "class";
    private $db2 = "course";
    private $db3 = "room";
    private $db4 = "instructor";
    private $db5 = "calendar";

    public function getRoomList()
    {
      $this->db->select("*");
      $this->db->from($this->privatedb);
      $query=$this->db->get();
      return $query->result();
    }

    public function insertRoom($data)
    {
      $this->db->insert($this->privatedb, $data);
      return true;
    }

    public function getRoomData($id)
    {
      $this->db->select("*");
      $this->db->where('id', $id);
      return $this->db->get($this->privatedb)->row();
    }

    public function checkRoomData($data, $id)
    {
      $this->db->select('name,description,status');
      $this->db->from($this->privatedb);
      $this->db->where('name', $data['name']);
      $this->db->where('description', $data['description']);
      $this->db->where('status', $data['status']);
      $this->db->where('id !=', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function updateRoomData($data, $id)
    {
      $this->db->where('id', $id);
      $this->db->update($this->privatedb, $data);
      return true;
    }
    
    public function getParentRoom($id){
      $this->db->select("*");
      $this->db->from($this->db1);
      $this->db->where('room_id', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function getCalendarData($id)
    {
      $this->db->select("course.cos_title as name,room.name as room,calendar.start_time,calendar.end_time,instructor.name as instructor, course.cos_title as course");
      $this->db->from($this->db5);   
      $this->db->join($this->privatedb, $this->privatedb.'.id = '.$this->db5.'.room_id', 'left');
      $this->db->join($this->db1, $this->db1.'.id = '.$this->db5.'.class_id', 'left');
      $this->db->join($this->db2, $this->db2.'.id = '.$this->db1.'.course_id', 'right');
      $this->db->join($this->db4, $this->db4.'.id = '.$this->db5.'.inst_id', 'left');          
      $this->db->where('calendar.room_id', $id);
      $query=$this->db->get();
      return $query->result();
    }
    
    public function fetch_all_event($id){
      $this->db->select("course.cos_title as name,calendar.id,class.description,calendar.start_time,calendar.end_time,color,room.name as room,instructor.name as instructor");
      $this->db->join($this->privatedb, $this->privatedb.'.id = '.$this->db5.'.room_id', 'left');
      $this->db->join($this->db1, $this->db1.'.id = '.$this->db5.'.class_id', 'left');
      $this->db->join($this->db2, $this->db2.'.id = '.$this->db1.'.course_id', 'left');
      $this->db->join($this->db4, $this->db4.'.id = '.$this->db5.'.inst_id', 'left'); 
      $this->db->where('calendar.room_id', $id);
      return $this->db->get($this->db5);
    }
    
    public function roomDelete($id)
    {
      $this->db->where('id', $id);
      $this->db->delete($this->privatedb);
      return true;
    }

  }

