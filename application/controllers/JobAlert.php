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

class JobAlert extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $this->load->model("CurrentAffairs_model");
        $data['exams'] = $this->CurrentAffairs_model->getExams();
        
        $data['title'] = ucfirst('All Job Alerts'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('JobAlert/index', $data);
        $this->load->view('JobAlert/add_job_alert',$data);
        $this->load->view('JobAlert/show_job_alert',$data);
        $this->load->view('JobAlert/edit_job_alert',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('JobAlert/jscript.php', $data);
    }

    function fetch_user()
   {
       $this->load->model("JobAlert_model");
       $fetch_data = $this->JobAlert_model->make_datatables();
       $data = array();
       foreach ($fetch_data as $row) {
           $sub_array = array();

           $sub_array[] = '<!----<button type="button" name="Details" onclick="getDetails(this.id)" id="details_' . $row->Id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#PostDetailModel">
         <i class="material-icons">visibility</i> </button>-->
          <button type="button" name="Edit" onclick="getEdit(this.id)" id="edit_' . $row->Id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#editfeeds" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteRecordDetails(this.id)" id="delete_' . $row->Id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

          $sub_array[] = $row->Title;
          $sub_array[] = $row->status;
          $sub_array[] = $row->created_at;

           $data[] = $sub_array;
       }
       $output = array("recordsTotal" => $this->JobAlert_model->get_all_data(), "recordsFiltered" => $this->JobAlert_model->get_filtered_data(), "data" => $data);
       echo json_encode($output);
   }
    
    
    function now()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
    }
    
    function upload()
    {
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/job-alert/';
            $config['upload_url'] = base_url() . 'AppAPI/job-alert/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/job-alert/" . $newname);
            return $newname;
        }
    }
    function upload_pdf()
    {
            $name="pdf";
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/job-alert/pdf/';
            $config['upload_url'] = base_url() . 'AppAPI/job-alert/pdf/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            move_uploaded_file($tmpname, "AppAPI/job-alert/pdf/" . $newname);
            return $newname;
    }
    
    public function addPost()
    {
        $image = 'placeholder.png';
        $this->load->model("JobAlert_model");
        
        if ($this->input->post('file')) {
            $image = $this->input->post('file');
        } else {
            $image = 'placeholder.png';
        }
        
        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES['file']['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = 'placeholder.png';
            }
        }


        if ($this->input->post('pdf')) {
            $pdf = $this->input->post('pdf');
        } else {
            $pdf = '';
        }
        
        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES['pdf']['name'])) {
                $newname = $this->upload_pdf();
                $pdf = $newname;
            } else {
                $pdf = '';
            }
        }

        
        $PostTitle = $this->input->post('job_title');
        $Description = $this->input->post('job_description');
        $job_apply_link = $this->input->post('job_apply_link');
        $Exam_Id = $this->input->post('Exam_Id');
        $Exam_Id=json_encode($Exam_Id);
        $Status = "Active";
        $created_at = $this->now();
        
        $data = array("job_title" => $PostTitle,
            "job_description" => $Description,
            "status" => $Status,
            "selected_exams_id" => $Exam_Id,
            "job_poster" => $image,
            "created_at" => $created_at,
            "job_apply_link" => $job_apply_link, "pdf_url"=>$pdf);
        
        $this->JobAlert_model->add($data);
        
        $art_msg['msg'] = 'Job Alert Post Added.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'JobAlert', 'refresh');
    }
    
    public function editPost()
    {
        $image = 'placeholder.png';
        $this->load->model("JobAlert_model");
    
        if ($this->input->post('e_job_alert_id')) {
            $id = $this->input->post('e_job_alert_id');
        }
        
        $sql="SELECT * FROM job_alert WHERE job_alert_id='".$id."' ";
        $data=$this->common_model->executeRow($sql);        
        $name="e_file";
        if ($this->input->post('e_file')) {
            $image = $this->input->post('e_file');
        } else {
            $image = '';
        }
        foreach ($_FILES as $name => $fileInfo)
        {
            if (!empty($_FILES['e_file']['name']))
            {
                $newname = $this->upload();
                $image = $newname;
            }
            else
            {
                $image = '';
            }
        }
        $name="pdf";

        if ($this->input->post('pdf')) {
            $pdf = $this->input->post('pdf');
        } else {
            $pdf = '';
        }
        foreach ($_FILES as $name => $fileInfo)
        {
            if (!empty($_FILES['pdf']['name']))
            {
                $newname = $this->upload_pdf();
                $pdf = $newname;
            }
            else
            {
                $pdf = '';
            }
        }

        if($pdf=="")
        {
            $pdf=$data->pdf_url;
        }

        if($image=="")
        {
            $image=$data->job_poster;
        }
        
        $PostTitle = $this->input->post('e_job_title');
        $Description = $this->input->post('e_job_description');
        $job_apply_link = $this->input->post('e_apply_link');
        $Exam_Id = $this->input->post('e_Exam_Id');
        $Exam_Id=json_encode($Exam_Id);

        $Status = $this->input->post('e_status');
        
        $data = array("job_title" => $PostTitle,
            "job_description" => $Description,
            "status" => $Status,
            "selected_exams_id" => $Exam_Id,
            "job_poster" => $image,
            "job_apply_link" => $job_apply_link, "pdf_url"=>$pdf);
        
        $this->JobAlert_model->update($id, $data);
        
        $art_msg['msg'] = 'Job Alert Post Updated.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'JobAlert', 'refresh');
    }
}
