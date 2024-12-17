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

class AppHelp extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data['title'] = ucfirst('AppHelp'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('app_help/index', $data);
        $this->load->view('app_help/edit', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('app_help/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $sql="SELECT * FROM app_help ORDER BY id DESC";
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
                       <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $subject->id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                       <i class="material-icons">mode_edit</i></button>
';

                        $sub_array[] = $subject->title;
                        $sub_array[] = $subject->description;
                   }
                    $data[] = $sub_array;
                }

                /////////////////////////////////////////////////////////
            }
        }


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);
    }
    
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM app_help WHERE id=".$id." ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->id, "title"=>$check->title, "description"=>$check->description);
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
        $description=$this->db->escape_str($_POST['description']);
        $edit_id=$_POST['edit_id'];
        
        $sql="UPDATE app_help SET  `title`='".$Title."', `description`='".$description."' WHERE id='".$edit_id."' ";

        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Help Details Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update Help Details.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

        redirect(base_url() . 'AppHelp', 'refresh');
    }
    
   


}
