
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

class All_exam_list_API  extends REST_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('All_exam_model_API');
    }

    //API - users sends id and on valid id users information is sent back
    function examById_get()
    {
        $id = $this->get('id');
        if (!$id) {
            $this->response("No ID specified", 400);
            exit;
        }

        $result = $this->All_exam_model_API->getExamById($id);

        if ($result) {
            $this->response($result, 200);
            exit;
        } else {
            $this->response("Invalid ID", 404);
            exit;
        }
    }


    //API - create a new users item in database.
    function addExam_post()
    {

        $exam_name = $this->post('exam_name');
        $status = $this->post('status');

        if (!$exam_name || !$status) {
            $this->response("Operation failed", 400);
        } else {
            $result = $this->All_exam_model_API->add(array("exam_name" => $exam_name, "status" => $status));
            if ($result === "Failed") {
                $this->response("Operation failed", 404);
            } elseif ($result === "Inserted") {
                $this->response("Success", 200);
            } elseif ($result === "Exists") {
                $this->response("Exists", 200);
            }
        }
    }


    //API - update a user
    function updateExam_put()
    {

        $exam_name = $this->put('exam_name');
        $status = $this->put('status');
        $id = $this->put('exam_id');

        if (!$exam_name || !$status) {
            $this->response("Enter complete user information to save", 400);
        } else {
            $result = $this->All_exam_model_API->update($id, array("exam_name" => $exam_name, "status" => $status));
            if ($result === 0) {
                $this->response("Exam information could not be saved. Try again.", 404);
            } else {
                $this->response("success", 200);
            }
        }
    }

    //API - delete a user
    function deleteExam_delete()
    {
        $id = $this->delete('id');
        if (!$id) {
            $this->response("Parameter missing", 404);
        }
        if ($this->All_exam_model_API->delete($id)) {
            $this->response("Success", 200);
        } else {
            $this->response("Failed", 400);
        }
    }

}
