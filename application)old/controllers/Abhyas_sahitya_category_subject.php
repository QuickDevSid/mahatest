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

class Abhyas_sahitya_category_subject extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data['title'] = ucfirst('Masik'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_category_subject', $data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_category_subject_add',$data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_category_subject_edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_category_subject_jscript.php', $data);
        
    }

    function fetch_abhyas_sahitya_category_subject()
    {

        $data=array();
        $sql="SELECT * FROM abhyas_sahitya_category_subject ORDER BY abhyas_sahitya_category_subject_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            foreach($fetch_data as $abhyas_sahitya_category_subject_data)
            {
                /////////////////////////////////////////////////////////
                $sql="SELECT * FROM `abhyas_sahitya_category` WHERE abhyas_sahitya_category_id=".$abhyas_sahitya_category_subject_data->abhyas_sahitya_category_id." ORDER BY abhyas_sahitya_category_id DESC";
                $fetch_cat = $this->common_model->executeRow($sql);
                if($fetch_cat)
                {
                    $sub_array = array();
                    if($fetch_cat)
                    {
                   
                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getcategoryDetailsEdit(this.id)" id="edit_' . $abhyas_sahitya_category_subject_data->abhyas_sahitya_category_subject_id. '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_post" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $abhyas_sahitya_category_subject_data->abhyas_sahitya_category_subject_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $abhyas_sahitya_category_subject_data->subject_name;
                        $sub_array[] = $fetch_cat->category_name;
                        $sub_array[] = $abhyas_sahitya_category_subject_data->status;
                        $sub_array[] = $abhyas_sahitya_category_subject_data->created_at;
                   }            
                    $data[] = $sub_array;
                }

                /////////////////////////////////////////////////////////
            }
        }        


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);          
    }
    function add_data()
    {
        if(isset($_POST))
        {
            $CategorySubjectTitle=$this->db->escape_str($_POST['CategorySubjectTitle']);
            $CategoryId=$_POST['CategoryId'];
            $category_status=$_POST['category_status'];

            $sql="SELECT * FROM `abhyas_sahitya_category_subject` WHERE abhyas_sahitya_category_id='".$CategoryId."' AND subject_name = '".$CategorySubjectTitle."' ";
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `abhyas_sahitya_category_subject`(`abhyas_sahitya_category_id`, `subject_name`, `status`) VALUES ('".$CategoryId."', '".$CategorySubjectTitle."', '".$category_status."')";
                $this->common_model->executeNonQuery($sql);
            }
        }

        $art_msg['msg'] = 'New Abhyas Sahitya Category Subject Updated.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Abhyas_sahitya_category_subject', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM abhyas_sahitya_category_subject WHERE abhyas_sahitya_category_subject_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $exam_id="";
                $sql="SELECT * FROM `abhyas_sahitya_category` WHERE abhyas_sahitya_category_id='".$check->abhyas_sahitya_category_id."' ";
                $exam=$this->common_model->executeRow($sql);
                if($exam)
                {
                    $exam_id=json_decode($exam->selected_exams_id);
                }
                
                $return_array=array("selected_exams_id"=>$exam_id,"abhyas_sahitya_category_subject_id"=>$check->abhyas_sahitya_category_subject_id, "abhyas_sahitya_category_id"=>$check->abhyas_sahitya_category_id, "subject_name"=>$check->subject_name, "status"=>$check->status);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    public function update_data()
    {
        $CategoryTitle=$this->db->escape_str($_POST['edit_CategoryTitle']);

        $CategorySubjectTitle=$this->db->escape_str($_POST['edit_CategorySubjectTitle']);
        $CategoryId=$_POST['edit_CategoryId'];
        $category_status=$_POST['edit_category_status'];
        $edit_id=$_POST['edit_id'];



        $sql="UPDATE abhyas_sahitya_category_subject SET `abhyas_sahitya_category_id`='".$CategoryId."', `subject_name`='".$CategorySubjectTitle."', `status`='".$category_status."' WHERE abhyas_sahitya_category_subject_id='".$edit_id."' ";
//        echo $sql;
        $update=$this->common_model->executeNonQuery($sql);

        if($update)
        {
            $art_msg['msg'] = 'Abhyas Sahitya Category Subject Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }
        else
        {
            $art_msg['msg'] = 'Error to update Abhyas Sahitya Category Subject.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }

       redirect(base_url() . 'Abhyas_sahitya_category_subject', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM abhyas_sahitya_category_subject WHERE abhyas_sahitya_category_subject_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM abhyas_sahitya_category_subject WHERE abhyas_sahitya_category_subject_id='".$id."'";
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
    public function get_select()
    {
        $response_array=array();
        $data_array=array();

        if(isset($_POST['id']))
        {
            $id=$_POST['id'];
            $sql="SELECT * FROM `abhyas_sahitya_category` WHERE JSON_CONTAINS(selected_exams_id, '[\"".$id."\"]') ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $response_array[]=array("id"=>$value->abhyas_sahitya_category_id, "name"=>$value->category_name);
                }
            }
        }
        echo json_encode($response_array);        
    }

}
?>