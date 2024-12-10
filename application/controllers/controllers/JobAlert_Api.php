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

class JobAlert_Api extends REST_controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("JobAlertApi_model");
    }
    
    function postById_get($id1)
    {
        $id = $id1;
        if (!$id) {
            $this->response("No ID specified", 400);
            exit;
        }
        $result = $this->JobAlertApi_model->getbyid($id);
        
        if ($result) {
           $this->response($result, 200);
//            print_r($result);
            exit;
        } else {
            $this->response("Invalid ID", 404);
            exit;
        }
    }
    
    function delete_delete()
    {
        $id = $this->delete('id');
        if (!$id) {
            $this->response("Parameter missing", 404);
        }
        
        if ($this->JobAlertApi_model->delete($id)) {
            $this->response("Success", 200);
        } else {
            $this->response("Failed", 400);
        }
    }
    
    function postById_D_get($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            $this->response("Parameter missing", 404);
        }
        $result = $this->JobAlertApi_model->getPostById_D($id);
        if ($result) {
            $this->response($result, 200);
        } else {
            $this->response("Invalid ID", 400);
        }
        
    }
}
