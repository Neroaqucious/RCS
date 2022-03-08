<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Dashboard extends CI_Controller 
  {
    private $private_db = "dashboard/Dashboard_Model";
		protected $session_id, $current_id, $username, $rolelevel, $permission, $current_session, $login_time, $csrf_key, $validsession, $site_name, $meta_tag, $timezone, $decimal_point ,$keyword;
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
			$this->globalHeader = array(
        'respond' => array(
          'description' => $this->meta_tag,
					'keyword' => $this->keyword,
          'author' => $this->author,
        )
      );
    }

    public function index()
    {
      $this->Header = array(
        'title' => "Admin Management",
				'uri' => array("dashboard",""),
      );
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);	
      
      $this->data['room'] = $this->Dashboard_Model->getRoomCount();
      $this->data['instructor'] = $this->Dashboard_Model->getInstructorListCount();
      $this->data['course_count'] = $this->Dashboard_Model->getCourseCount();
      $this->data['class_count'] = $this->Dashboard_Model->getClassCount();
      $result = $this->Dashboard_Model->getCalendarData();
      $rearange = [];
      foreach($result as $row) {
        $rearange[] = array(
          "id" => $row->id,
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
        $id[] = $key['id'];
        $name[] = $key['name'];
        $room[] = $key['room'];
        $start_time[] = $key['start_time'];
        $end_time[] = $key['end_time'];
        $instructor[] = $key['instructor'];
      }
      
      if(!empty($dateTime)) {
        array_multisort($dateTime,SORT_ASC,SORT_STRING,$rearange); 
      }
      $this->data['result'] = $rearange;

			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
      $this->load->view('dashboard/admin/index', $this->data);
    }

    public function load($id = null)
    {
      $event_data = $this->Dashboard_Model->fetch_all_event();
      foreach($event_data->result_array() as $row)
      {
        $data[] = array(
        'id' => $row['id'],
        'title' => $row['name'],
        'description' => $row['description'],
        'room' => $row['room'],
        'instructor' => $row['instructor'],
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



    /*********************
     * Initially session configure and reassign
    ********************/
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

    /*********************
     * DB Qurey 
     ********************/
    private function SQ_Get_authinfo($token, $slug)
    {
      $this->db->select('*');
      $this->db->from("admin_session");
      $this->db->where('csrf_token_key', $token);
      $this->db->where('csrf_slug_key', $slug);
      return $this->db->get()->row();
    }


  }
