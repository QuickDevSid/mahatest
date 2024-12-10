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

class Banner extends CI_Controller
{
    //functions
    function index()
    {
        $data=[];
        $this->load->model('Exam_section_model');
        $examSection=$this->Exam_section_model->getAllData();
        $data['examSectionArr']=$examSection;
        //print_r($data);die;
        $data['title'] = ucfirst('Manage Banners'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('Banner/index', $data);
        $this->load->view('Banner/add_banner_img',$data);
        $this->load->view('Banner/show_banner',$data);
        $this->load->view('Banner/edit_banner',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('Banner/jscript.php', $data);
    }

    function fetch_user()
   {
       $this->load->model("Banner_model");
       $this->load->model("Exam_section_model");
       $fetch_data = $this->Banner_model->make_datatables();
       //print_r($fetch_data);die;
       $data = array();
       foreach ($fetch_data as $row) {
           $sub_array = array();

           $sub_array[] = '<button type="button" name="Details" onclick="getbannerDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showbanner">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getBannerEdit(this.id)" id="client_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#editbanner" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteBannerDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';
          $sectionName=$row->section_id;
          $getSectionName=$this->Exam_section_model->getPostById($row->section_id);
          if($getSectionName){
                $sectionName=$getSectionName[0]['title'];
            }
          $sub_array[] = $row->banner_image;
          $sub_array[] =$sectionName;
          
          $sub_array[] = $row->status;
          $sub_array[] = date('d-m-Y H:i:s',strtotime($row->created_at));
          $sub_array[] = $row->sequence_no;
          $sub_array[] = $row->sub_section_id;
            
          
         

           $data[] = $sub_array;
       }
       $output = array("recordsTotal" => $this->Banner_model->get_all_data(), "recordsFiltered" => $this->Banner_model->get_filtered_data(), "data" => $data);
       echo json_encode($output);
   }

   //API - licenses sends id and on valid id licenses information is sent back editbyId

   function StudyById($pid = NULL)
   {
       $id = $pid;
       if (!$id) {
           echo json_encode("No ID specified");
           exit;
       }
       $this->load->model("Study_Material_Model_Api");
       $result = $this->Study_Material_Model_Api->getStudyById($id);
       if ($result) {
           echo json_encode($result);
           exit;
       } else {
           echo json_encode("Invalid ID");
           exit;
       }


    }

    public function getSubSectionDetail(){
        $section_id = $this->input->post('section_id');
        $options="<option value=''>Select</option>";
        if($section_id=='MPSC'){

        }else if($section_id=='Mock Test'){
            $this->load->model('Daily_quiz_model');
            $getResult=$this->Daily_quiz_model->getAllData();
            if($getResult){
                foreach($getResult as $row){
                    $options.="<option value='".$row['quiz_id']."'>".$row['quiz_title']."</option>";
                }
            }

        }else if($section_id=='Test Series'){
            $this->load->model('Test_series_model');
            $getResult=$this->Test_series_model->getAllData();
            if($getResult){
                foreach($getResult as $row){
                    $options.="<option value='".$row['test_series']."'>".$row['test_title']."</option>";
                }
            }
        }else if($section_id=='Current Affairs'){
            $this->load->model('CurrentAffairs_model');
            $getResult=$this->CurrentAffairs_model->getAllData();
            if($getResult){
                foreach($getResult as $row){
                    $options.="<option value='".$row['current_affair_id']."'>".$row['current_affair_title']."</option>";
                }
            }
        }else if($section_id=='Courses'){
            
        }else{

        }
        echo $options;
    }

}
