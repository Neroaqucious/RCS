<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * # VIEW CHECK POINT #
 */
  class Dashboard_Model extends CI_Model
  {
    private $privatedb = "room";
    private $db1 = "class";
    private $db2 = "course";
    private $db3 = "room";
    private $db4 = "instructor";
    private $db5 = "calendar";
  
    public function getRoomCount()
  {
    $this->db->select('*');
    $this->db->from($this->privatedb);
    $query=$this->db->get();
    return $query->num_rows();
  }

  public function getInstructorListCount()
  {
    $this->db->select('*');
    $this->db->from($this->db4);
    $query=$this->db->get();
    return $query->num_rows();
  }

  public function getCourseCount()
  {
    $this->db->select('*');
    $this->db->from($this->db2);
    $query=$this->db->get();
    return $query->num_rows();
  }

  public function getClassCount()
  {
    $this->db->select('*');
    $this->db->from($this->db1);
    $query=$this->db->get();
    return $query->num_rows();
  }

  public function getCalendarData()
  {
    $start_date = strtotime(date('Y-m-d 00:00:00'));
    $end_date = strtotime(date('Y-m-d 23:59:59'));
    $this->db->select("calendar.id,course.cos_title as name,room.name as room,calendar.start_time,calendar.end_time,instructor.name as instructor, course.cos_title as course");
    $this->db->from($this->db5);   
    $this->db->join($this->privatedb, $this->privatedb.'.id = '.$this->db5.'.room_id', 'left');
    $this->db->join($this->db1, $this->db1.'.id = '.$this->db5.'.class_id', 'left');
    $this->db->join($this->db2, $this->db2.'.id = '.$this->db1.'.course_id', 'right');
    $this->db->join($this->db4, $this->db4.'.id = '.$this->db5.'.inst_id', 'left');          
    $this->db->where($this->db5.'.start_time >', $start_date);
    $this->db->where($this->db5.'.end_time <', $end_date);    
    $query=$this->db->get();
    return $query->result();
  }
    
  public function fetch_all_event(){
    $this->db->select("course.cos_title as name,calendar.id,class.description,calendar.start_time,calendar.end_time,color,room.name as room,instructor.name as instructor");
    $this->db->join($this->privatedb, $this->privatedb.'.id = '.$this->db5.'.room_id', 'left');
    $this->db->join($this->db1, $this->db1.'.id = '.$this->db5.'.class_id', 'left');
    $this->db->join($this->db2, $this->db2.'.id = '.$this->db1.'.course_id', 'left');
    $this->db->join($this->db4, $this->db4.'.id = '.$this->db5.'.inst_id', 'left'); 
    return $this->db->get($this->db5);
  }

























  

  public function getStudentListCount()
  {
    $this->db->select('std_id,user_id as student_id,student.id,name,email,phone,address,status,std_profile.request_date');
    $this->db->from($this->db5);
    $this->db->join($this->db1, $this->db1.'.id = '.$this->db5.'.std_id', 'left' );
    $this->db->order_by('id','desc')->limit(4);
    $query=$this->db->get();
    return $query->result();
  }

  public function getMonthlyRecord()
  {
    $this->db->select('DATE_FORMAT(request_date,"%b") as month,count(id) as std_count');
    $this->db->group_by('month');
    $this->db->from($this->db5);
    $this->db->where('YEAR(request_date)', 2021);
    $this->db->order_by('month','asc');
    $query=$this->db->get();
    return $query->result();
  }



  }

