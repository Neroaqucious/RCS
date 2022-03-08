<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * # VIEW CHECK POINT #
 */
  class Classes_Model extends CI_Model
  {
    private $privatedb = "class";
    private $db2 = "course";
    private $db3 = "room";
    private $db4 = "instructor";
    private $db5 = "calendar";

    public function getCourse($unselected = true)
    {
      if ($unselected === true) {
        $data = array( '' => 'Select Course');
      }
      $this->db->where('status', 1);
      $query = $this->db->get($this->db2);
      $result = $query->result();
      foreach ($result as $row) {
        $data[$row->id] = $row->cos_title;
      }
      return $data;
    }

    public function getRoom($unselected = true)
    {
      if ($unselected === true) {
        $data = array( '' => 'Select Room');
      }
      $this->db->where('status', 1);
      $query = $this->db->get($this->db3);
      $result = $query->result();
      foreach ($result as $row) {
        $data[$row->id] = $row->name;
      }
      return $data;
    }

    public function getInstructor($unselected = true)
    {
      if ($unselected === true) {
        $data = array( '' => 'Select Insturctor');
      }
      $this->db->where('status', 1);
      $query = $this->db->get($this->db4);
      $result = $query->result();
      foreach ($result as $row) {
        $data[$row->id] = $row->name;
      }
      return $data;
    }

    public function getClassList()
    {
      $this->db->select("room.id as room_id, room.name as room_name, course.id as course_id,course.cos_title as course_name, instructor.id as inst_id, instructor.name as inst_name,class.description,class.created_at,class.updated_at,class.created_by,class.updated_by,class.status,duration,days,start_time,end_time,start_date,end_date,class.id");
      $this->db->from($this->privatedb);
      $this->db->join($this->db3, $this->db3.'.id = '.$this->privatedb.'.room_id', 'left');
      $this->db->join($this->db2, $this->db2.'.id = '.$this->privatedb.'.course_id', 'left');
      $this->db->join($this->db4, $this->db4.'.id = '.$this->privatedb.'.instructor_id', 'left');
      $query=$this->db->get();
      return $query->result();
    }

    public function insertClasses($data)
    {
      $this->db->insert($this->privatedb, $data);
      $id = $this->db->insert_id();
      return (isset($id)) ? $id : FALSE;
    }

    public function insertClassForCalendar($data)
    {
      $this->db->insert($this->db5, $data);
      return true;
    }
    
    public function checkRoomInstCalendar1($id, $inst_id, $start_date, $end_date)
    {
      $this->db->select("*");
      $this->db->from($this->db5);      
      $this->db->where('inst_id', $inst_id);
      $this->db->where('room_id', $id);
      $this->db->where('start_time <', $start_date+1);
      $this->db->where('end_time >', $end_date-1);  
      $query=$this->db->get();
      return $query->result();
    }

    public function checkRoomInstCalendar2($id, $inst_id, $start_date, $end_date)
    {
      $this->db->select("*");
      $this->db->from($this->db5);      
      $this->db->where('inst_id', $inst_id);
      $this->db->where('room_id', $id);
      $this->db->where('start_time >', $start_date+1);
      $this->db->where('start_time <', $end_date-1);  
      $query=$this->db->get();
      return $query->result();
    }

    public function checkRoomInstCalendar3($id, $inst_id, $start_date, $end_date)
    {
      $this->db->select("*");
      $this->db->from($this->db5);      
      $this->db->where('inst_id', $inst_id);
      $this->db->where('room_id', $id);
      $this->db->where('end_time >', $start_date+1);
      $this->db->where('end_time <', $end_date-1);  
      $query=$this->db->get();
      return $query->result();
    }

    public function checkPreCalendar1($id, $inst_id, $start_date, $end_date)
    {
      $this->db->select("*");
      $this->db->from($this->db5);      
      $this->db->where('inst_id', $inst_id);
      $this->db->where('room_id !=', $id);
      $this->db->where('start_time <', $start_date+1);
      $this->db->where('end_time >', $end_date-1);  
      $query=$this->db->get();
      return $query->result();
    }

    public function checkPreCalendar2($id, $inst_id, $start_date, $end_date)
    {
      $this->db->select("*");
      $this->db->from($this->db5);      
      $this->db->where('inst_id', $inst_id);
      $this->db->where('room_id !=', $id);
      $this->db->where('start_time >', $start_date+1);
      $this->db->where('start_time <', $end_date-1);  
      $query=$this->db->get();
      return $query->result();
    }

    public function checkPreCalendar3($id, $inst_id, $start_date, $end_date)
    {
      $this->db->select("*");
      $this->db->from($this->db5);      
      $this->db->where('inst_id', $inst_id);
      $this->db->where('room_id !=', $id);
      $this->db->where('end_time >', $start_date+1);
      $this->db->where('end_time <', $end_date-1);  
      $query=$this->db->get();
      return $query->result();
    }

    public function checkInstCalendar1($id, $inst_id, $start_date, $end_date)
    {
      $this->db->select("*");
      $this->db->from($this->db5);      
      $this->db->where('inst_id !=', $inst_id);
      $this->db->where('room_id', $id);
      $this->db->where('start_time <', $start_date+1);
      $this->db->where('end_time >', $end_date-1);  
      $query=$this->db->get();
      return $query->result();
    }

    public function checkInstCalendar2($id, $inst_id, $start_date, $end_date)
    {
      $this->db->select("*");
      $this->db->from($this->db5);      
      $this->db->where('inst_id !=', $inst_id);
      $this->db->where('room_id', $id);
      $this->db->where('start_time >', $start_date+1);
      $this->db->where('start_time <', $end_date-1);  
      $query=$this->db->get();
      return $query->result();
    }

    public function checkInstCalendar3($id, $inst_id, $start_date, $end_date)
    {
      $this->db->select("*");
      $this->db->from($this->db5);      
      $this->db->where('inst_id !=', $inst_id);
      $this->db->where('room_id', $id);
      $this->db->where('end_time >', $start_date+1);
      $this->db->where('end_time <', $end_date-1);  
      $query=$this->db->get();
      return $query->result();
    }

    public function getClassData($id)
    {
      $this->db->select("*");
      $this->db->where('id', $id);
      return $this->db->get($this->privatedb)->row();
    }

    public function checkClassesData($data, $id)
    {
      $this->db->select('room_id,course_id,instructor_id,duration,start_date,end_date,days,start_time,end_time,description,status,color');
      $this->db->from($this->privatedb);
      $this->db->where('room_id', $data['room_id']);
      $this->db->where('course_id', $data['course_id']);
      $this->db->where('instructor_id', $data['instructor_id']);
      $this->db->where('duration', $data['duration']);
      $this->db->where('days', $data['days']);
      $this->db->where('description', $data['description']);
      $this->db->where('start_time', $data['start_time']);
      $this->db->where('end_time', $data['end_time']);
      $this->db->where('start_date', $data['start_date']);
      $this->db->where('end_date', $data['end_date']);
      $this->db->where('color', $data['color']);
      $this->db->where('status', $data['status']);
      $this->db->where('id !=', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function updateClassData($data, $id)
    {
      $this->db->where('id', $id);
      $this->db->update($this->privatedb, $data);
      return true;
    }

    public function calendarRecordDelete($rid, $cid)
    {
      $this->db->where('room_id', $rid);
      $this->db->where('class_id', $cid);
      $this->db->delete($this->db5);
      return true;
    }

    public function getCalendarData($id, $start_date, $end_date)
    {      
      $this->db->select("course.cos_title as name,room.name as room,calendar.start_time,calendar.end_time,instructor.name as instructor");
      $this->db->from($this->db5);
      $this->db->join($this->privatedb, $this->privatedb.'.id = '.$this->db5.'.class_id', 'left');
      $this->db->join($this->db2, $this->db2.'.id = '.$this->privatedb.'.course_id', 'left');
      $this->db->join($this->db3, $this->db3.'.id = '.$this->privatedb.'.room_id', 'left');
      $this->db->join($this->db4, $this->db4.'.id = '.$this->privatedb.'.instructor_id', 'left');
      $this->db->where('class_id', $id);
      $this->db->where($this->db5.'.start_time >', $start_date);
      $this->db->where($this->db5.'.end_time <', $end_date);  
      $query=$this->db->get();
      return $query->result();
    }
    
    public function fetch_all_event($id){
      $this->db->select("course.cos_title as name,calendar.id,class.description,calendar.start_time,calendar.end_time,color,room.name as room,instructor.name as instructor");
      $this->db->join($this->privatedb, $this->privatedb.'.id = '.$this->db5.'.class_id', 'left');
      $this->db->join($this->db2, $this->db2.'.id = '.$this->privatedb.'.course_id', 'left');
      $this->db->join($this->db3, $this->db3.'.id = '.$this->privatedb.'.room_id', 'left');
      $this->db->join($this->db4, $this->db4.'.id = '.$this->privatedb.'.instructor_id', 'left');
      $this->db->where('calendar.class_id', $id);
      return $this->db->get($this->db5);
    }

    public function checkCalendarData($rid, $cid)
    {
      $this->db->from($this->db5);
      $this->db->where('room_id', $rid);
      $this->db->where('class_id', $cid);
      $this->db->where('status', 1);
      $query=$this->db->get();
      return $query->result();
    }

    public function classDelete($id)
    {
      $this->db->where('id', $id);
      $this->db->delete($this->privatedb);
      return true;
    }

  }

