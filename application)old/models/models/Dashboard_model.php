<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        $this->load->library('session');
        $this->load->database();
    }
    
    var $table = "user_login";
    var $select_column = array("login_id as id", "full_name as Name", "email as EmailID", "gender as Gender", "profile_image as Profile_Image", "selected_exams as Selected_Exams", "login_type as Login_Type", "status as Status", "created_at as Added_On");
    
    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        
        if (isset($_POST["search"]["value"])) {
            $this->db->like("Name", $_POST["search"]["value"]);
            $this->db->or_like("EmailID", $_POST["search"]["value"]);
        }
        
        $this->db->order_by('Id', 'DESC');
        $this->db->limit(50);
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
    
    function make_datatables()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->result();
    }
    
    function make_query_chart()
    {
        $this->db->select("status as Label, COUNT(*) as Value");
        $this->db->from("user_login");
        $this->db->group_by('status');
        
    }
    
    function make_query_state1()
    {
        $this->db->select("COUNT(*) AS Users");
        $this->db->from("user_login");
    }
    
    function make_query_state2()
    {
        $this->db->select("COUNT(*) AS exams");
        $this->db->from("exams");
    }
    
    function make_query_state3()
    {
        $this->db->select("COUNT(*) AS Videos");
        $this->db->from("videos");
    }
    
    function make_query_state4()
    {
        $this->db->select("COUNT(*) AS Jobs");
        $this->db->from("job_alert");
    }
    
    
    function make_donutchart()
    {
        $this->make_query_chart();
        $query = $this->db->get();
        return $query->result();
    }
    
    function make_statistic1()
    {
        $query = $this->make_query_state1();
        $query = $this->db->get();
        return $query->result();
    }
    
    function make_statistic2()
    {
        $query = $this->make_query_state2();
        $query = $this->db->get();
        return $query->result();
    }
    
    function make_statistic3()
    {
        $query = $this->make_query_state3();
        $query = $this->db->get();
        return $query->result();
    }
    
    function make_statistic4()
    {
        $query = $this->make_query_state4();
        $query = $this->db->get();
        return $query->result();
    }
    
    
   
    
    
  
}
