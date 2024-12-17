
<?php

class Masike_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }
    var $table = "masike";
  var $select_column = array("id", "category_id","title", "description", "image_url", "pdf_url", "status", "created_at", "can_download");

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
        if ($this->db->insert('masike', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    public function getCategories($limit=false){
        $this->db->select('category.id, category.title as category_name, CONCAT("'.base_url().'","AppAPI/category-icon/",category.icon_img) as category_img, COUNT(masike.category_id) as total');
        $this->db->from('masike');
        $this->db->join('category','category.id=masike.category_id','inner');
        $this->db->where('masike.status','Active');
        $this->db->group_by('masike.category_id');
        $this->db->order_by('category_id','ASC');
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

    function getItemsByCategory($category){
        $this->db->select('masike.id, category_id, category.title as category_name, masike.title, description, CONCAT("'.base_url().'","AppAPI/masike/images/",image_url) as image_url, CONCAT("'.base_url().'","AppAPI/masike/pdf/",pdf_url) as pdf_url, masike.status, masike.created_at, can_download');
        $this->db->where('masike.status','Active');
        $this->db->where('masike.category_id',$category);
        $this->db->from("masike, category");
        $this->db->where('masike.category_id = category.id ');
        $this->db->order_by('masike.created_at','desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
}
