<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Role extends CI_Controller
  {  
    private $private_db = "dashboard/Role_Model";
    protected $session_id, $current_id, $username, $rolelevel, $permission, $current_session, $login_time, $csrf_key, $validsession, $site_name, $meta_tag, $timezone, $decimal_point ,$keyword,$modified_view, $user_config;
    protected $data, $key, $url, $refuse, $globalHeader, $author = "Neroaquicous", $Header = array("alert" => '','title' => "",'respond' => '', 'uri' => array());    
      
    public function __construct()
    {
      parent::__construct();    
      $this->load->database();
      $this->load->model($this->private_db);
      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('configlibrary');
      $this->load->library('securitylibrary');
      
      /** Initial session assign **/
      $this->__Set_SessionData();
      /** Set Default timezone **/
      $this->configlibrary->__SetTimeZone($this->timezone);
      /** Validation token and session for authrize **/
      $this->__MainTokenValid();      
      /** Pre Default value Set **/
      $this->key = "pe_admin";
      $this->url = "admin/panel/";
      $this->globalHeader = array(
        'respond' => array(
          'description' => $this->meta_tag,
					'keyword' => $this->keyword,
          'author' => $this->author,
        )
      );
      $this->refuse = array();
      /** User Permission Checker **/
      $this->securitylibrary->__MatchPermissionValid($this->key,$this->url, $this->refuse);	
    }

    public function index()
    {
      $this->Header = array(
        'title' => "Role Management",
        'uri' => array("role","role_list"),
        'respond' => array(
          'add' => 'admin/role/add',
        ),
      );
      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
      $result = $this->Role_Model->getRoleList();  
      /** Modified User view configure */    
      $this->data['result'] = $this->__SetModifiedViwer($result);      
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);			
      $this->load->view('dashboard/role/index', $this->data);
    }

    public function add()
    {
      $this->Header = array(
        'title' => "Add Role Level",
        'uri' => array("role","role_add"),
        'respond' => array(
          'list' => 'admin/role'
        ),
      );
      $this->data  = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
      $this->dbprefix = $this->db->dbprefix;
      if($_POST) {
        $this->form_validation->set_rules('role_name','name','trim|required|is_unique['.$this->dbprefix.'rolelevel.name]|xss_clean');
        $this->form_validation->set_rules('session','session','trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('permission[]','permission','trim|xss_clean|required|callback_option_check');
        $this->form_validation->set_message('required', 'You must provide %s');

      if ($this->form_validation->run() === false) {
          $this->load->view('dashboard/role/add', $this->data);
      } else {
          $perm = substr(implode(', ', $this->input->post('permission')), 0);
          $data = array(        
            "name" => $this->configlibrary->__SetStrToLower($this->input->post('role_name')),
            "session" => $this->input->post('session')*60,
            "config" => $perm,
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
            'created_by' => $this->current_id,
            'updated_by' => $this->current_id,
            "status" => $this->input->post('status')
          );
          $data = $this->securitylibrary->__Match_Xss($data);
          $this->Role_Model->insertRole($data);
          /** User Query Record **/
          $this->seqlibrary->__Set_seq_record('c','role','', $this->current_id);
          $this->session->set_flashdata('msg_success', 'Your data has been insert!');
          redirect('admin/role');
        }
      } else {
        $this->load->view('dashboard/role/add', $this->data);
      }
    }
    
    public function edit($id)
    {
      $this->Header = array(
        'title' => "Edit Role Level",
        'uri' => array("role","role_list"),
        'respond' => array(
          'list' => 'admin/role',
          'add' => 'admin/role/add',
        ),
      );
      $respondheader  = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
      $this->dbprefix = $this->db->dbprefix;
      $this->data['result'] = $this->Role_Model->getRoleData($id);
      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/role", "Not allow!");
      /** User data marge **/
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
    
      if($_POST) {
        $this->form_validation->set_rules('role_name','name','trim|required|xss_clean');
        $this->form_validation->set_rules('session','session','trim|required|numeric|integer|xss_clean');
        $this->form_validation->set_rules('permission[]','permission','trim|xss_clean|required|callback_option_check');

        $this->form_validation->set_message('required', 'You must provide %s');

        if ($this->form_validation->run() === false) {
          $this->load->view('dashboard/role/edit', $this->data);
        } else {
          $perm = substr(implode(', ', $this->input->post('permission')), 0);
          $data = array(
            "name" => $this->configlibrary->__SetStrToLower($this->input->post('role_name')),
            "session" => $this->input->post('session')*60,
            "config" => $perm,
            "updated_at" => date('Y-m-d H:i:s'),
            'updated_by' => $this->current_id,
            "status" => $this->input->post('status')
          );
          $data = $this->securitylibrary->__Match_Xss($data);
          $checkdata = $this->Role_Model->checkRoleData($data, $id);
          
          if ($checkdata){
            $this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
            redirect('admin/role/edit/'.$id, $data);
          } else {
            $this->Role_Model->updateRoleData($data,$id);
            /** User Query Record **/
            $this->seqlibrary->__Set_seq_record('e','role',$id, $this->current_id);
            $this->session->set_flashdata('msg_success', 'Your data has been updated!');
            redirect('admin/role');          
          }          
        }
      } else {
        $this->load->view('dashboard/role/edit', $this->data);
      }
    }

    public function delete($id)
    {
      $currentrole = $this->Role_Model->getRoleData($id);
      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $currentrole, "/admin/role", "Not allow!");
      $checker = $this->Role_Model->getParentRole($currentrole->name);    
      if(count($checker) > 0) {
        $this->session->set_flashdata('msg_error', "Request data can't delete!");
        redirect('admin/role');
      } else {
        $this->Role_Model->roleDelete($id);
        /** User Query Record **/
        $this->seqlibrary->__Set_seq_record('d','role',$id, $this->current_id);
        $this->session->set_flashdata('msg_success', 'Your data has been delete!');
        redirect('admin/role');
      }
    }

    public function option_check()
    {
      if(empty($this->input->post('permission[]'))){
        $this->form_validation->set_message('option_check', 'You must provide %s');
        return FALSE;
      } else {
        return TRUE;
      }
    }
  
    /************************************************
		* Initial Session Configure and CSRF Validator *
    * session_id, current_id, username, rolelevel, permission, current_session
    * login_time, csrf_key, validsession, site_name, meta_tag, decimal_point
    * timezone, keyword, user_config
		***********************************************/
    private function __Set_SessionData()
    {
      //Userdata
      $this->session_id  = isset($_SESSION['__user_sessionid'])?$_SESSION['__user_sessionid']:"";
      $this->current_id = isset($_SESSION['__user_information']['user_id'])?$_SESSION['__user_information']['user_id']:"";
      $this->username = isset($_SESSION['__user_information']['user_name'])?$_SESSION['__user_information']['user_name']:"";
      $this->rolelevel = isset($_SESSION['__user_information']['user_role'])?$_SESSION['__user_information']['user_role']:"";
      $this->permission = isset($_SESSION['__user_information']['user_permission'])?$_SESSION['__user_information']['user_permission']:"";
      $this->current_session = isset($_SESSION['__user_information']['session'])?$_SESSION['__user_information']['session']:"";
      $this->login_time = isset($_SESSION['__user_information']['login_time'])?$_SESSION['__user_information']['login_time']:"";
      $this->csrf_key = isset($_SESSION['__user_tokengenerate'])?$_SESSION['__user_tokengenerate']:"";
      $this->validsession = isset($_SESSION['__user_session_validator']['check_point'])?$_SESSION['__user_session_validator']['check_point']:"";
      //Sitedata
      $this->site_name = isset($_SESSION['__site_configure']['site_name'])?$_SESSION['__site_configure']['site_name']:"";
      $this->meta_tag = isset($_SESSION['__site_configure']['meta_tag'])?$_SESSION['__site_configure']['meta_tag']:"";
      $this->decimal_point = isset($_SESSION['__site_configure']['decimal_point'])?$_SESSION['__site_configure']['decimal_point']:"";
      $this->timezone = isset($_SESSION['__site_configure']['timezone'])?$_SESSION['__site_configure']['timezone']:"";
      $this->keyword = isset($_SESSION['__site_configure']['keyword'])?$_SESSION['__site_configure']['keyword']:""; 
      $this->modified_view = isset($_SESSION['__site_configure']['modified_view'])?$_SESSION['__site_configure']['modified_view']:""; 
      $this->user_config = isset($_SESSION['__site_configure'])?$_SESSION['__site_configure']:""; 
    }

    private function __MainTokenValid() 
    {
      if(empty($this->__PreTokenValid())) {
          redirect('auth/logout');
      }
    }

    private function __PreTokenValid()
    {
      if(empty($this->csrf_key) || $this->validsession == false) {
        return FALSE;
      } else {
        $data = $this->configlibrary->__SetMbSplit('_', $this->csrf_key);
        $key_info = $this->SQ_Get_authinfo($data[0].'_', $data[1]);
        if(!empty($key_info)) {
          return TRUE;
        } else {
          return FALSE;
        }
      }
    }

    private function __SetModifiedViwer($data)
    {
      $viwer = $this->configlibrary->__Match_customview($this->permission, $this->modified_view);

      $q1 = $this->SQ_Get_customizeuser();
      foreach($q1 as $row){
        $custom[$row->id] = array(
          'id' => $row->id,
          'name' => $row->username
        );
      }

      if($viwer == true) {
        foreach($data as $row) {
          $row->created_by = $this->configlibrary->__Set_ModifiedView($custom,$row->created_by);
          $row->updated_by = $this->configlibrary->__Set_ModifiedView($custom,$row->updated_by);
        }
      }      
      return $data;
    }

    private function SQ_Get_authinfo($token, $slug)
    {
      $this->db->select('*');
      $this->db->from("admin_session");
      $this->db->where('csrf_token_key', $token);
      $this->db->where('csrf_slug_key', $slug);
      return $this->db->get()->row();
    }

    private function SQ_Get_customizeuser()
    {
      $this->db->select('id,username');
      $this->db->from("admin");
      $query=$this->db->get();
      return $query->result();
    }
  }