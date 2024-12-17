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

class Push_notification extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function all()
    {

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('push_notification/all', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('push_notification/jscript.php', $data);
        
    }
    
    function upload()
    {
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/upload';
            $config['upload_url'] = base_url() . 'AppAPI/upload';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/upload/" . $newname);
            return $newname;
        }
    }
    
    public function sent_to_all()
    {
        $title=$_POST['Title'];
        $msg=$_POST['msg'];
    
        $image = '';
        if ($this->input->post('image')) {
            $image = $this->input->post('image');
        } else {
            $image = '';
        }
    
        // foreach ($_FILES as $name => $fileInfo) {
        $name='image';
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload();
            $image = base_url() . "AppAPI/upload/" . $newname;
        } else {
            $image = '';
        }
        
        
        $art_msg['msg'] = 'Something Error.';
        $art_msg['type'] = 'error';

        if($title!="" && $msg!="")
        {
            $sql="SELECT * FROM user_login WHERE status='Active' ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $array=array();
                    $to=$value->device_id;
                    $this->push_notification($to, $title,$msg, $array);

                   $json = '';

			        $res = array();
			        $res['data']['title'] = $title;
			        $res['data']['message'] = $msg;
			        $res['data']['image'] = $image;
			        $res['data']['timestamp'] = date('Y-m-d G:i:s');

			        $json = $res;

			        $fields = array(
			            'to' => $value->device_id,
			            'data' => $json,
			        );

			        $this->sendPushNotification($fields);
                }
                $art_msg['msg'] = 'Message sent..';
                $art_msg['type'] = 'success';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Push_notification/all', 'refresh');
    }


    function group()
    {

        // echo '$(function () { $("#group").addClass("active");}); ';
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('push_notification/group', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('push_notification/jscript.php', $data);
        
    }

    
    public function sent_to_group()
    {
        $title=$_POST['Title'];
        $msg=$_POST['msg'];
    
        $image = '';
        if ($this->input->post('image')) {
            $image = $this->input->post('image');
        } else {
            $image = '';
        }
    
        // foreach ($_FILES as $name => $fileInfo) {
        $name='image';
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload();
            $image = base_url() . "AppAPI/upload/" . $newname;
        } else {
            $image = '';
        }
        
        $art_msg['msg'] = 'Something Error.';
        $art_msg['type'] = 'error';

        if($title!="" && $msg!="")
        {

            $array_ids = implode(",",$_POST['Exam_Id']);

            // echo $array_ids;
            $sql="SELECT * FROM user_login WHERE status='Active' AND selected_exams_id IN(".$array_ids.") ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $array=array();
                    $to=$value->device_id;
                    $this->push_notification($to, $title,$msg, $array);

                    $json = '';

			        $res = array();
			        $res['data']['title'] = $title;
			        $res['data']['message'] = $msg;
			        $res['data']['image'] = $image;
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
        $this->session->set_userdata('alert_msg', $art_msg);
       redirect(base_url() . 'Push_notification/group', 'refresh');
    }

    
    function single()
    {
        // echo '$(function () { $("#single").addClass("active");}); ';
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('push_notification/single', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('push_notification/jscript.php', $data);
        
    }

    public function sent_to_single()
    {
        $title=$_POST['Title'];
        $msg=$_POST['msg'];
    
        $image = '';
        if ($this->input->post('image')) {
            $image = $this->input->post('image');
        } else {
            $image = '';
        }
    
        // foreach ($_FILES as $name => $fileInfo) {
        $name='image';
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload();
            $image = base_url() . "AppAPI/upload/" . $newname;
        } else {
            $image = '';
        }
        
        $art_msg['msg'] = 'Something Error.';
        $art_msg['type'] = 'error';
       // $email=$_POST['email'];
        if($title!="" && $msg!="")
        {
$array_ids = implode(",",$_POST['email']);

            // echo $array_ids;
            $sql="SELECT * FROM user_login WHERE status='Active' AND email IN('".$array_ids."') ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $array=array();
                    $to=$value->device_id;
                   $this->push_notification($to, $title,$msg, $array);

					$json = '';

			        $res = array();
			        $res['data']['title'] = $title;
			        $res['data']['message'] = $msg;
			        $res['data']['image'] = $image;
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
        $this->session->set_userdata('alert_msg', $art_msg);
       redirect(base_url() . 'Push_notification/single', 'refresh');
    }



    public function push_notification($to, $title,$msg, $array)
    {
        return 1;
        $access_key="AAAAs0bzUV8:APA91bE4m4EG3lAISVoEfUgtJ-vdgByrIewOh51qfk0lytizVb5JJ1IrYt-gsSXF7vKdSoDGkjscPfV1kUxQNh3hn54MLhVgCpvU0nD9f9A7LngQ2Nglqqeq028qBSeyKTqS3saUYygh";
        
        $fcmMsg = array(
            'body' => $msg,
            'title' => $title,
            'sound' => "default",
            'color' => "#203E78",
            'icon'  => '',
        );
//        $array//extra information
        $fcmFields = array(
            'to' => $to,
            'priority' => 'high',
            'notification' => $fcmMsg,
            'data'=>$array
        );
        
        
        $headers = array(
            'Authorization: key=' . $access_key,
            'Content-Type: application/json'
        );
        $url="https://fcm.googleapis.com/fcm/send";
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $url );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
    }


  // function makes curl request to firebase servers
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
}
