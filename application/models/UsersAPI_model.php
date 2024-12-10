<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class UsersAPI_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    //API call - get a users record by id
    public function getuserbyid($id)
    {
        $this->db->select('id, name, mobile, email, password, type, status, profile_pic');
        $this->db->from('panel_users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    //API call - get all users record
    public function getallusers()
    {
        $this->db->select('id, name, mobile, email, password, type, status, profile_pic');
        $this->db->from('panel_users');
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    //API call - delete a users record
    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('panel_users')) {
            return true;
        } else {
            return false;
        }
    }

    //API call - add new users record
    public function add($data)
    {
        $condition = "email =" . "'" . $data['email'] . "'"; // Query to check whether username already exist or not
        $this->db->select('*');
        $this->db->from('panel_users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            if ($this->db->insert('panel_users', $data)) {
                return "Inserted";
            } else {
                return "Failed";
            }
        } else {
            return "Exists";
        }

    }

    //API call - update a users record
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('panel_users', $data)) {
            return true;
        } else {
            return false;
        }
    }
    
}
