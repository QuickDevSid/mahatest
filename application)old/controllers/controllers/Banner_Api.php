<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

require(APPPATH . '/libraries/REST_controller.php');

use Restserver\Libraries\REST_controller;

class Banner_Api extends REST_controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Banner_model_Api");
    }
    
    function now()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
    }
    
    function addbanner_post()
    {
        //print_r($_POST);die;
        //$config['upload_path'] = 'AppAPI/banner-images/';
        //$config['allowed_types'] = 'gif|jpg|png';
        //$config['encrypt_name'] = TRUE;
        //$config['file_name'] = time() . '-' . date("Y-m-d") . '-' . $_FILES['file']['name'];
        //$config['file_name'] =$_FILES['file']['name'];
        
        //$this->load->library('upload', $config);
        //if ($this->upload->do_upload("file")) {
           // $data = array('upload_data' => $this->upload->data());
            $banner_status = $this->input->post('banner_status');
            $section_id = $this->input->post('section_id');
            $sub_section_id = $this->input->post('sub_section_id');
            $sequence = $this->input->post('sequence');
            $image = "banner1.png";
            $created_at = $this->now();

            if (!empty($_FILES['file']['name'])) {
                $path = 'AppAPI/banner-images/';
                $images = upload_file('file', $path);
                if (empty($images['error'])) {
                    $image = $images;
                }
            }

            $result = $this->Banner_model_Api->save_upload($image, $banner_status, $created_at, $section_id,$sub_section_id,$sequence);
            if ($result === "Failed") {
                $this->response("Operation failed", 404);
            } elseif ($result === "Inserted") {
                $this->response("Success", 200);
            } elseif ($result === "Exists") {
                $this->response("Exists", 200);
            }
        //}
    }
    
    //end code here use this code for both side show and edit
    function BannerById_get($id1)
    {
        $id = $id1;
        if (!$id) {
            $this->response("No ID specified", 400);
            exit;
        }
        $result = $this->Banner_model_Api->getbannerbyid($id);
        
        if ($result) {
            $section_id = $result[0]['section_id'];
            $options="<option value=''>Select</option>";
            if($section_id=='MPSC'){

            }else if($section_id=='Mock Test'){
                $this->load->model('Daily_quiz_model');
                $getResult=$this->Daily_quiz_model->getAllData();
                if($getResult){
                    foreach($getResult as $row){
                        $sel='';
                        if($result[0]['sub_section_id']==$row['quiz_id']){
                            $sel="selected";
                        }
                        $options.="<option value='".$row['quiz_id']."' ".$sel.">".$row['quiz_title']."</option>";
                       
                    }
                }

            }else if($section_id=='Test Series'){
                $this->load->model('Test_series_model');
                $getResult=$this->Test_series_model->getAllData();
                if($getResult){
                    foreach($getResult as $row){
                        $sel="";
                        if($result[0]['sub_section_id']==$row['test_series']){
                            $sel='selected';
                        }
                        $options.="<option value='".$row['test_series']."' ".$sel.">".$row['test_title']."</option>";
                    }
                }
            }else if($section_id=='Current Affairs'){
                $this->load->model('CurrentAffairs_model');
                $getResult=$this->CurrentAffairs_model->getAllData();
                if($getResult){
                    foreach($getResult as $row){
                        $sel='';
                        if($result[0]['sub_section_id']==$row['current_affair_id']){
                            $sel='selected';
                        }
                        $options.="<option value='".$row['current_affair_id']."' ".$sel.">".$row['current_affair_title']."</option>";
                    }
                }
            }else if($section_id=='Courses'){
                
            }else{

            }
            $result[0]['sub_section_id']=$options;
            $result[0]['created_at']=date('d-m-Y H:i:s',strtotime($result[0]['created_at']));
            $this->response($result, 200);
            exit;
        } else {
            $this->response("Invalid ID", 404);
            exit;
        }
    }
    
    //fetch recored for edit
    function editbannerD_post()
    {
        //print_r($_POST);die;
        //$config['encrypt_name'] = TRUE;
        //$config['upload_path'] = 'AppAPI/banner-images/';
        //$config['allowed_types'] = 'gif|jpg|png';
        $id = $this->input->post('e_banner_id');
        $e_status = $this->input->post('e_status');
        $e_img1 = $this->input->post('e_img1');
        $section_id = $this->input->post('e_section_id');
        $sub_section_id = $this->input->post('e_sub_section_id');
        $sequence_no = $this->input->post('e_sequence');
        $getBannerDetails=$this->Banner_model_Api->getbannerbyid($id);
        if ($_FILES['file']['name'] == '') {

            $image = $getBannerDetails[0]['image_name'];
        } else {
            //$config['file_name'] = $_FILES['file']['name'];
           // $config['file_name'] = time() . '-' . date("Y-m-d") . '-' . $_FILES['file']['name'];
          //  $this->load->library('upload', $config);
           // if ($this->upload->do_upload("file")) {
             //   $data = array('upload_data' => $this->upload->data());
                
            //    $image = $data['upload_data']['file_name'];
                if(!empty($getBannerDetails[0]['image_name']) && file_exists('AppAPI/banner-images/'.$getBannerDetails[0]['image_name'])){
                    unlink('AppAPI/banner-images/'.$getBannerDetails[0]['image_name']);
                }
           // }

            if (!empty($_FILES['file']['name'])) {
                $path = 'AppAPI/banner-images/';
                $images = upload_file('file', $path);
                if (empty($images['error'])) {
                    $image = $images;
                }
            }
        }
        $result = $this->Banner_model_Api->update_upload($id, $image, $e_status,$section_id, $sub_section_id,$sequence_no);
        if ($result === "Failed") {
            $this->response("Operation failed", 404);
        } elseif ($result === "Updated") {
            $this->response("Success", 200);
        } elseif ($result === "Exists") {
            $this->response("Exists", 200);
        }
        
    }
    
    function deleteBanner_delete()
    {
        
        $id = $this->delete('id');
        if (!$id) {
            $this->response("Parameter missing", 404);
        }
        
        $getBannerDetails=$this->Banner_model_Api->getbannerbyid($id);
        if ($this->Banner_model_Api->delete($id)) {
            if(!empty($getBannerDetails[0]['image_name']) && file_exists('AppAPI/banner-images/'.$getBannerDetails[0]['image_name'])){
                unlink('AppAPI/banner-images/'.$getBannerDetails[0]['image_name']);
            }
            $this->response("Success", 200);
        } else {
            $this->response("Failed", 400);
        }
    }
    
    
}
