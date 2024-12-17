
<?php

class AbhyasSahitya_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "abhyas_sahitya";
     var $select_column = array("abhyas_sahitya_id", "abhyas_sahitya_category_id","title", "description", "image_url", "pdf_url", "status", "created_at", "can_download", "type");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("title", $_POST["search"]["value"]);
        }
        $this->db->order_by('abhyas_sahitya_id', 'DESC');
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
        $this->db->where('abhyas_sahitya_id', $id);
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
        $this->db->where('abhyas_sahitya_id', $id);
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
        if ($this->db->insert('abhyas_sahitya', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    public function getAbhyasSahityaCategory($limit=false){
        $this->db->select('category.id,category.title as category_name,CONCAT("'.base_url().'","AppAPI/category-icon/",category.icon_img) as category_img,COUNT(abhyas_sahitya.abhyas_sahitya_category_id) as total');
        $this->db->from('abhyas_sahitya');
        $this->db->join('category','category.id=abhyas_sahitya.abhyas_sahitya_category_id','inner');
        $this->db->where('abhyas_sahitya.status','Active');
        $this->db->group_by('abhyas_sahitya.abhyas_sahitya_category_id');
        $this->db->order_by('abhyas_sahitya_category_id','ASC');
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
        $this->db->select('abhyas_sahitya_id, abhyas_sahitya_category_id, category.title as category_name, abhyas_sahitya.title, description, CONCAT("'.base_url().'","AppAPI/abhyas_sahitya/images/",image_url) as image_url, CONCAT("'.base_url().'","AppAPI/abhyas_sahitya/pdf/",pdf_url) as pdf_url, abhyas_sahitya.status, abhyas_sahitya.created_at, can_download, type');
        $this->db->where('abhyas_sahitya.status','Active');
        $this->db->where('abhyas_sahitya.abhyas_sahitya_category_id',$category);
        $this->db->where('abhyas_sahitya.type',$type);
        $this->db->from("abhyas_sahitya, category");
        $this->db->where('abhyas_sahitya.abhyas_sahitya_category_id = category.id ');
        $this->db->order_by('abhyas_sahitya.created_at','desc');

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }

    }
}
