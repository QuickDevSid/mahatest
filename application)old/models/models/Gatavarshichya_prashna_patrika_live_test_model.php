<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Gatavarshichya_prashna_patrika_live_test_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    
    public function insert($data) {
        $res = $this->db->insert_batch('gatavarshichya_prashna_patrika_live_test',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
