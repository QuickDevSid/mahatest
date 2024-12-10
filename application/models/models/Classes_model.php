<?php

class Classes_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "classes";
     var $select_column = array("id", "title", "status", "created_at", "updated_at","description", "icon", "subject_id", "(SELECT quiz_subject.subject_name FROM quiz_subject WHERE quiz_subject.subject_id = classes.subject_id ) AS subject_name");

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
        $this->db->select('id,title,created_at,description,status,CONCAT("'.base_url().'","AppAPI/category-icon/",icon) as icon,subject_id, (SELECT quiz_subject.subject_name FROM quiz_subject WHERE quiz_subject.subject_id = classes.subject_id ) AS subject_name');
        $this->db->where('status','Active');
        $this->db->from($this->table);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getAllDataBySection($section, $limit=false){
        $this->db->select('id,title,created_at,description,status,CONCAT("'.base_url().'","AppAPI/category-icon/",icon) as icon,subject_id, (SELECT quiz_subject.subject_name FROM quiz_subject WHERE quiz_subject.subject_id = classes.subject_id ) AS subject_name');
        $this->db->where('status','Active');
        $this->db->where('section',$section);
        $this->db->from($this->table);
        if($limit){
            $this->db->limit($limit);
        }
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    //API call - get a licenses record by id
    public function getDataById($id)
    {
        $this->db->select('id,title,created_at,description,status,CONCAT("'.base_url().'","AppAPI/category-icon/",icon) as icon, icon as icon_img,subject_id, (SELECT quiz_subject.subject_name FROM quiz_subject WHERE quiz_subject.subject_id = classes.subject_id ) AS subject_name');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where($whereArr);
        $query = $this->db->get();
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

    function save($data)
    {
        
        if ($this->db->insert('classes', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    function update($id,$data)
    {
        
        $this->db->where('id', $id);
        if ($this->db->update('classes', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('classes')) {
            return true;
        } else {
            return false;
        }
    }
    
}
