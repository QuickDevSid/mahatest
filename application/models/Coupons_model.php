
<?php

class Coupons_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }
    var $table = "coupons";
  var $select_column = array("id", "type", "coupon_code", "description",  "coupon_amount", "usage_count", "status", "created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("coupon_code", $_POST["search"]["value"]);
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

    function getAllData(){
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getPostById($id)
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

    function save( $data)
    {
        //return $data;
        if ($this->db->insert('coupons', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    function getCoupons($type){
        $this->db->select('id, type, coupon_code, description,  coupon_amount, usage_count, status, created_at');
        $this->db->where('status','Active');
        $this->db->where('type',$type);
        $this->db->from("coupons");
        $this->db->order_by('created_at','desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function checkCouponCode($id, $type)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('coupon_code', $id);
        $this->db->where('type', $type);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function updateViews($id){
        $this->db->set('usage_count', 'usage_count + 1', FALSE);
        $this->db->where('id', $id);

        if($this->db->update('coupons')){
            return true;
        }else{
            return false;
        }
    }

}
