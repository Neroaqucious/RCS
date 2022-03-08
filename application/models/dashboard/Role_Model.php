<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * # VIEW CHECK POINT #
 */
  class Role_Model extends CI_Model
  {
    private $privatedb = "rolelevel";
    private $db1 = "admin";

    public function getRoleList()
    {
      $this->db->select("*");
      $this->db->from($this->privatedb);
      $query=$this->db->get();
      return $query->result();
    }

    public function insertRole($data)
    {
      $this->db->insert($this->privatedb, $data);
      return true;
    }

    public function getRoleData($id)
    {
      $this->db->select("*");
      $this->db->where('id', $id);
      return $this->db->get($this->privatedb)->row();
    }

    public function checkRoleData($data, $id)
    {
      $this->db->select('name,config,session,status');
      $this->db->from($this->privatedb);
      $this->db->where('name', $data['name']);
      $this->db->where('config', $data['config']);
      $this->db->where('session', $data['session']);
      $this->db->where('status', $data['status']);
      $this->db->where('id !=', $id);
      $query=$this->db->get();
      return $query->result();
    }

    public function updateRoleData($data, $id)
    {
      $this->db->where('id', $id);
      $this->db->update($this->privatedb, $data);
      return true;
    }
    
    public function getParentRole($role){
      $this->db->select("*");
      $this->db->from($this->db1);
      $this->db->where('role', $role);
      $query=$this->db->get();
      return $query->result();
    }

    public function roleDelete($id)
    {
      $this->db->where('id', $id);
      $this->db->delete($this->privatedb);
      return true;
    }

  }

