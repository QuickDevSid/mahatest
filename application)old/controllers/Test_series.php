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

class Test_series extends CI_Controller
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
        $this->load->view('test_series/index', $data);
        $this->load->view('test_series/add',$data);
        $this->load->view('test_series/edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $sql="SELECT * FROM test_series ORDER BY test_series DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
//            print_r($fetch_data);
            foreach($fetch_data as $test_series)
            {
                /////////////////////////////////////////////////////////
                if(1)
                {
                    $array=json_decode($test_series->selected_exams_id);
                    if (is_array($array))
                    {
                    }
                    else
                    {
                        $array=array();
                        array_push($array, $test_series->selected_exams_id);
                    }
                    $exam_name=array();
                    for($i=0; $i<sizeof($array);$i++)
                    {
                       $sql="SELECT * FROM exams WHERE exam_id='".$array[$i]."' ";
                       $exam=$this->common_model->executeRow($sql);
                       $exam_name[]=$exam->exam_name;
                    }
                    $List = implode(', ', $exam_name);

                    $sub_array = array();
                    if(1)
                    {
                   
                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $test_series->test_series  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $test_series->test_series  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $test_series->test_title;
                        $sub_array[] = $List;
                        $sub_array[] = $test_series->test_price;
                        $sub_array[] = $test_series->test_exams;
                        $sub_array[] = $test_series->status;
                        $sub_array[] = $test_series->created_at;
                   }
                    $data[] = $sub_array;
                }

                /////////////////////////////////////////////////////////
            }
        }


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);
    }
    function add_data()
    {
        if(isset($_POST))
        {
            $title=$this->db->escape_str($_POST['TestSeriesTitle']);
            $Exam_Id=$_POST['Exam_Id'];
            $Exam_Id=json_encode($Exam_Id);
            $status=$_POST['status'];
            $test_price=$_POST['test_price'];
            $test_exams=$_POST['test_exams'];
            $test_details=$this->db->escape_str($_POST['test_details']);
            
    
            $image = 'study1.png';
            if ($this->input->post('test_image')) {
                $image = $this->input->post('test_image');
            } else {
                $image = 'study1.png';
            }
    
            // foreach ($_FILES as $name => $fileInfo) {
            $name='test_image';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = 'study1.png';
            }
            // }
    
            
            $sql="SELECT * FROM `test_series` WHERE test_title = '".$title."' ";
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `test_series`(`selected_exams_id`, `test_title`, `status`, `created_at`, `test_price`, `test_exams`, `test_details`, `test_image`) VALUES ('".$Exam_Id."', '".$title."', '".$status."', '".date('Y-m-d H:i:s')."', '".$test_price."', '".$test_exams."', '".$test_details."', '".$image."')";
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New test series updated.';
                    $art_msg['type'] = 'success';
                }
                else
                {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            }
            else
            {
                $art_msg['msg'] = 'New test series already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Test_series', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM test_series WHERE test_series='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->test_series, "exam_id"=>json_decode($check->selected_exams_id), "title"=>$check->test_title, "status"=>$check->status, "test_price"=>$check->test_price, "test_exams"=>$check->test_exams, "test_details"=>$check->test_details);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    public function update_data()
    {

        $title=$this->db->escape_str($_POST['TestSeriesTitle']);
        $Exam_Id=$_POST['Exam_Id'];
        $Exam_Id=json_encode($Exam_Id);
        $status=$_POST['status'];
        $edit_id=$_POST['edit_id'];
        $test_price=$_POST['test_price'];
        $test_exams=$_POST['test_exams'];
        $test_details=$this->db->escape_str($_POST['test_details']);
    
    
        $image = 'study1.png';
        
        
        $sql="SELECT * FROM test_series WHERE test_series='".$edit_id."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            $name='test_image';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = $check->test_image;//'study1.png';
            }
            
            
            $sql="UPDATE test_series SET `selected_exams_id`='".$Exam_Id."', `test_title`='".$title."', `status`='".$status."', `test_price`='".$test_price."', `test_exams`='".$test_exams."', `test_details`='".$test_details."', `test_image`='".$image."' WHERE test_series='".$edit_id."' ";
            
            $update=$this->common_model->executeNonQuery($sql);
            
    
            if($update)
            {
                $art_msg['msg'] = 'Test series Updated.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
            else
            {
                $art_msg['msg'] = 'Error to update test series.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';
    
        }
        


        redirect(base_url() . 'Test_series', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM test_series WHERE test_series='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM test_series WHERE test_series='".$id."'";
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
        $name='test_image';
        $filename = $_FILES[$name]['name'];
        $tmpname = $_FILES[$name]['tmp_name'];
        
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/test_series';
            $config['upload_url'] = base_url() . 'AppAPI/test_series';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/test_series/" . $newname);
            return $newname;
        }
    
}
?>
