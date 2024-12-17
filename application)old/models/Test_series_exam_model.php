<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Test_series_exam_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    
    public function insert($data) {
        $res = $this->db->insert_batch('test_series_questions',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
