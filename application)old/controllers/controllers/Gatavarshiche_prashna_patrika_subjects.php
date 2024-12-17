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

class Gatavarshiche_prashna_patrika_subjects extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data['title'] = ucfirst('Exam'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('gatavarshichce_prashna_patrika_subjects/index', $data);
        $this->load->view('gatavarshichce_prashna_patrika_subjects/add',$data);
        $this->load->view('gatavarshichce_prashna_patrika_subjects/edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('gatavarshichce_prashna_patrika_subjects/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $sql="SELECT * FROM gatavarshiche_prashna_subjects ORDER BY gatavarshichya_prashna_patrika_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            foreach($fetch_data as $gatavarshi_prashna_patrika)
            {
                /////////////////////////////////////////////////////////
                if(1)
                {
                    $array=json_decode($gatavarshi_prashna_patrika->selected_exam_id);
                    if (is_array($array))
                    {
                    }
                    else
                    {
                        $array=array();
                        array_push($array, $gatavarshi_prashna_patrika->selected_exam_id);
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
                       <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $gatavarshi_prashna_patrika->gatavarshichya_prashna_patrika_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $gatavarshi_prashna_patrika->gatavarshichya_prashna_patrika_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';
                        $sub_array[] = $gatavarshi_prashna_patrika->exam_name;
                        $sub_array[] = $List;
                        $sub_array[] = $gatavarshi_prashna_patrika->status;
                        $sub_array[] = $gatavarshi_prashna_patrika->created_at;
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

            $sql="SELECT * FROM `gatavarshiche_prashna_subjects` WHERE selected_exam_id='".$exam_Id."' AND exam_name = '".$Title."' ";
            // echo $sql;
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `gatavarshiche_prashna_subjects`(`selected_exam_id`, `exam_name`, `status`, `created_at`) VALUES ('".$exam_Id."', '".$Title."', '".$status."', '".date('Y-m-d H:i:s')."')";
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New Exam updated.';
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
                $art_msg['msg'] = 'New Exam already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Gatavarshiche_prashna_patrika_subjects', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM gatavarshiche_prashna_subjects WHERE gatavarshichya_prashna_patrika_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->gatavarshichya_prashna_patrika_id, "selected_exams_id"=>json_decode($check->selected_exam_id), "title"=>$check->exam_name, "status"=>$check->status);
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


        $sql="UPDATE gatavarshiche_prashna_subjects SET `selected_exam_id`='".$exam_id."', `exam_name`='".$Title."', `status`='".$status."' WHERE gatavarshichya_prashna_patrika_id='".$edit_id."' ";
        // echo $sql;
        // exit(0);
        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Sarav gatavarshichya prashna patrika exam name Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update Exam.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

        redirect(base_url() . 'Gatavarshiche_prashna_patrika_subjects', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM gatavarshiche_prashna_subjects WHERE gatavarshichya_prashna_patrika_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM gatavarshiche_prashna_subjects WHERE gatavarshichya_prashna_patrika_id='".$id."'";
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
