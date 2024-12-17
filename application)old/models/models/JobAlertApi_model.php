<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class JobAlertApi_model extends CI_Model
{
    
    public function __construct()
    {
        $this->load->database();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    public function getbyid($id)
    {
        // $this->db->select('job_alert_id,job_title,job_description,job_apply_link,job_poster,status,created_at,selected_exams_id');
        // $this->db->from('job_alert');
        // $this->db->where('job_alert_id', $id);
        // $query = $this->db->get();
        // if ($query->num_rows() == 1) {
        //     return $query->result_array();
        // } else {
        //     return 0;
        // }

        $return_array=array();
        $sql="SELECT * FROM job_alert WHERE job_alert_id='".$id."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            $return_array=array("job_alert_id"=>$check->job_alert_id, "selected_exams_id"=>json_decode($check->selected_exams_id), "job_title"=>$check->job_title, "job_description"=>$check->job_description, "job_apply_link"=>$check->job_apply_link, "job_poster"=>$check->job_poster, "pdf_url"=>$check->pdf_url, "status"=>$check->status);

        }
        return $return_array;

    }

    
    public function delete($id)
    {
        $this->db->where('job_alert_id', $id);
        if ($this->db->delete('job_alert')) {
            return true;
        } else {
            return false;
        }
    }
    
    
    public function getPostById_D($id)
    {
        $this->db->select("job_alert.*, exams.exam_name");
        $this->db->from("job_alert, exams");
        $this->db->where('job_alert.selected_exams_id = exams.exam_id ');
        $this->db->where('job_alert_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
}
