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

class Feedback extends CI_Controller
{
    //functions
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    function index()
    {
        $data['title'] = ucfirst('All Feedback'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('Feedback/index', $data);
        $this->load->view('Feedback/show_feedback', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('Feedback/jscript', $data);
    }

    function fetch_user()
    {
       $sql="SELECT user_feedback.*, user_login.full_name as full_name, user_login.email as email, user_login.selected_exams as selected_exams FROM user_feedback, user_login WHERE user_feedback.login_id = user_login.login_id ORDER BY user_feedback.id DESC";
       $fetch_data = $this->common_model->executeArray($sql);
       if($fetch_data)
       {
           // print_r($fetch_data);
           foreach($fetch_data as $subject)
           {
               /////////////////////////////////////////////////////////
               if(1)
               {
                   $sub_array = array();
                   if(1)
                   {
                    
                       $sub_array[] = '
                       <button type="button" name="Details" onclick="getFeedbackDetails(this.id)" id="details_' . $subject->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showdought">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Delete" onclick="deleteFeedbackDetails(this.id)" id="delete_' . $subject->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          
';
                    
                       $sub_array[] = $subject->full_name;
                       $sub_array[] = $subject->email;
                       $sub_array[] = $subject->selected_exams;
                       $sub_array[] = $subject->message;
                   }
                   $data[] = $sub_array;
               }
            
               /////////////////////////////////////////////////////////
           }
       }
       
       $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
       echo json_encode($output);
    }

  
    function feedbackById($pid = NULL)
    {
        $return_array=array();
        if($pid!="")
        {
            $sql="SELECT user_feedback.*, user_login.full_name as full_name, user_login.email as email, user_login.selected_exams as selected_exams FROM user_feedback, user_login WHERE user_feedback.login_id = user_login.login_id AND user_feedback.id = '". $pid . "'ORDER BY user_feedback.id DESC";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->id, "full_name"=>$check->full_name, "email"=>$check->email, "selected_exams"=>$check->selected_exams, "message"=>$check->message);
            }
        }
        else
        {
        
        }
        echo json_encode($return_array);
    }
    
    
    public function deleteFeedback($id)
    {
        
            $id=$id;
            $sql="SELECT * FROM user_feedback WHERE id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM user_feedback WHERE id='".$id."'";
                $delete=$this->common_model->executeNonQuery($sql);
                if($delete)
                {
                    echo 'success';
                }
                else
                {
                    echo 'error';
                }
            }
            else
            {
                echo 'error';
            }
            
        
        
    }
}
