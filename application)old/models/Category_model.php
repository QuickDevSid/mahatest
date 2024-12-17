
<?php

class Category_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "category";
     var $select_column = array("id", "section","title","icon_img","status", "created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("title", $_POST["search"]["value"]);
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

    function getAllData($condition){
        $this->db->select($this->select_column);
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->where('status','Active');
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
    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select('id, section, title, CONCAT("'.base_url().'","AppAPI/category-icon/",icon_img) as icon_img, status, created_at');
        $this->db->from($this->table);
        $this->db->where($whereArr);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->row_array();
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

    function save_upload($data)
    {
        
        if ($this->db->insert('category', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    function update_upload($id,$data)
    {
        
        $this->db->where('id', $id);
        if ($this->db->update('category', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('category')) {
            return true;
        } else {
            return false;
        }
    }
}
