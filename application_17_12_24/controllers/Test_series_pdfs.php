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

class Test_series_pdfs extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }
    
    //functions
    function index()
    {
        $data['title'] = ucfirst('Test Series PDF'); // Capitalize the first letter
        
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('TestSeriesPDF/index', $data);
        $this->load->view('TestSeriesPDF/add',$data);
        $this->load->view('TestSeriesPDF/edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('TestSeriesPDF/jscript', $data);
        
    }
    
    function fetch()
    {
   
        $sql="SELECT * FROM test_series_pdf ORDER BY id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            // print_r($fetch_data);
            foreach($fetch_data as $masike)
            {
                /////////////////////////////////////////////////////////
                $sql="SELECT * FROM `test_series` WHERE test_series =".$masike->test_series_id." LIMIT 1";
                $fetch_cat = $this->common_model->executeRow($sql);
                if($fetch_cat)
                {
                    $sub_array = array();
                    
                    $sub_array[] = '<button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $masike->id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_masike" >
                       <i class="material-icons">mode_edit</i></button>
                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $masike->id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>';
                    
                    $sub_array[] = $masike->title;
                    $sub_array[] = $fetch_cat->test_title;
                    $sub_array[] = $masike->status;
                    $sub_array[] = $masike->created_at;
                    
                    $data[] = $sub_array;
                }
                
                /////////////////////////////////////////////////////////
            }
        }
        
        
        $output = array("recordsTotal" => sizeof($data), "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);
    }
    
    
    public function recordById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM test_series_pdf WHERE id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $exam_id="";
                $sql="SELECT * FROM `test_series` WHERE test_series='".$check->test_series_id."' ";
                $exam=$this->common_model->executeRow($sql);
                if($exam)
                {
                    $exam_id=$exam->selected_exams_id;
                }
                
                $return_array=array("id"=>$check->id, "test_series"=>$check->test_series_id, "title"=>$check->title, "selected_exams_id"=>$exam_id, "status"=>$check->status, "description"=>$check->description);
            }
        }
        else
        {
        
        }
        echo json_encode($return_array);
    }
    
    
    public function deleteRecord()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
            $sql="SELECT * FROM test_series_pdf WHERE id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM test_series_pdf WHERE id='".$id."'";
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
    
    function upload()
    {
        $name='image_url';
        $filename = $_FILES[$name]['name'];
        $tmpname = $_FILES[$name]['tmp_name'];
        
        $exp = explode('.', $filename);
        $ext = end($exp);
        $newname = $exp[0] . '_' . time() . "." . $ext;
        $config['upload_path'] = 'AppAPI/test_series/thumbnails';
        $config['upload_url'] = base_url() . 'AppAPI/test_series/thumbnails';
        $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
        $config['max_size'] = '2000000';
        $config['file_name'] = $newname;
        $this->load->library('upload', $config);
        move_uploaded_file($tmpname, "AppAPI/test_series/thumbnails/" . $newname);
        return $newname;
    }
    
    function upload_pdf()
    {
            $name='pdf_url';
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config2['upload_path'] = 'AppAPI/test_series/pdf';
            $config2['upload_url'] = base_url() . 'AppAPI/test_series/pdf';
            $config2['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config2['max_size'] = '2000000';
            $config2['file_name'] = $newname;
            $this->load->library('upload', $config2);
            move_uploaded_file($tmpname, "AppAPI/test_series/pdf/" . $newname);
            return $newname;
      
    }
    
    public function addRecord()
    {
        
        $image = 'study1.png';
       /* if ($this->input->post('image_url')) {
            $image = $this->input->post('image_url');
        } else {
            $image = 'study1.png';
        }
        */
        // foreach ($_FILES as $name => $fileInfo) {
       /* $name='image_url';
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload();
            $image = $newname;
        } else {
            $image = 'study1.png';
        }*/
        // }
        
        
        $pdf = 'pdf1.pdf';
        if ($this->input->post('pdf_url')) {
            $pdf = $this->input->post('pdf_url');
        } else {
            $pdf = 'pdf1.pdf';
        }
        
        $name='pdf_url';
        
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload_pdf();
            $pdf = $newname;
        } else {
            $pdf = 'pdf1.pdf';
        }
        // }
        
        $MasikeTitle=$this->db->escape_str($_POST['Title']);
        $MasikeCategoryId=$_POST['TestSeriesId'];
        $Description=$this->db->escape_str($_POST['Description']);
        $masike_status=$_POST['status'];
        
        
        if($pdf!="" && $image!="" && $MasikeTitle!="" && $MasikeCategoryId!="" && $masike_status!="" && $Description!="")
        {
            $sql="SELECT * FROM test_series_pdf WHERE title like '%".$MasikeTitle."%'";
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `test_series_pdf`(`test_series_id`, `title`, `description`, `image_url`, `pdf_url`, `status`, `created_at`) VALUES ('".$MasikeCategoryId."', '".$MasikeTitle."', '".$Description."', '".$image."', '".$pdf."' ,'".$masike_status."', '".date('Y-m-d H:i:s')."')";
//                echo $sql;
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New PDF updated Updated.';
                    $art_msg['type'] = 'success';
                }
                else
                {
                    $art_msg['msg'] = 'Error to add new PDF.';
                    $art_msg['type'] = 'error';
                }
            }
            else
            {
                $art_msg['msg'] = 'Repeat PDF.';
                $art_msg['type'] = 'error';
            }
            
        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';
            
        }
        
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Test_series_pdfs', 'refresh');
        
    }
    
    public function updateRecord()
    {
        $MasikeTitle=$this->db->escape_str($_POST['Title']);
        $MasikeCategoryId=$_POST['TestSeriesId'];
        $Description=$this->db->escape_str($_POST['Description']);
        $masike_status=$_POST['status'];
        $edit_id=$_POST['edit_id'];
        
        $sql="SELECT * FROM test_series_pdf WHERE id='".$edit_id."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
         
         /*   $name='image_url';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = $check->image_url;//'study1.png';
            }
            */
            $name='pdf_url';
            
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_pdf();
                $pdf = $newname;
            } else {
                $pdf = $check->pdf_url;//'pdf1.pdf';
            }
            
            $sql="UPDATE test_series_pdf SET `test_series_id`='".$MasikeCategoryId."', `title`='".$MasikeTitle."', `description`='".$Description."', `pdf_url`='".$pdf."', `status`='".$masike_status."' WHERE id='".$edit_id."' ";
            // echo $sql;exit(0);
            $insert=$this->common_model->executeNonQuery($sql);
            if($insert)
            {
                $art_msg['msg'] = 'PDf Updated.';
                $art_msg['type'] = 'success';
            }
            else
            {
                $art_msg['msg'] = 'Error to update PDF.';
                $art_msg['type'] = 'error';
            }
            
        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';
            
        }
        
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Test_series_pdfs', 'refresh');
        
    }
    
    public function get_select()
    {
        $response_array=array();
        $data_array=array();
        
        if(isset($_POST['id']))
        {
            $id=$_POST['id'];
            $sql="SELECT * FROM `test_series` WHERE JSON_CONTAINS(selected_exams_id, '[\"".$id."\"]') ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $response_array[]=array("id"=>$value->test_series, "name"=>$value->test_title);
                }
            }
        }
        echo json_encode($response_array);
    }

}
