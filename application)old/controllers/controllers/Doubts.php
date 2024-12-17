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

class Doubts extends CI_Controller
{
    //functions
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    function index()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('Doubts/index', $data);
        $this->load->view('Doubts/show_dought', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('Doubts/jscript', $data);
    }

    function fetch_user()
   {
       $this->load->model("Doubts_models");
       $fetch_data = $this->Doubts_models->make_datatables();
       $data = array();
       foreach ($fetch_data as $row) {
           $sub_array = array();

           $sub_array[] = '<button type="button" name="Details" onclick="getdoughtDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showdought">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Delete" onclick="deletedoughtDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

          $sub_array[] = $row->user_id;
          $sub_array[] = $row->doubt_question	;

          if($row->status=='Active')
          {
            $status='<a href="#" class="btn btn-primary" onclick="return change_status('.$row->id.', \'Deactive\')">Active</a>';
          }
          else
          {
            $status='<a href="#" class="btn btn-danger" onclick="return change_status('.$row->id.', \'Active\')">Deactive</a>';
          }
          $sub_array[] = $status;
          
           $data[] = $sub_array;
       }
       $output = array("recordsTotal" => $this->Doubts_models->get_all_data(), "recordsFiltered" => $this->Doubts_models->get_filtered_data(), "data" => $data);
       echo json_encode($output);
   }

   public function updateStatus()
   {
      $id=$_POST['id'];
      $status=$_POST['status'];

      $sql="SELECT * FROM `doubts` WHERE doubt_id='".$id."'";
      $check=$this->common_model->executeRow($sql);
      if($check)
      {
        $sql="UPDATE `doubts` SET status='".$status."' WHERE doubt_id='".$id."'";
        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
          echo "Success";
        }
        else
        {
          echo "Something wrong";
        }
      }
      else
      {
        echo "Something wrong";
      }
   }
    
    
    public function add_data()
    {
        if(isset($_POST))
        {
            $Title=$this->db->escape_str($_POST['message']);
            $Id=$this->db->escape_str($_POST['id']);
            
            $status = 'Active';
            $comment_status = 'Approved';
            $created_at = date('Y-m-d H:i:s');
            $date = date('Y-m-d');
            $time = date('H:i:s');
            
                $sql="INSERT INTO `doubts_comment`( `doubt_id`, `login_id`, `comment_body`,`status`, `comment_status`, `date`, `time`, `created_at`) VALUES (".$Id.", 1 , '".$Title."', '".$status."', '".$comment_status."','".$date."','".$time."','".$created_at."')";
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New Comment Added.';
                    $art_msg['type'] = 'success';
                }
                else
                {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        
        redirect(base_url() . 'Doubts', 'refresh');
        
    }
    
    
    function commentById($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("Doubts_models");
        $result = $this->Doubts_models->getPostComment($id);
        if ($result) {
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
        
    }
    
    public function updateStatusComment()
    {
        $id=$_POST['id'];
        $status=$_POST['status'];
        
        $sql="SELECT * FROM `doubts_comment` WHERE doubts_comment_id ='".$id."'";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            $sql="UPDATE `doubts_comment` SET status='".$status."', comment_status='".$status."' WHERE doubts_comment_id ='".$id."'";
            $update=$this->common_model->executeNonQuery($sql);
            if($update)
            {
                echo "Success";
            }
            else
            {
                echo "Something wrong";
            }
        }
        else
        {
            echo "Something wrong";
        }
    }
}
