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

class Gatavarshichya_prashna_patrika_year_practice extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data['title'] = ucfirst('Subject'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('gatavarshichya_prashna_patrika_year_practice/index', $data);
        $this->load->view('gatavarshichya_prashna_patrika_year_practice/add',$data);
        $this->load->view('gatavarshichya_prashna_patrika_year_practice/edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('gatavarshichya_prashna_patrika_year_practice/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $sql="SELECT year_id, question_paper_year, status, created_at, (SELECT gatavarshiche_prashna_subjects.exam_name AS question_paper_id FROM gatavarshiche_prashna_subjects WHERE gatavarshiche_prashna_subjects.gatavarshichya_prashna_patrika_id  = practice_test_year.question_paper_id) AS question_paper_id FROM practice_test_year ORDER BY year_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            foreach($fetch_data as $gatavarshi_prashna_patrika)
            {
               
                    $sub_array = array();
          
                   
                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $gatavarshi_prashna_patrika->year_id   . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $gatavarshi_prashna_patrika->year_id   . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $gatavarshi_prashna_patrika->question_paper_year;
                        $sub_array[] = $gatavarshi_prashna_patrika->question_paper_id;
                        $sub_array[] = $gatavarshi_prashna_patrika->status;
                        $sub_array[] = $gatavarshi_prashna_patrika->created_at;
                        
                    $data[] = $sub_array;
               
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
            $question_paper_id=$_POST['question_paper_id'];
            $question_paper_year=$_POST['question_paper_year'];
            $status=$_POST['status'];

            $sql="SELECT * FROM `practice_test_year` WHERE question_paper_id='".$question_paper_id."' AND question_paper_year = '".$question_paper_year."' ";
            // echo $sql;
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `practice_test_year`(`question_paper_id`, `question_paper_year`, `status`, `created_at`) VALUES ('".$question_paper_id."', '".$question_paper_year."', '".$status."', '".date('Y-m-d H:i:s')."')";
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New Subject added.';
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
                $art_msg['msg'] = 'Subject already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Gatavarshichya_prashna_patrika_year_practice', 'refresh');

    }
    
    public function get_select()
    {
        $response_array=array();
        $data_array=array();
        
        if(isset($_POST['id']))
        {
            $id=$_POST['id'];
            // $sql="SELECT * FROM `abhyas_sahitya_category` WHERE selected_exams_id='".$id."' ";
            
            $sql="SELECT * FROM `gatavarshiche_prashna_subjects` WHERE JSON_CONTAINS(selected_exam_id, '[\"".$id."\"]') AND status = 'Active' ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $response_array[]=array("id"=>$value->gatavarshichya_prashna_patrika_id , "name"=>$value->exam_name);
                }
            }
        }
        echo json_encode($response_array);
    }
    
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM practice_test_year WHERE year_id ='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->year_id , "question_paper_id"=>$check->question_paper_id, "question_paper_year"=>$check->question_paper_year, "status"=>$check->status);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    public function update_data()
    {
        $edit_question_paper_year=$this->db->escape_str($_POST['edit_question_paper_year']);
        $edit_question_paper_id=$_POST['edit_question_paper_id'];
        $edit_status=$_POST['edit_status'];
        $edit_id=$_POST['edit_id'];
        
        $sql="UPDATE practice_test_year SET `question_paper_year`='".$edit_question_paper_year."', `question_paper_id`='".$edit_question_paper_id."', `status`='".$edit_status."' WHERE year_id ='".$edit_id."' ";
       
        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Subject Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update Subject.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

        redirect(base_url() . 'Gatavarshichya_prashna_patrika_year_practice', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM practice_test_year WHERE year_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM practice_test_year WHERE year_id='".$id."'";
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
