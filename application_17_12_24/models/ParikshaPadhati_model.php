
<?php

class ParikshaPadhati_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }
    var $table = "pariksha_padhati";
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
        if ($this->db->insert('pariksha_padhati', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    public function getCategories($limit=false){
        $this->db->select('category.id, category.title as category_name, CONCAT("'.base_url().'","AppAPI/category-icon/",category.icon_img) as category_img, COUNT(pariksha_padhati.category_id) as total');
        $this->db->from('pariksha_padhati');
        $this->db->join('category','category.id=pariksha_padhati.category_id','inner');
        $this->db->where('pariksha_padhati.status','Active');
        $this->db->group_by('pariksha_padhati.category_id');
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
        $this->db->select('pariksha_padhati.id, category_id, category.title as category_name, pariksha_padhati.title, description, CONCAT("'.base_url().'","AppAPI/pariksha_padhati/images/",image_url) as image_url, CONCAT("'.base_url().'","AppAPI/pariksha_padhati/pdf/",pdf_url) as pdf_url, pariksha_padhati.status, pariksha_padhati.created_at, can_download');
        $this->db->where('pariksha_padhati.status','Active');
        $this->db->where('pariksha_padhati.category_id',$category);
        $this->db->from("pariksha_padhati, category");
        $this->db->where('pariksha_padhati.category_id = category.id ');
        $this->db->order_by('pariksha_padhati.created_at','desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
}