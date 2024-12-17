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

class User_API extends REST_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UsersAPI_model');
    }

    //API - users sends id and on valid id users information is sent back
    function userById_get()
    {
        $id = $this->get('id');
        if (!$id) {
            $this->response("No ID specified", 400);
            exit;
        }

        $result = $this->UsersAPI_model->getuserbyid($id);

        if ($result) {
            $this->response($result, 200);
            exit;
        } else {
            $this->response("Invalid ID", 404);
            exit;
        }
    }

    //API -  Fetch All user
    function users_get()
    {
        $result = $this->UsersAPI_model->getallusers();
        if ($result) {
            $this->response($result, 200);
        } else {
            $this->response("No record found", 404);
        }
    }
    
    //API - create a new users item in database.
    function addUser_post()
    {

        $name = $this->post('name');
        $mobile = $this->post('mobile');
        $email = $this->post('email');
        $password = $this->post('password');
        $type = $this->post('type');
        $status = $this->post('status');

        if (!$name || !$mobile || !$email || !$password || !$type || !$status) {
            $this->response("Operation failed", 400);
        } else {
            $result = $this->UsersAPI_model->add(array("name" => $name, "mobile" => $mobile, "email" => $email, "password" => $password, "type" => $type, "status" => $status));
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
    function updateUser_put()
    {

        $name = $this->put('name');
        $mobile = $this->put('mobile');
        $email = $this->put('email');
        $password = $this->put('password');
        $type = $this->put('type');
        $status = $this->put('status');
        $id = $this->put('id');

        if (!$name || !$mobile || !$email || !$password || !$type || !$status) {
            $this->response("Enter complete user information to save", 400);
        } else {
            $result = $this->UsersAPI_model->update($id, array("name" => $name, "mobile" => $mobile, "email" => $email, "password" => $password, "type" => $type, "status" => $status));
            if ($result === 0) {
                $this->response("User information could not be saved. Try again.", 404);
            } else {
                $this->response("success", 200);
            }
        }
    }

    //API - delete a user
    function deleteUser_delete()
    {
        $id = $this->delete('id');
        if (!$id) {
            $this->response("Parameter missing", 404);
        }
        if ($this->UsersAPI_model->delete($id)) {
            $this->response("Success", 200);
        } else {
            $this->response("Failed", 400);
        }
    }

}
