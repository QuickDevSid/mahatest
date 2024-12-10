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

class Pariksha_paddhati_abhyaskram_syllabus extends CI_Controller
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
        $this->load->view('pariksha_paddhati_abhyaskram_syllabus/index', $data);
        $this->load->view('pariksha_paddhati_abhyaskram_syllabus/add',$data);
        $this->load->view('pariksha_paddhati_abhyaskram_syllabus/edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('pariksha_paddhati_abhyaskram_syllabus/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $sql="SELECT * FROM pariksha_paddhati_abhyaskram_syllabus ORDER BY exam_syllabus_syllabus_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            // print_r($fetch_data);
            foreach($fetch_data as $pariksha_paddhati_abhyaskram_syllabus)
            {
                /////////////////////////////////////////////////////////
                $sql="SELECT * FROM `pariksha_paddhati_abhyaskram` WHERE pariksha_paddhati_abhyaskram_id=".$pariksha_paddhati_abhyaskram_syllabus->pariksha_paddhati_abhyaskram_id." ";
                $fetch_exam = $this->common_model->executeRow($sql);
                if($fetch_exam)
                {
                    $sub_array = array();
                    if($fetch_exam)
                    {
                   
                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $pariksha_paddhati_abhyaskram_syllabus->exam_syllabus_syllabus_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $pariksha_paddhati_abhyaskram_syllabus->exam_syllabus_syllabus_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $pariksha_paddhati_abhyaskram_syllabus->title;
                        $sub_array[] = $fetch_exam->title;
                        $sub_array[] = $pariksha_paddhati_abhyaskram_syllabus->status;
                        $sub_array[] = $pariksha_paddhati_abhyaskram_syllabus->created_at;
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
            $title=$this->db->escape_str($_POST['Title']);
            $ppa_id=$_POST['ppa_id'];
            $status=$_POST['status'];
            $Description=$this->db->escape_str($_POST['Description']);

            $sql="SELECT * FROM `pariksha_paddhati_abhyaskram_syllabus` WHERE pariksha_paddhati_abhyaskram_id='".$ppa_id."' AND title = '".$title."' ";
            // echo $sql;
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `pariksha_paddhati_abhyaskram_syllabus`(`pariksha_paddhati_abhyaskram_id`, `title`, `status`, `created_at`, `description`) VALUES ('".$ppa_id."', '".$title."', '".$status."', '".date('Y-m-d H:i:s')."', '".$Description."')";
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New pariksha paddhati abhyaskram syllabus updated.';
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
                $art_msg['msg'] = 'New pariksha paddhati abhyaskram syllabus already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Pariksha_paddhati_abhyaskram_syllabus', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM pariksha_paddhati_abhyaskram_syllabus WHERE exam_syllabus_syllabus_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->exam_syllabus_syllabus_id, "ppa_id"=>$check->pariksha_paddhati_abhyaskram_id, "title"=>$check->title, "status"=>$check->status, "description"=>$check->description);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    public function update_data()
    {

            $title=$this->db->escape_str($_POST['Title']);
            $ppa_id=$_POST['ppa_id'];
            $status=$_POST['status'];
            $Description=$this->db->escape_str($_POST['Description']);

        $edit_id=$_POST['edit_id'];


        $sql="UPDATE pariksha_paddhati_abhyaskram_syllabus SET `pariksha_paddhati_abhyaskram_id`='".$ppa_id."', `title`='".$title."', `status`='".$status."', `description`='".$Description."' WHERE exam_syllabus_syllabus_id='".$edit_id."' ";
        // echo $sql;
        // exit(0);
        $update=$this->common_model->executeNonQuery($sql);



        if($update)
        {
            $art_msg['msg'] = 'Pariksha paddhati abhyaskram syllabus Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }
        else
        {
            $art_msg['msg'] = 'Error to update pariksha paddhati abhyaskram syllabus.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }

        redirect(base_url() . 'Pariksha_paddhati_abhyaskram_syllabus', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM pariksha_paddhati_abhyaskram_syllabus WHERE exam_syllabus_syllabus_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM pariksha_paddhati_abhyaskram_syllabus WHERE exam_syllabus_syllabus_id='".$id."'";
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