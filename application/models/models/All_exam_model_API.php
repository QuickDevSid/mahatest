<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class All_exam_model_API extends CI_Model
{
    
    public function __construct()
    {
        $this->load->database();
    }


    //fetch recored for edit
    public function getExamById($id)
    {
        $this->db->select('exam_id, exam_name, status, created_at');
        $this->db->from('exams');
        $this->db->where('exam_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }


    //API call - delete a users record
    public function delete($id)
    {
        $this->db->where('exam_id', $id);
        if ($this->db->delete('exams')) {
            return true;
        } else {
            return false;
        }
    }

    //API call - add new users record
    public function add($data)
    {
        $condition = "exam_name =" . "'" . $data['exam_name'] . "'"; // Query to check whether username already exist or not
        $this->db->select('*');
        $this->db->from('exams');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            if ($this->db->insert('exams', $data)) {
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
        $this->db->where('exam_id', $id);
        if ($this->db->update('exams', $data)) {
            return true;
        } else {
            return false;
        }
    }
}
