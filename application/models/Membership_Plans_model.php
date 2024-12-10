<?php

class Membership_Plans_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    var $table = "membership_plans";
    var $select_column = array("id", "title", "sub_heading", "description", "price", "actual_price", "discount_per", "no_of_months", "usage_count", "status", "created_at", "updated_at");

    public function get_single_membership_plans()
    {
        $this->db->where('membership_plans.is_deleted', '0');
        $this->db->where('membership_plans.new_status', '1');
        $this->db->where('membership_plans.id', $this->uri->segment(3));
        $result = $this->db->get('membership_plans');
        $result = $result->row();
        return $result;
    }

    public function set_membership_plans_details()
    {

        $data = array(
            // 'id' => '12',
            'title' => $this->input->post('title'),
            'sub_heading' => $this->input->post('subtitle'),
            'actual_price' => $this->input->post('mrp'),
            'price' => $this->input->post('sale_price'),
            'discount_per' => $this->input->post('discount'),
            'description' => $this->input->post('description'),
            'no_of_months' => $this->input->post('validity'),
            'status' => $this->input->post('record_status'),
            'created_at' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;
        $id = $this->input->post('id');
        // echo $id;
        // exit;
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('membership_plans', $data);
            return 0;
        } else {
            $this->db->insert('membership_plans', $data);
            return 1;
        }
    }

    public function get_single_membership_plans_list()
    {
        $this->db->select('*');
        // $this->db->where('courses.record_status', 'Active');
        $this->db->where('membership_plans.new_status', '1');
        $this->db->where('membership_plans.is_deleted', '0');
        $this->db->order_by('membership_plans.id', 'DESC');
        $result = $this->db->get('membership_plans');
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




    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("exam_name", $_POST["search"]["value"]);
        }
        $this->db->order_by('id', 'DESC');
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

    function getAllData()
    {
        $this->db->select($this->select_column);
        $this->db->where('status', 'Active');
        $this->db->from($this->table);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    //API call - get a licenses record by id
    public function getPostById($id)
    {
        //return var_dump($id);
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function editbyId($id)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    function save($data)
    {

        if ($this->db->insert($this->table, $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }
    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where($whereArr);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row_array();
        } else {
            return 0;
        }
    }
    function update($id, $data)
    {

        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table)) {
            return true;
        } else {
            return false;
        }
    }
    public function checkUserSelectedPlan($id)
    {
        $this->db->select('count(*)');
        $query = $this->db->where('plan_id', $id)->get('user_login');
        return $query->row_array();
    }
}
