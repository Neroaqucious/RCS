<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Instructor extends CI_Controller
	{
		//db and configuration
		private $private_db = "dashboard/Instructor_Model";
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
			$this->key = "pe_instructor";
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
				'title' => "Instructor Management",
				'uri' => array("instructor","instructor_list"),
				'respond' => array(
					'add' => 'admin/instructor/add'
				),
			);
			
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$list = $this->Instructor_Model->getInstructorList();
			$this->data['result'] = $this->__SetModifiedViwer($list);			
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
			$this->load->view('dashboard/instructor/list', $this->data);
		}

		public function add()
		{
			$this->Header = array(
				'title' => "Add Instructor",
				'uri' => array("instructor","instructor_add"),
				'respond' => array(
					'list' => 'admin/instructor',
				),
			);
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, []);
			$this->dbprefix = $this->db->dbprefix;

			if($_POST) {
				$this->form_validation->set_rules('full_name', 'instructor name', 'trim|required|min_length[5]|is_unique['.$this->dbprefix.'instructor.name]|xss_clean');
				$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique['.$this->dbprefix.'instructor.email]|xss_clean');
				$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[30]|xss_clean');
				$this->form_validation->set_rules('conf_password', 'confirm password', 'trim|required|min_length[6]|max_length[30]|xss_clean|matches[password]');
				$this->form_validation->set_rules('address', 'address', 'trim|xss_clean');      
				$this->form_validation->set_rules('birthday', 'birthday', 'trim|xss_clean');
				$this->form_validation->set_rules('education', 'education', 'trim|xss_clean');
				$this->form_validation->set_rules('nrc', 'NRC Number', 'trim|xss_clean');
				$this->form_validation->set_rules('lecture', 'lecture', 'trim|xss_clean');
				$this->form_validation->set_rules('phone', 'phone number', 'trim|required|numeric|xss_clean');

				$this->form_validation->set_message('required', 'You must enter %s!');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_message('valid_email', 'The %s must be valid!');
				$this->form_validation->set_error_delimiters("","");

				if ($this->form_validation->run() === false) {
					$this->load->view('dashboard/instructor/add', $this->data);
				} else {
					$lastid = $this->Instructor_Model->getLastID();   
					$lastid = (isset($lastid->id)?$lastid->id:0);
					$lastid = $this->configlibrary->__Set_SerialID("inst_", $lastid, 5);
					$password = $this->securitylibrary->__SetPasswordHashing($this->input->post('password'));
					
					$data = array(
						'inst_id' => $lastid,
						'name' => $this->input->post('full_name'),
						'email' => $this->input->post('email'),
						'password' => $password,
						'phone' => $this->input->post('phone'),
						'address' => $this->input->post('address'),
						'birthday' => $this->input->post('birthday'),
						'nrc' => $this->input->post('nrc'),
						'education' => $this->input->post('education'),
						'lecture' => $this->input->post('lecture'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->current_id,
            'updated_by' => $this->current_id,
						'status' => $this->input->post('status'),
					);
					$data = $this->securitylibrary->__Match_Xss($data);					
	
					$this->Instructor_Model->insertInstructor($data);
					$this->session->set_flashdata('msg_success', 'Your data has been insert!');
					redirect('admin/instructor');
				}
			} else {
				$this->load->view('dashboard/instructor/add', $this->data);
			}
		}

		public function edit($id)
		{
			$this->Header = array(
				'title' => "Edit Instructor",
				'uri' => array("instructor","instructor_list"),
				'respond' => array(
					'list' => 'admin/instructor',
					'add' => 'admin/instructor/add',
				),
			);

			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$this->data['result'] = $this->Instructor_Model->getInstructorData($id);
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/instructor", "Not allow!");			
			/** User data marge **/
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);

			if($_POST) {
				$this->form_validation->set_rules('full_name', 'instructor name', 'trim|required|min_length[5]|xss_clean');
				$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
				$this->form_validation->set_rules('password', 'password', 'trim|min_length[6]|max_length[30]|xss_clean');
				$this->form_validation->set_rules('conf_password', 'confirm password', 'trim|min_length[6]|max_length[30]|xss_clean|matches[password]');
				$this->form_validation->set_rules('address', 'address', 'trim|xss_clean');      
				$this->form_validation->set_rules('birthday', 'birthday', 'trim|xss_clean');
				$this->form_validation->set_rules('education', 'education', 'trim|xss_clean');
				$this->form_validation->set_rules('nrc', 'NRC Number', 'trim|required|xss_clean');
				$this->form_validation->set_rules('lecture', 'lecture', 'trim|xss_clean');
				$this->form_validation->set_rules('phone', 'phone number', 'trim|required|numeric|xss_clean');
				
				$this->form_validation->set_message('required', 'You must enter %s!');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_message('valid_email', 'The %s must be valid!');
				$this->form_validation->set_error_delimiters("","");

				if ($this->form_validation->run() === false) {
					$this->load->view('dashboard/instructor/edit', $this->data);
				} else {

					$data = array(
						'name' => $this->input->post('full_name'),
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'address' => $this->input->post('address'),
						'birthday' => $this->input->post('birthday'),
						'nrc' => $this->input->post('nrc'),
						'education' => $this->input->post('education'),
						'lecture' => $this->input->post('lecture'),
						'updated_at' => date('Y-m-d H:i:s'),
						'updated_by' => $this->current_id,
						'status' => $this->input->post('status'),
					);
					if(!empty($this->input->post('password'))) {
						$data['password'] = $this->securitylibrary->__SetPasswordHashing($this->input->post('password'));
					}
					$data = $this->securitylibrary->__Match_Xss($data);

					$checkdata = $this->Instructor_Model->checkInstructorData($data, $id);
      		$checkemail = $this->Instructor_Model->checkInstructor($this->input->post('std_email'),$id);

					if ($checkdata || $checkemail){
						$this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
						redirect('admin/instructor/edit/'.$id, $data);
					} else {
						$this->Instructor_Model->updateInstructorData($data,$id);
						$this->session->set_flashdata('msg_success', 'Your data has been updated!');
						redirect('admin/instructor');
					}				
				}
			} else {
				$this->load->view('dashboard/instructor/edit', $this->data);
			}
		}

		public function view($id)
		{
			$this->Header = array(
				'title' => "View Instructor",
				'uri' => array("instructor","instructor_list"),
				'respond' => array(
					'add' => 'admin/instructor/add',
					'list' => 'admin/instructor',
				),
			);

			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$this->data['result'] = $this->Instructor_Model->getInstructorData($id);			
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/instructor", "Not allow!");
			/** User data marge **/
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
			$this->load->view('dashboard/instructor/view', $this->data);
		}

		public function delete($id)
		{
			/** 
			 * Instructor GET/
			 **/
			$current = $this->Instructor_Model->getInstructorData($id);
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $current, "/admin/instructor", "Not allow!");

			$checker = $this->Instructor_Model->getParentInstrcutor($current->id);

			if(count($checker) > 0) {
				$this->session->set_flashdata('msg_error', "Request data can't delete!");
				redirect('admin/instructor');
			} else {
				$this->Instructor_Model->instructorDelete($id);
				$this->session->set_flashdata('msg_success', 'Your data has been delete!');
				redirect('admin/instructor');
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
