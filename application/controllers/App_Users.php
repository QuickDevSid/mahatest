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
    public function app_users_details(){        
        $data['title'] = ucfirst('App User Devices Details');
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('app_users/app_user_details', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('app_users/jscript_device.php', $data);
	}

    function fetch_user()
    {
        $this->load->model("AppUsers_model");
        $fetch_data = $this->AppUsers_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $membership_details_text = '-';
            if($row->is_active_membership == '1'){
                $membership_details = $this->AppUsers_model->check_membership($row->id,$row->my_membership_id);
                if(!empty($membership_details)){
                    $membership_details_text = $membership_details->membership_title . '<br>Period: ' . date('d-m-Y',strtotime($membership_details->start_date)) . ' to ' . date('d-m-Y',strtotime($membership_details->end_date)) . '<br>Purchased On: ' . date('d-m-Y h:i A',strtotime($membership_details->created_at));
                }
            }
            // <button type="button" name="Details" onclick="getUserDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#UserDetailModel">
            // <i class="material-icons">visibility</i></button>
            $sub_array[] = '<a type="button" title="All Payments" name="Payments" href="'.base_url().'all_payments?user_id='.$row->id.'" id="payments_' . $row->id . '" class="btn bg-blue waves-effect btn-xs">
                                <i class="material-icons">money</i>
                            </a>
                            <a type="button" title="All Contents" name="Payments" href="'.base_url().'all_bought_contents?user_id='.$row->id.'" id="payments_' . $row->id . '" style="background-color:#3c4856 !important;" class="btn bg-blue waves-effect btn-xs">
                                <i class="material-icons">description</i>
                            </a>
            <button type="button" name="Delete" onclick="deleteUserDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                <i class="material-icons">delete</i>
            </button>';
            $sub_array[] = $membership_details_text;
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
