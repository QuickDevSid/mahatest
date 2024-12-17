<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class JobAlert_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "job_alert";
     var $select_column = array("job_alert_id as Id", "job_title as Title", "job_description as Description","job_apply_link as Link","job_poster as Poster", "status", "created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("Title", $_POST["search"]["value"]);
        }
        $this->db->order_by('Id', 'DESC');
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

    //API call - get a licenses record by id
    public function getPostById($id)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('job_alert_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    
    public function add($data){
        if($this->db->insert('job_alert', $data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function update($id, $data){
        $this->db->where('job_alert_id', $id);
        if($this->db->update('job_alert', $data)){
            return true;
        }else{
            return false;
        }
    }
}
