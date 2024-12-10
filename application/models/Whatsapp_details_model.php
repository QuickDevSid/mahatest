<?php

class Whatsapp_details_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    var $table = "membership_plans";
    var $select_column = array("id", "title", "sub_heading", "description", "price", "actual_price", "discount_per", "no_of_months", "usage_count", "status", "created_at", "updated_at");



    public function set_whatsapp_details_details()
    {
        $data = array(
            'whatsapp_number' => $this->input->post('whatsapp_number'),
            'created_on' => date('Y-m-d H:i:s')
        );
        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('tbl_whatsapp_details', $data);
            return 0;
        } else {
            $this->db->insert('tbl_whatsapp_details', $data);
            return 1;
        }
    }

    public function get_single_whatsapp_details()
    {
        $this->db->where('tbl_whatsapp_details.is_deleted', '0');
        $this->db->where('tbl_whatsapp_details.status', '1');
        $this->db->where('tbl_whatsapp_details.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_whatsapp_details');
        $result = $result->row();
        return $result;
    }

    public function get_single_whatsapp_details_list()
    {
        $this->db->where('tbl_whatsapp_details.status', '1');
        $this->db->where('tbl_whatsapp_details.is_deleted', '0');
        $this->db->order_by('tbl_whatsapp_details.id', 'ASC');
        $result = $this->db->get('tbl_whatsapp_details');
        return $result->result();
    }

    public function delete_membership_plans_list()
    {
        $data = array(
            'new_status' => 0,
            'status' => 'Inactive',
            'is_deleted' => 1
        );

        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('membership_plans', $data);
    }

    public function status_membership_plans_list_active()
    {
        // $id = $this->uri->segment(3);
        // echo $id;
        // exit;
        $data = array(
            'status' => 'Inactive'
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('membership_plans', $data);
    }

    public function status_membership_plans_list_in_active()
    {
        $data = array(
            'status' => 'Active'
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('membership_plans', $data);
    }
}
