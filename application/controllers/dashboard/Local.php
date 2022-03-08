<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Local extends CI_Controller
	{
		private $private_db = "dashboard/Local_Model"; 
		protected $session_id, $current_id, $username, $rolelevel, $permission, $current_session, $login_time, $csrf_key, $validsession, $site_name, $meta_tag, $timezone, $decimal_point ,$keyword,$modified_view, $user_config, $dbprefix;
		protected $data, $key, $url, $refuse, $globalHeader, $author = "Neroaquicous", $Header = array("alert" => '','title' => "",'respond' => '', 'uri' => array());
		
		//File upload data
		private $filename;
		private $upload_path = "./upload/assets/adm/new/";
		private $file_path = "/../../../upload/assets/adm/new/";
		private $max_size = "202800";  // upload max size 200 MB
		private $max_width = "1600";
		private $max_height = "1600";
		private $allow_type = 'jpg|jpeg|png|JPEG';

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
			$this->key = "pe_information";
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
				'title' => "Local Company Management",
				'uri' => array("information","local_list"),
				'respond' => array(
					'add' => 'admin/local/add'
				),
			);
			
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$result = $this->Local_Model->getLocal();
			$this->data['result'] = $this->__SetModifiedViwer($result);
			foreach ($this->data['result'] as $row)
			{
				$row->subject = $this->configlibrary->__SetTextLimiter($row->subject, 30);
				$row->thumb = $this->upload_path."_thumb/".$row->thumb;
			}
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
			$this->load->view('dashboard/local/list', $this->data);
		}

		public function add()
		{
			$this->Header = array(
				'title' => "Add Local Company",
				'uri' => array("information","local_list"),
				'respond' => array(
					'list' => 'admin/local',
					'tags' => $this->Local_Model->getTagsData(),
				),
			);
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, []);
			$this->dbprefix = $this->db->dbprefix;
			if($_POST) {
				$this->form_validation->set_rules('subject', 'subject', 'trim|required|xss_clean');
				$this->form_validation->set_rules('requirement', 'requirement', 'trim|required|xss_clean');
				$this->form_validation->set_rules('tags', 'tags', 'trim|required|xss_clean');
				$this->form_validation->set_rules('userfile', 'cover photo', 'trim');
				$this->form_validation->set_rules('name', 'name', 'trim|required|is_unique['.$this->dbprefix.'jpschool.name]|xss_clean');
				$this->form_validation->set_rules('email', 'email', 'trim|xss_clean');
				$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
				$this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean');

				$this->form_validation->set_message('required', 'You must enter %s!');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_message('valid_email', 'The %s must be valid!');

				if ($this->form_validation->run() === false) {
					$this->load->view('dashboard/local/add', $this->data);
				} else {
					$data = array(
						'name' => $this->input->post('name'),
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'address' => $this->input->post('address'),
						'subject' => $this->input->post('subject'),
						'requirement' => $this->input->post('requirement'),
						'tag_id' => $this->input->post('tags'),
						'created_at' => date("Y-m-d H:i:s"),
						'updated_at' => date("Y-m-d H:i:s"),
						'created_by' => $this->current_id,
            'updated_by' => $this->current_id,
						'status' => $this->input->post('status'),
					);
					$data = $this->securitylibrary->__Match_Xss($data);
					$checkdata = $this->Local_Model->localCheck($data);
					if ($checkdata){
						$this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
						redirect('admin/local/add');
					}

					if (!empty($_FILES['userfile']['name'])) {
						//image upload sever and add database
						$imgupload = $this->configlibrary->__MainDataUpload($this->filename, $this->upload_path, $this->max_size, $this->max_width, $this->max_height, $this->allow_type, TRUE, TRUE, TRUE);
						
						if (!empty($imgupload['msg_error'])) {
							$this->session->set_flashdata('msg_error', $imgupload['msg_error']);
							redirect('admin/local/add');
						} else {
							$data['photo'] = $imgupload['file_name'];
							$data['thumb'] = $imgupload['raw_name']."_thumb".$imgupload['file_ext']; //thumb file create							
						}
					}
					
					$this->Local_Model->localInsert($data);
					$this->session->set_flashdata('msg_success', 'Your data has been insert!');
					redirect('admin/local');
				}
			} else {
				$this->load->view('dashboard/local/add', $this->data);
			}
		}

		public function edit($id)
		{
			$this->Header = array(
				'title' => "Edit Local Company",
				'uri' => array("information","local_list"),
				'respond' => array(
					'list' => 'admin/local',
					'add' => 'admin/local/add',
					'tags' => $this->Local_Model->getTagsData(),
					'id' => $id,
				),
			);
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$this->data['result'] = $this->Local_Model->getlocalsDetail($id);
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/local", "Not allow!");			
			/** User data marge **/
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
			$recent_photo = $this->data['result']->photo;
			$recent_thumb = $this->data['result']->thumb;

			if($_POST) {
				$this->form_validation->set_rules('subject', 'subject', 'trim|required|xss_clean');
				$this->form_validation->set_rules('requirement', 'requirement', 'trim|required|xss_clean');
				$this->form_validation->set_rules('tags', 'tags', 'trim|required|xss_clean');
				$this->form_validation->set_rules('userfile', 'cover photo', 'trim');
				$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('email', 'email', 'trim|xss_clean');
				$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
				$this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean');

				$this->form_validation->set_message('required', 'You must enter %s!');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_error_delimiters("","");

				if ($this->form_validation->run() === false) {
					$this->load->view('dashboard/local/edit', $this->data);
				} else {
					$data = array(
						'name' => $this->input->post('name'),
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'address' => $this->input->post('address'),
						'subject' => $this->input->post('subject'),
						'requirement' => $this->input->post('requirement'),
						'tag_id' => $this->input->post('tags'),
						'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->current_id,
						'status' => $this->input->post('status'),
					);
					$data = $this->securitylibrary->__Match_Xss($data);
					$checkdata = $this->Local_Model->localCheck($data, $id);

					if (!empty($_FILES['userfile']['name'])) {
						if(!empty($recent_photo)) {
							$preview_link = dirname(__FILE__)."".$this->file_path."".$recent_photo;
							if(file_exists($preview_link)){
								unlink($preview_link);
							}
						}
						
						if(!empty($recent_thumb)) {
							$preview_thumb = dirname(__FILE__)."".$this->file_path."_thumb/".$recent_thumb;
							if(file_exists($preview_thumb)){
								unlink($preview_thumb);
							}
						}
						
						//image upload sever and add database
						$imgupload = $this->configlibrary->__MainDataUpload($this->filename, $this->upload_path, $this->max_size, $this->max_width, $this->max_height, $this->allow_type, TRUE, TRUE, TRUE);
						
						if(!empty($imgupload['msg_error'])) {
							$this->session->set_flashdata('msg_error', $imgupload['msg_error']);
							redirect('admin/local/edit/'.$id);
						} else {
							$data['photo'] = $imgupload['file_name'];
							$data['thumb'] = $imgupload['raw_name']."_thumb".$imgupload['file_ext'];
						}
					} else {
						if ($checkdata) {
							$this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
							redirect('admin/local/edit/'.$id);
						}
					}					
					$this->Local_Model->localsUpdate($data, $id);
					$this->session->set_flashdata('msg_success', 'Your data has been update!');
					redirect("admin/local");
				}
			} else {
				$this->load->view('dashboard/local/edit', $this->data);
			}
		}

		public function view($id)
		{
			$this->Header = array(
				'title' => "View Local Company Detail",
				'uri' => array("information","local_list"),
				'respond' => array(
					'add' => 'admin/local/add',
					'list' => 'admin/local',
				),
			);
			
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$this->data['result'] = $this->Local_Model->getlocalsDetail($id);
			
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/local", "Not allow!");
			/** User data marge **/
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
			$this->load->view('dashboard/local/view', $this->data);
		}

		public function delete($id)
		{
			/** 
			 * Course GET/
			 **/		
			$list = $this->Local_Model->getlocalsDetail($id);
			/** Validation User data **/
			
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $list, "/admin/local", "Not allow!");	
			$recent_cover = $list->photo;
			$recent_thumb = $list->thumb;
				
			if(!empty($recent_cover)) {
				$preview_link = dirname(__FILE__)."".$this->file_path."".$recent_cover;
				if(file_exists($preview_link)){
					unlink($preview_link);
				}
			}
			
			if (!empty($recent_thumb)) {
				$preview_thumb = dirname(__FILE__)."".$this->file_path."_thumb/".$recent_thumb;
				if(file_exists($preview_thumb)){
					unlink($preview_thumb);
				}
			}
			
			$this->Local_Model->localsDelete($id);
			$this->session->set_flashdata('msg_success', 'Your data has been delete!');
			redirect('admin/local');
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
