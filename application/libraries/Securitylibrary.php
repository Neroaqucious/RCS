<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Securitylibrary 
  {

    protected $CI;
    protected $session, $csrf_token, $csrf_slug, $encrypt_key;

    public function __construct()
    {
      $this->CI =& get_instance();
      $this->CI->load->helper('url');
      $this->CI->load->library('encryption');
      $this->CI->load->library('session');
    }

    public function __MainSecretLogin($password, $hash)
    {
      return password_verify($password, $hash);
    }
    
    public function __Match_Xss($data){
      return $this->CI->security->xss_clean($data);
    }

    public function __SetPasswordHashing($data)
    {
      return password_hash($data, PASSWORD_BCRYPT);
    }

    public function __SetDefault64Encode($data)
    {
      return base64_encode($data);
    }
  
    public function __SetDefault64Decode($data)
    {
      return base64_decode($data);
    }
  
    public function __SetCustomEncrypt($data)
    {
      $this->encrypt_key = $this->CI->encryption->encrypt($data);
      return $this->encrypt_key;
    }
  
    public function __SetCustomDecrypt($data)
    {
      $this->encrypt_key = $this->CI->encryption->decrypt($data);
      return $this->encrypt_key;
    }

    public function __Set_SessionData($session, $set_time = null)
    {
      if($session != "" && $set_time != "") {
        $this->CI->session->set_tempdata($session, Null, $set_time); //Set session time 4 hour
      } else {
        $this->CI->session->set_tempdata($session, Null, 1800); //Set session time 30 minutes
      }
      return true;
    }

    public function __Set_SessionDataWithKey($session, $key, $set_time = null)
    {
      $this->CI->session->set_userdata($session);
      if($set_time != "") {
        $this->CI->session->mark_as_temp(array($key => $set_time )); //Set session time 4 hour
      } else {
        $this->CI->session->mark_as_temp(array($key => 1800 )); //Set session time 30 minutes
      }
      return true;
    }

    public function __MatchCsrfToken($slug = "kakunin")
    {
      $firstkey = $_SESSION['__ci_last_regenerate'];
      $secondkey = $this->__SetCustomEncrypt($firstkey);
      $thirdkey = strtolower(mb_substr($secondkey, 0, 10));
      $this->csrf_token = preg_replace("/[\/+_~]/", "$1", $thirdkey);
      return "\$2y$10$.PktRcs".$this->csrf_token."_";
    }
    
    public function __MatchCsrfSlug($x = 4, $y = 4)
    {
      $comp1 = $comp2 = []; $dd = $dd1 = $dd3 = "";
      $tokenkey = $this->__SetCustomEncrypt($this->__MatchTokenGenerate());
      
      $first_str = preg_replace("/[\/]/", "$1", $tokenkey);
      $first_str = preg_replace("/[0-9+_~]/", "$1", $first_str);
      for ($i = 0; $i < $x; $i++) {
        $comp1[] = mb_substr($first_str, (2*$i), $y);
      }
      foreach ($comp1 as $row) {
        $dd .= $row."-";
      }
      
      $second_str = preg_replace("/[A-z+_~*^]/", "$1", $tokenkey);
      for ($i = 0; $i < $x; $i++) {
        $comp2[] = mb_substr($second_str, (2*$i), $y);
      }
      foreach ($comp2 as $row) {
        $dd1 .= $row."-";
      }
      
      $data = array_combine($comp1, $comp2);
      foreach ($data as $key=>$val) {
        $dd3 .= strtolower($val."-".$key);
      }

      $this->csrf_slug = $dd3;
      return $this->csrf_slug; 
    }
    
    private function __MatchTokenGenerate()
    {
      $agent = $this->CI->agent->platform();      
      $ipaddress =  $this->CI->input->ip_address();      
      $key1 = $this->__SetCustomEncrypt($agent);
      $key2 = $this->__SetCustomEncrypt($ipaddress);
      
      if (!empty($key1) && !empty($key2))
      {
        $csrf = $key1."$".$key2;
        $csrf = substr($csrf, 1, 30);
      }
      return $csrf;
    }
    
    public function __GetPerson_IPAddress($iprequest = False)
    {
      if($iprequest == True || $iprequest == 1) {
        if($socket = @fsockopen("www.google.com", 80, $num, $error, 5)){
          $ipAddress = file_get_contents('https://api.ipify.org');
        }
      } else {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
          $ipAddress = $this->CI->input->ip_address();
        }
      }
      $validip = $this->CI->input->valid_ip($ipAddress)?$ipAddress:'Error';
      return $validip;
    }

    public function __GetHideUrl_Generate($data, $iprequest = False) {
      $allow_ip = isset($data->allow_ip)?$data->allow_ip:"";
      $private = $this->__GetPerson_IPAddress($iprequest);
      if($this->__MatchHideUrl_Generate($private, $allow_ip)) {
        return true;
      } else {
        return false;
      }
    }

    public function __MatchHideUrl_Generate($target, $data){
      $assgin = explode(',', $data);
      foreach($assgin as $row) {
        $ipdata[] =  trim($row);
      }
  
      if(count($ipdata) == 1) {
        if($ipdata[0] == trim($target)) {
          return true;
        } else {
          return false;
        }
      } else {
        if (in_array($target, $ipdata)) {
          return true;
        } else {
          return false;
        }
      }
    }
    
    public function __SetHideUrl_Generate($data){
      $skey = $data->skey;
      $slug_key = $this->__MatchCsrfSlug();

      /** checkpoint session data assign*/
      $ipmatch = array(
        "ip_token" => $skey,
        'ip_slug' => $slug_key,
        'ip_timeout' => date('Y-m-d H:i:s',time()+120)
      );
      $sessionchecker = array(
        '__ip_generate_key' => $ipmatch,
      );

      $IPsession = $this->__Set_SessionDataWithKey($sessionchecker, '__ip_generate_key', 180); // 3 min after session
      if($IPsession) {
        return base_url('admin/portal/login');
      }
    }

    public function __MatchEmptyCheck($id,$data = Null, $return, $url){
      if(empty($id) || !is_numeric($id) || empty($data)){
        $this->CI->session->set_flashdata('msg_error', "Bad Request, Not allowed permission!");
        redirect($url, $return);
      }
    }

    /**
     * $refer (Ture/False) If value have or not 
     * $value Validate 
     * $return return url
     * 
     */
    public function __MatchSessionValid($refer, $value, $return){
      if($refer == True){
        if(!empty($value) || $value == true || $value != ""){
          redirect($return);
        }
      }
      if($refer == False){
        if(empty($value) || $value == false || $value == ""){
          redirect($return);
        }
      }
    }

    public function __ValidSessionWithData($value, $url, $respond){
      if($_SESSION['__auth_csrf_token'] != $value[0] || $_SESSION['__auth_csrf_slug'] != $value[1]) {
        $this->CI->session->set_flashdata('msg_error', $respond);
        redirect($url);
      } else {
        return true;
      }
    }

    /**
     * $key => check key
     * $url => return url
     * $refuse => url refuse if have * Sample * admin/add 
     * don't used first place and last place (/)
     */
    public function __MatchPermissionValid($key, $url, $refuse = array()){
      $current = uri_string(); 
      $explod = explode('/', $current);
      foreach($explod as $row) {
        if(!is_numeric($row)) {
          $current_url[] = ($row);
        }
      }
      $current = implode('/', $current_url); 
      if(!in_array($current, $refuse)) {
        if($this->CI->configlibrary->__MatchStrPos($_SESSION['__user_information']['user_permission'],$key) === FALSE){
          $this->CI->session->set_flashdata('msg_error', "Your aren't permission for this config!");
          redirect($url);
        }
      } else {
        return true;
      }
    }

    /**
     *  Other Configuration 
     */
    public function __MatchEmptyValid($id = Null, $data = Null, $url, $msg){
      if(empty($id) || !is_numeric($id) || empty($data) || $data == ""){
        $this->CI->session->set_flashdata('msg_error', $msg);
        redirect($url);
      }
	  }


  }