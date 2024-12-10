<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_model extends CI_Model { 

    public function get_app_users_list_ajx($length, $start, $search){
        if($search !=""){
            // $this->db->or_like('tbl_app_users.project',$search);
            $this->db->or_like('tbl_app_users.username',$search);
            $this->db->or_like('tbl_app_users.password',$search);
            $this->db->or_like('tbl_app_users.mobile_no',$search);
            $this->db->or_like('tbl_app_users.email',$search);
            $this->db->or_like('tbl_app_users.name',$search);
            $this->db->or_like('tbl_app_users.last_login_on',$search);
            $this->db->or_like('tbl_app_users.device_details',$search);
        }	

        if($this->input->post('project') !=""){
            $this->db->where('tbl_app_users.project', $this->input->post('project'));
        }
        
        $this->db->where('tbl_app_users.is_deleted','0');
        $this->db->order_by('tbl_app_users.id','DESC');
        $this->db->limit($length,$start);
        $result = $this->db->get('tbl_app_users');
        return $result->result();		
	}
	public function get_app_users_count_ajx($search){
        if($search !=""){
            // $this->db->or_like('tbl_app_users.project',$search);
            $this->db->or_like('tbl_app_users.username',$search);
            $this->db->or_like('tbl_app_users.password',$search);
            $this->db->or_like('tbl_app_users.mobile_no',$search);
            $this->db->or_like('tbl_app_users.email',$search);
            $this->db->or_like('tbl_app_users.name',$search);
            $this->db->or_like('tbl_app_users.last_login_on',$search);
            $this->db->or_like('tbl_app_users.device_details',$search);
        }

        if($this->input->post('project') !=""){
            $this->db->where('tbl_app_users.project', $this->input->post('project'));
        }	

        $this->db->where('tbl_app_users.is_deleted','0');
        $this->db->order_by('tbl_app_users.id','DESC');
        $result = $this->db->get('tbl_app_users');
        return $result->num_rows();
	}






}