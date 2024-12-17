<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Study_Material_Model_Api extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    // for add study
    public function add($data)
    {
        $condition = "study_material_title =" . "'" . $data['study_name'] . "'"; // Query to check whether username already exist or not
        $this->db->select('*');
        $this->db->from('study_material');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            if ($this->db->insert('study_material', $data)) {
                return "Inserted";
            } else {
                return "Failed";
            }
        } else {
            return "Exists";
        }

    }
    public function getStudyById($id){
         //echo $id;
         //$this->load->model("CurrentAffairs_model");
          $this->db->select('study_material_id, study_material_title, status, created_at');
          $this->db->from('study_material');
          $this->db->where('study_material_id',$id);
          $query = $this->db->get();
          if($query->num_rows() == 1)
          {
              return $query->result_array();
          }
          else
          {
            return 0;
         }
     }
     public function geteditstudybyid($id){
         //echo $id;
         //$this->load->model("CurrentAffairs_model");
          $this->db->select('study_material_id, study_material_title, status, created_at');
          $this->db->from('study_material');
          $this->db->where('study_material_id',$id);
          $query = $this->db->get();
          if($query->num_rows() == 1)
          {
              return $query->result_array();
          }
          else
          {
            return 0;
         }
     }
     public function update($id, $data)
    {
     $this->db->where('study_material_id', $id);
     if($this->db->update('study_material', $data)){
        return true;
      }else{
        return false;
      }
    }
    public function delete($id)
    {
        $this->db->where('study_material_id', $id);
        if ($this->db->delete('study_material')) {
            return true;
        } else {
            return false;
        }
    }
    //this code for add study content
public  function add_study_content($content_id,$study_quiz_title,$study_total_qua,$study_total_time,$study_content_status)
{
   $data = array(
           'study_material_id' => $content_id,
           'quiz_title'     => $study_quiz_title,
           'total_questions'     => $study_total_qua,
           'total_time'     => $study_total_time,
           'status'     => $study_content_status


       );

   if ($this->db->insert('study_material_content_quiz',$data)) {
           return "Inserted";
       } else {
           return "Failed";
       }
}
public function delete_content($id)
     {
         $this->db->where('study_material_content_quiz_id', $id);
         if ($this->db->delete('study_material_content_quiz')) {
             return true;
         } else {
             return false;
         }
     }


}
