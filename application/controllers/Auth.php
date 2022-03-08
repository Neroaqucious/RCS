<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Auth extends CI_Controller 
  {
    private $private_db = "dashboard/Auth_Model", $username, $password, $status, $session_id, $csrf_token, $token, $slug;
    protected $data, $globalHeader = array("alert" => '','title' => "",'msg' => "", 'respond' => '');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
      $this->load->model($this->private_db);
      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('configlibrary');
      $this->load->library('securitylibrary');
      $this->configlibrary->__SetTimeZone();
      $this->__Set_InitSiteConfigData();
      $this->token = $this->securitylibrary->__MatchCsrfToken();
      $this->slug = $this->securitylibrary->__MatchCsrfSlug(4,8);
    }

    public function index()
    {
      $this->globalHeader = array(
        "alert" => '',
        'title' => "Admin Login",
        'action' => '/auth/login',
        'respond' => array(
          'add' => '',
          'list' => '',
          'description' => 'PKT Education Center, education center, online learning page, online learning system, Japanese langauge, Training Center',
          'author' => 'nero',
          "token" => $this->token, 
          "slug" => $this->slug,
        ),
      );

      $tokensession = array(
        '__auth_csrf_token' => $this->token,
        '__auth_csrf_slug' => $this->slug,
      );

      $this->securitylibrary->__Set_SessionDataWithKey($tokensession, '__auth_session', 3000);
      $this->data = $this->configlibrary->__SetDataMarge($this->globalHeader, []);      
      $this->load->view('dashboard/auth/login', $this->data);
    }
    
    public function login()
    {
      if($_POST) {
        $this->form_validation->set_rules('user_name', 'username!','trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('user_password', 'password!', 'trim|required|min_length[5]|xss_clean');
        $this->form_validation->set_rules('token', 'token!','trim|required|xss_clean');
        $this->form_validation->set_rules('slug', 'slug!','trim|required|xss_clean');

        if ($this->form_validation->run() === false) {
          $this->session->set_flashdata('msg_error', "something wrong, please try again!");
          redirect('/');
        } else {
          $this->username = $this->securitylibrary->__Match_Xss($this->input->post('user_name'));
          $this->password = $this->securitylibrary->__Match_Xss($this->input->post('user_password'));
          $token = $this->securitylibrary->__Match_Xss($this->input->post('token'));
          $slug = $this->securitylibrary->__Match_Xss($this->input->post('slug'));
          /** Validation previous token and slug key from loader */
          $this->securitylibrary->__ValidSessionWithData(array($token, $slug), '/', 'Invalid information!');
          $userdata = $this->SQ_Get_authinfo($this->username);	
          $role = $this->SQ_Get_userrole($userdata->role);
          if(!empty($userdata) && $this->securitylibrary->__MainSecretLogin($this->password, $userdata->password)) {
            $this->status = $userdata->status;
            if(!empty($this->status) && $this->status == 1 && $role->status == 1) {
              unset($_SESSION['__auth_csrf_token']);
              unset($_SESSION['__auth_csrf_slug']);
              $siteconfig = $this->SQ_Get_siteconfig();							
							foreach($siteconfig as $val) {
								$site_config[$val->name] = $val->value;
							}
              $token = $this->securitylibrary->__MatchCsrfToken($token);

              $userconfig = array(
                'admin_id' => $userdata->id,
                "csrf_token_key" => $token,
                "csrf_slug_key" => $slug,
                "ipaddress" => $this->securitylibrary->__GetPerson_IPAddress(),
                "agent" => $this->agent->browser().", ".$this->agent->version().", ".$this->agent->platform(),
                "session" => $role->session,
                "start_time" => date('Y-m-d H:i:s'),
                "end_time" => date('Y-m-d H:i:s',time()+$role->session),
              );

              $current_id = $this->SQ_SetAdminSession($userconfig);
              $admin_info = array(
                'user_id' => $userdata->id,
                'user_name' => $this->username,
                'user_role' => $role->name,
                'user_permission' => $role->config,
                'ip_address' => $this->input->ip_address(),
                'useragent' => $this->agent->browser().", ".$this->agent->version().", ".$this->agent->platform(),
                'session' => $role->session,
                'login_time' => date('Y-m-d H:i:s',time()),
                'session_timeout' => date('Y-m-d H:i:s',time()+$role->session)
              );

              /** real session data assign*/
              $sessiondata = array(
                '__user_sessionid' => $current_id,
                '__user_information' => $admin_info,
                '__user_tokengenerate' => $token.$slug,
                '__site_configure' => $site_config,
              );
              $this->session->set_userdata($sessiondata);

              /** checkpoint session data assign*/
              $presession = array(
                "check_point" => TRUE,
                'record_timeout' => date('Y-m-d H:i:s',time()+$role->session-1)
              );

              $sessionchecker = array(
                '__user_session_validator' => $presession,
              );

              $session_check = $this->securitylibrary->__Set_SessionDataWithKey($sessionchecker, '__user_session_validator', $role->session-1);

              if($session_check) {              
                redirect('admin/panel/');	
              } else {
                $this->session->set_flashdata('msg_error', "something wrong, please try again!");
                redirect('/');
              }
            } else {
              $this->session->set_flashdata('msg_error', "please contact with admin!");
              redirect('/');
            }
          } else {
            $this->session->set_flashdata('msg_error', "invalid information!");
            redirect('/');
          }
        }
      } else {
        $this->session->set_flashdata('msg_error', "something wrong, please try again!");
        redirect('/');
      }
    }

    public function logout()
    {
      if($this->session_id) {
        $this->SQ_RemoveUserRecord($this->session_id);
      }
      $this->session->unset_userdata("__user_information");
      $this->session->unset_userdata("__user_tokengenerate");
      $this->session->unset_userdata("__user_sessionid");
      $this->session->unset_userdata("__site_configure");
      $this->session->unset_userdata("__user_session_validator");
      unset($_SESSION['__ci_vars']['__user_session_validator']);
      unset($_SESSION['__ci_vars']);
      redirect('/');
    }

    /**
     * Initial Session Assign
     * 
     */
    private function __Set_InitSiteConfigData()
    { 
      $this->csrf_token = isset($_SESSION['__user_tokengenerate'])?$_SESSION['__user_tokengenerate']:"";                 
      $this->session_id = isset($_SESSION['__user_sessionid'])?$_SESSION['__user_sessionid']:"";            
    }

    /***
     * DB Qurey 
     */
    private function SQ_Get_authinfo($user_name)
    {
      $this->db->select('*');
      $this->db->from('admin');
      $this->db->where('username', $user_name);
      return $this->db->get()->row();
    }

    private function SQ_Get_userrole($role)
    {
      $this->db->from('rolelevel');
      $this->db->where('id', $role);
      return $this->db->get()->row();
    }
    
    private function SQ_Get_siteconfig()
    {
      $this->db->select('*');
      $this->db->from('configure');
      $query=$this->db->get();
      return $query->result();
    }

    private function SQ_RemoveUserRecord($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('admin_session');
      return true;
    }

    public function SQ_SetAdminSession($data)
    {
      $this->db->insert("admin_session", $data);
      $id = $this->db->insert_id();
      return (isset($id)) ? $id : FALSE;
    }

  }