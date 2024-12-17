


<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class CurrentAffairsApi_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    
    //API call - delete a Current Affair's record
    public function delete($id)
    {
        $this->db->where('current_affair_id', $id);
        if ($this->db->delete('current_affairs')) {
            return true;
        } else {
            return false;
        }
    }

    //API call - add new users record
   
    
}
