<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Course_Model extends CI_Model
  {
    private $db1 = "course";
    private $db3 = "level";
    private $db7 = "subcategory";


    

    private $db4 = "batch";
    private $db5 = "student";
    private $db6 = "std_course";
    private $db8 = "std_profile";
    
    public function getTopic($unselected = true)
    {
      if ($unselected === true) {
        $data = array( '' => 'Select Subcategory');
      }
      $this->db->where('status', 1);
      $query = $this->db->get($this->db7);
      $result = $query->result();
      foreach ($result as $row) {
        $data[$row->id] = $row->name;
      }
      return $data;
    }
    
    public function getLevel($unselected = true)
    {
      if ($unselected === true) {
        $data = array( '' => 'Select Level');
      }
      $this->db->where('status', 1);
      $query = $this->db->get($this->db3);
      $result = $query->result();
      foreach ($result as $row) {
        $data[$row->id] = $row->name;
      }
      return $data;
    }

    public function fetch_course($key)
    {
      $this->db->where('subcat_id', $key);
      $this->db->order_by('id', 'ASC');
      $query = $this->db->get($this->db3);
      $output = '<option value="">Select Level</option>';
      $select = 'selected';
      foreach($query->result() as $row)
      {
      $output .= 
      '<option value="'.$row->id.'" '.((isset($level_id) && $level_id == $row->id) 
      ?"$select":"").'>'.$row->name.'</option>';
      }
      return $output;
    }

    public function getCourseList()
    {
      $this->db->select('course.id,cos_title,cos_des1,cos_image,cos_thumb,ref_key,course.status,subcategory.name as subcategory,course.created_at, course.updated_at,course.created_by, course.updated_by,slug_name,level.name as level');
      $this->db->from($this->db1);
      $this->db->join($this->db7, "".$this->db7.".id = ".$this->db1.".subcat_id", 'left');
      $this->db->join($this->db3, "".$this->db3.".id = ".$this->db1.".level_id", 'left');
      $this->db->order_by($this->db1.".id", "desc");
      $query=$this->db->get();
      return $query->result();
    }

    public function checkCourse($data)
    {
      $this->db->select('cos_title,cos_des1,level_id,ref_key,status,subcat_id');
      $this->db->from($this->db1);
      $this->db->where('cos_title', $data['cos_title']);
      $this->db->where('cos_des1', $data['cos_des1']);
      $this->db->where('subcat_id', $data['subcat_id']);
      $this->db->where('level_id', $data['level_id']);
      $this->db->where('ref_key', $data['ref_key']);
      $this->db->where('status', $data['status']);
      $query=$this->db->get();
      return $query->result();
    }

    public function checkEditCourse($data, $id)
    {
      $this->db->select('cos_title,cos_des1,level_id,ref_key,status,subcat_id');
      $this->db->from($this->db1);
      $this->db->where('cos_title', $data['cos_title']);
      $this->db->where('cos_des1', $data['cos_des1']);
      $this->db->where('subcat_id', $data['subcat_id']);
      $this->db->where('level_id', $data['level_id']);
      $this->db->where('ref_key', $data['ref_key']);
      $this->db->where('status', $data['status']);
      $this->db->where('id !=', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function checkSlug($slug, $id)
    {
      $this->db->select('slug_name');
      $this->db->from($this->db1);
      $this->db->where('slug_name', $slug);
      $this->db->where('id !=', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function insertCourse($data)
    {
        $this->db->insert($this->db1, $data);
        return true;
    }

    public function detailCourse($id)
    {
      $this->db->select('*');
      $this->db->where('id', $id);
      return $this->db->get($this->db1)->row();
    }

    public function detailCourseList($id)
    {
      $this->db->select('course.id,cos_title,cos_des1,level_id,cos_image,course.status,ref_key,level.name as level,slug_name,subcategory.name as subcategory');
      $this->db->join($this->db3, $this->db3.'.id = '.$this->db1.'.level_id', 'left');
      $this->db->join($this->db7, $this->db7.'.id = '.$this->db1.'.subcat_id', 'left');
      $this->db->where($this->db1.'.id', $id);
      return $this->db->get($this->db1)->row();
    }
    
    public function getTotalBatchDetail($id)
    {
      $this->db->select('*');
      $this->db->from($this->db4);
      $this->db->where("course_id", $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function getStudentLists($id)
    {
      $this->db->select('student.id as std_id, user_id,name,std_profile.request_date,std_profile.activate_date,email,phone,std_profile.status, image_file');
      $this->db->from($this->db6);
      $this->db->join($this->db5, $this->db5.'.id = '.$this->db6.'.std_id', 'left');
      $this->db->join($this->db8, $this->db8.'.std_id = '.$this->db6.'.std_id', 'left');
      $this->db->order_by($this->db6.'.request_date', 'DESC');
      $this->db->where($this->db6.'.cos_id', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function courseUpdate($data, $id)
    {
      $this->db->where('id', $id);
      $this->db->update($this->db1, $data);
      return true;
    }
    
    public function courseDelete($id)
    {
      $this->db->where('id', $id);
      $this->db->delete($this->db1);
      return true;
    }

  }
