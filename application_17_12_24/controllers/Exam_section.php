<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_section extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
    }

    
    public function index()
    {
        //echo "if";die;
        $data['title'] = ucfirst('Exam Section'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('exam_section/index', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_section/jscript', $data);
        
    }


    public function get_exam_section_details()
    {
        
        $this->load->model("Exam_section_model");
        $fetch_data = $this->Exam_section_model->make_datatables();
        //print_r($fetch_data);die;
        $data = array();
        foreach ($fetch_data as $row) {
           $sub_array = array();

           $sub_array[] = '<button type="button" name="Details" onclick="getExamSectionDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getExamSectionDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
          <i class="material-icons">mode_edit</i></button>

          ';

          $sub_array[] = $row->title;
          
          $sub_array[] = $row->background_color;
          $sub_array[] = $row->icon;
          $sub_array[] = date("d-m-Y H:i:s",strtotime($row->created_at));

           $data[] = $sub_array;
       }
       $output = array("recordsTotal" => $this->Exam_section_model->get_all_data(), "recordsFiltered" => $this->Exam_section_model->get_filtered_data(), "data" => $data);
      
       echo json_encode($output);
    }

    function now()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
    }
    
    public function addExamSection(){
        //print_r($_POST);die;
        if (!is_dir('AppAPI/exam-section-icon/')) {
            mkdir('AppAPI/exam-section-icon/', 0777, TRUE);    
        }
        
      /*  $config['upload_path'] = 'AppAPI/exam-section-icon/';
        $config['allowed_types'] = 'gif|jpg|png';
        //$config['encrypt_name'] = TRUE;
        $config['file_name'] = time() . '-' . date("Y-m-d") . '-' . $_FILES['file']['name'];
        //$config['file_name'] =$_FILES['file']['name'];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("iconfile")){
            $data = $this->upload->data();
        }*/
        //die;
        
        $this->load->model("Exam_section_model");
        

        


        $title = $this->input->post('Title');
        $background_color = $this->input->post('background_color');
        $created_at = $this->now();
        $data=['title'=>$title,
            'created_at'=>$created_at,
            'background_color'=>$background_color];


        if (!empty($_FILES['iconfile']['name'])) {
            $path = 'AppAPI/exam-section-icon/';
            $images = upload_file('iconfile', $path);
            if (empty($images['error'])) {
                $data['icon'] = $images;
            }
        }

        //print_r($data);die;
        $result = $this->Exam_section_model->save_upload($data);
        //print_r($result);die;
        if ($result === "Failed") {
            echo "Operation failed";
        } elseif ($result === "Inserted") {
            echo "Success";
        } elseif ($result === "Exists") {
            echo "Exists";
        }
    
   }


   public function fetchExamSectionDetail($id){
       
    if (!$id) {
        echo "No ID specified";
        exit;
    }
    $this->load->model("Exam_section_model");
    $result = $this->Exam_section_model->getPostById($id);
    
    if ($result) {
        $row=[];
        $row=$result[0];
        $row['created_at']=date("d-m-Y H:i:s",strtotime($result[0]['created_at']));
        echo json_encode($row);
        exit;
    } else {
        echo "Invalid ID";
        exit;
    }
}

public function editExamSection(){
    //print_r($_POST);die;
    if (!is_dir('AppAPI/exam-section-icon/')) {
        mkdir('AppAPI/exam-section-icon/', 0777, TRUE);    
    }
    
   /* $icon=$this->input->post('old_iconfile');
    
    if(!empty($_FILES['edit_iconfile']['name'])){
        $config['upload_path'] = 'AppAPI/exam-section-icon/';
        $config['allowed_types'] = 'gif|jpg|png';
        //$config['encrypt_name'] = TRUE;
        $config['file_name'] = time() . '-' . date("Y-m-d") . '-' . $_FILES['edit_iconfile']['name'];
        //$config['file_name'] =$_FILES['file']['name'];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("edit_iconfile")){
            $data = $this->upload->data();
            $icon = $data['file_name'];
            if(!empty($this->input->post('old_iconfile')) && file_exists('AppAPI/exam-section-icon/'.$this->input->post('old_iconfile'))){
                unlink('AppAPI/exam-section-icon/'.$this->input->post('old_iconfile'));
            }
        }
    }*/
    //die;
    
    $this->load->model("Exam_section_model");


    $id = $this->input->post('edit_id');
    $title = $this->input->post('Title');
    $background_color = $this->input->post('background_color');
    $updated_On = $this->now();

    $data=['title'=>$title,
        'updated_at'=>$updated_On,
        'background_color'=>$background_color,
        'icon'=>null];

    if ($this->input->post('remove_image') != 'on'){
        if (!empty($_FILES['edit_iconfile']['name'])) {
            $path = 'AppAPI/exam-section-icon/';
            $images = upload_file('edit_iconfile', $path);
            if (empty($images['error'])) {
                $data['icon'] = $images;
            }
        }
    }

    $result = $this->Exam_section_model->update_upload($id,$data);
    //print_r($result);die;
    if ($result === "Failed") {
        echo "Operation failed";
    } elseif ($result === "Updated") {
        echo "Success";
    } elseif ($result === "Exists") {
        echo "Exists";
    }
}

}