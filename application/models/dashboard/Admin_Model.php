<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * # VIEW CHECK POINT #
 */
  class Admin_Model extends CI_Model
  {
    private $db1 = "admin";
    private $db2 = "admin_profile";
    private $db3 = "admin_session";
    private $db4 = "rolelevel";

    public function getAdminList()
    {
      $this->db->select('admin.id,username,rolelevel.name as role,admin.status,admin_profile.created_at,admin_profile.updated_at,admin_profile.created_by,admin_profile.updated_by');
      $this->db->from($this->db1);
      $this->db->join($this->db2, $this->db2.'.admin_id = '.$this->db1.'.id', 'left' );
      $this->db->join($this->db4, $this->db4.'.id = '.$this->db1.'.role', 'left' );
      $query=$this->db->get();
      return $query->result();
    }

    public function getUserDataList($id)
    {
      $this->db->select('admin.id as id,admin.password,username,password,admin.status,address,admin_profile.name as full_name,email,phone,rolelevel.config,rolelevel.session,rolelevel.name as role,rolelevel.session');
      $this->db->where('admin.id', $id);
      $this->db->join($this->db2, $this->db2.'.admin_id = '.$this->db1.'.id', 'left' );
      $this->db->join($this->db4, $this->db4.'.id = '.$this->db1.'.role', 'left' );
      return $this->db->get($this->db1)->row();
    }

    public function getUserSessionRecordList($id) {
      $this->db->select('*');
      $this->db->from($this->db3);
      $this->db->where('admin_id', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function roleLevel($unselected = true)
    {
      if ($unselected === true) {
        $data = array( '' => 'Select Role');
      }
      $this->db->where('status', 1);
      $query = $this->db->get($this->db4);
      $result = $query->result();
      foreach ($result as $row) {
        $data[$row->id] = strtolower($row->name);
      }
      return $data;
    }

    public function getAdminDataList($id)
    {
      $this->db->select('admin.id as id,username,admin.status,role as role,admin_profile.name,email,phone,address');
      $this->db->where('admin.id', $id);
      $this->db->join($this->db2, $this->db2.'.admin_id = '.$this->db1.'.id', 'left' );
      $this->db->join($this->db4, $this->db4.'.id = '.$this->db1.'.role', 'left' );
      return $this->db->get($this->db1)->row();
    }

    public function checkUserProfile($data, $except)
    {
      $this->db->select('email');
      $this->db->from($this->db2);	
      $this->db->where('email', $data['email']);
      $this->db->where('admin_id !=', $except);
      $query=$this->db->get();
      return $query->result();
    }

    public function checkUserName($data, $except)
    {
      $this->db->select('username');
      $this->db->from($this->db1);	
      $this->db->where('username', $data['username']);
      $this->db->where('id !=', $except);
      $query=$this->db->get();
      return $query->result();
    }

    public function updateAdminAuthorize($data, $id)
    {
      $this->db->where('id', $id);
      $this->db->update($this->db1, $data);
      return true;
    }
    
    public function updateAdminProfile($data, $id)
    {
      $this->db->where('admin_id', $id);
      $this->db->update($this->db2, $data);
      return true;
    }

    public function adminDelete($id)
    {
      $this->db->where('id', $id);
      $this->db->delete($this->db1);
      return true;
    }

    public function adminProfileDelete($id)
    {
      $this->db->where('admin_id', $id);
      $this->db->delete($this->db2);
      return true;
    }

    public function adminRecordDelete($id,$user = null)
    {
      if(!empty($user)) {
        $this->db->where('id !=', $user);
      }
      $this->db->where('admin_id', $id);
      $this->db->delete($this->db3);
      return true;
    }

    public function updateAdminPassword($data, $id)
    {
      $this->db->where('id', $id);
      $this->db->update($this->db1, $data);
      return true;
    }

    public function userInsert($data)
    {
      $this->db->insert($this->db1, $data);
      $id = $this->db->insert_id();
      return (isset($id)) ? $id : FALSE;
    }

    public function userProfileInsert($data)
    {
      $this->db->insert($this->db2, $data);
      return true;
    }

  }

