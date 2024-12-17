<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class AppUsers_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    var $table = "user_login";
    var $select_column = array("login_id  as id", "full_name as Name", "email as Email_ID", "gender as Gender", "profile_image as Profile_Pic", "status as Status", "created_at as Added_On", "selected_exams as Selected_Exams", "login_type as Login_Type", "place", "mobile_number", "selected_exams", "selected_exams_id",'state_id','district_id','last_user_login','device_id');

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("Name", $_POST["search"]["value"]);
            $this->db->or_like("Email_ID", $_POST["search"]["value"]);
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
    public function getAppUserById($id)
    {
        

        $this->db->select('login_id,full_name,email,password,gender,profile_image,selected_exams,login_type,status,created_at');
           $this->db->from('user_login');
           $this->db->where('login_id',$id);
           $query = $this->db->get();
           if($query->num_rows() == 1)
           {
               return $query->result_array();
           }
           else
           {
             return 0;
          }
    }


}
