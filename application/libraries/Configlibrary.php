<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Configlibrary 
  {
    protected $CI;
    /**
     * Custom Config Library ()
     **/
    public function __construct()
    {
      $this->CI =& get_instance();
      $this->CI->load->helper('url');
      $this->CI->load->library('form_validation');
      $this->CI->load->library('encryption');
      $this->CI->load->library('session');
      $this->CI->load->library('upload');
      $this->CI->load->library('image_lib');
      $this->CI->load->library('calendar');
    }

    public function __SetTimeZone($zone = Null)
    {
      if(!empty($zone)) {
        date_default_timezone_set($zone);
      } else {
        date_default_timezone_set('Asia/Rangoon');
      }            
    }

    public function __SetDefaultNotify()
    {
      $notic = [];
      $notic['student'] = $this->CI->Config_Model->getStudentList();
      $notic['feedback'] = $this->CI->Config_Model->getFeedbackList();
      $notic['course'] = $this->CI->Config_Model->getStudentCourseList();
      return $notic;
    }

    public function __SetDataMargeRecursive(Array $data1,Array $data2)
    {
      $result = [];
      $result = array_merge_recursive($data1, $data2);
      return $result;
    }


    public function __SetDataMarge(Array $data1,Array $data2)
    {
      $result = [];
      $result = array_merge($data1, $data2);
      return $result;
    }

    public function __SetStrToLower($str)
    {
      return strtolower($str);
    }
  
    public function __SetMbSplit($key, $value)
    {
      return mb_split($key, $value);
    }

    public function __MatchStrPos($value, $find)
    {
      if(!empty($value)) {
        return strpos($value, $find);
      }
    }

    public function _slugKeyGen($str)
    {
      return url_title($str);
    }

    public function __Match_customview($sess_config, $modified_view)
    {
      if (strpos($sess_config,'admin') !== false && $modified_view == 1) {
        return true;
      }
    }

    public function __Set_ModifiedView($data, $id = Null) 
    {      
      if(!empty($data[$id])) {
        return $data[$id]['name'];
      } else {
        return " - ";
      }
    }

    public function __MatchOptCheck($value)
    {
      if(empty($value)){
        $this->CI->form_validation->set_message('option_check', 'You must provide %s');
        return FALSE;
      } else {
        return TRUE;
      }
    }

    public function __SetTextLimiter($text, $limit) 
    {
      if (strlen($text) > $limit) {
        $text = mb_substr($text, 0, $limit) . '...';
      }
      return $text;
    }

    function __Set_SerialID($key, $data, $length) 
    {
      return $key.str_pad(($data+1), $length, '0', STR_PAD_LEFT);
    }

    /**
     * Data upload Library
     * 
     * 
     */
    public function __MainDataUpload($filename, $upload_path, $max_size, $max_width, $max_height, $allow_type, $encrypt, $overwrite, $resize)
    {
      $config['file_name'] = $filename;
      $config['upload_path'] = $upload_path;
      $config['encrypt_name'] = $encrypt;
      $config['overwrite'] = $overwrite;
      $config['max_size'] = $max_size;
      $config['max_width'] = $max_width;
      $config['max_height'] = $max_height;
      $config['allowed_types'] = $allow_type;
      $config['detect_mime'] = TRUE;
      $this->CI->upload->initialize($config);
      $this->CI->load->library('upload', $config);

      if(!$this->CI->upload->do_upload('userfile')) {
        $data['msg_error'] = $this->CI->upload->display_errors();
      } else {
        $data = $this->CI->upload->data(); //data upload
        if($resize == TRUE) {
          $this->__PreResizeData($data);
        }
      }
      return $data;
    }

    public function __PreResizeData($file)
    {
      $config1['image_library'] = 'gd2';
      $config1['source_image'] = $file['full_path'];
      $config1['new_image'] = $file['file_path']."_thumb";
      $config1['create_thumb'] = TRUE;
      $config1['maintain_ratio'] = TRUE;
      $config1['width']         = 300;
      $config1['height']       = 300;

      $this->CI->load->library('image_lib', $config1);
      $this->CI->image_lib->initialize($config1);

      if (!$this->CI->image_lib->resize()) {
        echo $this->CI->image_lib->display_errors();
      }
      $this->CI->image_lib->clear();
    }

    public function getTargetdays($date1, $date2, $string)
    {
      return new DatePeriod(
        new DateTime($date1),
        DateInterval::createFromDateString($string),
        new DateTime($date2),
      );
    }

    public function targetDateGenerate(array $target, $start_date, $end_date, $start, $end) 
    {
      $array_day = [];
      $start = explode(":",$start);
      $end = explode(":",$end);
    
      if(in_array('Sun', $target)) {
        foreach ($this->getTargetdays($start_date, $end_date, 'next sunday') as $days) {
          $day1 = $days;
          $day2 = $days;
          if($days->format('l') == "Sunday") {
            $array_day[$days->format('Y-m-d')] = $day1->format("Y-m-d ".$start[0].":".$start[1].":s")." ~ ".$day2->format("Y-m-d ".$end[0].":".$end[1].":s");
          }   
        }
      }
      
      if(in_array('Mon', $target)) {
        foreach ($this->getTargetdays($start_date, $end_date, 'next monday') as $days) {
          $day1 = $days;
          $day2 = $days;
          if($days->format('l') == "Monday") {
            $array_day[$days->format('Y-m-d')] = $day1->format("Y-m-d ".$start[0].":".$start[1].":s")." ~ ".$day2->format("Y-m-d ".$end[0].":".$end[1].":s");
          }   
        }
      }

      if(in_array('Tue', $target)) {
        foreach ($this->getTargetdays($start_date, $end_date, 'next tuesday') as $days) {
          $day1 = $days;
          $day2 = $days;
          if($days->format('l') == "Tuesday") {
            $array_day[$days->format('Y-m-d')] = $day1->format("Y-m-d ".$start[0].":".$start[1].":s")." ~ ".$day2->format("Y-m-d ".$end[0].":".$end[1].":s");
          }   
        }
      }

      if(in_array('Wed', $target)) {
        foreach ($this->getTargetdays($start_date, $end_date, 'next wednesday') as $days) {
          $day1 = $days;
          $day2 = $days;
          if($days->format('l') == "Wednesday") {
            $array_day[$days->format('Y-m-d')] = $day1->format("Y-m-d ".$start[0].":".$start[1].":s")." ~ ".$day2->format("Y-m-d ".$end[0].":".$end[1].":s");
          }   
        }
      }

      if(in_array('Thu', $target)) {
        foreach ($this->getTargetdays($start_date, $end_date, 'next thursday') as $days) {
          $day1 = $days;
          $day2 = $days;
          if($days->format('l') == "Thursday") {
            $array_day[$days->format('Y-m-d')] = $day1->format("Y-m-d ".$start[0].":".$start[1].":s")." ~ ".$day2->format("Y-m-d ".$end[0].":".$end[1].":s");
          }   
        }
      }

      if(in_array('Fri', $target)) {
        foreach ($this->getTargetdays($start_date, $end_date, 'next friday') as $days) {
          $day1 = $days;
          $day2 = $days;
          if($days->format('l') == "Friday") {
            $array_day[$days->format('Y-m-d')] = $day1->format("Y-m-d ".$start[0].":".$start[1].":s")." ~ ".$day2->format("Y-m-d ".$end[0].":".$end[1].":s");
          }   
        }
      }

      if(in_array('Sat', $target)) {
        foreach ($this->getTargetdays($start_date, $end_date, 'next saturday') as $days) {
          $day1 = $days;
          $day2 = $days;
          if($days->format('l') == "Saturday") {
            $array_day[$days->format('Y-m-d')] = $day1->format("Y-m-d ".$start[0].":".$start[1].":s")." ~ ".$day2->format("Y-m-d ".$end[0].":".$end[1].":s");
          }   
        }
      }

      return $array_day;
    }

    public function targetUsort($data)
    {
      function cmp($a, $b)
      {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
      }
      return usort($data, "cmp");
    }

    public function targetDateDifferent($first, $last, $valid = true) 
    {
       // Creates DateTime objects
       $datetime1 = date_create($first);
       $datetime2 = date_create($last);
       // Calculates the difference between DateTime objects
       $interval = date_diff($datetime1, $datetime2);
        if($valid) {
          return $interval->format('%a days');
        } else {
          return $interval->format('%a');
        }
       // Display the result
       
    }

    /**
     * $val = week, return current week start and end;
     * $val = month, return current month start and end;
     * $val = day, return current day start and end;
     */
    public function targetWeeKMonth($val = 'week')
    {
      $return_time = [];

      if($val == 'week') {
        $start = (date('D') != 'Mon') ? date('Y-m-d 00:00:00', strtotime('last Monday')) : date('Y-m-d 00:00:00');
        $finish = (date('D') != 'Sun') ? date('Y-m-d 23:59:59', strtotime('next Sunday')) : date('Y-m-d 23:59:59');
      } elseif($val == 'day') {
        $date = new DateTime('now');
        $start = $date->format('Y-m-d 00:00:00');
        $finish = $date->format('Y-m-d 23:59:59');  
      } else {
        $date = new DateTime('now');
        $date->modify('last day of this month');         
        $start = $date->format('Y-m-01 23:59:59');
        $finish = $date->format('Y-m-d 23:59:59');  
      }
      $return_time = array('start' => strtotime($start), 'end' => strtotime($finish));
      return $return_time;
    }
    
  }