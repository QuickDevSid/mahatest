<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Membership_Plans extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Membership_Plans_model");
    }
    //functions
    function index()
    {

        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('membership_plans/index', $data);
        //        $this->load->view('membership_plans/details', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('membership_plans/jscript.php', $data);
    }


    public function add_membership_plans()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Membership_Plans_model->get_single_membership_plans(); //

            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('membership_plans/add_membership_plans', $data);
            $this->load->view('templates/footer1', $data);
            // $this->load->view('courses/jscript.php', $data);
            $this->load->view('membership_plans/membershipscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Courses.");
        } else {
            $res = $this->Membership_Plans_model->set_membership_plans_details();
            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Membership Plans details added successfully!");
                redirect('membership_plans/membership_plans_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Membership Plans entry updated!");
                redirect('membership_plans/membership_plans_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Membership Plans.");
                redirect('membership_plans/membership_plans_list');
            }
        }
    }

    public function membership_plans_list()
    {
        $data['category'] = $this->Membership_Plans_model->get_single_membership_plans_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('membership_plans/membership_plans_list', $data);
        $this->load->view('templates/footer1', $data);
        // $this->load->view('courses/jscript.php', $data);
        $this->load->view('membership_plans/membershiplistscript.php', $data);
    }


    public function delete_membership_plans_list($id)
    {
        $this->Membership_Plans_model->delete_membership_plans_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('membership_plans/membership_plans_list');
    }

    public function status_membership_plans_list_active($id)
    {
        $this->Membership_Plans_model->status_membership_plans_list_active($id);
        // $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('membership_plans/membership_plans_list');
    }

    public function status_membership_plans_list_in_active($id)
    {
        $this->Membership_Plans_model->status_membership_plans_list_in_active($id);
        // $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('membership_plans/membership_plans_list');
    }



    //API - licenses sends id and on valid id licenses information is sent back
    public function add_data()
    {
        if (isset($_POST)) {

            $Title = $this->db->escape_str($_POST['title']);
            $sub_heading = $this->db->escape_str($_POST['sub_heading']);
            $price = $this->db->escape_str($_POST['price']);
            $actual_price = $this->db->escape_str($_POST['actual_price']);
            $discount_per = $this->db->escape_str($_POST['discount_per']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $no_of_months = $this->db->escape_str($_POST['no_of_months']);
            $check = $this->Membership_Plans_model->getDataByWhereCondition(['title' => $Title]);
            if (!$check) {
                $description = str_replace('\r\n', '', $description);

                $actual_price = $price - ($price * $discount_per / 100);
                $data = [
                    'title' => $Title,
                    'sub_heading' => $sub_heading,
                    'price' => $price,
                    'actual_price' => $actual_price,
                    'discount_per' => $discount_per,
                    'status' => $status,
                    'no_of_months' => $no_of_months,
                    'description' => $description
                ];
                $insert = $this->Membership_Plans_model->save($data);
                if ($insert == 'Inserted') {
                    echo "inserted";
                    $art_msg['msg'] = 'New Plan Added.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            } else {
                echo "false";
                die;
                $art_msg['msg'] = 'New Plan already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'membership_plans', 'refresh');
    }


    public function get_membership_section_details()
    {

        $fetch_data = $this->Membership_Plans_model->make_datatables();
        /* echo $this->db->last_query();
        print_r($fetch_data);die; */
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getExamSectionDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getExamSectionDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteExamSectionDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

            $sub_array[] = $row->title;

            $sub_array[] = $row->sub_heading;
            $sub_array[] = $row->price;
            $sub_array[] = $row->actual_price;
            $sub_array[] = $row->discount_per;
            $sub_array[] = $row->no_of_months;
            $sub_array[] = $row->usage_count;
            $sub_array[] = $row->status;
            $sub_array[] = date("d-m-Y H:i:s", strtotime($row->created_at));

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->Membership_Plans_model->get_all_data(), "recordsFiltered" => $this->Membership_Plans_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }
    public function get_single_membership($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->Membership_Plans_model->getPostById($id);

        if ($result) {
            $row = [];
            $row = $result[0];
            $row['created_at'] = date("d-m-Y H:i:s", strtotime($result[0]['created_at']));
            echo json_encode($row);
            exit;
        } else {
            echo "Invalid ID";
            exit;
        }
    }
    public function update_member_data()
    {
        if (isset($_POST)) {

            $id = $this->input->post('id');
            $Title = $this->db->escape_str($_POST['title']);
            $sub_heading = $this->db->escape_str($_POST['sub_heading']);
            $price = $this->db->escape_str($_POST['price']);
            $actual_price = $this->db->escape_str($_POST['actual_price']);
            $discount_per = $this->db->escape_str($_POST['discount_per']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $no_of_months = $this->db->escape_str($_POST['no_of_months']);
            $check = $this->Membership_Plans_model->getDataByWhereCondition(['title' => $Title, 'id !=' => $id]);
            if (!$check) {

                $actual_price = $price - ($price * $discount_per / 100);
                $description = str_replace('\r\n', '', $description);
                $data = [
                    'title' => $Title,
                    'sub_heading' => $sub_heading,
                    'price' => $price,
                    'actual_price' => $actual_price,
                    'discount_per' => $discount_per,
                    'status' => $status,
                    'no_of_months' => $no_of_months,
                    'description' => $description
                ];
                $insert = $this->Membership_Plans_model->update($id, $data);
                if ($insert == 'Updated') {
                    echo "Updated";
                    $art_msg['msg'] = 'New Plan updated.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            } else {
                $art_msg['msg'] = 'New Plan already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'membership_plans', 'refresh');
    }
    public function delete_member_data($id)
    {
        //echo $id;die;
        if (!$id) {
            echo "Parameter missing";
            return false;
        }
        // $result = $this->Membership_Plans_model->checkUserSelectedPlan($id);
        if ($this->Membership_Plans_model->delete($id)) {
            echo "Success";
            return true;
        } else {
            echo "Failed";
            return false;
        }
    }
}
