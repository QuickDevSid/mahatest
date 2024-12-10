<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Daily_quiz_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "daily_quiz";
    var $select_column = array("quiz_id  as id", "quiz_title as Title","quiz_questions","quiz_duration", "status", "created_at", "subject_id");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("quiz_title", $_POST["search"]["value"]);
        }
        $this->db->order_by('quiz_id', 'DESC');
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

    //API call - get a licenses record by id
    function getAllData(){
        $this->db->select('*');
        $this->db->where('status','Active');
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
        $this->db->where('exam_id', $id);
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
        $this->db->where('exam_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    //this code for fetch recored in table format in when add quation
    var $table2 = "daily_quiz_questions dqq, daily_quiz dq";
    var $select_column1 = array("dqq.daily_quiz_questions_id as id","dqq.quiz_id as user_id", "question", "option1", "option2",
    "option3","option4","answer","dqq.status as st","dq.quiz_id as quiz","dq.quiz_title as title", "subject_id");
    function make_query_qua($id)
   {
       $this->db->select($this->select_column1);
       $this->db->from($this->table2);
       $this->db->where('dqq.quiz_id', $id);
       $this->db->where('dqq.quiz_id = dq.quiz_id');





       if (isset($_POST["search"]["value"])) {
           $this->db->like("dqq.quiz_id", $_POST["search"]["value"]);

       }
       $this->db->order_by('dqq.quiz_id', 'DESC');
   }
    function make_datatables_qua($id)
    {

        $this->make_query_qua($id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data_qua($id)
    {
        $this->make_query_qua($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data_qua($id)
    {
        $this->db->select("*");
        $this->db->from($this->table2);
        $this->db->where('dqq.quiz_id', $id);
        return $this->db->count_all_results();
    }
    
    
    public function insert($data) {
        $res = $this->db->insert_batch('daily_quiz_questions',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
