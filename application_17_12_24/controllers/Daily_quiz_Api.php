
<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

require(APPPATH . '/libraries/REST_controller.php');

use Restserver\Libraries\REST_controller;

class Daily_quiz_Api  extends REST_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Daily_quiz_model_Api");
        $this->load->model("common_model"); //custome data insert, update, delete library
    }
    //add study
    function addQuiz_post()
    {
        $quiz_title= $this->post('quiz_title');
        $quiz_qua= $this->post('quiz_qua');
        $quiz_duration= $this->post('quiz_duration');
        $quiz_status = $this->post('quiz_status');
        $CreatedOn = $this->post('CreatedOn');

        $result = $this->Daily_quiz_model_Api->add(array(
        "quiz_title" => $quiz_title,
        "quiz_questions" => $quiz_qua,
        "quiz_duration" => $quiz_duration,
        "status" => $quiz_status,
        "created_at" => $CreatedOn
        ));

        if ($result === "Failed") {
            $this->response("Operation failed", 404);
        } elseif ($result === "Inserted") {
            $this->response("Success", 200);
        } elseif ($result === "Exists") {
            $this->response("Exists", 200);
        }
    }

   function QuizById_get($id1)
          {
                $id =$id1;
                if (!$id) {
                $this->response("No ID specified", 400);
                exit;
                }
                $result = $this->Daily_quiz_model_Api->getQuizById($id);

                if ($result) {
                $this->response($result, 200);
                exit;
                } else {
                $this->response("Invalid ID", 404);
                exit;
                }
          }
          function Quizbyadd_post()
         {

             $id = $this->post('e_quiz_id');
             $e_quiz_title = $this->post('e_quiz_title');
             $e_quiz_questions = $this->post('e_quiz_questions');
             $e_quiz_duration = $this->post('e_quiz_duration');
             $e_status = $this->post('e_status');
             $e_created_at = $this->post('e_created_at');

             $result = $this->Daily_quiz_model_Api->update_upload($id, array("quiz_title" => $e_quiz_title,"quiz_questions" => $e_quiz_questions,"quiz_duration" => $e_quiz_duration,
              "status" => $e_status,"created_at" => $e_created_at));

             if ($result === 0) {
                 $this->response("Client information could not be saved. Try again.", 404);
             } else {
                 $this->response("success", 200);
             }

         }
         function deletequiz_delete()
 {
     $id = $this->delete('id');
     if (!$id) {
         $this->response("Parameter missing", 404);
     }

     if ($this->Daily_quiz_model_Api->delete($id)) {
         $this->response("Success", 200);
     } else {
         $this->response("Failed", 400);
     }
 }
 //this code for add quation
 function addquation_post()
   {
     $quiz_id= $this->input->post('quiz_id');
     $quiz_quation= $this->input->post('quiz_quation');
     $quiz_opt1= $this->input->post('quiz_opt1');
     $quiz_opt2= $this->input->post('quiz_opt2');
     $quiz_opt3= $this->input->post('quiz_opt3');
     $quiz_opt4= $this->input->post('quiz_opt4');
     $quiz_status= $this->input->post('quiz_status');
     $subject_id= $this->input->post('subject_id');
     $explanation= ($this->input->post('explanation'));
     $quiz_ans= $this->input->post('quiz_ans');
     $edit_id= $this->input->post('edit_id');

      if($edit_id==0)
      {
         $result= $this->Daily_quiz_model_Api->add_qua_qua($quiz_id,$quiz_quation,$quiz_opt1,$quiz_opt2,$quiz_opt3,$quiz_opt4,$quiz_status,$quiz_ans, $subject_id, $explanation);
         if ($result === "Failed")
          {
            $this->response("Operation failed", 404);
          }
         elseif ($result === "Inserted")
          {
            $this->response("Success", 200);
          }
           elseif ($result === "Exists")
         {
           $this->response("Exists", 200);
         }
      }
      else
      {
        $sql="UPDATE daily_quiz_questions SET `question`='".$quiz_quation."', `option1`='".$quiz_opt1."', `option2`='".$quiz_opt2."', `option3`='".$quiz_opt3."', `option4`='".$quiz_opt4."', `answer`='".$quiz_ans."', `explanation`='', `status`='".$quiz_status."', `subject_id`='".$subject_id."' WHERE daily_quiz_questions_id='".$edit_id."' ";

            $insert=$this->common_model->executeNonQuery($sql);
            if($insert)
            {
              echo "Success";
            }
            else
            {
              echo "Operation failed";
            }        
      }

  }
  function deletequizqua_delete()
  {
  $id = $this->delete('id');
  if (!$id) {
  $this->response("Parameter missing", 404);
  }

  if ($this->Daily_quiz_model_Api->delete_qua($id)) {
  $this->response("Success", 200);
  } else {
  $this->response("Failed", 400);
  }
  }




}
