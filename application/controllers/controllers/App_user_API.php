
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

class App_user_API extends REST_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("AppUsers_API_model");
    }
    
     //delete data form sql
     function deleteUser_delete()
    {
        $id = $this->delete('id');
        if (!$id) {
            $this->response("Parameter missing", 404);
        }

        if ($this->AppUsers_API_model->delete($id)) {
            $this->response("Success", 200);
        } else {
            $this->response("Failed", 400);
        }
    }
    
}
