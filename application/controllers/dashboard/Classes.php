<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Classes extends CI_Controller
  {
    private $private_db = "dashboard/Classes_Model";
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
      $this->key = "pe_classes";
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
				'title' => "Class Management",
				'uri' => array("class","class_list"),
				'respond' => array(
					'add' => 'admin/class/add'
				),
			);
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
      $result = $this->Classes_Model->getClassList();
      /** Modified User view configure */    
      $this->data['result'] = $this->__SetModifiedViwer($result);
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
      $this->load->view('dashboard/class/index', $this->data);
    }

    public function add()
    {
      $this->Header = array(
				'title' => "Add Class",
				'uri' => array("class","class_add"),
				'respond' => array(
					'list' => 'admin/class',
					'course' => $this->Classes_Model->getCourse(),
          'room' => $this->Classes_Model->getRoom(),
          'instructor' => $this->Classes_Model->getInstructor(),
				),
			);

      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);    
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, []);

      if($_POST) {
        $this->form_validation->set_rules('room','room','trim|required|xss_clean');
        $this->form_validation->set_rules('course','course','trim|required|xss_clean');
        $this->form_validation->set_rules('instructor','instructor','trim|required|xss_clean');
        $this->form_validation->set_rules('desc','description','trim|xss_clean');
        $this->form_validation->set_rules('class_days[]', 'days', 'trim|required|xss_clean|callback_option_check');
        $this->form_validation->set_rules('start_time', 'start time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_time', 'end time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_date', 'start date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_date', 'end date', 'trim|required|xss_clean');
        $this->form_validation->set_message('required', 'The %s required.');
      if ($this->form_validation->run() === false) {
        $this->load->view('dashboard/class/add', $this->data);
      } else {
        $selectday = substr(implode(', ', $this->input->post('class_days')), 0);
        $duration = $this->configlibrary->targetDateDifferent($this->input->post('start_date'),$this->input->post('end_date'), false);
        /**
         * Request Data validation on calendar!
         */
        $json = $this->__attendDateGenerate($this->input->post('class_days'), $this->input->post('start_date'), $this->input->post('end_date'), $this->input->post('start_time'), $this->input->post('end_time'));
        $this->configlibrary->targetUsort($json);
        foreach($json as $time) {
        $spliter = explode(' ~ ', $time);
          $checkdata1[] = $this->Classes_Model->checkPreCalendar1($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkdata2[] = $this->Classes_Model->checkPreCalendar2($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkdata3[] = $this->Classes_Model->checkPreCalendar3($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
    
          $checkinst1[] = $this->Classes_Model->checkInstCalendar1($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkinst2[] = $this->Classes_Model->checkInstCalendar2($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkinst3[] = $this->Classes_Model->checkInstCalendar3($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));

          $checkBoth1[] = $this->Classes_Model->checkRoomInstCalendar1($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkBoth2[] = $this->Classes_Model->checkRoomInstCalendar2($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkBoth3[] = $this->Classes_Model->checkRoomInstCalendar3($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));

          $acceptRoom[] = array(
            'room_id' => $this->input->post('room'),
            'start_time' => strtotime($spliter[0]),
            'end_time' => strtotime($spliter[1])
          );        
        }
        $betweenCheck = array_filter($checkdata1);
        $firstCheck = array_filter($checkdata2);
        $lastCheck = array_filter($checkdata3);

        $instCheck1 = array_filter($checkinst1);
        $instCheck2 = array_filter($checkinst2);
        $instCheck3 = array_filter($checkinst3);

        $bothCheck1 = array_filter($checkBoth1);
        $bothCheck2 = array_filter($checkBoth2);
        $bothCheck3 = array_filter($checkBoth3);
      
        if (!empty($betweenCheck) || !empty($firstCheck) || !empty($lastCheck)) {        
          $this->session->set_flashdata('msg_error', 'Your data (datetime and instructor) already exits! please select another time from except!');
          redirect('admin/class/add');
        } elseif (!empty($instCheck1) || !empty($instCheck2) || !empty($instCheck3)) {        
          $this->session->set_flashdata('msg_error', 'Your room is already exits! please select another room from except!');
          redirect('admin/class/add');
        } elseif (!empty($bothCheck1) || !empty($bothCheck2) || !empty($bothCheck3)) {
          $this->session->set_flashdata('msg_error', 'Your room and instructor are already exits! please select another from except!');
          redirect('admin/class/add');
        }else {        
            $data = array(        
              "room_id" => $this->input->post('room'),
              "course_id" => $this->input->post('course'),
              "instructor_id" => $this->input->post('instructor'),
              "description" => $this->input->post('desc'),
              "duration" => $duration,
              "days" => $selectday,
              "start_time" => $this->input->post('start_time'),
              "end_time" => $this->input->post('end_time'),
              "start_date" => $this->input->post('start_date'),
              "end_date" => $this->input->post('end_date'),
              "color" => $this->input->post('color'),
              "created_at" => date('Y-m-d H:i:s'),
              "updated_at" => date('Y-m-d H:i:s'),
              'created_by' => $this->current_id,
              'updated_by' => $this->current_id,
              "status" => $this->input->post('status')
            );

            $data = $this->securitylibrary->__Match_Xss($data);
            $insert_id = $this->Classes_Model->insertClasses($data);

            if($this->input->post('status') == 1) {
              if($insert_id){
                foreach($acceptRoom as $data) {
                  $data = array(
                    'room_id' => $data['room_id'],
                    'class_id' => $insert_id,
                    'inst_id' => $this->input->post('instructor'),
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'status' => 0,
                  );
                  $this->Classes_Model->insertClassForCalendar($data);
                }
                /** User Query Record **/
                $this->seqlibrary->__Set_seq_record('c','class','', $this->current_id);
              } else {
                $this->session->set_flashdata('msg_error', 'Something is wrong!');
                redirect('admin/class/add');
              }        
            }
            $this->session->set_flashdata('msg_success', 'Your data has been insert!');
            redirect('admin/class');
          }      
        }
      } else {
        $this->load->view('dashboard/class/add', $this->data);
      }
    }

    public function edit($id)
    {
      $this->Header = array(
				'title' => "Edit Class",
				'uri' => array("class","class_list"),
				'respond' => array(
					'list' => 'admin/class',
          'add' => 'admin/class/add',
					'course' => $this->Classes_Model->getCourse(),
          'room' => $this->Classes_Model->getRoom(),
          'instructor' => $this->Classes_Model->getInstructor(),
				),
			);
      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);    			    
      $this->data['result'] = $this->Classes_Model->getClassData($id);
      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/class", "Not allow!");
      /** User data marge **/
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
    
      if($_POST) {
        $this->form_validation->set_rules('room','room','trim|required|xss_clean');
        $this->form_validation->set_rules('course','course','trim|required|xss_clean');
        $this->form_validation->set_rules('instructor','instructor','trim|required|xss_clean');
        $this->form_validation->set_rules('desc','description','trim|xss_clean');
        $this->form_validation->set_rules('class_days[]', 'days', 'trim|required|xss_clean|callback_option_check');
        $this->form_validation->set_rules('start_time', 'start time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_time', 'end time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_date', 'start date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_date', 'end date', 'trim|required|xss_clean');
        $this->form_validation->set_message('required', 'The %s required');
      if ($this->form_validation->run() === false) {
        $this->load->view('dashboard/class/edit', $this->data);
      } else {
        $selectday = substr(implode(', ', $this->input->post('class_days')), 0);
        $duration = $this->configlibrary->targetDateDifferent($this->input->post('start_date'),$this->input->post('end_date'), false);

        /** Destroy preview record! */
          $this->Classes_Model->calendarRecordDelete($this->input->post('room'), $id);
          /**
         * Request Data validation on calendar!
         */
        $json = $this->__attendDateGenerate($this->input->post('class_days'), $this->input->post('start_date'), $this->input->post('end_date'), $this->input->post('start_time'), $this->input->post('end_time'));
        $this->configlibrary->targetUsort($json);
        foreach($json as $time) {
          $spliter = explode(' ~ ', $time);
          $checkdata1[] = $this->Classes_Model->checkPreCalendar1($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkdata2[] = $this->Classes_Model->checkPreCalendar2($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkdata3[] = $this->Classes_Model->checkPreCalendar3($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));

          $checkinst1[] = $this->Classes_Model->checkInstCalendar1($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkinst2[] = $this->Classes_Model->checkInstCalendar2($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkinst3[] = $this->Classes_Model->checkInstCalendar3($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));

          $checkBoth1[] = $this->Classes_Model->checkRoomInstCalendar1($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkBoth2[] = $this->Classes_Model->checkRoomInstCalendar2($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));
          $checkBoth3[] = $this->Classes_Model->checkRoomInstCalendar3($this->input->post('room'),$this->input->post('instructor'),strtotime($spliter[0]),strtotime($spliter[1]));

          $acceptRoom[] = array(
            'room_id' => $this->input->post('room'),
            'start_time' => strtotime($spliter[0]),
            'end_time' => strtotime($spliter[1])
          );        
        }
          $betweenCheck = array_filter($checkdata1);
          $firstCheck = array_filter($checkdata2);
          $lastCheck = array_filter($checkdata3);

          $instCheck1 = array_filter($checkinst1);
          $instCheck2 = array_filter($checkinst2);
          $instCheck3 = array_filter($checkinst3);

          $bothCheck1 = array_filter($checkBoth1);
          $bothCheck2 = array_filter($checkBoth2);
          $bothCheck3 = array_filter($checkBoth3);
        
          if (!empty($betweenCheck) || !empty($firstCheck) || !empty($lastCheck)) {        
            $this->session->set_flashdata('msg_error', 'Your data (datetime and instructor) already exits! please select another time from except!');
            redirect('admin/class/edit/'.$id);
          } elseif (!empty($instCheck1) || !empty($instCheck2) || !empty($instCheck3)) {        
            $this->session->set_flashdata('msg_error', 'Your room is already exits! please select another room from except!');
            redirect('admin/class/add');
          } elseif (!empty($bothCheck1) || !empty($bothCheck2) || !empty($bothCheck3)) {
            $this->session->set_flashdata('msg_error', 'Your room and instructor are already exits! please select another from except!');
            redirect('admin/class/add');
          } else {        
              $data = array(        
                "room_id" => $this->input->post('room'),
                "course_id" => $this->input->post('course'),
                "instructor_id" => $this->input->post('instructor'),
                "description" => $this->input->post('desc'),
                "duration" => $duration,
                "days" => $selectday,
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "start_date" => $this->input->post('start_date'),
                "end_date" => $this->input->post('end_date'),
                "color" => $this->input->post('color'),
                "updated_at" => date('Y-m-d H:i:s'),
                'updated_by' => $this->current_id,
                "status" => $this->input->post('status')
              );
              $data = $this->securitylibrary->__Match_Xss($data);
              $checkdata = $this->Classes_Model->checkClassesData($data, $id);

            if ($checkdata){
              $this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
              redirect('admin/class/edit/'.$id);
            } else {
              $return = $this->Classes_Model->updateClassData($data,$id);
              if($this->input->post('status') == 1) {
                  if($return) {
                    foreach($acceptRoom as $data) {
                      $data = array(
                        'room_id' => $data['room_id'],
                        'class_id' => $id,
                        'inst_id' => $this->input->post('instructor'),
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'status' => 0,
                      );
                      $this->Classes_Model->insertClassForCalendar($data);
                    }
                    /** User Query Record **/
                    $this->seqlibrary->__Set_seq_record('e','class',$id, $this->current_id);
                  } else {
                    $this->session->set_flashdata('msg_error', 'Something is wrong!');
                    redirect('admin/class/edit/'.$id);
                  }                                    
              } 
              $this->session->set_flashdata('msg_success', 'Your data has been updated!');
              redirect('admin/class');
            }
          }
        }
      } else {
        $this->load->view('dashboard/class/edit', $this->data);
      }
    }

    public function view($id)
    {
      $this->Header = array(
				'title' => "Overview Class",
				'uri' => array("class","class_list"),
				'respond' => array(
          'list' => 'admin/class',
					'add' => 'admin/class/add',
          'view' => '#slideRightModal',
					'id' => $id
				),
			);

      $respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);       
      $month = $this->configlibrary->targetWeeKMonth('month');
      $result = $this->Classes_Model->getCalendarData($id, $month['start'], $month['end']);

      $rearange = [];
      foreach($result as $row) {
        $rearange[] = array(
          "name" => $row->name,
          "room" => $row->room,
          "start_time" => $row->start_time,
          "end_time" => $row->end_time,
          "instructor" => $row->instructor,
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
      
      if(!empty($dateTime)) {
        array_multisort($dateTime,SORT_ASC,SORT_STRING,$rearange); 
      }
      $this->data['result'] = $rearange;

      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/class", "Not allow!");
      $this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
      $this->load->view('dashboard/class/overview', $this->data);
    }

    public function load($id = null)
    {
      $event_data = $this->Classes_Model->fetch_all_event($id);
      foreach($event_data->result_array() as $row)
      {
        $data[] = array(
        'id' => $row['id'],
        'title' => $row['name'],
        'description' => $row['description'],
        'room' => $row['room'],
        'start' => date('Y-m-d\TH:i:s', $row['start_time']),
        'end' => date('Y-m-d\TH:i:s', $row['end_time']),
        'instructor' => $row['instructor'],
        "backgroundColor" => $row['color'],
        "borderColor" => $row['color'],
        "url" => "",
        "customRender" => true
        );
      }
      echo json_encode($data);
    }

    public function delete($id)
    {
      /**
       * Class
       */
      $current = $this->Classes_Model->getClassData($id);
      /** Validation User data **/
      $this->securitylibrary->__MatchEmptyValid($id, $current, "/admin/class", "Not allow!");
      $checker = $this->Classes_Model->checkCalendarData($current->room_id, $current->id);
      
      if(count($checker) > 0) {
        $this->session->set_flashdata('msg_error', "Request data can't delete!");
        redirect('admin/class');
      } else {
        $this->Classes_Model->classDelete($id);
        $this->Classes_Model->calendarRecordDelete($current->room_id, $current->id);
        /** User Query Record **/
        $this->seqlibrary->__Set_seq_record('d','class',$id, $this->current_id);
        $this->session->set_flashdata('msg_success', 'Your data has been delete!');
        redirect('admin/class');
      }
    }

    public function option_check()
    {
      if(empty($this->input->post('class_days[]'))){
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

    /**
     * $data = day array('Sun','Mon','Tue','Wed','Thu','Fri','Sat','Sun');
     * $start_date
     * $end_date
     * $start_time
     * $end_time
     */
    public function __attendDateGenerate(array $data, $start_date, $end_date, $start_time, $end_time)
    {
      // Add days to date and display it
      $initial = date('Y-m-d', strtotime($start_date));
      $final = date('Y-m-d', strtotime($end_date));

      $target_date = $this->configlibrary->targetDateGenerate($data, $initial, $final, $start_time, $end_time);
      // return json_encode($target_date);
      return $target_date;
    }

  }