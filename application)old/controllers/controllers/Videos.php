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

class Videos extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }
    
    //functions
    function index()
    {
        $data=[];
        $data['title'] = ucfirst('Videos'); // Capitalize the first letter
        $this->load->model('Exam_model');
        $examArr=$this->Exam_model->getAllData();
        $data['examArr']=$examArr;
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('videos/index', $data);
        $this->load->view('videos/add_youtube', $data);
        $this->load->view('videos/edit_youtube', $data);
        $this->load->view('videos/add_vimeo', $data);
        $this->load->view('videos/edit_vimeo', $data);
        $this->load->view('videos/add_upload', $data);
        $this->load->view('videos/edit_upload', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('videos/jscript.php', $data);
        
    }
    
    function fetch_data()
    {
        
        $this->load->model("Videos_model");
        $this->load->model("Exam_model");
        $fetch_data = $this->Videos_model->make_datatables();
        //print_r($fetch_data);die;
        if ($fetch_data) {
            foreach ($fetch_data as $videos) {
                /////////////////////////////////////////////////////////
                if (1) {
                    $array = json_decode($videos->selected_exams_id);
                    //print_r($array);die;
                    if (is_array($array)) {
                    } else {
                        $array = array();
                        array_push($array, $videos->selected_exams_id);
                    }
                    $exam_name = array();
                    for ($i = 0; $i < sizeof($array); $i++) {
                        //echo $array[$i];die;
                        $exam = $this->Exam_model->getPostById((int)$array[$i]);
                        //print_r($exam);die;
                        $exam_name[] = $exam->exam_name;
                    }
                    $List = implode(', ', $exam_name);
                    
                    $button = '';
                    $sub_array = array();
                    if (1) {
                        
                        if ($videos->output == 'youtube') {
                            $button = '<button type="button" name="Edit" onclick="getDetailsEditYoutube(this.id)" id="edit_' . $videos->video_id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_youtube" >
                       <i class="material-icons">mode_edit</i></button>
                       ';
                        } elseif ($videos->output == 'exo_player') {
                            $button = '<button type="button" name="Edit" onclick="getDetailsEditUpload(this.id)" id="edit_' . $videos->video_id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_upload" >
                       <i class="material-icons">mode_edit</i></button>
                       ';
                        } elseif ($videos->output == 'vimeo') {
                            $button = '<button type="button" name="Edit" onclick="getDetailsEditVimeo(this.id)" id="edit_' . $videos->video_id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_vimeo" >
                       <i class="material-icons">mode_edit</i></button>
                       ';
                        }
                        
                        $sub_array[] = $button . '<button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $videos->video_id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';
    
    
    
                        $sub_array[] = $videos->video_title;
                        $sub_array[] = $List;
                        if ($videos->output == "exo_player") {
                            $sub_array[] = '<a href="' . $videos->video_url . '" target="_blank">View</a>';
                        } else {
                            $sub_array[] = $videos->video_url;
                        }
                        
                        
                        $sub_array[] = $videos->video_duration;
                        $sub_array[] = $videos->status;
                        $sub_array[] = date('d-m-Y H:i:s',strtotime($videos->created_at));
                    }
                    $data[] = $sub_array;
                }
                
                /////////////////////////////////////////////////////////
            }
        }
        
        
        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);
    }
    
    function upload($nam)
    {
        $name=$nam;
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/video';
            $config['upload_url'] = base_url() . 'AppAPI/video';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/video/" . $newname);
            return $newname;
       
    }
    
    function upload_video($nam)
    {
    
        $name=$nam;
        $filename = $_FILES[$name]['name'];
        $tmpname = $_FILES[$name]['tmp_name'];
        $exp = explode('.', $filename);
        $ext = end($exp);
        $newname = $exp[0] . '_' . time() . "." . $ext;
        $config2['upload_path'] = 'AppAPI/video/';
        $config2['upload_url'] = base_url() . 'AppAPI/video/';
        $config2['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
        $config2['max_size'] = '2000000';
        $config2['file_name'] = $newname;
        $this->load->library('upload', $config2);
        move_uploaded_file($tmpname, "AppAPI/video/" . $newname);
        return $newname;

    }
    
    function add_data_youtube()
    {
        if (isset($_POST)) {
            $Title = $this->db->escape_str($_POST['Title_y']);
            $URL = $this->db->escape_str($_POST['URL_y']);
            $duration = $this->db->escape_str($_POST['duration_y']);
            $video_status = $this->db->escape_str($_POST['video_status_y']);
            $Thumbnail = $this->db->escape_str($_POST['Thumbnail_y']);
            $output_type = 'youtube';
            $status = $_POST['status_y'];
            $exams = $_POST['exams_y'];
            $exams = json_encode($exams);
            
             $description = $this->db->escape_str($_POST['description_y']);
             
            $image = 'placeholder.png';
            if ($this->input->post('Thumbnail_y')) {
                $image = $this->input->post('Thumbnail_y');
            } else {
                $image = 'placeholder.png';
            }
    
            $name='Thumbnail_y';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload($name);
                $image = base_url() . "AppAPI/video/" . $newname;
            } else {
                $image =  base_url() . "AppAPI/video/" . 'placeholder.png';
            }
            
            $sql = "SELECT * FROM `videos` WHERE selected_exams_id='" . $exams . "' AND video_title = '" . $Title . "' ";
            // echo $sql;
            $check = $this->common_model->executeRow($sql);
            if (!$check) {
                $sql = "INSERT INTO `videos`(`selected_exams_id`, `video_title`, `payment_status`,`output`,`status`, `created_at`, `video_url`, `video_duration`, `video_thumbnail`, `description`) VALUES ('" . $exams . "', '" . $Title . "' ,'" . $video_status . "', '" . $output_type . "','" . $status . "', '" . date('Y-m-d H:i:s') . "', '" . $URL . "', '" . $duration . "', '" . $image . "', '" . $description . "')";
                $insert = $this->common_model->executeNonQuery($sql);
                if ($insert) {
                    $art_msg['msg'] = 'New Videos Added.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            } else {
                $art_msg['msg'] = 'Videos already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        
        redirect(base_url() . 'Videos', 'refresh');
        
    }
    
    function add_data_upload()
    {
        if (isset($_POST)) {
            $Title = $this->db->escape_str($_POST['Title_u']);
            $URL = $this->db->escape_str($_POST['URL_u']);
            $duration = $this->db->escape_str($_POST['duration_u']);
            $video_status = $this->db->escape_str($_POST['video_status_u']);
            $Thumbnail = $this->db->escape_str($_POST['Thumbnail_u']);
            $output_type = 'exo_player';
            $status = $_POST['status_u'];
            $exams = $_POST['exams_u'];
            $exams = json_encode($exams);
            $description = $this->db->escape_str($_POST['description_u']);
            
            $image = 'placeholder.png';
            if ($this->input->post('Thumbnail_u')) {
                $image = $this->input->post('Thumbnail_u');
            } else {
                $image = 'placeholder.png';
            }
            
            $name='Thumbnail_u';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload($name);
                $image = base_url() . "AppAPI/video/" . $newname;
            } else {
                $image =  base_url() . "AppAPI/video/" . 'placeholder.png';
            }
    
    
    
            $pdf = 'placeholder.mp4';
            if ($this->input->post('URL_u')) {
                $pdf = $this->input->post('URL_u');
            } else {
                $pdf = 'placeholder.mp4';
            }
    
            $name='URL_u';
    
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_video($name);
                $pdf = base_url() . "AppAPI/video/" . $newname;
            } else {
                $pdf = base_url() . "AppAPI/video/" . 'placeholder.mp4';
            }
            
            $sql = "SELECT * FROM `videos` WHERE selected_exams_id='" . $exams . "' AND video_title = '" . $Title . "' ";
            // echo $sql;
            $check = $this->common_model->executeRow($sql);
            if (!$check) {
                $sql = "INSERT INTO `videos`(`selected_exams_id`, `video_title`, `payment_status`,`output`,`status`, `created_at`, `video_url`, `video_duration`, `video_thumbnail`, `description`) VALUES ('" . $exams . "', '" . $Title . "' ,'" . $video_status . "', '" . $output_type . "','" . $status . "', '" . date('Y-m-d H:i:s') . "', '" . $pdf . "', '" . $duration . "', '" . $image . "', '" . $description . "')";
                $insert = $this->common_model->executeNonQuery($sql);
                if ($insert) {
                    $art_msg['msg'] = 'New Videos Added.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            } else {
                $art_msg['msg'] = 'Videos already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        
        redirect(base_url() . 'Videos', 'refresh');
        
    }
    
    function add_data_vimeo()
    {
        if (isset($_POST)) {
            $Title = $this->db->escape_str($_POST['Title_v']);
            $URL = $this->db->escape_str($_POST['URL_v']);
            $duration = $this->db->escape_str($_POST['duration_v']);
            $video_status = $this->db->escape_str($_POST['video_status_v']);
            $Thumbnail = $this->db->escape_str($_POST['Thumbnail_v']);
            $output_type = 'vimeo';
            $status = $_POST['status_v'];
            $exams = $_POST['exams_v'];
            $exams = json_encode($exams);
            $description = $this->db->escape_str($_POST['description_v']);
            
            $image = 'placeholder.png';
            if ($this->input->post('Thumbnail_v')) {
                $image = $this->input->post('Thumbnail_v');
            } else {
                $image = 'placeholder.png';
            }
            
            $name='Thumbnail_v';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload($name);
                $image = base_url() . "AppAPI/video/" . $newname;
            } else {
                $image =  base_url() . "AppAPI/video/" . 'placeholder.png';
            }
            
            $sql = "SELECT * FROM `videos` WHERE selected_exams_id='" . $exams . "' AND video_title = '" . $Title . "' ";
            // echo $sql;
            $check = $this->common_model->executeRow($sql);
            if (!$check) {
                $sql = "INSERT INTO `videos`(`selected_exams_id`, `video_title`, `payment_status`,`output`,`status`, `created_at`, `video_url`, `video_duration`, `video_thumbnail`, `description`) VALUES ('" . $exams . "', '" . $Title . "' ,'" . $video_status . "', '" . $output_type . "','" . $status . "', '" . date('Y-m-d H:i:s') . "', '" . $URL . "', '" . $duration . "', '" . $image . "', '" . $description . "')";
                $insert = $this->common_model->executeNonQuery($sql);
                if ($insert) {
                    $art_msg['msg'] = 'New Videos Added.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            } else {
                $art_msg['msg'] = 'Videos already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        
        redirect(base_url() . 'Videos', 'refresh');
        
    }
    
    public function CategoryById($id = "")
    {
        $return_array = array();
        if ($id != "") {
            $sql = "SELECT * FROM videos WHERE video_id='" . $id . "' ";
            $check = $this->common_model->executeRow($sql);
            if ($check) {
                $return_array = array("id" => $check->video_id, "selected_exams_id" => json_decode($check->selected_exams_id), "payment_status" => $check->payment_status, "output" => $check->output, "video_title" => $check->video_title, "video_url" => $check->video_url, "video_duration" => $check->video_duration, "status" => $check->status, "video_thumbnail" => $check->video_thumbnail, "description" => $check->description);
            }
        } else {
        
        }
        echo json_encode($return_array);
    }
    
    public function update_data_youtube()
    {
        $id = $this->db->escape_str($_POST['edit_id_y']);
    
        $Title = $this->db->escape_str($_POST['edit_Title_y']);
        $URL = $this->db->escape_str($_POST['edit_URL_y']);
        $duration = $this->db->escape_str($_POST['edit_duration_y']);
        $video_status = $this->db->escape_str($_POST['edit_video_status_y']);
        $Thumbnail = $this->db->escape_str($_POST['edit_Thumbnail_y']);
        $output_type = 'youtube';
        $status = $_POST['edit_status_y'];
        $exams = $_POST['edit_exams_y'];
        $exams = json_encode($exams);
        $description = $this->db->escape_str($_POST['edit_description_y']);
        
        $image = 'placeholder.png';
        if ($this->input->post('edit_Thumbnail_y')) {
            $image = $this->input->post('edit_Thumbnail_y');
        } else {
            $image = 'placeholder.png';
        }
    
        $name='edit_Thumbnail_y';
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload($name);
            $image = base_url() . "AppAPI/video/" . $newname;
        } else {
            $image =  base_url() . "AppAPI/video/" . 'placeholder.png';
        }
        
        $sql = "SELECT * FROM videos WHERE video_id='" . $id . "' ";
        $check = $this->common_model->executeRow($sql);
        if ($check) {
            

            
            if ($image == 'placeholder.png'){
                $sql = "UPDATE videos SET `video_title`='" . $Title . "', `selected_exams_id`='" . $exams . "', `payment_status`='" . $video_status . "',`output`='" . $output_type . "', `video_url`='" . $URL . "', `video_duration`='" . $duration . "', status='" . $status . "', description='" . $description . "' WHERE video_id='" . $id . "' ";
            }else{
                $sql = "UPDATE videos SET `video_title`='" . $Title . "', `selected_exams_id`='" . $exams . "', `payment_status`='" . $video_status . "',`output`='" . $output_type . "', `video_url`='" . $URL . "', `video_duration`='" . $duration . "', video_thumbnail='" . $image . "', status='" . $status . "', description='" . $description . "' WHERE video_id='" . $id . "' ";
            }
            
            $update = $this->common_model->executeNonQuery($sql);
            if ($update) {
                $art_msg['msg'] = 'videos Updated.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            } else {
                $art_msg['msg'] = 'Error to update videos.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        } else {
            $art_msg['msg'] = 'Something Error.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
            
        }
        
        redirect(base_url() . 'Videos', 'refresh');
    }
    
    
    public function update_data_vimeo()
    {
        $id = $this->db->escape_str($_POST['edit_id_v']);
    
        $Title = $this->db->escape_str($_POST['edit_Title_v']);
        $URL = $this->db->escape_str($_POST['edit_URL_v']);
        $duration = $this->db->escape_str($_POST['edit_duration_v']);
        $video_status = $this->db->escape_str($_POST['edit_video_status_v']);
        $Thumbnail = $this->db->escape_str($_POST['edit_Thumbnail_v']);
        $output_type = 'vimeo';
        $status = $_POST['edit_status_v'];
        $exams = $_POST['edit_exams_v'];
        $exams = json_encode($exams);
        $description = $this->db->escape_str($_POST['edit_description_v']);
        
        $image = 'placeholder.png';
        if ($this->input->post('edit_Thumbnail_v')) {
            $image = $this->input->post('edit_Thumbnail_v');
        } else {
            $image = 'placeholder.png';
        }
    
        $name='edit_Thumbnail_v';
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload($name);
            $image = base_url() . "AppAPI/video/" . $newname;
        } else {
            $image =  base_url() . "AppAPI/video/" . 'placeholder.png';
        }
        
        $sql = "SELECT * FROM videos WHERE video_id='" . $id . "' ";
        $check = $this->common_model->executeRow($sql);
        if ($check) {
            
            
            
            if ($image == 'placeholder.png'){
                $sql = "UPDATE videos SET `video_title`='" . $Title . "', `selected_exams_id`='" . $exams . "', `payment_status`='" . $video_status . "',`output`='" . $output_type . "', `video_url`='" . $URL . "', `video_duration`='" . $duration . "', status='" . $status . "' , description='" . $description . "' WHERE video_id='" . $id . "' ";
            }else{
                $sql = "UPDATE videos SET `video_title`='" . $Title . "', `selected_exams_id`='" . $exams . "', `payment_status`='" . $video_status . "',`output`='" . $output_type . "', `video_url`='" . $URL . "', `video_duration`='" . $duration . "', video_thumbnail='" . $image . "', status='" . $status . "', description='" . $description . "' WHERE video_id='" . $id . "' ";
            }
            
            $update = $this->common_model->executeNonQuery($sql);
            if ($update) {
                $art_msg['msg'] = 'videos Updated.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            } else {
                $art_msg['msg'] = 'Error to update videos.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        } else {
            $art_msg['msg'] = 'Something Error.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
            
        }
        
        redirect(base_url() . 'Videos', 'refresh');
    }
    
    
    public function update_data_upload()
    {
        $id = $this->db->escape_str($_POST['edit_id_u']);
    
        $Title = $this->db->escape_str($_POST['edit_Title_u']);
        $URL = $this->db->escape_str($_POST['edit_URL_u']);
        $duration = $this->db->escape_str($_POST['edit_duration_u']);
        $video_status = $this->db->escape_str($_POST['edit_video_status_u']);
        $Thumbnail = $this->db->escape_str($_POST['edit_Thumbnail_u']);
        $output_type = 'exo_player';
        $status = $_POST['edit_status_u'];
        $exams = $_POST['edit_exams_u'];
        $exams = json_encode($exams);
        $description = $this->db->escape_str($_POST['edit_description_u']);
        
        $image = 'placeholder.png';
        if ($this->input->post('edit_Thumbnail_u')) {
            $image = $this->input->post('edit_Thumbnail_u');
        }
    
        $name='edit_Thumbnail_u';
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload($name);
            $image = base_url() . "AppAPI/video/" . $newname;
        }
    
    
    
        $pdf = 'placeholder.mp4';
        if ($this->input->post('edit_URL_u')) {
            $pdf = $this->input->post('edit_URL_u');
        }
    
        $name1='edit_URL_u';
    
        if (!empty($_FILES[$name1]['name'])) {
            $newname1 = $this->upload_video($name1);
            $pdf = base_url() . "AppAPI/video/" . $newname1;
        }
    
   
        $sql = "SELECT * FROM videos WHERE video_id='" . $id . "' ";
        $check = $this->common_model->executeRow($sql);
        if ($check) {
            
            
            
            if ($image == 'placeholder.png'){
                
                if ($pdf == 'placeholder.mp4'){
                    $sql = "UPDATE videos SET `video_title`='" . $Title . "', `selected_exams_id`='" . $exams . "', `payment_status`='" . $video_status . "',`output`='" . $output_type . "', `video_duration`='" . $duration . "', status='" . $status . "' , description='" . $description . "' WHERE video_id='" . $id . "' ";
                 
                }else{
                    $sql = "UPDATE videos SET `video_title`='" . $Title . "', `selected_exams_id`='" . $exams . "', `payment_status`='" . $video_status . "',`output`='" . $output_type . "', `video_url`='" . $pdf . "', `video_duration`='" . $duration . "', status='" . $status . "' , description='" . $description . "' WHERE video_id='" . $id . "' ";
                  
                }

            }else{
                if ($pdf == 'placeholder.mp4'){
                    $sql = "UPDATE videos SET `video_title`='" . $Title . "', `selected_exams_id`='" . $exams . "', `payment_status`='" . $video_status . "',`output`='" . $output_type . "', `video_duration`='" . $duration . "', video_thumbnail='" . $image . "', status='" . $status . "', description='" . $description . "' WHERE video_id='" . $id . "' ";
                  
                }else{
                    $sql = "UPDATE videos SET `video_title`='" . $Title . "', `selected_exams_id`='" . $exams . "', `payment_status`='" . $video_status . "',`output`='" . $output_type . "', `video_url`='" . $pdf . "', `video_duration`='" . $duration . "', video_thumbnail='" . $image . "', status='" . $status . "', description='" . $description . "' WHERE video_id='" . $id . "' ";
                  
                }
                
            }
            
            $update = $this->common_model->executeNonQuery($sql);
            if ($update) {
                $art_msg['msg'] = 'videos Updated.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            } else {
                $art_msg['msg'] = 'Error to update videos.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        } else {
            $art_msg['msg'] = 'Something Error.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
            
        }
        
        redirect(base_url() . 'Videos', 'refresh');
    }
    function deleteCategory()
    {
        if ($_REQUEST['id']) {
            $id = $_REQUEST['id'];
            $sql = "SELECT * FROM videos WHERE video_id='" . $id . "' ";
            $check = $this->common_model->executeRow($sql);
            if ($check) {
                $sql = "DELETE FROM videos WHERE video_id='" . $id . "'";
                $delete = $this->common_model->executeNonQuery($sql);
                if ($delete) {
                    echo 'success';
                } else {
                    echo 'error';
                }
            } else {
                echo 'error';
            }
            
        }
        
    }

    public function add_video_data(){
       // echo "<pre>";print_r($_POST);print_r($_FILES);
        if (isset($_POST)) {
            $Title = $this->db->escape_str($_POST['Title_u']);
            $URL = $this->db->escape_str($_POST['URL_u']);
            $duration = $this->db->escape_str($_POST['duration']);
            $video_status = $this->db->escape_str($_POST['video_status']);
            $video_type = $this->db->escape_str($_POST['video_type']);
            $Thumbnail = $this->db->escape_str($_POST['Thumbnail']);
            if($video_type=='upload'){
                $output_type = 'exo_player';
                $video_url = 'placeholder.mp4';              
                $name='URL_u';
        
                if (!empty($_FILES[$name]['name'])) {
                    $newname = $this->upload_video($name);
                    $video_url = base_url() . "AppAPI/video/" . $newname;
                } else {
                    $video_url = base_url() . "AppAPI/video/" . 'placeholder.mp4';
                }
            }else if($video_type=='youtube'){
                $output_type = 'youtube';
                $video_url = $this->db->escape_str($_POST['URL_y']);
            }else{
                $output_type='vimeo';
                $video_url = $this->db->escape_str($_POST['URL_v']);
            }
            
            $status = $_POST['status'];
            $exams = $_POST['exams_u'];
            $exams = json_encode($exams);
            $description = $this->db->escape_str($_POST['description']);
            
            $image = 'placeholder.png';
            if ($this->input->post('Thumbnail')) {
                $image = $this->input->post('Thumbnail');
            } else {
                $image = 'placeholder.png';
            }
            
            $name='Thumbnail';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload($name);
                $image = base_url() . "AppAPI/video/" . $newname;
            } else {
                $image =  base_url() . "AppAPI/video/" . 'placeholder.png';
            }
            $this->load->model('Videos_model');   
            $check = $this->Videos_model->getDataByWhereCondition(['selected_exams_id'=>$exams,'video_title'=>$Title]);
            if (!$check) {
                
                $insert = $this->Videos_model->save([
                    'selected_exams_id'=>$exams,
                    'video_title'=>$Title,
                    'payment_status'=>$video_status,
                    'output'=>$output_type,
                    'status'=>$status,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'video_url'=>$video_url,
                    'description'=>$description,
                    'video_duration'=>$duration,
                    'video_thumbnail'=>$image
                ]);
                //print_r($insert);die;
                if ($insert=='Inserted') {
                    $art_msg['msg'] = 'New Videos Added.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            } else {
                $art_msg['msg'] = 'Videos already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        
        redirect(base_url() . 'Videos', 'refresh');
    }
}

?>
