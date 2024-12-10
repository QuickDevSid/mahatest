
<?php

class Exam_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "exams";
     var $select_column = array("exam_id", "exam_name","status", "created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("exam_name", $_POST["search"]["value"]);
        }
        $this->db->order_by('exam_id', 'DESC');
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
        $this->db->where('exam_id', $id);
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
        $this->db->where('exam_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
}
