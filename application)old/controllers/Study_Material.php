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

class Study_Material extends CI_Controller
{
    //functions
    function index()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('Study/index', $data);
        $this->load->view('Study/add_study', $data);
        $this->load->view('Study/show_study', $data);
        $this->load->view('Study/edit_material', $data);
        $this->load->view('Study/add_study_content_quiz', $data);
        //add_study_content_quiz
        $this->load->view('templates/footer1', $data);
        $this->load->view('Study/jscript.php', $data);
    }
    
    function fetch_user()
    {
        $this->load->model("Study_Material_Model");
        $fetch_data = $this->Study_Material_Model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            
            $sub_array[] = '<button type="button" name="Details" onclick="getstudyDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showstudy">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getStudyEdit(this.id)" id="client_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_exam" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteStudyDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          <button type="button" name="Add" onclick="addContentDetails(this.id)" id="Add_' . $row->id . '" data-type="confirm" class="btn bg-green waves-effect btn-xs" data-toggle="modal" data-target="#addstudycontent">
       <i class="material-icons">add</i></button>
          ';
            
            $sub_array[] = $row->Title;
            $sub_array[] = $row->status;
            $sub_array[] = $row->created_at;
            
            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->Study_Material_Model->get_all_data(), "recordsFiltered" => $this->Study_Material_Model->get_filtered_data(), "data" => $data);
        echo json_encode($output);
    }
    
    //API - licenses sends id and on valid id licenses information is sent back editbyId
    
    function StudyById($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("Study_Material_Model_Api");
        $result = $this->Study_Material_Model_Api->getStudyById($id);
        if ($result) {
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
        
    }
    
    //this code for fetch recored in table format in add section table
    function fetch_qua_ans($cid = NULL)
    {
        $id = $cid;
        $this->load->model("Study_Material_Model");
        $fetch_data = $this->Study_Material_Model->make_datatables_qua($id);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '

          <button type="button" name="Delete" onclick="deletcontentDetails(this.id,this.value)" value="' . $row->material_id . '"  id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>

          ';
            $sub_array[] = $row->title;
            
            $sub_array[] = $row->quiz_title;
            $sub_array[] = $row->total_questions;
            $sub_array[] = $row->total_time;
            
            $sub_array[] = $row->st;
            
            
            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->Study_Material_Model->get_all_data_qua($id), "recordsFiltered" => $this->Study_Material_Model->get_filtered_data_qua($id), "data" => $data);
        echo json_encode($output);
    }
    
    
}
