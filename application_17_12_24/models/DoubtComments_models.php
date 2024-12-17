<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class DoubtComments_models extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    var $table = "doubts_comment";
    var $select_column = array("doubts_comment_id", "doubt_id", "login_id", "comment_body", "status", "created_at", "updated_on", "messageSender");
    
    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST["search"]["value"])) {
            $this->db->like("comment_body", $_POST["search"]["value"]);
        }
        $this->db->order_by('doubts_comment_id ', 'DESC');
    }
    
    function make_datatables()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function get_all_data()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    public function getRecordById($doubtID, $limit=false){
        $this->db->select('doubts_comment_id, doubt_id, login_id, comment_body, status, messageSender, created_at, updated_on');
        $this->db->from('doubts_comment');
        $this->db->where('doubt_id',$doubtID);
        $this->db->where('status','Active');
        $this->db->order_by('doubts_comment_id','ASC');
        if($limit){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function save( $data)
    {
        //return $data;
        if ($this->db->insert('doubts_comment', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }
}
