<?php

class Exam_subsubject_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "quiz_subsubject";
     var $select_column = array("id","subject_id", "title", "status", "created_at","description");

    function make_query()
    {
        $this->db->select("id,quiz_subsubject.subject_id,title,quiz_subsubject.status, created_at,quiz_subsubject.description,subject_name");
        $this->db->join('quiz_subject','quiz_subsubject.subject_id=quiz_subject.subject_id','inner');
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
        //echo $this->db->last_query();die;
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
        $this->db->select('id,subject_id,title,created_at,description,status');
        $this->db->from($this->table);
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
        $this->db->select("id,quiz_subsubject.subject_id,title,quiz_subsubject.status, created_at,quiz_subsubject.description,subject_name");
        $this->db->join('quiz_subject','quiz_subsubject.subject_id=quiz_subject.subject_id','inner');
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
        //return $whereArr;
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where($whereArr);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()==1) {
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
        
        if ($this->db->insert('quiz_subsubject', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    function update($id,$data)
    {
        
        $this->db->where('id', $id);
        if ($this->db->update('quiz_subsubject', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('quiz_subsubject')) {
            return true;
        } else {
            return false;
        }
    }



    // Get list of Chapters by Subject and Section
    public function getAllDataChapterBySubjectSection($subject, $section, $limit=false){
        $this->db->select('quiz_subsubject.id as ChapterId, quiz_subsubject.title as Title, quiz_subsubject.description as Description, quiz_subsubject.status as Status, CONCAT("'.base_url().'","AppAPI/category-icon/",quiz_subject.icon) as icon, COUNT(quizs.sub_subject_id) as quizCount');
        $this->db->from('quizs');
        $this->db->join('quiz_subsubject','quiz_subsubject.id = quizs.sub_subject_id','inner');
        $this->db->join('quiz_subject','quiz_subject.subject_id = quiz_subsubject.subject_id','inner');
        $this->db->where('quizs.subject_id',$subject);
        $this->db->where('quizs.section',$section);
        $this->db->where('quizs.status','Active');
        $this->db->group_by('quizs.sub_subject_id');
        $this->db->order_by("quiz_subsubject.id", "ASC");

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
}
