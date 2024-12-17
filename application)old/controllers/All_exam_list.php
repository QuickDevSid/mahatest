
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

class All_exam_list extends CI_Controller
{
    //functions
    function index()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('Exam/index', $data);
        $this->load->view('Exam/show_exam', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('Exam/jscript', $data);
    }

    function fetch_user()
    {
        $this->load->model("All_exam_model");
        $fetch_data = $this->All_exam_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Edit" onclick="getFormDetails(this.id)" id="user_' . $row->id . '" class="btn bg-blue waves-effect btn-xs" data-toggle="modal" data-target="#editExamDetails">
           <i class="material-icons">settings</i></button>
       		<button type="button" name="Delete" onclick="deleteExamDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
           <i class="material-icons">delete</i></button>
       		<button type="button" name="Details" onclick="getExamDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#getExamDetails">
            <i class="material-icons">visibility</i> </button>';
            $sub_array[] = $row->Title;
            $sub_array[] = $row->status;
            $sub_array[] = $row->created_at;

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->All_exam_model->get_all_data(), "recordsFiltered" => $this->All_exam_model->get_filtered_data(), "data" => $data);
        echo json_encode($output);
    }

    //API - licenses sends id and on valid id licenses information is sent back editbyId

    function ExamById($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("All_exam_model_API");
        $result = $this->All_exam_model_API->getExamById($id);
        if ($result) {
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }

    }


}
