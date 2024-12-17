<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Users_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    var $table = "panel_users";
    var $select_column = array("id", "name", "mobile", "email", "password", "type", "status", "is_deleted");

    public function delete_user($id){
        $this->db->where('id',$id);
        $this->db->where('is_deleted','0');
        $exist = $this->db->get('panel_users')->row();
        if(!empty($exist)){
            $this->db->where('id',$id);
            $this->db->update('panel_users',array('is_deleted'=>'1'));
        }
        return true;
    }
    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST["search"]["value"])) {
            $this->db->like("name", $_POST["search"]["value"]);
            $this->db->or_like("mobile", $_POST["search"]["value"]);
            $this->db->or_like("email", $_POST["search"]["value"]);
            $this->db->or_like("type", $_POST["search"]["value"]);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->where('is_deleted', '0');
    }


    /**
     * This function is used to Update record in table
     */
    public function updateRow($table, $col, $colVal, $data) {
        $this->db->where($col,$colVal);
        $this->db->update($table,$data);
        return true;
    }
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('panel_users', $data)) {
            return true;
        } else {
            return false;
        }
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

    //API call - get a users record by id
    function getuserbyid($id)
    {
        $this->db->select('*');
        $this->db->from('panel_users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function getDataByid($tableName='',$columnValue='',$colume='')
    {
        $this->db->select('*');
        $this->db->from($tableName);
        $this->db->where($colume , $columnValue);
        $query = $this->db->get();
        return $result = $query->row();
    }

    function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
