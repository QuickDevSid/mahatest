<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Doubts_models extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    var $table = "doubts";
    var $select_column = array("doubt_id","user_id", "doubt_question", "doubt_image", "status");
    
    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST["search"]["value"])) {
            $this->db->like("doubt_question", $_POST["search"]["value"]);
        }
        $this->db->order_by('doubt_id ', 'DESC');
    }
    function get_user_details($id){
        $this->db->where('login_id',$id);
        $result = $this->db->get('user_login')->row();
        return $result;
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




    public function getDoubts($userID, $limit=false){
        $this->db->select('doubt_id, user_id, doubt_question, doubt_image, CONCAT("'.base_url().'","AppAPI/user-doubts/",doubt_image) as doubt_image_full_path, status, created_at');
        $this->db->from('doubts');
        $this->db->where('status','Active');
        $this->db->where('user_id',$userID);
        $this->db->order_by('doubt_id ','DESC');
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

    
    // public function getSingleDoubts($userID){
    //     $this->db->select('doubts.*,user_login.Name');
    //     $this->db->join('user_login','doubts.user_id= user_login.id');
    //     $this->db->where('doubts.is_deleted', '0');
    //     $this->db->where('doubts.id', $id);
    //     $result = $this->db->get('doubts')->row();
    //     return $result;
    // }

    public function getSingleDoubtss($userID, $doubtId, $limit=false){
        $this->db->select('doubt_id, user_id, doubt_question, doubt_image, CONCAT("'.base_url().'","AppAPI/user-doubts/",doubt_image) as doubt_image_full_path, status, created_at');
        $this->db->from('doubts');
        $this->db->where('status','Active');
        $this->db->where('user_id',$userID);
        $this->db->where('doubt_id',$doubtId);
        $this->db->order_by('doubt_id ','DESC');
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
        if ($this->db->insert('doubts', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    
}
