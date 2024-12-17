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

class Pariksha_paddhati_update extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    public function CutOffById($id)
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM pariksha_paddhati_abhyaskram_last_yearcut WHERE pariksha_paddhati_abhyaskram_id='".$id."' LIMIT 1 ";
//            echo $sql;
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->pariksha_paddhati_abhyaskram_last_yearcut_id, "ppa_id"=>$check->pariksha_paddhati_abhyaskram_id, "title"=>$check->title, "status"=>$check->status, "description"=>$check->description);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }
    public function update_cutoff()
    {
    	$id=$_POST['cutoff_id'];
            $title=$this->db->escape_str($_POST['Title']);
            $status=$_POST['status'];
            $Description=$this->db->escape_str($_POST['Description']);

        $sql="SELECT * FROM `pariksha_paddhati_abhyaskram_last_yearcut` WHERE pariksha_paddhati_abhyaskram_id='".$id."' LIMIT 1 ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
        	$sql="UPDATE pariksha_paddhati_abhyaskram_last_yearcut SET `title`='".$title."', `description`='".$Description."' ,`status`='".$status."' WHERE pariksha_paddhati_abhyaskram_last_yearcut_id='".$check->pariksha_paddhati_abhyaskram_last_yearcut_id."' ";

        }
        else
        {
            $sql="INSERT INTO `pariksha_paddhati_abhyaskram_last_yearcut`(`pariksha_paddhati_abhyaskram_id`, `title`, `status`, `created_at`, `description`) VALUES ('".$id."', '".$title."', '".$status."', '".date('Y-m-d H:i:s')."', '".$Description."')";
        }

        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Pariksha paddhati abhyaskram last yearcut Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update Pariksha paddhati abhyaskram last yearcut.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

        redirect(base_url() . 'Pariksha_paddhati_abhyaskram', 'refresh');
    }
    function SyllabusById($id=0)
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM pariksha_paddhati_abhyaskram_syllabus WHERE pariksha_paddhati_abhyaskram_id='".$id."' LIMIT 1 ";

            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("title"=>$check->title, "status"=>$check->status, "description"=>$check->description);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }


    public function update_syllabus()
    {
    	$id=$_POST['syllabus_id'];
    	// print_r($_POST);exit(0);
        $title=$this->db->escape_str($_POST['Title']);
        $status=$_POST['status'];
        $Description=$this->db->escape_str($_POST['Description']);


        $sql="SELECT * FROM `pariksha_paddhati_abhyaskram_syllabus` WHERE pariksha_paddhati_abhyaskram_id='".$id."' LIMIT 1 ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {

	        $sql="UPDATE pariksha_paddhati_abhyaskram_syllabus SET `title`='".$title."', `status`='".$status."', `description`='".$Description."' WHERE exam_syllabus_syllabus_id='".$check->exam_syllabus_syllabus_id."' ";
        }
        else
        {
            $sql="INSERT INTO `pariksha_paddhati_abhyaskram_syllabus`(`pariksha_paddhati_abhyaskram_id`, `title`, `status`, `created_at`, `description`) VALUES ('".$id."', '".$title."', '".$status."', '".date('Y-m-d H:i:s')."', '".$Description."')";
        }

        // echo $sql;
        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Pariksha paddhati syllabus Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update Pariksha paddhati syllabus.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

       redirect(base_url() . 'Pariksha_paddhati_abhyaskram', 'refresh');


    }
    public function WattageById($id)
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM pariksha_paddhati_abhyaskram_wattage WHERE pariksha_paddhati_abhyaskram_id='".$id."' LIMIT 1 ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("title"=>$check->title, "status"=>$check->status, "description"=>$check->description);
            }
        }
        else
        {

        }
        echo json_encode($return_array);

    }

    public function update_wattage()
    {
    	$id=$_POST['wattage_id'];
    	// print_r($_POST);exit(0);
        $title=$this->db->escape_str($_POST['Title']);
        $status=$_POST['status'];
        $Description=$this->db->escape_str($_POST['Description']);


        $sql="SELECT * FROM `pariksha_paddhati_abhyaskram_wattage` WHERE pariksha_paddhati_abhyaskram_id='".$id."' LIMIT 1 ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {

	        $sql="UPDATE pariksha_paddhati_abhyaskram_wattage SET `title`='".$title."', `status`='".$status."', `description`='".$Description."' WHERE pariksha_paddhati_abhyaskram_wattage_id='".$check->pariksha_paddhati_abhyaskram_wattage_id ."' ";
        }
        else
        {
            $sql="INSERT INTO `pariksha_paddhati_abhyaskram_wattage`(`pariksha_paddhati_abhyaskram_id`, `title`, `status`, `created_at`, `description`) VALUES ('".$id."', '".$title."', '".$status."', '".date('Y-m-d H:i:s')."', '".$Description."')";
        }

        // echo $sql;
        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Pariksha paddhati wattage Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update Pariksha paddhati wattage .';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

       redirect(base_url() . 'Pariksha_paddhati_abhyaskram', 'refresh');

    }

}
