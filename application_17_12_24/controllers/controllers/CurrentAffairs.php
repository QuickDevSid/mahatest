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

class CurrentAffairs extends CI_Controller
{
    //functions
    function index()
    {
        $this->load->model("CurrentAffairs_model");
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['exams'] = $this->CurrentAffairs_model->getExams();
        $this->load->model('Category_model');
        $data['category']=$this->Category_model->getAllData(['section'=>'Current Affairs']);
       // print_r($data['category']);die;
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('current_affairs/index', $data);
        $this->load->view('current_affairs/edit_current_affaires', $data);
        $this->load->view('current_affairs/add_current_affaires', $data);
        $this->load->view('current_affairs/details', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('current_affairs/jscript.php', $data);
    }
    
    function fetch_user()
    {
        $this->load->model("CurrentAffairs_model");
        $fetch_data = $this->CurrentAffairs_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            
            $sub_array[] = '<button type="button" name="Details" onclick="getPostDetails(this.id)" id="details_' . $row->current_affair_id  . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#PostDetailModel">
          <i class="material-icons">visibility</i> </button>
           <button type="button" name="Edit" onclick="getPostDetailsEdit(this.id)" id="edit_' . $row->current_affair_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_post" >
           <i class="material-icons">mode_edit</i></button>

           <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $row->current_affair_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
           <i class="material-icons">delete</i></button>
           ';
            
            $sub_array[] = $row->current_affair_title;
            $sub_array[] = $row->status;
            $sub_array[] = $row->views;
            $sub_array[] = date('d-m-Y H:i:s',strtotime($row->created_at));
            
            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->CurrentAffairs_model->get_all_data(), "recordsFiltered" => $this->CurrentAffairs_model->get_filtered_data(), "data" => $data);
        echo json_encode($output);
    }
    
