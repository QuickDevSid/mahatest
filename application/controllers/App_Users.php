<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class App_Users extends CI_Controller
{
    //functions
    function index()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('app_users/index', $data);
        $this->load->view('app_users/details', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('app_users/jscript.php', $data);
    }

    function fetch_user()
    {
        $this->load->model("AppUsers_model");
        $fetch_data = $this->AppUsers_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getUserDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#UserDetailModel">
          <i class="material-icons">visibility</i></button>
           <button type="button" name="Delete" onclick="deleteUserDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
            <i class="material-icons">delete</i></button>';
            $sub_array[] = $row->Name;
            $sub_array[] = $row->Email_ID;
            $sub_array[] = $row->Gender;
            $sub_array[] = $row->mobile_number;
            $sub_array[] = $row->selected_exams;
            $sub_array[] = $row->place;
            $sub_array[] = $row->Status;
            $sub_array[] = $row->Added_On;

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->AppUsers_model->get_all_data(), "recordsFiltered" => $this->AppUsers_model->get_filtered_data(), "data" => $data);
        echo json_encode($output);
    }

    //API - licenses sends id and on valid id licenses information is sent back
    function userById($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("AppUsers_model");
        $result = $this->AppUsers_model->getAppUserById($id);
        if ($result) {
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }

    }
}
