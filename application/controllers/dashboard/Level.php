<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Level extends CI_Controller
  {
    private $private_db = "dashboard/Level_Model"; 
    protected $session_id, $current_id, $username, $rolelevel, $permission, $current_session, $login_time, $csrf_key, $validsession, $site_name, $meta_tag, $timezone, $decimal_point ,$keyword,$modified_view, $user_config, $dbprefix;
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
      $this->key = "pe_category";
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
        'title' => "Level Management",
        'uri' => array("category","level_list"),
        'respond' => array(
          'modal' => '#addNoteModal'        
        ),
      );
      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
      $result = $this->Level_Model->levelList();
      /** Modified User view configure */    
      $this->data['result'] = $this->__SetModifiedViwer($result);
      $this->data['subcategory'] = $this->Level_Model->getSubCategory();
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);	
      $this->dbprefix = $this->db->dbprefix;

      if($_POST) {
        $this->form_validation->set_rules('name', 'level name', 'trim|required|xss_clean|min_length[2]|is_unique['.$this->dbprefix.'level.name]');
        $this->form_validation->set_rules('subcatid', 'subcategory name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('desc', 'description', 'trim|xss_clean');
        $this->form_validation->set_error_delimiters("","");

        if ($this->form_validation->run() === false) {
          $this->load->view('dashboard/level/list', $this->data);
        } else {
          $data = array(
            'subcat_id' => $this->input->post('subcatid'),
            'name' => $this->configlibrary->__SetStrToLower($this->input->post('name')),
            'description' => $this->input->post('desc'),
            'status' => $this->input->post('status'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->current_id,
            'updated_by' => $this->current_id,
          );
          $data = $this->securitylibrary->__Match_Xss($data);

          if($data){
            $this->Level_Model->insert($data);
            /** User Query Record **/
            $this->seqlibrary->__Set_seq_record('c','level','', $this->current_id);
            $this->session->set_flashdata('msg_success', 'Your data has been insert!');
            redirect('admin/level');
          }
        }
      } else {
        $this->load->view('dashboard/level/list', $this->data);
      }
    }

    public function add()
    {
      $this->index();
    }

    public function edit($id)
    {
      $this->Header = array(
        'title' => "Edit Level",
        'uri' => array("category","level_list"),
        'respond' => array(
          'list' => 'admin/level'        
        ),
      );
      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
      $this->data['result'] = $this->Level_Model->detail($id);
      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/level", "Not allow!");
      $this->data['subcategory'] = $this->Level_Model->getSubCategory();
      /** User data marge **/
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);		
      if($_POST) {
        $this->form_validation->set_rules('name', 'level name', 'trim|required|xss_clean|min_length[1]');
        $this->form_validation->set_rules('subcatid', 'subcategory name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('desc', 'description', 'trim|xss_clean');

        $this->form_validation->set_message('required', 'You must enter a %s!');
        $this->form_validation->set_message('is_unique', 'Your %s is already exits!');

        if ($this->form_validation->run() === false) {
          $this->load->view('dashboard/level/edit', $this->data);
        } else {
          $data = array(
              'subcat_id' => $this->input->post('subcatid'),
              'name' => $this->configlibrary->__SetStrToLower($this->input->post('name')),
              'description' => $this->input->post('desc'),
              'status' => $this->input->post('status'),
              'updated_at' => date("Y-m-d H:i:s"),
              'updated_by' => $this->current_id,
          );

          $data = $this->securitylibrary->__Match_Xss($data);
          $checkdata = $this->Level_Model->levelChecks($data, $id);

          if ($checkdata){
            $this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
            redirect('admin/level/edit/'.$id);
          } else {
            $this->Level_Model->levelUpdate($data, $id);
            /** User Query Record **/
            $this->seqlibrary->__Set_seq_record('e','level',$id, $this->current_id);
            $this->session->set_flashdata('msg_success', 'Your data has been update!');
            redirect("admin/level");
          }				
        }
      } else {
        $this->load->view('dashboard/level/edit', $this->data);
      }
    }

    public function delete($id)
    {
      /**
       * SubCategory /GET 
       */
      $current = $this->Level_Model->detail($id);
      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $current, "/admin/level", "Not allow!");
      $parentChecker = $this->Level_Model->checkParentlevel($id);		
      if(count($parentChecker) > 0 ) {
        $this->session->set_flashdata('msg_error', "Request data can't delete!");
        redirect('admin/level');
      } else {
        $this->Level_Model->levelDelete($id);
        /** User Query Record **/
        $this->seqlibrary->__Set_seq_record('d','level',$id, $this->current_id);
        $this->session->set_flashdata('msg_success', 'Your data has been delete!');
        redirect('admin/level');
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
