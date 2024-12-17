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

class Sarav_prashnasanch_subjects extends CI_Controller
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
        $this->load->view('sarav_prashnasanch_subjects/index', $data);
        $this->load->view('sarav_prashnasanch_subjects/add',$data);
        $this->load->view('sarav_prashnasanch_subjects/edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('sarav_prashnasanch_subjects/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $sql="SELECT * FROM sarav_prashnasanch_subjects ORDER BY sarav_prashnasanch_subjects_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            // print_r($fetch_data);
            foreach($fetch_data as $sarav_prashnasanch_subjects)
            {
                /////////////////////////////////////////////////////////
                if(1)
                {

                    $array=json_decode($sarav_prashnasanch_subjects->selected_exams_id);
                    if (is_array($array))
                    {
                    }
                    else
                    {
                        $array=array();
                        array_push($array, $sarav_prashnasanch_subjects->selected_exams_id);                
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
                       <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $sarav_prashnasanch_subjects->sarav_prashnasanch_subjects_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $sarav_prashnasanch_subjects->sarav_prashnasanch_subjects_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $sarav_prashnasanch_subjects->subject_name;
                        $sub_array[] = $List;
                        $sub_array[] = $sarav_prashnasanch_subjects->status;
                        $sub_array[] = $sarav_prashnasanch_subjects->created_at;
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
            $Title=$this->db->escape_str($_POST['Title']);
            $exam_Id=$_POST['exam_id'];
            $exam_Id=json_encode($exam_Id);
            $status=$_POST['status'];

            $sql="SELECT * FROM `sarav_prashnasanch_subjects` WHERE subject_name = '".$Title."' ";
            // echo $sql;
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `sarav_prashnasanch_subjects`(`selected_exams_id`, `subject_name`, `status`, `created_at`) VALUES ('".$exam_Id."', '".$Title."', '".$status."', '".date('Y-m-d H:i:s')."')";
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New Sarav prashnasanch subjects updated.';
                    $art_msg['type'] = 'success';
                }
                else
                {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            }
            else
            {
                $art_msg['msg'] = 'New sarav prashnasanch subjects already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Sarav_prashnasanch_subjects', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM sarav_prashnasanch_subjects WHERE sarav_prashnasanch_subjects_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->sarav_prashnasanch_subjects_id, "selected_exams_id"=>json_decode($check->selected_exams_id), "title"=>$check->subject_name, "status"=>$check->status);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    public function update_data()
    {
        $Title=$this->db->escape_str($_POST['Title']);
        $exam_id=$_POST['exam_id'];
        $exam_id=json_encode($exam_id);
        $status=$_POST['status'];
        $edit_id=$_POST['edit_id'];


        $sql="UPDATE sarav_prashnasanch_subjects SET `selected_exams_id`='".$exam_id."', `subject_name`='".$Title."', `status`='".$status."' WHERE sarav_prashnasanch_subjects_id='".$edit_id."' ";
        // echo $sql;
        // exit(0);
        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Sarav prashnasanch subjects Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }
        else
        {
            $art_msg['msg'] = 'Error to update sarav prashnasanch subjects.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }

        redirect(base_url() . 'Sarav_prashnasanch_subjects', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM sarav_prashnasanch_subjects WHERE sarav_prashnasanch_subjects_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM sarav_prashnasanch_subjects WHERE sarav_prashnasanch_subjects_id='".$id."'";
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