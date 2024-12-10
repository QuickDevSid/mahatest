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

class Masike extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data['title'] = ucfirst('Masik'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('Masike/masike_index', $data);
        $this->load->view('Masike/masike_add',$data);
        $this->load->view('Masike/masike_edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('Masike/jscript', $data);
        
    }

    public function category()
    {
        $data['title'] = ucfirst('Masik'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('Masike/category_index', $data);
        $this->load->view('Masike/category_edit',$data);
        $this->load->view('Masike/category_add',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('Masike/category-jscript', $data);
    }

    function fetch_masike()
    {
//        $this->load->model("CurrentAffairs_model");

        $sql="SELECT * FROM masike ORDER BY masike_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
           // print_r($fetch_data);
            foreach($fetch_data as $masike)
            {
                /////////////////////////////////////////////////////////
                $sql="SELECT * FROM `masike_category` WHERE category_id =".$masike->category_id." LIMIT 1";
                // echo $sql;
//                echo $masike->masike_id." | ";
                $fetch_cat = $this->common_model->executeRow($sql);
                if($fetch_cat)
                {
                    $sub_array = array();
                    
                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getmasikeDetailsEdit(this.id)" id="edit_' . $masike->masike_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_masike" >
                       <i class="material-icons">mode_edit</i></button>
                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $masike->masike_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>';

                        $sub_array[] = $masike->title;
                        $sub_array[] = $fetch_cat->category_name;
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

    function fetch_category()
    {
        $this->load->model("CurrentAffairs_model");


        $sql="SELECT * FROM `masike_category` ORDER BY category_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $array=json_decode($row->selected_exams_id);
            if (is_array($array))
            {
            }
            else
            {
                $array=array();
                array_push($array, $row->selected_exams_id);
            }
//            print_r($array);

           if(1)
           {
                $exam_name=array();
                for($i=0; $i<sizeof($array);$i++)
                {
                   $sql="SELECT * FROM exams WHERE exam_id='".$array[$i]."' ";
                   $exam=$this->common_model->executeRow($sql);
                   $exam_name[]=$exam->exam_name;
                }
                $List = implode(', ', $exam_name);
           
            $sub_array[] = '
           <button type="button" name="Edit" onclick="getcategoryDetailsEdit(this.id)" id="edit_' . $row->category_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_post" >
           <i class="material-icons">mode_edit</i></button>

           <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $row->category_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
           <i class="material-icons">delete</i></button>
           ';
            
                $sub_array[] = $row->category_name;
                $sub_array[] = $List;
                $sub_array[] = $row->status;
                $sub_array[] = $row->created_at;
           }
            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);
    }

    public function add_data()
    {
        if(isset($_POST))
        {
            $CategoryTitle=$this->db->escape_str($_POST['CategoryTitle']);
            $Exam_Id=$_POST['Exam_Id'];

            $Exam_Id=json_encode($Exam_Id);

            $category_status=$_POST['category_status'];
            $sql="SELECT * FROM `masike_category` WHERE selected_exams_id='".$Exam_Id."' AND category_name = '".$CategoryTitle."' ";
            
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `masike_category`(`selected_exams_id`, `category_name`, `status`) VALUES ('".$Exam_Id."', '".$CategoryTitle."', '".$category_status."')";
                $this->common_model->executeNonQuery($sql);
            }
        }

        $art_msg['msg'] = 'New Masike Category Updated.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Masike/category', 'refresh');
    }
    public function update_data()
    {
        $CategoryTitle=$this->db->escape_str($_POST['CategoryTitle']);
        $Exam_Id=$_POST['Exam_Id'];
        $Exam_Id=json_encode($Exam_Id);

        $category_status=$_POST['category_status'];
        $edit_id=$_POST['edit_id'];


        $sql="UPDATE masike_category SET `selected_exams_id`='".$Exam_Id."', `category_name`='".$CategoryTitle."', `status`='".$category_status."' WHERE category_id='".$edit_id."' ";
        $this->common_model->executeNonQuery($sql);

        $art_msg['msg'] = 'Masike Category Updated.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Masike/category', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM masike_category WHERE category_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("category_id"=>$check->category_id, "selected_exams_id"=>json_decode($check->selected_exams_id), "category_name"=>$check->category_name, "status"=>$check->status);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    public function MasikeById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM masike WHERE masike_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $exam_id="";
                $sql="SELECT * FROM `masike_category` WHERE category_id='".$check->category_id."' ";
                $exam=$this->common_model->executeRow($sql);
                if($exam)
                {
                    $exam_id=$exam->selected_exams_id;
                }
                
                $return_array=array("id"=>$check->masike_id, "category"=>$check->category_id, "title"=>$check->title, "selected_exams_id"=>$exam_id, "status"=>$check->status, "description"=>$check->description);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    public function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM masike_category WHERE category_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM masike_category WHERE category_id='".$id."'";
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

    public function deleteMasike()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM masike WHERE masike_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM masike WHERE masike_id='".$id."'";
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
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/masike/thumbnails';
            $config['upload_url'] = base_url() . 'AppAPI/masike/thumbnails';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/masike/thumbnails/" . $newname);
            return $newname;
        }
    }
    function upload_pdf()
    {
        // foreach ($_FILES as $name => $fileInfopdf)

        {
            $name='masike_pdf';
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config2['upload_path'] = 'AppAPI/masike/pdf';
            $config2['upload_url'] = base_url() . 'AppAPI/masike/pdf';
            $config2['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config2['max_size'] = '2000000';
            $config2['file_name'] = $newname;
            $this->load->library('upload', $config2);
            move_uploaded_file($tmpname, "AppAPI/masike/pdf/" . $newname);
            return $newname;
        }
    }

    public function addMasike()
    {

        $image = 'study1.png';
        if ($this->input->post('masike_image')) {
            $image = $this->input->post('masike_image');
        } else {
            $image = 'study1.png';
        }
        
        // foreach ($_FILES as $name => $fileInfo) {
        $name='masike_image';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = 'study1.png';
            }
        // }


        $pdf = 'pdf1.pdf';
        if ($this->input->post('masike_pdf')) {
            $pdf = $this->input->post('masike_pdf');
        } else {
            $pdf = 'pdf1.pdf';
        }
        
        // foreach ($_FILES as $name => $fileInfopdf) {
            $name='masike_pdf';

            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_pdf();
                $pdf = $newname;
            } else {
                $pdf = 'pdf1.pdf';
            }
        // }

        $MasikeTitle=$this->db->escape_str($_POST['MasikeTitle']);
        $MasikeCategoryId=$_POST['MasikeCategoryId'];
        $Description=$this->db->escape_str($_POST['Description']);
        $masike_status=$_POST['masike_status'];
        //  echo '<pre>'; print_r($MasikeCategoryId); exit;


        if($pdf!="" && $image!="" && $MasikeTitle!="" && $MasikeCategoryId!="" && $masike_status!="" && $Description!="")
        
        {
            
            $sql="SELECT * FROM masike WHERE title like '%".$MasikeTitle."%'";
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `masike`(`category_id`, `title`, `description`, `image_url`, `pdf_url`, `status`, `created_at`) VALUES ('".$MasikeCategoryId."', '".$MasikeTitle."', '".$Description."', '".$image."', '".$pdf."' ,'".$masike_status."', '".date('Y-m-d H:i:s')."')";
//                echo $sql;
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New Masike updated Updated.';
                    $art_msg['type'] = 'success';
                }
                else
                {
                    $art_msg['msg'] = 'Error to add new Masike.';
                    $art_msg['type'] = 'error';
                }
            }
            else
            {
                $art_msg['msg'] = 'Repeat Masike.';
                $art_msg['type'] = 'error';
            }

        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';

        }

        $this->session->set_userdata('alert_msg', $art_msg);
       redirect(base_url() . 'Masike', 'refresh');

    }

    public function updateMasike()
    {
        $MasikeTitle=$this->db->escape_str($_POST['MasikeTitle']);
        $MasikeCategoryId=$_POST['MasikeCategoryId'];
        $Description=$this->db->escape_str($_POST['Description']);
        $masike_status=$_POST['masike_status'];
        $edit_id=$_POST['edit_id'];

        $sql="SELECT * FROM masike WHERE masike_id='".$edit_id."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {

            $name='masike_image';
                if (!empty($_FILES[$name]['name'])) {
                    $newname = $this->upload();
                    $image = $newname;
                } else {
                    $image = $check->image_url;//'study1.png';
                }

                $name='masike_pdf';

                if (!empty($_FILES[$name]['name'])) {
                    $newname = $this->upload_pdf();
                    $pdf = $newname;
                } else {
                    $pdf = $check->pdf_url;//'pdf1.pdf';
                }

                $sql="UPDATE masike SET `category_id`='".$MasikeCategoryId."', `title`='".$MasikeTitle."', `description`='".$Description."', `image_url`='".$image."', `pdf_url`='".$pdf."', `status`='".$masike_status."' WHERE masike_id='".$edit_id."' ";
                // echo $sql;exit(0);
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'Masike Updated.';
                    $art_msg['type'] = 'success';
                }
                else
                {
                    $art_msg['msg'] = 'Error to update masike.';
                    $art_msg['type'] = 'error';
                }

        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';

        }

       $this->session->set_userdata('alert_msg', $art_msg);
       redirect(base_url() . 'Masike', 'refresh');

    }

    public function get_select()
    {
        $response_array=array();
        $data_array=array();

        if(isset($_POST['id']))
        {
            $id=$_POST['id'];
            $sql="SELECT * FROM `masike_category` WHERE JSON_CONTAINS(selected_exams_id, '[\"".$id."\"]') ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $response_array[]=array("id"=>$value->category_id, "name"=>$value->category_name);
                }
            }
        }
        echo json_encode($response_array);
    }

}
