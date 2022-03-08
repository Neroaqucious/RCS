<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Seqlibrary 
  {
    protected $CI, $data, $seq1 = "dashboard/Config_Model";
    /**
     * Custom Config Library ()
     **/
    public function __construct()
    {
      $this->CI =& get_instance();
      $this->CI->load->model($this->seq1);
    }

    /** 
     * c = Created
     * e = Edit
     * d = Delete
     * **/
    private function __Match_seq_transfer($key, $title, $id = null) 
    {
      $data = array(
        'a' => '%name% created',
        'e' => '%name% id (%id%) edited',
        'd' => '%name% id (%id%) deleted',
      );

      switch($key){
        case 'c':
        $return = str_replace('%name%',$title,$data['a']);
        break;
  
        case 'e':
        $return = str_replace('%name%',$title,$data['e']);
          if(!empty($id)){
            $return = str_replace('%id%',$id,$return);
          }
        break;
  
        case 'd':
        $return = str_replace('%name%',$title,$data['d']);
          if(!empty($id)){
            $return = str_replace('%id%',$id,$return);
          }
        break;

        default:
          $return = '';
          break;
      }  
      return $return;
    }   

    public function __Set_seq_record($key, $title, $id = null, $adm_id) 
    {
      $query = $this->__Match_seq_transfer($key, $title, $id);
      $this->data = array(
        'admin_id' => $adm_id,
        'query' => $query,
        'timezone' => now(),
      );
      $query = $this->CI->securitylibrary->__Match_Xss($this->data);
      $seqcheck = $this->CI->Config_Model->seqInsert($query);
      return $seqcheck;
    }

  }