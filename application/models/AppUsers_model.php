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
    var $select_column = array("login_id  as id", "full_name as Name", "my_membership_id as my_membership_id", "email as Email_ID", "is_active_membership as is_active_membership", "gender as Gender", "profile_image as Profile_Pic", "status as Status", "created_at as Added_On", "selected_exams as Selected_Exams", "login_type as Login_Type", "place", "mobile_number", "selected_exams", "selected_exams_id",'state_id','district_id','last_user_login','device_id');

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
        if($this->input->get('is_member') != ""){
            $this->db->where('is_active_membership', $this->input->get('is_member'));
            $this->db->where("my_membership_id !=",'');
            $this->db->where('CURDATE() BETWEEN start_date AND end_date');
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function check_membership($userid,$id){        
        $this->db->select('tbl_my_membership.id, tbl_my_membership.membership_id, tbl_my_membership.login_id, tbl_my_membership.start_date, tbl_my_membership.end_date, tbl_my_membership.amount, tbl_my_membership.payment_id, tbl_my_membership.status, tbl_my_membership.is_deleted, tbl_my_membership.created_at, tbl_my_membership.updated_at, membership_plans.title as membership_title');
        $this->db->join('membership_plans', 'membership_plans.id = tbl_my_membership.membership_id');
        $this->db->join('user_login', 'user_login.login_id = tbl_my_membership.login_id');
        $this->db->where('tbl_my_membership.is_deleted', '0');
        $this->db->where('tbl_my_membership.login_id', $userid);
        $this->db->where('tbl_my_membership.id', $id);
        $this->db->order_by('tbl_my_membership.id', 'desc');
        $membership_details = $this->db->get('tbl_my_membership')->row();
        return $membership_details;
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
