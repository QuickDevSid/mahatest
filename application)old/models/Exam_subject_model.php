<?php

class Exam_subject_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "quiz_subject";
     var $select_column = array("subject_id", "subject_name", "status", "created_at","description", "icon", "section");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("subject_name", $_POST["search"]["value"]);
        }
        $this->db->order_by('subject_id', 'DESC');
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
        $this->db->select('subject_id,subject_name,created_at,description,status,CONCAT("'.base_url().'","AppAPI/category-icon/",icon) as icon,section');
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
        $this->db->select('quiz_subject.subject_id, quiz_subject.subject_name, quiz_subject.created_at, quiz_subject.description, quiz_subject.status, CONCAT("'.base_url().'","AppAPI/category-icon/",quiz_subject.icon) as icon, quiz_subject.section, COUNT(quizs.subject_id) as total');
        $this->db->from('quizs');
        $this->db->join('quiz_subject','quiz_subject.subject_id = quizs.subject_id','inner');
        $this->db->where('quiz_subject.status','Active');
        $this->db->where('quizs.status','Active');
        $this->db->where('quiz_subject.section',$section);
        $this->db->group_by('quizs.subject_id');
        $this->db->order_by('quiz_subject.subject_id ','ASC');

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
    public function getDataById($id)
    {
        $this->db->select('subject_id,subject_name,created_at,description,status,CONCAT("'.base_url().'","AppAPI/category-icon/",icon) as icon, icon as icon_img,section');
        $this->db->from($this->table);
        $this->db->where('subject_id', $id);
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
        $this->db->where('subject_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function save($data)
    {
        
        if ($this->db->insert('quiz_subject', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    function update($id,$data)
    {
        
        $this->db->where('subject_id', $id);
        if ($this->db->update('quiz_subject', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }

    public function delete($id)
    {
        $this->db->where('subject_id', $id);
        if ($this->db->delete('quiz_subject')) {
            return true;
        } else {
            return false;
        }
    }
    
}
