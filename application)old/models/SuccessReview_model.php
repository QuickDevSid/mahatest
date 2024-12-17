
<?php

class SuccessReview_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "yashogatha";
     var $select_column = array("yashogatha_id", "category","yashogatha_image", "yashogatha_title", "yashogatha_description", "status", "created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("yashogatha_title", $_POST["search"]["value"]);
        }
        $this->db->order_by('yashogatha_id', 'DESC');
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

    function getAllData($limit=false){
        $this->db->select('yashogatha_id, category, CONCAT("'.base_url().'","AppAPI/yashogatha/",yashogatha_image) as yashogatha_image, yashogatha_title, yashogatha_description, status, created_at');
        $this->db->where('status', 'Active');
        $this->db->order_by('yashogatha_id','DESC');
        $this->db->from($this->table);
        if($limit){
            $this->db->limit($limit);
        }
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
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('yashogatha_id', $id);
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
        $this->db->where('yashogatha_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function save_data( $category, $yashogatha_image, $yashogatha_title, $yashogatha_description, $status)
    {
        $data = array( 'category'=>$category,'yashogatha_image'=>$yashogatha_image, 'yashogatha_title' => $yashogatha_title, 'yashogatha_description' => $yashogatha_description, 'status' => $status);
        //return $data;
        if ($this->db->insert('yashogatha', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    function update_data($id, $category, $yashogatha_image, $yashogatha_title, $yashogatha_description, $status)
    {
        $data = array( 'category'=>$category,'yashogatha_image'=>$yashogatha_image, 'yashogatha_title' => $yashogatha_title, 'yashogatha_description' => $yashogatha_description, 'status' => $status);
        //return $data;
        $this->db->where('yashogatha_id', $id);
        if ($this->db->update('yashogatha', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }

    public function delete($id)
    {
        $this->db->where('yashogatha_id', $id);
        if ($this->db->delete('yashogatha')) {
            return true;
        } else {
            return false;
        }
    }
    
}
