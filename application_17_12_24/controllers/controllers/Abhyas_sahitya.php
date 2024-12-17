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

class Abhyas_sahitya extends CI_Controller
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
        $this->load->view('Abhyas_sahitya/abhyas_sahitya', $data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_add', $data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_edit', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('Abhyas_sahitya/abhyas_sahitya_jscript.php', $data);
        
    }
    function fetch_abhyas_sahitya()
    {
//        $this->load->model("CurrentAffairs_model");

        $sql="SELECT * FROM abhyas_sahitya ORDER BY abhyas_sahitya_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
//            print_r($fetch_data);
            foreach($fetch_data as $abhyas_sahitya)
            {
                /////////////////////////////////////////////////////////
                $sql="SELECT * FROM `abhyas_sahitya_category` WHERE abhyas_sahitya_category_id=".$abhyas_sahitya->abhyas_sahitya_category_id." ORDER BY abhyas_sahitya_category_id DESC";
                // echo $sql;
                $fetch_cat = $this->common_model->executeRow($sql);
                if($fetch_cat)
                {

                    $sql="SELECT * FROM `abhyas_sahitya_category` WHERE abhyas_sahitya_category_id=".$abhyas_sahitya->abhyas_sahitya_category_id." ";
                    // echo $sql;
                    $fetch_sub = $this->common_model->executeRow($sql);


                    $sub_array = array();
                    if($fetch_sub)
                    {
                   
                        // $sql="SELECT * FROM `abhyas_sahitya_category_subject` WHERE `abhyas_sahitya_category_id`=".$abhyas_sahitya->abhyas_sahitya_category_id."  ";
                        // $subject=$this->common_model->executeRow($sql);

                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $abhyas_sahitya->abhyas_sahitya_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_abhyas_sahitya" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $abhyas_sahitya->abhyas_sahitya_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $abhyas_sahitya->title;
                        $sub_array[] = $fetch_cat->category_name;
                        // $sub_array[] = $fetch_sub->subject_name;
                        $sub_array[] = $abhyas_sahitya->status;
                        $sub_array[] = $abhyas_sahitya->created_at;
                        $data[] = $sub_array;
                   }
                }

                /////////////////////////////////////////////////////////
            }
        }
        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);
    }

    public function Abhyas_sahityaById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM abhyas_sahitya WHERE abhyas_sahitya_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {

                $exam_id="";
                $sql="SELECT * FROM `abhyas_sahitya_category` WHERE abhyas_sahitya_category_id='".$check->abhyas_sahitya_category_id."' ";
                $exam=$this->common_model->executeRow($sql);
                if($exam)
                {
                    $exam_id=json_decode($exam->selected_exams_id);
                }


                $return_array=array("selected_exams_id"=>$exam_id,"abhyas_sahitya_id"=>$check->abhyas_sahitya_id, "abhyas_sahitya_category_id"=>$check->abhyas_sahitya_category_id, "abhyasSahtyaTitle"=>$check->title,"description"=>$check->description , "status"=>$check->status);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    function upload()
    {
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/abhyas_sahitya/thumbnails';
            $config['upload_url'] = base_url() . 'AppAPI/abhyas_sahitya/thumbnails';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/abhyas_sahitya/thumbnails/" . $newname);
            return $newname;
        }
    }
    function upload_pdf()
    {
        // foreach ($_FILES as $name => $fileInfopdf)

        {
            $name='abhyas_sahitya_pdf';
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config2['upload_path'] = 'AppAPI/abhyas_sahitya/pdf';
            $config2['upload_url'] = base_url() . 'AppAPI/abhyas_sahitya/pdf';
            $config2['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config2['max_size'] = '2000000';
            $config2['file_name'] = $newname;
            $this->load->library('upload', $config2);
            move_uploaded_file($tmpname, "AppAPI/abhyas_sahitya/pdf/" . $newname);
            return $newname;
        }
    }

    public function addAbhyasSahitya()
    {

        $image = 'study1.png';
        if ($this->input->post('abhyas_sahitya_image')) {
            $image = $this->input->post('abhyas_sahitya_image');
        } else {
            $image = 'study1.png';
        }
        
        // foreach ($_FILES as $name => $fileInfo) {
        $name='abhyas_sahitya_image';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = 'study1.png';
            }
        // }


        $pdf = 'pdf1.pdf';
        if ($this->input->post('abhyas_sahitya_pdf')) {
            $pdf = $this->input->post('abhyas_sahitya_pdf');
        } else {
            $pdf = 'pdf1.pdf';
        }
        
        // foreach ($_FILES as $name => $fileInfopdf) {
            $name='abhyas_sahitya_pdf';

            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_pdf();
                $pdf = $newname;
            } else {
                $pdf = 'pdf1.pdf';
            }
        // }

        $AbhyasSahtyaTitle=$this->db->escape_str($_POST['AbhyasSahtyaTitle']);
        $AbhyasSahityaCategoryId=$_POST['AbhyasSahityaCategoryId'];
        $Description=$this->db->escape_str($_POST['Description']);
        $AbhyasSahitya_status=$_POST['AbhyasSahitya_status'];

        $Description = str_replace('\r\n', '', $Description);
        
        if($AbhyasSahtyaTitle!="" && $AbhyasSahityaCategoryId!="" && $AbhyasSahitya_status!="" && $Description!="")
        {
            $sql="SELECT * FROM abhyas_sahitya WHERE title like '%".$AbhyasSahtyaTitle."%'";
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `abhyas_sahitya`(`abhyas_sahitya_category_id`, `title`, `description`, `image_url`, `pdf_url`, `status`, `created_at`) VALUES ('".$AbhyasSahityaCategoryId."', '".$AbhyasSahtyaTitle."', '".$Description."', '".$image."', '".$pdf."' ,'".$AbhyasSahitya_status."', '".date('Y-m-d H:i:s')."')";
//                echo $sql;
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                  //  $this->sent_push_notification("New Publication in Abhyas Sahitya", "New Content Added - ".$AbhyasSahtyaTitle, json_encode($this->get_exam($AbhyasSahityaCategoryId)));
                    
                    $art_msg['msg'] = 'New Abhyas Sahitya Added.';
                    $art_msg['type'] = 'success';
                }
                else
                {
                    $art_msg['msg'] = 'Error to add new Abhyas Sahitya.';
                    $art_msg['type'] = 'error';
                }
            }
            else
            {
                $art_msg['msg'] = 'Repeat Abhyas Sahitya.';
                $art_msg['type'] = 'error';
            }

        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';

        }

        $this->session->set_userdata('alert_msg', $art_msg);
       redirect(base_url() . 'Abhyas_sahitya', 'refresh');

    }

    
    public function editAbhyasSahitya()
    {

        
        // foreach ($_FILES as $name => $fileInfo) {
        $name='abhyas_sahitya_image';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = '';
            }
        // }

        
        // foreach ($_FILES as $name => $fileInfopdf) {
            $name='abhyas_sahitya_pdf';

            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_pdf();
                $pdf = $newname;
            } else {
                $pdf = '';
            }
        // }

        $edit_id=$_POST['edit_id'];
        $AbhyasSahtyaTitle=$this->db->escape_str($_POST['edit_AbhyasSahtyaTitle']);
        $AbhyasSahityaCategoryId=$_POST['edit_AbhyasSahityaCategoryId'];
        $Description=$this->db->escape_str($_POST['edit_Description']);
        $AbhyasSahitya_status=$_POST['edit_abhyasSahitya_status'];

        $Description = str_replace('\r\n', '', $Description);
        
        // print_r($_POST);
        if($AbhyasSahtyaTitle!="" && $AbhyasSahityaCategoryId!="" && $AbhyasSahitya_status!="" && $Description!="")
        {
            $sql="SELECT * FROM abhyas_sahitya WHERE  abhyas_sahitya_id=".$edit_id." ";
            // echo $sql;
            // echo "Hii";

            $check=$this->common_model->executeRow($sql);
            if($check)
            {

                echo "Hii";

                if($image!="")
                {
                    $img_txt=" , `image_url`='".$image."' ";
                }
                else
                {
                    $img_txt='';
                }

                if($pdf!="")
                {
                    $pdf_txt=" , `pdf_url`='".$pdf."' ";
                }
                else
                {
                    $pdf_txt='';
                }
            // echo $sql;


                $sql="UPDATE abhyas_sahitya SET `abhyas_sahitya_category_id`='".$AbhyasSahityaCategoryId."', `title`='".$AbhyasSahtyaTitle."', `description`='".$Description."' ".$pdf_txt." ".$img_txt." WHERE abhyas_sahitya_id=".$edit_id." ";
            // echo $sql;
            // exit(0);
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'Abhyas Sahitya edited.';
                    $art_msg['type'] = 'success';
                }
                else
                {
                    $art_msg['msg'] = 'Error to edit Abhyas Sahitya.';
                    $art_msg['type'] = 'error';
                }
            }
            else
            {
                $art_msg['msg'] = 'Repeat Abhyas Sahitya.';
                $art_msg['type'] = 'error';
            }

        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';

        }

        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Abhyas_sahitya', 'refresh');
    }

    function deleteAbhyas_sahitya()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM abhyas_sahitya WHERE abhyas_sahitya_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM abhyas_sahitya WHERE abhyas_sahitya_id='".$id."'";
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

    public function get_select()
    {
        $response_array=array();
        $data_array=array();

        if(isset($_POST['id']))
        {
            $id=$_POST['id'];
            // $sql="SELECT * FROM `abhyas_sahitya_category` WHERE selected_exams_id='".$id."' ";

            $sql="SELECT * FROM `abhyas_sahitya_category` WHERE JSON_CONTAINS(selected_exams_id, '[\"".$id."\"]') ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $response_array[]=array("id"=>$value->abhyas_sahitya_category_id, "name"=>$value->category_name);
                }
            }
        }
        echo json_encode($response_array);
    }
    
    
    public function sent_push_notification($title1, $message, $exam)
    {
        $title=$title1;
        $msg=$message;
        
        if($title!="" && $msg!="")
        {
            
            $array_ids = implode(",",$exam);
            
            // echo $array_ids;
            $sql="SELECT * FROM user_login WHERE status='Active' AND selected_exams_id IN(".$array_ids.") ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $array=array();
                    $to=$value->device_id;
                    $json = '';
                    
                    $res = array();
                    $res['data']['title'] = $title;
                    $res['data']['message'] = $msg;
                    $res['data']['image'] = '';
                    $res['data']['timestamp'] = date('Y-m-d G:i:s');
                    
                    $json = $res;
                    
                    $fields = array(
                        'to' => $value->device_id,
                        'data' => $json,
                    );
                    
                    $this->sendPushNotification($fields);
                    
                }
                $art_msg['msg'] = 'Message sent.';
                $art_msg['type'] = 'success';
                
            }
        }
        return true;
    }
    
    private function sendPushNotification($fields) {
        
        $access_key="AAAAs0bzUV8:APA91bE4m4EG3lAISVoEfUgtJ-vdgByrIewOh51qfk0lytizVb5JJ1IrYt-gsSXF7vKdSoDGkjscPfV1kUxQNh3hn54MLhVgCpvU0nD9f9A7LngQ2Nglqqeq028qBSeyKTqS3saUYygh";
        
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $headers = array(
            'Authorization: key=' . $access_key,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
        
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        
        // Close connection
        curl_close($ch);
        
        return $result;
    }
    
    public function get_exam($id)
    {
        if(isset($id))
        {
            $sql="SELECT * FROM `abhyas_sahitya_category` WHERE abhyas_sahitya_category_id = '".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                    return $check->selected_exams_id;
            }
        }
        return "";
    }
}
