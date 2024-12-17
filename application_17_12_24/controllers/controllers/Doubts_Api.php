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

class Doubts_Api extends REST_controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Doubts_model_Api");
    }
    
    //fetch recored for show
    function doughtById_get($id1)
    {
        $id = $id1;
        if (!$id) {
            $this->response("No ID specified", 400);
            exit;
        }
        $result = $this->Doubts_model_Api->getdoughtbyid($id);
        
        if ($result) {
            $this->response($result, 200);
            exit;
        } else {
            $this->response("Invalid ID", 404);
            exit;
        }
    }
    
    function deletedought_delete()
    {
        $id = $this->delete('id');
        if (!$id) {
            $this->response("Parameter missing", 404);
        }
        
        if ($this->Doubts_model_Api->delete($id)) {
            $this->response("Success", 200);
        } else {
            $this->response("Failed", 400);
        }
    }
    
    
}
