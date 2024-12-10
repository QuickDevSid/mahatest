<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
    }

    
    public function index()
    {
        //echo "if";die;
        $this->load->model('Exam_section_model');
        $examSection=$this->Exam_section_model->getAllData();
        $data['title'] = ucfirst('Category'); // Capitalize the first letter
        $data['examSectionArr']=$examSection;

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('category/index', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('category/jscript', $data);
        
    }


    public function get_category_details()
    {
        
        $this->load->model("Category_model");
        $fetch_data = $this->Category_model->make_datatables();
        //print_r($fetch_data);die;
        $data = array();
        foreach ($fetch_data as $row) {
           $sub_array = array();

           $sub_array[] = '<button type="button" name="Details" onclick="getCategoryDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getCategoryDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteCategoryDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

          $sub_array[] = $row->section;
          
          $sub_array[] = $row->title;
          $sub_array[] = date("d-m-Y H:i:s",strtotime($row->created_at));

           $data[] = $sub_array;
       }
       $output = array("recordsTotal" => $this->Category_model->get_all_data(), "recordsFiltered" => $this->Category_model->get_filtered_data(), "data" => $data);
      
       echo json_encode($output);
    }

    function now()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
    }
    
    public function addCategory(){
        //print_r($_POST);die;
        if (!is_dir('AppAPI/category-icon/')) {
            mkdir('AppAPI/category-icon/', 0777, TRUE);    
        }
        
       /* $config['upload_path'] = 'AppAPI/category-icon/';
        $config['allowed_types'] = 'gif|jpg|png';
        //$config['encrypt_name'] = TRUE;
        $config['file_name'] = time() . '-' . date("Y-m-d") . '-' . $_FILES['file']['name'];
        //$config['file_name'] =$_FILES['file']['name'];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("iconfile")){
            $data = $this->upload->data();
        }*/
        //die;
        
        $this->load->model("Category_model");

        
        //$icon = $data['file_name'];
        $title = $this->input->post('Title');
        $status = $this->input->post('status');
        $section = $this->input->post('section');
        $created_at = $this->now();
        $data=['title'=>$title,
            'created_at'=>$created_at,
            'section'=>$section,
            'status'=>$status];

        if (!empty($_FILES['iconfile']['name'])) {
            $path = 'AppAPI/category-icon/';
            $images = upload_file('iconfile', $path);
            if (empty($images['error'])) {
                $data['icon_img'] = $images;
            }
        }

        //print_r($data);die;
        $result = $this->Category_model->save_upload($data);
        //print_r($result);die;
        if ($result === "Failed") {
            echo "Operation failed";
        } elseif ($result === "Inserted") {
            echo "Category add Successfully";
        } elseif ($result === "Exists") {
            echo "Exists";
        }
    
   }


   public function fetchCategoryDetail($id){
       
    if (!$id) {
        echo "No ID specified";
        exit;
    }
    $this->load->model("Category_model");
    $result = $this->Category_model->getPostById($id);
    
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

public function editCategory(){
    //print_r($_FILES);die;
    if (!is_dir('AppAPI/category-icon/')) {
        mkdir('AppAPI/category-icon/', 0777, TRUE);    
    }
    

   /* if(!empty($_FILES['edit_iconfile']['name'])){
        $config['upload_path'] = 'AppAPI/category-icon/';
        $config['allowed_types'] = 'gif|jpg|png';
        //$config['encrypt_name'] = TRUE;
        $config['file_name'] = time() . '-' . date("Y-m-d") . '-' . $_FILES['edit_iconfile']['name'];
        //$config['file_name'] =$_FILES['file']['name'];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("edit_iconfile")){
            $data = $this->upload->data();
            $icon = $data['file_name'];
            if(!empty($this->input->post('old_iconfile')) && file_exists('AppAPI/category-icon/'.$this->input->post('old_iconfile'))){
                unlink('AppAPI/category-icon/'.$this->input->post('old_iconfile'));
            }
        }
    }*/
    //die;
    
    $this->load->model("Category_model");

    //$icon = $data['file_name'];

    $id = $this->input->post('edit_id');
    $title = $this->input->post('Title');
    $section = $this->input->post('section');
    $section = $this->input->post('section');
    $status = $this->input->post('status');
    $data=['title'=>$title,
        'section'=>$section,
        'status'=>$status];

    if (!empty($_FILES['edit_iconfile']['name'])) {
        $path = 'AppAPI/category-icon/';
        $images = upload_file('edit_iconfile', $path);
        if (empty($images['error'])) {
            $data['icon_img'] = $images;
        }
    }

    $result = $this->Category_model->update_upload($id,$data);
    //print_r($result);die;
    if ($result === "Failed") {
        echo "Operation failed";
    } elseif ($result === "Updated") {
        echo "Category update Successfully";
    } elseif ($result === "Exists") {
        echo "Exists";
    }
}

function deleteCategory($id)
{
    //echo $id;die;
    if (!$id) {
        echo "Parameter missing";
    }
    $this->load->model("Category_model");
    $result = $this->Category_model->getPostById($id);
    if($result){
       
        $iconimg=$result[0]['icon_img'];
        
        if ($this->Category_model->delete($id)) {
            
            if(!empty($iconimg) && file_exists('AppAPI/category-icon/'.$iconimg)){
                unlink('AppAPI/category-icon/'.$iconimg);
            }
            echo "Category delete Successfully";
         } else {
             echo "Failed";
         }

    }else{
        echo "Failed";
    }
    
}
}
