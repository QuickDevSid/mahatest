<?php


class Test_series_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "test_series";
     var $select_column = array(
        'id',
        "title",
        "sub_headings",
        "banner_image",
        "mrp",
        "sale_price",
        "discount",
        "status",
        "usage_count",
        "description",
        "created_at",
        "updated_at",
     );

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("test_title", $_POST["search"]["value"]);
        }
        $this->db->order_by('id', 'DESC');
    }

    function make_datatables()
    {
        $this->make_query();
        $query = $this->db->get();
        if(empty($query)){
            return [];
        }
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        if(empty($query)){
            return [];
        }
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
        $this->db->where('status','Active');
        $this->db->from($this->table);
       
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
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
    function save( $data)
    {
        //return $data;
        if ($this->db->insert($this->table, $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }
    public function updateViews($id){
        $this->db->set('views_count', 'views_count + 1', FALSE);
        $this->db->where('id', $id);

        if($this->db->update($this->table)){
            return true;
        }else{
            return false;
        }
    }
    function update($id,$data)
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
}
?>