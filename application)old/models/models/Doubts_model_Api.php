<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Doubts_model_Api extends CI_Model
{
    
    public function __construct()
    {
        $this->load->database();
    }
    
    public function getdoughtbyid($id)
    {
        $this->db->select('D.doubt_id  as id, U.full_name as username, D.doubt_question as question, D.doubt_image as image, D.status as status, D.created_at as created_at, U.selected_exams as exam_name');
        $this->db->from('doubts D,  user_login U');
        $this->db->where('D.user_id = U.login_id');
        $this->db->where('D.doubt_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    
    public function delete($id)
    {
        $this->db->where('doubt_id', $id);
        if ($this->db->delete('doubts')) {
            return true;
        } else {
            return false;
        }
    }
    
    
}
