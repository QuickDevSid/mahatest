
<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class AppUsers_API_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    
    //delete recored form sql
    public function delete($id)
     {
         $this->db->where('login_id', $id);
         if ($this->db->delete('user_login')) {
             return true;
         } else {
             return false;
         }
     }
     //fetch record for edit
     public function getclientbyid($id){
          $this->db->select('login_id, full_name, email, password, gender, selected_exams, mobile_number, selected_exams_id,  `status`, `created_at`','state_id','district_id','device_id');
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


     public function getDetailByWhereConditionArr($whereArr){
        $this->db->select('*');
        $this->db->from('user_login');
        $this->db->where($whereArr);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->row_array();
        }
        else
        {
          return 0;
       }
     }
     public function save_user($data){
        if ($this->db->insert('user_login', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }
    function update($id,$data)
    {
        $this->db->where('login_id', $id);
        if ($this->db->update('user_login', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }

}
