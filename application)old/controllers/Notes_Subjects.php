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

class Notes_Subjects extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data['title'] = ucfirst('Notes Subjects'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('notes/subject_index', $data);
        $this->load->view('notes/subject_add',$data);
        $this->load->view('notes/subject_edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('notes/subject-jscript.php', $data);
        
    }

    function fetch_data()
    {

        $sql="SELECT * FROM notes_subject ORDER BY notes_subject_id   DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            foreach($fetch_data as $yashogatha)
            {
                /////////////////////////////////////////////////////////
                if(1)
                {
                    $sub_array = array();
                    if(1)
                    {
                   
                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getSubjectsDetailsEdit(this.id)" id="edit_' . $yashogatha->notes_subject_id   . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_subject" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $yashogatha->notes_subject_id   . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $yashogatha->subject_name;
                        $sub_array[] = $yashogatha->status;
                        $sub_array[] = $yashogatha->created_at;
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
        
        $Title=$this->db->escape_str($_POST['SubjectTitle']);
        $Status=$_POST['subject_status'];
        
    
        if($Title!="" && $Status!="")
        {
            $sql="SELECT * FROM notes_subject WHERE subject_name like '%".$Title."%'";
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `notes_subject`(`subject_name`, `status`, `created_at`) VALUES ('".$Title."', '".$Status."', '".date('Y-m-d H:i:s')."')";
//                echo $sql;
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New Notes updated Updated.';
                    $art_msg['type'] = 'success';
                }
                else
                {
                    $art_msg['msg'] = 'Error to add new Masike.';
                    $art_msg['type'] = 'error';
                }
            }
            else
            {
                $art_msg['msg'] = 'Repeat Notes.';
                $art_msg['type'] = 'error';
            }
        
        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';
        
        }
    
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Notes_Subjects', 'refresh');
    
    }


    public function update_data()
    {
        $Title=$this->db->escape_str($_POST['edit_subject_name']);
        $Status=$_POST['edit_status'];
        $edit_id=$_POST['edit_id'];
    
        $sql="SELECT * FROM notes_subject WHERE notes_subject_id  ='".$edit_id."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            
            $sql="UPDATE notes_subject SET `subject_name`='".$Title."', `status`='".$Status."' WHERE notes_subject_id='".$edit_id."' ";
            // echo $sql;exit(0);
            $insert=$this->common_model->executeNonQuery($sql);
            if($insert)
            {
                $art_msg['msg'] = 'Notes Updated.';
                $art_msg['type'] = 'success';
            }
            else
            {
                $art_msg['msg'] = 'Error to update Notes.';
                $art_msg['type'] = 'error';
            }
        
        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';
        
        }
    
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Notes_Subjects', 'refresh');
    
    }
    
    function delete_data()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM notes_subject WHERE notes_subject_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM notes_subject WHERE notes_subject_id='".$id."'";
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
    
    public function subjectById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM notes_subject WHERE notes_subject_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
               
                $return_array=array("notes_subject_id"=>$check->notes_subject_id  , "subject_name"=>$check->subject_name, "title"=>$check->status);
            }
        }
        else
        {
        
        }
        echo json_encode($return_array);
    }
    
}
?>
