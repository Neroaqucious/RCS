<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Admin extends CI_Controller 
  {
    private $private_db = "dashboard/Admin_Model";
		protected $session_id, $current_id, $username, $rolelevel, $permission, $current_session, $login_time, $csrf_key, $validsession, $site_name, $meta_tag, $timezone, $decimal_point ,$keyword, $modified_view, $user_config;
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
      $this->key = "admin";
			$this->url = "admin/panel/";
			$this->globalHeader = array(
        'respond' => array(
          'description' => $this->meta_tag,
					'keyword' => $this->keyword,
          'author' => $this->author,
        )
      );
      $this->refuse = array('admin/profile', 'admin/password','admin/edit', 'delete/record');		
			/** User Permission Checker **/
			$this->securitylibrary->__MatchPermissionValid($this->key,$this->url, $this->refuse);	
    }

    /**************************
		 * ALL User Configuration *
		 *************************/
		public function index()
		{			
			$this->Header = array(
        'title' => "Admin Management",
				'uri' => array("admin","admin_list"),
        'respond' => array(
          'add' => 'admin/auth/add',
          'list' => '',					
        ),
      );
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$result = $this->Admin_Model->getAdminList();
			/** Modified User view configure */    
      $this->data['result'] = $this->__SetModifiedViwer($result);      
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);	
			$this->load->view('dashboard/admin/lists', $this->data);
		}

		public function views($id)
		{
			$this->Header = array(
        'title' => "User Detail",
				'uri' => array("admin","admin_list"),
        'respond' => array(
          'add' => 'admin/auth/add',
          'list' => 'admin/auth/list',
					'config' => $this->user_config,
					'id' => $id
        ),
      );
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);			
			$this->data['result'] = $this->Admin_Model->getUserDataList($id);
			$this->data['record'] = $this->Admin_Model->getUserSessionRecordList($id);
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/auth/list", "Not allow!");
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);			
			$this->load->view('dashboard/admin/views', $this->data);
		}
		
		public function add()
		{
			$this->Header = array(
        'title' => "Add Users",
				'uri' => array("admin","admin_add"),
        'respond' => array(
          'list' => 'admin/auth/list',
					'rolelist' => $this->Admin_Model->roleLevel(),
        ),
      );
			$this->data  = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			
			if($_POST) {
				$this->form_validation->set_rules('user_name','user name','trim|required|xss_clean|min_length[3]|is_unique[PKT_admin.username]');
				$this->form_validation->set_rules('user_pass','password','trim|required|xss_clean|min_length[6]|max_length[30]');
				$this->form_validation->set_rules('user_conf_pass','confirm password','trim|required|matches[user_pass]|xss_clean|min_length[6]|max_length[30]');
				$this->form_validation->set_rules('role','role permission','trim|required|xss_clean');
				$this->form_validation->set_rules('status','status','trim|xss_clean');
				$this->form_validation->set_rules('admin_name','full name','trim|required|xss_clean');
				$this->form_validation->set_rules('admin_email','email','trim|required|xss_clean|valid_email|is_unique[PKT_admin_profile.email]');
				$this->form_validation->set_rules('admin_phone','phone','trim|xss_clean|required|numeric');
			
				$this->form_validation->set_message('required', 'You must enter %s!');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_message('valid_email', 'The %s must be valid!');
			if ($this->form_validation->run() === false) {
					$this->load->view('dashboard/admin/add', $this->data);
			} else {
				$password = $this->securitylibrary->__SetPasswordHashing($this->input->post('user_pass'));
				$authorize = array(
					'username' => $this->input->post('user_name'),
					'password' => $password,
					'role' => $this->input->post('role'),
					'status' => $this->input->post('status')
				);
				$authorize = $this->securitylibrary->__Match_Xss($authorize);
				$user_id = $this->Admin_Model->userInsert($authorize);

					if (!empty($user_id)){
						$profile = array(
							'admin_id' => $user_id,
							'name' => $this->input->post('admin_name'),
							'email' => $this->input->post('admin_email'),
							'phone' => $this->input->post('admin_phone'),
							'address' => $this->input->post('admin_address'),
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
							'created_by' => $this->current_id,
							'updated_by' => $this->current_id,
						);
						$profile = $this->securitylibrary->__Match_Xss($profile);
						$this->Admin_Model->userProfileInsert($profile);
						/** User Query Record **/
            $this->seqlibrary->__Set_seq_record('c','admin','', $this->current_id);
						$this->session->set_flashdata('msg_success', 'Your data has been insert!');
						redirect("admin/auth/list");

					} else {
						$this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
						redirect("admin/auth/add");
					}
				}
			} else {
				$this->load->view('dashboard/admin/add', $this->data);
			}
		}

		public function edit($id)
		{
			$this->Header = array(
        'title' => "Edit Users",
				'uri' => array("admin","admin_list"),
        'respond' => array(
					'add' => 'admin/auth/add',
          'list' => 'admin/auth/list',
					'rolelist' => $this->Admin_Model->roleLevel(),
					'id' => $id
        ),
      );
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);

			$this->data['result'] = $this->Admin_Model->getAdminDataList($id);
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/auth/list", "Not allow!");
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
			
			if($_POST) {
				$this->form_validation->set_rules('user_name','user name','trim|required|xss_clean|min_length[3]');
				$this->form_validation->set_rules('user_pass','user password','trim|xss_clean|min_length[6]|max_length[30]'); 
				$this->form_validation->set_rules('user_conf_pass','user confirm password','trim|matches[user_pass]|xss_clean|min_length[6]|max_length[30]'); 
				$this->form_validation->set_rules('role','role','trim|required|xss_clean');
				$this->form_validation->set_rules('status','status','trim|xss_clean');
				$this->form_validation->set_rules('admin_name','name','trim|required|xss_clean');
				$this->form_validation->set_rules('admin_email','email','trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules('admin_phone','phone','trim|xss_clean|required|numeric');
				$this->form_validation->set_rules('admin_address','address','trim|xss_clean');
				
				$this->form_validation->set_message('required', 'You must enter %s!');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_message('valid_email', 'The %s must be valid!');
				if ($this->form_validation->run() === false) {
						$this->load->view('dashboard/admin/edit', $this->data);
				} else {
				
					$authorize = array(
						'username' => $this->input->post('user_name'),
						'role' => $this->input->post('role'),
						'status' => $this->input->post('status')
					);

					$profile = array(
						'name' => $this->input->post('admin_name'),
						'email' => $this->input->post('admin_email'),
						'phone' => $this->input->post('admin_phone'),
						'address' => $this->input->post('admin_address'),
						'updated_at' => date('Y-m-d H:i:s'),
						'updated_by' => $this->current_id,
					);
				
					if(!empty($this->input->post('user_pass'))) {
						$authorize['password'] = $this->securitylibrary->__SetPasswordHashing($this->input->post('user_pass'));
					}
					$authorize = $this->securitylibrary->__Match_Xss($authorize);
					$profile = $this->securitylibrary->__Match_Xss($profile);

					$check1 = $this->Admin_Model->checkUserProfile($profile, $id);
					$check2 = $this->Admin_Model->checkUserName($authorize, $id);
					if($check1) {
						$this->session->set_flashdata('msg_error', 'Your email already exits!');
						redirect("admin/auth/edit/".$id);
					} elseif($check2) { 
						$this->session->set_flashdata('msg_error', 'Your username already exits!');
						redirect("admin/auth/edit/".$id);
					} else {
						$this->Admin_Model->updateAdminAuthorize($authorize, $id);
						$this->Admin_Model->updateAdminProfile($profile, $id);
						/** User Query Record **/
            $this->seqlibrary->__Set_seq_record('e','admin',$id, $this->current_id);
						$this->session->set_flashdata('msg_success', 'Your data has been update!');
						redirect("admin/auth/list");
					}
				}
			} else {
				$this->load->view('dashboard/admin/edit', $this->data);
			}
		}

		public function withdraw($id)
		{		
			$current = $this->Admin_Model->getUserDataList($id);		
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $current, "/admin/auth/list", "Not allow!");

			if($this->current_id == $id) {
				$this->session->set_flashdata('msg_error', 'Something wrong!');
				redirect('admin/auth/list');
			} else {
				$this->Admin_Model->adminDelete($id);
				$this->Admin_Model->adminProfileDelete($id);
				$this->Admin_Model->adminRecordDelete($id);	
				/** User Query Record **/
				$this->seqlibrary->__Set_seq_record('d','admin',$id, $this->current_id);
				$this->session->set_flashdata('msg_success', 'Your data has been delete!');
				redirect('admin/auth/list');
			}
		}

		public function delete_all_record($id = null)
		{
			if($this->current_id == $id) {
				$this->session->set_flashdata('msg_error', "Request process can't complete!");
				redirect('admin/auth/list');
			} else {
				$this->Admin_Model->adminRecordDelete($id);
				/** User Query Record **/
				$this->seqlibrary->__Set_seq_record('d','admin record','all', $this->current_id);
				$this->session->set_flashdata('msg_success', 'Force logout process complete!');
				redirect('admin/auth/list');
			}
		}

    /**********************
		 * User Configuration *
		 *********************/
		public function profile()
		{
			$this->Header = array(
        'title' => "Profile",
				'uri' => array('dashboard', ''),
        'respond' => array(
					'config' => $this->user_config,
          'userid' => $this->current_id,
					'session_id' => $this->session_id
        ),
      );
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);

			$this->data['result'] = $this->Admin_Model->getUserDataList($this->current_id);					
			$this->data['record'] = $this->Admin_Model->getUserSessionRecordList($this->current_id);		
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);			
			$this->load->view('dashboard/user/index', $this->data);
		}

    public function edit_user()
		{
			$this->Header = array(
        'title' => "Edit Profile",
				'uri' => array('dashboard', ''),
        'respond' => array(
          'userid' => $this->current_id,
					'session_id' => $this->session_id
        ),
      );
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$this->data['result'] = $this->Admin_Model->getUserDataList($this->current_id);
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($this->current_id, $this->data['result'], "/admin/profile", "Not allow!");
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
			
			if($_POST) {
				$this->form_validation->set_rules('admin_name','name','trim|required|xss_clean');
				$this->form_validation->set_rules('admin_email','email','trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules('admin_phone','phone','trim|xss_clean|required|numeric');
				$this->form_validation->set_rules('admin_address','address','trim|xss_clean');
				
				$this->form_validation->set_message('required', 'You must enter %s!');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_message('valid_email', 'The %s must be valid!');

			if ($this->form_validation->run() === false) {
				$this->load->view('dashboard/user/user_edit', $this->data);
			} else {
				
				$profile = array(
					'name' => $this->input->post('admin_name'),
					'email' => $this->input->post('admin_email'),
					'phone' => $this->input->post('admin_phone'),
					'address' => $this->input->post('admin_address'),
					'updated_at' => date('Y-m-d H:i:s'),
					'updated_by' => $this->current_id,
				);

				$email_check = $this->Admin_Model->checkUserProfile($profile, $this->current_id);
					if($email_check) {
						$this->session->set_flashdata('msg_error', 'Your email already exits!');
						redirect("admin/edit", $this->data);
					} else {
						$this->Admin_Model->updateAdminProfile($profile, $this->current_id);
						/** User Query Record **/
						$this->seqlibrary->__Set_seq_record('e','profile',$this->current_id, $this->current_id);
						$this->session->set_flashdata('msg_success', 'Your data has been update!');
						redirect("admin/profile");
					}
				}
			} else {
				$this->load->view('dashboard/user/user_edit', $this->data);
			}
		}

		public function password()
		{
			$this->Header = array(
        'title' => "Edit Password",
				'uri' => array('dashboard', ''),
        'respond' => array(
          'userid' => $this->current_id,
					'session_id' => $this->session_id
        ),
      );
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$this->data['result'] = $this->Admin_Model->getUserDataList($this->current_id);
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($this->current_id, $this->data['result'], "/admin/profile", "Not allow!");
			/** User data marge **/
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);			

			if($_POST) {
				$this->form_validation->set_rules('curr_user_pass', 'current passowrd', 'trim|xss_clean|required|min_length[6]|max_length[30]');
				$this->form_validation->set_rules('new_user_pass', 'new password', 'trim|xss_clean|required|min_length[6]|max_length[30]');
				$this->form_validation->set_rules('user_conf_pass', 'confirm password', 'trim|xss_clean|required|min_length[6]|max_length[30]|matches[new_user_pass]');

				$this->form_validation->set_message('required', 'You must enter %s!');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_message('valid_email', 'The %s must be valid!');
				if ($this->form_validation->run() === false) {
					$this->load->view('dashboard/user/user_password', $this->data);
				} else {
					$this->password = $this->input->post('curr_user_pass');
					if(!empty($this->password)) {
						if($this->securitylibrary->__MainSecretLogin($this->password, $this->data['result']->password)) {
							$password = $this->securitylibrary->__SetPasswordHashing($this->input->post('new_user_pass'));
							$newpass = array(
								'password' => $password,
							);							
							$this->Admin_Model->updateAdminPassword($newpass, $this->current_id);
							/** User Query Record **/
							$this->seqlibrary->__Set_seq_record('e','password',$this->current_id, $this->current_id);
							$this->session->set_flashdata('msg_success', 'Your password changed successfully!');
							redirect("admin/profile");
						} else {
							$this->session->set_flashdata('msg_error', 'Please insert your login password correstly!');
							redirect("admin/password");
						}
					}
				}
			} else {
				$this->load->view('dashboard/user/user_password', $this->data);
			}
		}
		
		public function delete_record($id = null, $user = null){
			$deleteid = $this->Admin_Model->adminRecordDelete($id, $user);
			/** User Query Record **/
			$this->seqlibrary->__Set_seq_record('d','admin record',$id, $this->current_id);
			if($deleteid){
				$this->session->set_flashdata('msg_success', 'Session record has been delete!');
				redirect('admin/profile');
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
