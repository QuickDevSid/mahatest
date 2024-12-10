<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Daily_quiz_model_Api extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    // for add study
    public function add($data)
    {
      if ($this->db->insert('daily_quiz', $data)) {
             return "Inserted";
         } else {
             return "Failed";
         }

    }
    public function getQuizById($id){
        //echo $id;
        //$this->load->model("CurrentAffairs_model");
         $this->db->select('*');
         $this->db->from('daily_quiz');
         $this->db->where('quiz_id',$id);
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
    public  function update_upload($id, $data)
    {
      $this->db->where('quiz_id', $id);
   if($this->db->update('daily_quiz', $data)){
      return "Inserted";
    }else{
     return "Failed";
    }
 }
 public function delete($id)
    {
        $this->db->where('quiz_id', $id);
        if ($this->db->delete('daily_quiz')) {
            return true;
        } else {
            return false;
        }
    }
//this code add qua and ans
function add_qua_qua($quiz_id,$quiz_quation,$quiz_opt1,$quiz_opt2,$quiz_opt3,$quiz_opt4,$quiz_status,$quiz_ans, $subject_id, $explanation)
    {
       $data = array(
               'quiz_id' => $quiz_id,
               'question'     => $quiz_quation,
               'option1'     => $quiz_opt1,
               'option2'     => $quiz_opt2,
               'option3'     => $quiz_opt3,
               'option4'     => $quiz_opt4,
               'answer'     => $quiz_ans,
               'status'     => $quiz_status,
               'subject_id'     => $subject_id,
                'explanation' =>$explanation
           );

       if ($this->db->insert('daily_quiz_questions',$data)) {
               return "Inserted";
           } else {
               return "Failed";
           }
   }
   public function delete_qua($id)
      {
          $this->db->where('daily_quiz_questions_id', $id);
          if ($this->db->delete('daily_quiz_questions')) {
              return true;
          } else {
              return false;
          }
      }
      


}
