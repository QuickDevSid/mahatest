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

class Abhyas_sahitya_category extends CI_Controller
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
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_category', $data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_category_add',$data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_category_edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_category_jscript.php', $data);
        
    }

    function fetch_abhyas_sahitya_category()
    {

        $sql="SELECT * FROM abhyas_sahitya_category ORDER BY abhyas_sahitya_category_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            // print_r($fetch_data);
            foreach($fetch_data as $abhyas_sahitya_category)
            {
                /////////////////////////////////////////////////////////
                if(1)
                {
                    $array=json_decode($abhyas_sahitya_category->selected_exams_id);
                    if (is_array($array))
                    {
                    }
                    else
                    {
                        $array=array();
                        array_push($array, $abhyas_sahitya_category->selected_exams_id);                
                    }            
                    $exam_name=array();
                    for($i=0; $i<sizeof($array);$i++)
                    {
                       $sql="SELECT * FROM exams WHERE exam_id='".$array[$i]."' ";
                       $exam=$this->common_model->executeRow($sql);  
                       $exam_name[]=$exam->exam_name;              
                    }
                    $List = implode(', ', $exam_name);

                    $sub_array = array();
                    if(1)
                    {
                   

                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getcategoryDetailsEdit(this.id)" id="edit_' . $abhyas_sahitya_category->abhyas_sahitya_category_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_post" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $abhyas_sahitya_category->abhyas_sahitya_category_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $abhyas_sahitya_category->category_name;
                        $sub_array[] = $List;
                        $sub_array[] = $abhyas_sahitya_category->status;
                        $sub_array[] = $abhyas_sahitya_category->created_at;
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
            $CategoryTitle=$this->db->escape_str($_POST['CategoryTitle']);
            $Exam_Id=$_POST['Exam_Id'];
            $Exam_Id=json_encode($Exam_Id);


            $category_status=$_POST['category_status'];

            $sql="SELECT * FROM `abhyas_sahitya_category` WHERE selected_exams_id='".$Exam_Id."' AND category_name = '".$CategoryTitle."' ";
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `abhyas_sahitya_category`(`selected_exams_id`, `category_name`, `status`) VALUES ('".$Exam_Id."', '".$CategoryTitle."', '".$category_status."')";
                $this->common_model->executeNonQuery($sql);
            }
        }

        $art_msg['msg'] = 'New Abhyas Sahitya Category Updated.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Abhyas_sahitya_category', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM abhyas_sahitya_category WHERE abhyas_sahitya_category_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("abhyas_sahitya_category_id"=>$check->abhyas_sahitya_category_id, "selected_exams_id"=>json_decode($check->selected_exams_id), "category_name"=>$check->category_name, "status"=>$check->status);
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
        $Exam_Id=$_POST['edit_Exam_Id'];
        $Exam_Id=json_encode($Exam_Id);
        $category_status=$_POST['edit_category_status'];
        $edit_id=$_POST['edit_id'];


        $sql="UPDATE abhyas_sahitya_category SET `selected_exams_id`='".$Exam_Id."', `category_name`='".$CategoryTitle."', `status`='".$category_status."' WHERE abhyas_sahitya_category_id='".$edit_id."' ";
        $update=$this->common_model->executeNonQuery($sql);

        if($update)
        {
            $art_msg['msg'] = 'Abhyas Sahitya Category Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }
        else
        {
            $art_msg['msg'] = 'Error to update Abhyas Sahitya Category.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }

        redirect(base_url() . 'Abhyas_sahitya_category', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM abhyas_sahitya_category WHERE abhyas_sahitya_category_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM abhyas_sahitya_category WHERE abhyas_sahitya_category_id='".$id."'";
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
}
?>