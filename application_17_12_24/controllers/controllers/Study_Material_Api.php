
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

class Study_Material_API extends REST_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Study_Material_Model_Api");
    }
    //add study
    function addStudy_post()
    {
        $study_name= $this->post('study_name');
        $study_status = $this->post('study_status');
        $CreatedOn = $this->post('CreatedOn');

        $result = $this->Study_Material_Model_Api->add(array(
          "study_material_title" => $study_name,
        "status" => $study_status,
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
    //fetch recored for edit
   function studyById_get()
  {
      $id = $this->get('id');
      if (!$id) {
          $this->response("No ID specified", 400);
          exit;
      }
      $result = $this->Study_Material_Model_Api->geteditstudybyid($id);

      if ($result) {
          $this->response($result, 200);
          exit;
      } else {
          $this->response("Invalid ID", 404);
          exit;
      }
  }
  function update_studyById_put()
  {

      $id = $this->put('u_exam_id');
      $u_exam_name = $this->put('u_exam_name');
      $u_status = $this->put('u_status');
      $u_created_at = $this->put('u_created_at');

      $result = $this->Study_Material_Model_Api->update($id, array("study_material_title" => $u_exam_name, "status" => $u_status,"created_at" => $u_created_at));

      if ($result === 0) {
          $this->response("Client information could not be saved. Try again.", 404);
      } else {
          $this->response("success", 200);
      }

  }
  function deleteStudy_delete()
  {
      $id = $this->delete('id');
      if (!$id) {
          $this->response("Parameter missing", 404);
      }

      if ($this->Study_Material_Model_Api->delete($id)) {
          $this->response("Success", 200);
      } else {
          $this->response("Failed", 400);
      }
  }
  function add_content_post()
    {
      $content_id= $this->input->post('content_id');
      $study_quiz_title= $this->input->post('study_quiz_title');
      $study_total_qua= $this->input->post('study_total_qua');
      $study_total_time= $this->input->post('study_total_time');
      $study_content_status= $this->input->post('study_content_status');




      $result= $this->Study_Material_Model_Api->add_study_content($content_id,$study_quiz_title,$study_total_qua,$study_total_time,$study_content_status);
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
   //delete code
   function deletecontent_delete()
  {
  $id = $this->delete('id');
  if (!$id) {
  $this->response("Parameter missing", 404);
  }

  if ($this->Study_Material_Model_Api->delete_content($id)) {
  $this->response("Success", 200);
  } else {
  $this->response("Failed", 400);
  }
  }




}
