
<?php

class AbhyasSahitya_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "tbl_other_option";
     var $select_column = array("id", "other_option_category_id","title","short_description", "description", "image_url", "pdf_url", "status", "created_on", "can_download", "type");

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
        if ($this->db->insert('tbl_other_option', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    public function getAbhyasSahityaCategory($limit=false){
        $this->db->select('category.id,category.title as category_name,CONCAT("'.base_url().'","AppAPI/category-icon/",category.icon_img) as category_img,COUNT(tbl_other_option.other_option_category_id) as total');
        $this->db->from('tbl_other_option');
        $this->db->join('tbl_other_option_category','category.id=tbl_other_option.other_option_category_id','inner');
        $this->db->where('tbl_other_option.status','Active');
        $this->db->group_by('tbl_other_option.other_option_category_id');
        $this->db->order_by('other_option_category_id','ASC');
        if($limit){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getAbhyasSahityaByCategory($category, $type){
        $this->db->select('id, other_option_category_id	, tbl_other_option_category.title as category_name, tbl_other_option.title, description, CONCAT("'.base_url().'","AppAPI/tbl_other_option/images/",image_url) as image_url, CONCAT("'.base_url().'","AppAPI/tbl_other_option/pdf/",pdf_url) as pdf_url, tbl_other_option.status, tbl_other_option.created_on, can_download, type');
        $this->db->where('tbl_other_option.status','Active');
        $this->db->where('tbl_other_option.other_option_category_id',$category);
        $this->db->where('tbl_other_option.type',$type);
        $this->db->from("tbl_other_option, category");
        $this->db->where('tbl_other_option.other_option_category_id = tbl_other_option_category.id ');
        $this->db->order_by('tbl_other_option.created_on','desc');

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }

    }
}
