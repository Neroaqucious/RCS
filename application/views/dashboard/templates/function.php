<?php 
  defined('BASEPATH') OR exit('No direct script access allowed'); 
  $sess_config = isset($_SESSION['__user_information']['user_permission'])?$_SESSION['__user_information']['user_permission']:"";
  $modified_view = isset($_SESSION['__site_configure']['modified_view'])?$_SESSION['__site_configure']['modified_view']:""; 

  function string_pos($sting, $find)
  {
    return strpos($sting, $find);
  }

  function customize_view($view, $data = null)
  {
    $sess_config = isset($_SESSION['__user_information']['user_permission'])?$_SESSION['__user_information']['user_permission']:"";
    $modified_view = isset($_SESSION['__site_configure']['modified_view'])?$_SESSION['__site_configure']['modified_view']:""; 
    if (strpos($sess_config,'admin') !== false && $modified_view == true) {
      if($view == 'th') {
        $data = "<th width='1'>Creator</th><th width='1'>Editor</th>";
      } else {
        $data = '<td class="text-center text-primary">'. $data .'</td>';
      }
      return $data;
    } else {
      return false;
    }
    
  }



?>