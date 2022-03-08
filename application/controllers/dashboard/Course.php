<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Course extends CI_Controller
	{
		private $private_db = "dashboard/Course_Model"; 
		protected $session_id, $current_id, $username, $rolelevel, $permission, $current_session, $login_time, $csrf_key, $validsession, $site_name, $meta_tag, $timezone, $decimal_point ,$keyword,$modified_view, $user_config, $dbprefix;
    protected $data, $key, $url, $refuse, $globalHeader, $author = "Neroaquicous", $Header = array("alert" => '','title' => "",'respond' => '', 'uri' => array());
		
		//File upload data
		private $filename;
		private $upload_path = "./upload/assets/adm/cos/";
		private $file_path = "/../../../upload/assets/adm/cos/";
		private $max_size = "202800";  // upload max size 200 MB
		private $max_width = "1600";
		private $max_height = "1600";
		private $allow_type = 'jpg|jpeg|png|JPEG|gif|GIF';
		
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
			$this->key = "pe_course";
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
				'title' => "Course Management",
				'uri' => array("course","course_list"),
				'respond' => array(
					'add' => 'admin/course/add'
				),
			);
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$result = $this->Course_Model->getCourseList();
			/** Modified User view configure */    
      $this->data['result'] = $this->__SetModifiedViwer($result);
			foreach ($this->data['result'] as $row) {
				$row->cos_thumb = $this->upload_path."_thumb/".$row->cos_thumb;
			}
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);	
			$this->load->view('dashboard/course/list', $this->data);
		}
		
		public function add()
		{
			$this->Header = array(
				'title' => "Add Course",
				'uri' => array("course","course_add"),
				'respond' => array(
					'list' => 'admin/course',
					'level' => $this->Course_Model->getLevel(),
					'topic' => $this->Course_Model->getTopic(),
				),
			);
			
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);    
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, []);
			$this->dbprefix = $this->db->dbprefix;
			
			if($_POST) {
				$this->form_validation->set_rules('name', 'course title', 'trim|required|xss_clean');
				$this->form_validation->set_rules('desc', 'course description', 'trim|required|xss_clean');
				$this->form_validation->set_rules('level', 'level', 'trim|required|xss_clean');
				$this->form_validation->set_rules('subcategory', 'subcategory', 'trim|required|xss_clean');
				$this->form_validation->set_rules('default_key', 'class', 'trim|required|xss_clean');
				$this->form_validation->set_rules('userfile', 'lessons', 'trim');
				$this->form_validation->set_rules('description2', 'course description2', 'trim|xss_clean');
				$this->form_validation->set_rules('slug', 'slug name', 'trim|required|xss_clean|is_unique['.$this->dbprefix.'course.slug_name]');
				
				$this->form_validation->set_message('required', 'You must enter %s');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_error_delimiters("","");
				
				if ($this->form_validation->run() === false) {
					$this->load->view('dashboard/course/add', $this->data);
				} else {
					$data = array(
						'cos_title' => $this->input->post('name'),
						'cos_des1' => $this->input->post('desc'),
						'level_id' => $this->input->post('level'),
						'subcat_id' => $this->input->post('subcategory'),
						'created_at' => date("Y-m-d H:i:s"),
						'updated_at' => date("Y-m-d H:i:s"),
						'ref_key' => $this->input->post('default_key'),
						'slug_name' => $this->configlibrary->_slugKeyGen($this->input->post('slug')),
						'created_by' => $this->current_id,
            'updated_by' => $this->current_id,
						'status' => $this->input->post('status')
					);
					$data = $this->securitylibrary->__Match_Xss($data);
					$checkdata = $this->Course_Model->checkCourse($data);
					
					if ($checkdata) {
						$this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
						redirect('admin/course/add');
					}
					
					if (!empty($_FILES['userfile']['name'])) {
						//image upload sever and add database
						$imgupload = $this->configlibrary->__MainDataUpload($this->filename, $this->upload_path, $this->max_size, $this->max_width, $this->max_height, $this->allow_type, TRUE, TRUE, TRUE);
						
						if (!empty($imgupload['msg_error'])) {
							$this->session->set_flashdata('msg_error', $imgupload['msg_error']);
							redirect('admin/course/add');
						} else {
							$data['cos_image'] = $imgupload['file_name'];
							$data['cos_thumb'] = $imgupload['raw_name']."_thumb".$imgupload['file_ext']; //thumb file create
						}
					} 

					$this->Course_Model->insertCourse($data);
					$this->session->set_flashdata('msg_success', 'Your data has been insert!');
					redirect('admin/course');
					
				}
			} else {
				$this->load->view('dashboard/course/add', $this->data);
			}
		}
		
		public function edit($id)
		{
			$this->Header = array(
				'title' => "Edit Course",
				'uri' => array("course","course_list"),
				'respond' => array(
					'list' => 'admin/course'
				),
			);
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			$this->data['result'] = $this->Course_Model->detailCourse($id);
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/course", "Not allow!");
			$this->data['level'] = $this->Course_Model->getLevel();
			$this->data['topic'] = $this->Course_Model->getTopic();			
			/** User data marge **/
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);
			$recent_cover = $this->data['result']->cos_image;
			$recent_thumb = $this->data['result']->cos_thumb;
			
			if ($_POST) {
				$this->form_validation->set_rules('name', 'course title', 'trim|required|xss_clean');
				$this->form_validation->set_rules('desc', 'course description', 'trim|required|xss_clean');
				$this->form_validation->set_rules('description2', 'course description2', 'trim|xss_clean');
				$this->form_validation->set_rules('slug', 'slug name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('subcategory', 'subcategory', 'trim|required|xss_clean');
				$this->form_validation->set_rules('level', 'level', 'trim|required|xss_clean');
				$this->form_validation->set_rules('default_key', 'key', 'trim|required|xss_clean');
				$this->form_validation->set_rules('userfile', 'lessons', 'trim');
				
				$this->form_validation->set_message('required', 'You must enter %s!');
				$this->form_validation->set_message('is_unique', 'Your %s is already exits!');
				$this->form_validation->set_message('numeric', 'The %s always allow only numbers!');
				$this->form_validation->set_error_delimiters("","");
				
				if ($this->form_validation->run() === false) {
					$this->load->view('dashboard/course/edit', $this->data);
				} else {
					
					$data = array(
						'cos_title' => $this->input->post('name'),
						'cos_des1' => $this->input->post('desc'),
						'subcat_id' => $this->input->post('subcategory'),
						'level_id' => $this->input->post('level'),
						'updated_at' => date("Y-m-d H:i:s"),
						'ref_key' => $this->input->post('default_key'),
						'slug_name' => $this->configlibrary->_slugKeyGen($this->input->post('slug')),
						'updated_by' => $this->current_id,
						'status' => $this->input->post('status')
					);
					
					$data = $this->securitylibrary->__Match_Xss($data);
					$checkdata = $this->Course_Model->checkEditCourse($data, $id);
					$unique_slug = $this->Course_Model->checkSlug(strtolower($this->input->post('slug')), $id);
					
					if (!empty($_FILES['userfile']['name'])) {
						if(!empty($recent_cover)) {
							$preview_link = dirname(__FILE__)."".$this->file_path."".$recent_cover;
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
							redirect('admin/course/edit/'.$id);
						} else {
							$data['cos_image'] = $imgupload['file_name'];
							$data['cos_thumb'] = $imgupload['raw_name']."_thumb".$imgupload['file_ext'];
						}
					} else {
						if ($checkdata) {
							$this->session->set_flashdata('msg_error', 'Your data already exits! please fill other data!');
							redirect('admin/course/edit/'.$id);
						} elseif ($unique_slug) {
							$this->session->set_flashdata('msg_error', 'Your slug name already exits! please fill other data!');
							redirect('admin/course/edit/'.$id);
						}
					}
					
					$this->Course_Model->courseUpdate($data, $id);
					$this->session->set_flashdata('msg_success', 'Your data has been update!');
					redirect("admin/course");
				}
			} else {
				$this->load->view('dashboard/course/edit', $this->data);
			}
		}
		
		public function view($id)
		{
			$this->Header = array(
				'title' => "View Course Detail",
				'uri' => array("course","course_list"),
				'respond' => array(
					'add' => 'admin/course/add',
					'list' => 'admin/course',
				),
			);
			
			$respondheader = $this->configlibrary->__SetDataMargeRecursive($this->globalHeader, $this->Header);
			
			$this->data['result'] = $this->Course_Model->detailCourseList($id);

			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $this->data['result'], "/admin/course", "Not allow!");
			/** User data marge **/
			$this->data = $this->configlibrary->__SetDataMarge($respondheader, $this->data);			
			$this->load->view('dashboard/course/view', $this->data);
		}
		
		public function delete($id)
		{	
			/** 
			 * Course GET/
			 **/		
			$list = $this->Course_Model->detailCourse($id);
			/** Validation User data **/
			$this->securitylibrary->__MatchEmptyValid($id, $list, "/admin/course", "Not allow!");			
			$batchchecker = $this->Course_Model->getTotalBatchDetail($list->id);
			if(count($batchchecker) > 0 ){
				$this->session->set_flashdata('msg_error', "Bad Request, You can't delete this data!");
				redirect('admin/course');
			} else {
				$recent_cover = $list->cos_image;
				$recent_thumb = $list->cos_thumb;
				
				if(!empty($recent_cover)) {
					$preview_link = dirname(__FILE__)."".$this->file_path."".$recent_cover;
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
				
				$this->Course_Model->courseDelete($id);
				$this->session->set_flashdata('msg_success', 'Your data has been delete!');
				redirect('admin/course');
			}
		}

		public function fetch_level()
		{
			if($_POST) {
					$data = $this->input->post('subcategory');
					echo $this->Course_Model->fetch_course($data);
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