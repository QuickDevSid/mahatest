
<?php

class Exam_section_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "exam_section";
     var $select_column = array("id", "title", "icon", "created_at","updated_at","background_color");

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
        $this->db->select('id,title,CONCAT("'.base_url().'","AppAPI/exam-section-icon/",icon) as icon,created_at,updated_at,background_color');
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

    function save_upload($data)
    {
        
        if ($this->db->insert('exam_section', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    function update_upload($id,$data)
    {
        
        $this->db->where('id', $id);
        if ($this->db->update('exam_section', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('exam_section')) {
            return true;
        } else {
            return false;
        }
    }
    
}