    //API - licenses sends id and on valid id licenses information is sent back editbyId
    function postById($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("CurrentAffairs_model");
        $result = $this->CurrentAffairs_model->getPostById($id);
        if ($result) {
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
        
    }
    
    //API - licenses sends id and on valid id licenses information is sent back editbyId
    function postById_D($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("CurrentAffairs_model");
        $result = $this->CurrentAffairs_model->getPostById_D($id);
        if ($result) {
            
            $result[0]['created_at']=date('d-m-Y H:i:s',strtotime($result[0]['created_at']));
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
        
    }
    
    function commentById($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("CurrentAffairs_model");
        $result = $this->CurrentAffairs_model->getPostComment($id);
        if ($result) {
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
        
    }
    
    function now()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
    }
    
    /**
     * This function is used to upload file
     * @return Void
     */
    function upload()
    {
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = 'current_affair' . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/current-affairs/';
            $config['upload_url'] = base_url() . 'AppAPI/current-affairs/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/current-affairs/" . $newname);
            return $newname;
        }
    }
    
    function upload_setting()
    {   
        if (!is_dir('AppAPI/exam-section-setting/')) {
            mkdir('AppAPI/exam-section-setting/', 0777, TRUE);
        }
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = "exam_section_setting" . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/exam-section-setting/';
            $config['upload_url'] = base_url() . 'AppAPI/exam-section-setting/';
            $config['allowed_types'] = "jpg|jpeg|png";
            $config['max_size'] = '200000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/exam-section-setting/" . $newname);
            return $newname;
        }
    }
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function addPost()
    {
        //print_r($_POST);die;
        $image = 'placeholder.png';
        $this->load->model("CurrentAffairs_model");
        
        $sequence_no= $this->input->post('sequence_no');
        /*$checkDataExist=$this->CurrentAffairs_model->getDataByWhereCondition(['sequence_no'=>$sequence_no]);
        if($checkDataExist){
            $art_msg['msg'] = 'Sequence No. is already used.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'current_affairs', 'refresh');
        }*/
        if ($this->input->post('post_image')) {
            $image = $this->input->post('post_image');
        } else {
            $image = 'placeholder.png';
        }
        
        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = 'placeholder.png';
            }
        }

        $PostTitle = $this->input->post('PostTitle');
        $Description = $this->input->post('Description');
       // $Exam_Id = json_encode($this->input->post('Exam_Id'));
        $Category= $this->input->post('Category');
        $current_date=date("Y-m-d",strtotime($this->input->post('current_date')));
        $Status = "Active";
        $created_at = $this->now();
        $data = array("current_affair_title" => $PostTitle,
            "current_affair_description" => $Description,
            "status" => $Status,
           // "selected_exams_id" => $Exam_Id,
            "current_affair_image" => $image,
            "created_at" => $current_date,
            "category" => $Category,
            "sequence_no" => $sequence_no

        );
        
        $this->CurrentAffairs_model->add($data);
        
        $art_msg['msg'] = 'Current Affair Post Added.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'current_affairs', 'refresh');
    }
    
    
    public function editPost($id = '')
    {
        $image = 'placeholder.png';
        $this->load->model("CurrentAffairs_model");
    
        if ($this->input->post('edit_id')) {
            $id = $this->input->post('edit_id');
        }


        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
                if(!empty($this->input->post('post_image_old')) && file_exists('AppAPI/current-affairs/'.$this->input->post('post_image_old'))){
                    unlink('AppAPI/current-affairs/'.$this->input->post('post_image_old'));
                }
            }
        }

        if ($image == "placeholder.png"){
            if ($this->input->post('post_image_old')) {
                $newname = $this->input->post('post_image_old');
                $image = $newname;
            } else {
                $image = 'placeholder.png';
            }
        }



        $PostTitle = $this->input->post('edit_PostTitle');
        $sequence_no = $this->input->post('sequence_no');
        $Description = $this->input->post('edit_Description');
       // $Exam_Id = json_encode($this->input->post('edit_Exam_Id'));
        $Status = $this->input->post('edit_Status');
        $Category= $this->input->post('category');
        $current_date=date("Y-m-d",strtotime($this->input->post('current_date')));
        
        $data = array("current_affair_title" => $PostTitle,
            "current_affair_description" => $Description,
            "status" => $Status,
           // "selected_exams_id" => $Exam_Id,
            "current_affair_image" => $image,
            "category" => $Category,
            "sequence_no" => $sequence_no
        );
        
        $this->CurrentAffairs_model->update($id, $data);
        
        $art_msg['msg'] = 'Current Affair Post Updated.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'current_affairs', 'refresh');
    }

    public function current_affairs_setting(){
        $this->load->model("CurrentAffairs_model");
        $data['title'] = ucfirst('All Section Setting'); // Capitalize the first letter
        $data['exams'] = $this->CurrentAffairs_model->getExams();
        $this->load->model('Category_model');
        $data['category']=$this->Category_model->getAllData(['section'=>'Current Affairs']);
       // print_r($data['category']);die;
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('current_affairs/exam_section_setting', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('current_affairs/setting_jscript.php', $data);
    }

    public function addSettingPost(){
        //print_r($_POST);print_r($_FILES);die;
        $image = 'placeholder.png';
        $this->load->model("CurrentAffairSetting_model");
        
       
       
        if ($this->input->post('post_image')) {
            $image = $this->input->post('post_image');
        } else {
            $image = 'placeholder.png';
        }
        
        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_setting();
                $image = $newname;
            } else {
                $image = 'placeholder.png';
            }
        }

        $title = $this->input->post('title');
        $subtitle = $this->input->post('subtitle');
       
        $sectionTilte1= $this->input->post('sectionTilte1');
        $sectionTilte2= $this->input->post('sectionTilte2');
        $sectionTilte3= $this->input->post('sectionTilte3');
        
        $Created_at = $this->now();
        $data = array("title" => $title,
            "subtitle" => $subtitle,           
            "icon_img" => $image,
            "created_at" => $Created_at,
            "section_title_1" => $sectionTilte1,
            "section_title_2" => $sectionTilte2,
            "section_title_3" => $sectionTilte3

        );
        
        $this->CurrentAffairSetting_model->add($data);
        
        $art_msg['msg'] = 'Current Affair Post Added.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'current_affairs', 'refresh');
    }

    
    function fetch_setting()
    {
        $this->load->model("CurrentAffairSetting_model");
        $fetch_data = $this->CurrentAffairSetting_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            
            $sub_array[] = '<button type="button" name="Edit" onclick="getPostDetailsEdit(this.id)" id="edit_' . $row->id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_post" >
           <i class="material-icons">mode_edit</i></button>';
            
            $sub_array[] = $row->Section;
            $sub_array[] = $row->title;
            $sub_array[] = $row->subtitle;
            
            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->CurrentAffairSetting_model->get_all_data(), "recordsFiltered" => $this->CurrentAffairSetting_model->get_filtered_data(), "data" => $data);
        echo json_encode($output);
    }

    function postById_setting($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("CurrentAffairSetting_model");
        $result = $this->CurrentAffairSetting_model->getPostById($id);
        if ($result) {
            //$result[0]['subtitle']=explode(',',$result[0]['subtitle']);
            $result[0]['created_at']=date('d-m-Y H:i:s',strtotime($result[0]['created_at']));

            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
        
    }
    

    public function editSettingPost(){
        //print_r($_POST);print_r($_FILES);die;
        
        $this->load->model("CurrentAffairSetting_model");
/*
        if ($this->input->post('post_image_old')) {
            $image = $this->input->post('post_image_old');
        } else {
            $image = 'placeholder.png';
        }
        
        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_setting();
                $image = $newname;
            } 
        }*/

        $title = $this->input->post('title');
        $subtitle = $this->input->post('subtitle');
        $sectionTilte1= $this->input->post('sectionTilte1');
        $sectionTilte2= $this->input->post('sectionTilte2');
        $sectionTilte3= $this->input->post('sectionTilte3');
        $sectionTilte4= $this->input->post('sectionTilte4');
        $sectionTilte5= $this->input->post('sectionTilte5');
        $section= $this->input->post('section');
        $description= $this->input->post('description');
        $id= $this->input->post('edit_id');
        
        $Created_at = $this->now();
        $data = array("title" => $title,
            "subtitle" => $subtitle,
            "section_title_1" => $sectionTilte1,
            "section_title_2" => $sectionTilte2,
            "section_title_3" => $sectionTilte3,
            "section_title_4" => $sectionTilte4,
            "section_title_5" => $sectionTilte5,
            "Description" => $description

        );


        if (!empty($_FILES['post_image']['name'])) {
            $path = 'AppAPI/exam-section-setting/';
            $images = upload_file('post_image', $path);
            if (empty($images['error'])) {
                $data['icon_img'] = $images;
            }
        }


        $this->CurrentAffairSetting_model->update($id,$data);
        
        $art_msg['msg'] = 'Section Setting Updated.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'current_affairs_setting', 'refresh');
    }

    public function deleteSettingPost(){
        $id = $this->delete('id');
        if (!$id) {
            $this->response("Parameter missing", 404);
        }
        $this->load->model('CurrentAffairSetting_model');
        $result=$this->CurrentAffairSetting_model->getPostById($id);
        if ($this->CurrentAffairSetting_model->delete($id)) {
            if(!empty($result[0]['icon_img']) && file_exists('AppAPI/exam-section-setting/'.$result[0]['icon_img'])){
                unlink('AppAPI/exam-section-setting/'.$result[0]['icon_img']);
            }
            $this->response("Success", 200);
        } else {
            $this->response("Failed", 400);
        }
    }

}
