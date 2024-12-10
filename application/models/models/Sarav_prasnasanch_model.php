<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Sarav_prasnasanch_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    
    public function insert($data) {
        $res = $this->db->insert_batch('sarav_prashnasanch_question',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
