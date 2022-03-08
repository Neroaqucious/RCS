<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Room extends CI_Controller
  {
    private $private_db = "dashboard/Room_Model"; 
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
      $this->load->library('seqlibrary');
      
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
        'title' => "Room Management",
        'uri' => array("category","room_list"),
        'respond' => array(
          'add' => 'admin/room/add'        
        ),
      );
      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
      $result = $this->Room_Model->getRoomList();
      /** Modified User view configure */    
      $this->data['result'] = $this->__SetModifiedViwer($result);
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
      $this->load->view('dashboard/room/index', $this->data);
    }

    public function add()
    {
      $this->Header = array(
        'title' => "Add Room",
        'uri' => array("category","room_list"),
        'respond' => array(
          'list' => 'admin/room'        
        ),
      );
      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);    
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, []);
      $this->dbprefix = $this->db->dbprefix;
      if($_POST) {
        $this->form_validation->set_rules('name','name','trim|required|is_unique['.$this->dbprefix.'room.name]|xss_clean');
        $this->form_validation->set_rules('description','description','trim|xss_clean');
        $this->form_validation->set_message('required', 'You must provide %s');

      if ($this->form_validation->run() === false) {
          $this->load->view('dashboard/room/add', $this->data);
      } else {
          $data = array(        
            "name" => $this->input->post('name'),
            "description" => $this->input->post('description'),
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
            'created_by' => $this->current_id,
            'updated_by' => $this->current_id,
            "status" => $this->input->post('status')
          );
          $data = $this->securitylibrary->__Match_Xss($data);
          $this->Room_Model->insertRoom($data);
          /** User Query Record **/
          $this->seqlibrary->__Set_seq_record('c','room','', $this->current_id);
          $this->session->set_flashdata('msg_success', 'Your data has been insert!');
          redirect('admin/room');
        }
      } else {
        $this->load->view('dashboard/room/add', $this->data);
      }
    }
    
    public function edit($id)
    {
      $this->Header = array(
        'title' => "Edit Room",
        'uri' => array("category","room_list"),
        'respond' => array(
          'list' => 'admin/room',
          'id' => $id 
        ),
      );
      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);    
      $this->data['result'] = $this->Room_Model->getRoomData($id);
      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/room", "Not allow!");
      /** User data marge **/
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
    
      if($_POST) {
        $this->form_validation->set_rules('name','name','trim|required|xss_clean');
        $this->form_validation->set_rules('description','description','trim|xss_clean');
        $this->form_validation->set_message('required', 'You must provide %s');

      if ($this->form_validation->run() === false) {
          $this->load->view('dashboard/room/edit', $this->data);
      } else {
          $data = array(
            "name" => $this->input->post('name'),
            "description" => $this->input->post('description'),
            "updated_at" => date('Y-m-d H:i:s'),
            'updated_by' => $this->current_id,
            "status" => $this->input->post('status')
          );
          $data = $this->securitylibrary->__Match_Xss($data);

          $checkdata = $this->Room_Model->checkRoomData($data, $id);        
          if ($checkdata){
            $this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
            redirect('admin/room/edit/'.$id, $data);
          } else {
            $this->Room_Model->updateRoomData($data,$id);
            /** User Query Record **/
            $this->seqlibrary->__Set_seq_record('e','room',$id, $this->current_id);
            $this->session->set_flashdata('msg_success', 'Your data has been updated!');
            redirect('admin/room');
          }        
        }
      } else {
        $this->load->view('dashboard/room/edit', $this->data);
      }
    }

    public function delete($id)
    {
      /** 
       * Room GET/
       * **/
      $current = $this->Room_Model->getRoomData($id);
      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $current, "/admin/room", "Not allow!");
      $checker = $this->Room_Model->getParentRoom($current->id);    
      if(count($checker) > 0) {
        $this->session->set_flashdata('msg_error', "Request data can't delete!");
        redirect('admin/room');
      } else {
        $this->Room_Model->roomDelete($id);
        /** User Query Record **/
        $this->seqlibrary->__Set_seq_record('d','room',$id, $this->current_id);
        $this->session->set_flashdata('msg_success', 'Your data has been delete!');
        redirect('admin/room');
      }
    }
    
    public function view($id)
    {
      $this->Header = array(
				'title' => "Overview Room",
				'uri' => array("room","room_list"),
				'respond' => array(
          'list' => 'admin/room',
					'add' => 'admin/room/add',
          'view' => '#slideRightModal',
					'id' => $id
				),
			);
      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
      $result = $this->Room_Model->getCalendarData($id);

      $rearange = [];
      foreach($result as $row) {
        $rearange[] = array(
          "name" => $row->name,
          "room" => $row->room,
          "start_time" => $row->start_time,
          "end_time" => $row->end_time,
          "instructor" => $row->instructor,
          "course" => $row->course,
        );
      }

      foreach($rearange as $c=>$key) {
        $dateTime[] = $key['start_time'];
        $name[] = $key['name'];
        $room[] = $key['room'];
        $start_time[] = $key['start_time'];
        $end_time[] = $key['end_time'];
        $instructor[] = $key['instructor'];
      }

      array_multisort($dateTime,SORT_ASC,SORT_STRING,$rearange); 
      $this->data['result'] = $rearange;

      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/room", "No calendar record!");

      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
      $this->load->view('dashboard/room/overview', $this->data);
    }

    public function load($id = null)
    {
      $event_data = $this->Room_Model->fetch_all_event($id);
      foreach($event_data->result_array() as $row)
      {
        $data[] = array(
        'id' => $row['id'],
        'title' => $row['name'],
        'instructor' => $row['instructor'],
        'description' => $row['description'],
        'room' => $row['room'],
        'start' => date('Y-m-d\TH:i:s', $row['start_time']),
        'end' => date('Y-m-d\TH:i:s', $row['end_time']),
        "backgroundColor" => $row['color'],
        "borderColor" => $row['color'],
        "url" => "",
        "customRender" => true
        );
      }
      echo json_encode($data);
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