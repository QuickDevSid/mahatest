<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Study_Material_Model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "study_material";
    var $select_column = array("study_material_id  as id", "study_material_title as Title", "status", "created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("Title", $_POST["search"]["value"]);
        }
        $this->db->order_by('Id', 'DESC');
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
    var $table2 = "study_material_content_quiz dqq, study_material dq";
    var $select_column1 = array("dqq.study_material_content_quiz_id as id","dqq.study_material_id as material_id", "quiz_title", "total_questions",
     "total_time","dqq.status as st","dq.study_material_id as study_id","dq.study_material_title as title");
    function make_query_qua($id)
   {
       $this->db->select($this->select_column1);
       $this->db->from($this->table2);
       $this->db->where('dqq.study_material_id', $id);
       $this->db->where('dqq.study_material_id = dq.study_material_id');





       if (isset($_POST["search"]["value"])) {
           $this->db->like("dqq.study_material_id", $_POST["search"]["value"]);

       }
       $this->db->order_by('dqq.study_material_id', 'DESC');
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
        $this->db->where('dqq.study_material_id', $id);
        return $this->db->count_all_results();
    }

}
