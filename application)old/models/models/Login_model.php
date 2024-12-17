<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

Class Login_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function validate_login($postData){
        $this->db->select('*');
        $this->db->where('email', $postData['username']);
        $this->db->where('password', $postData['password']);
        $this->db->where('status', 'Active');
        $this->db->from('panel_users');
        $query=$this->db->get();
        if ($query->num_rows() == 0)
            return false;
        else
            return $query->result();
    }

}
