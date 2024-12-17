<?php
require_once 'vendor/autoload.php';
class User_Payments_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_payments_ajx_list($length, $start, $search)
    {
        $this->db->select('tbl_user_payments.*, user_login.full_name, user_login.email, user_login.mobile_number');
        $this->db->join('user_login', 'tbl_user_payments.user_id = user_login.login_id');
        $this->db->where('tbl_user_payments.is_deleted', '0');
        if ($search !== "") {
            $this->db->group_start();
            $this->db->like('user_login.full_name', $search);
            $this->db->like('user_login.email', $search);
            $this->db->like('user_login.mobile_number', $search);
            $this->db->like('tbl_user_payments.payment_on', $search);
            $this->db->like('tbl_user_payments.transaction_id', $search);
            $this->db->like('tbl_user_payments.payment_amount', $search);
            $this->db->group_end();
        }
        if($this->input->post('user_id') != ""){
            $this->db->where('tbl_user_payments.user_id', $this->input->post('user_id'));
        }
        if($this->input->post('type') != ""){
            $this->db->where('tbl_user_payments.payment_for', $this->input->post('type'));
        }
        $this->db->limit($length, $start);
        $this->db->order_by('tbl_user_payments.payment_on', 'desc');
        $this->db->group_by('tbl_user_payments.id');
        $result = $this->db->get('tbl_user_payments');
        return $result->result();
    }
    public function get_payments_ajx_count($search)
    {
        $this->db->select('tbl_user_payments.*, user_login.full_name, user_login.email, user_login.mobile_number');
        $this->db->join('user_login', 'tbl_user_payments.user_id = user_login.login_id');
        $this->db->where('tbl_user_payments.is_deleted', '0');
        if ($search !== "") {
            $this->db->group_start();
            $this->db->like('user_login.full_name', $search);
            $this->db->like('user_login.email', $search);
            $this->db->like('user_login.mobile_number', $search);
            $this->db->like('tbl_user_payments.payment_on', $search);
            $this->db->like('tbl_user_payments.transaction_id', $search);
            $this->db->like('tbl_user_payments.payment_amount', $search);
            $this->db->group_end();
        }
        if($this->input->post('user_id') != ""){
            $this->db->where('tbl_user_payments.user_id', $this->input->post('user_id'));
        }
        if($this->input->post('type') != ""){
            $this->db->where('tbl_user_payments.payment_for', $this->input->post('type'));
        }
        $this->db->order_by('tbl_user_payments.payment_on', 'desc');
        $this->db->group_by('tbl_user_payments.id');
        $result = $this->db->get('tbl_user_payments');
        return $result->num_rows();
    }
    public function get_content_details($table,$id){
        $this->db->where('id',$id);
        return $this->db->get($table)->row();;
    }
    public function get_contents_ajx_list($length, $start, $search)
    {
        $this->db->select('tbl_user_contents.*, user_login.full_name, user_login.email, user_login.mobile_number');
        $this->db->join('user_login', 'tbl_user_contents.user_id = user_login.login_id');
        $this->db->where('tbl_user_contents.is_deleted', '0');
        if ($search !== "") {
            $this->db->group_start();
            $this->db->like('user_login.full_name', $search);
            $this->db->like('user_login.email', $search);
            $this->db->like('user_login.mobile_number', $search);
            $this->db->like('tbl_user_contents.payment_on', $search);
            $this->db->like('tbl_user_contents.transaction_id', $search);
            $this->db->like('tbl_user_contents.payment_amount', $search);
            $this->db->group_end();
        }
        if($this->input->post('user_id') != ""){
            $this->db->where('tbl_user_contents.user_id', $this->input->post('user_id'));
        }
        if($this->input->post('type') != ""){
            $this->db->where('tbl_user_contents.type', $this->input->post('type'));
        }
        $this->db->limit($length, $start);
        $this->db->order_by('tbl_user_contents.payment_on', 'desc');
        $this->db->group_by('tbl_user_contents.id');
        $result = $this->db->get('tbl_user_contents');
        return $result->result();
    }
    public function get_contents_ajx_count($search)
    {
        $this->db->select('tbl_user_contents.*, user_login.full_name, user_login.email, user_login.mobile_number');
        $this->db->join('user_login', 'tbl_user_contents.user_id = user_login.login_id');
        $this->db->where('tbl_user_contents.is_deleted', '0');
        if ($search !== "") {
            $this->db->group_start();
            $this->db->like('user_login.full_name', $search);
            $this->db->like('user_login.email', $search);
            $this->db->like('user_login.mobile_number', $search);
            $this->db->like('tbl_user_contents.payment_on', $search);
            $this->db->like('tbl_user_contents.transaction_id', $search);
            $this->db->like('tbl_user_contents.payment_amount', $search);
            $this->db->group_end();
        }
        if($this->input->post('user_id') != ""){
            $this->db->where('tbl_user_contents.user_id', $this->input->post('user_id'));
        }
        if($this->input->post('type') != ""){
            $this->db->where('tbl_user_contents.type', $this->input->post('type'));
        }
        $this->db->order_by('tbl_user_contents.payment_on', 'desc');
        $this->db->group_by('tbl_user_contents.id');
        $result = $this->db->get('tbl_user_contents');
        return $result->num_rows();
    }
}
