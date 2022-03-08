<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_Model extends CI_Model
{
    protected $seq1 = 'seq_record';

    public function seqInsert($data)
    {
      $this->db->insert($this->seq1, $data);
      return true;
    }

}
