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

class Notes extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data['title'] = ucfirst('Notes'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('notes/index', $data);
        $this->load->view('notes/notes_add',$data);
        $this->load->view('notes/notes_edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('notes/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $sql="SELECT notes_subject_content.*, notes_subject.subject_name FROM notes_subject_content, notes_subject WHERE notes_subject_content.notes_subject_id = notes_subject.notes_subject_id  ORDER BY notes_subject_content_id  DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            foreach($fetch_data as $yashogatha)
            {
                /////////////////////////////////////////////////////////
                if(1)
                {
                    $sub_array = array();
                    if(1)
                    {
                   
                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getNotesDetailsEdit(this.id)" id="edit_' . $yashogatha->notes_subject_content_id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_notes" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $yashogatha->notes_subject_content_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $yashogatha->title;
                        $sub_array[] = $yashogatha->subject_name;
                        $sub_array[] = $yashogatha->status;
                        $sub_array[] = $yashogatha->created_at;
                   }
                    $data[] = $sub_array;
                }

                /////////////////////////////////////////////////////////
            }
        }


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);
    }
    
    function upload()
    {
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/notes/thumbnails';
            $config['upload_url'] = base_url() . 'AppAPI/notes/thumbnails';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/notes/thumbnails/" . $newname);
            return $newname;
        }
    }
    function upload_pdf()
    {
        // foreach ($_FILES as $name => $fileInfopdf)
        
        {
            $name='notes_pdf';
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config2['upload_path'] = 'AppAPI/notes/pdf';
            $config2['upload_url'] = base_url() . 'AppAPI/notes/pdf';
            $config2['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config2['max_size'] = '2000000';
            $config2['file_name'] = $newname;
            $this->load->library('upload', $config2);
            move_uploaded_file($tmpname, "AppAPI/notes/pdf/" . $newname);
            return $newname;
        }
    }

    function add_data()
    {
    
        $image = 'study1.png';
        if ($this->input->post('notes_image')) {
            $image = $this->input->post('notes_image');
        } else {
            $image = 'study1.png';
        }
    
        // foreach ($_FILES as $name => $fileInfo) {
        $name='notes_image';
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload();
            $image = $newname;
        } else {
            $image = 'study1.png';
        }
        // }
    
    
        $pdf = 'pdf1.pdf';
        if ($this->input->post('notes_pdf')) {
            $pdf = $this->input->post('notes_pdf');
        } else {
            $pdf = 'pdf1.pdf';
        }
    
        // foreach ($_FILES as $name => $fileInfopdf) {
        $name='notes_pdf';
    
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload_pdf();
            $pdf = $newname;
        } else {
            $pdf = 'pdf1.pdf';
        }
        // }
    
        $NotesTitle=$this->db->escape_str($_POST['NotesTitle']);
        $NotesSubjectId=$_POST['NotesSubjectId'];
        $Description=$this->db->escape_str($_POST['Description']);
        $NotesStatus=$_POST['NotesStatus'];
        $SelectedExamId=$_POST['SelectedExamId'];
        $SelectedExamId=json_encode($SelectedExamId);
    
        if($pdf!="" && $image!="" && $NotesTitle!="" && $NotesSubjectId!="" && $NotesStatus!="" && $Description!="")
        {
            $sql="SELECT * FROM notes_subject_content WHERE title like '%".$NotesTitle."%'";
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `notes_subject_content`(`notes_subject_id`, `selected_exams_id`, `title`, `description`, `image_url`, `pdf_url`, `status`, `created_at`) VALUES ('".$NotesSubjectId."', '".$SelectedExamId."', '".$NotesTitle."', '".$Description."', '".$image."' ,'".$pdf."','".$NotesStatus."', '".date('Y-m-d H:i:s')."')";
//                echo $sql;
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New Notes updated Updated.';
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
                $art_msg['msg'] = 'Repeat Notes.';
                $art_msg['type'] = 'error';
            }
        
        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';
        
        }
    
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Notes', 'refresh');
    
    }


    public function update_data()
    {
        $NotesTitle=$this->db->escape_str($_POST['edit_NotesTitle']);
        $NotesSubjectId=$_POST['edit_NotesSubjectId'];
        $Description=$this->db->escape_str($_POST['edit_Description']);
        $NotesStatus=$_POST['edit_NotesStatus'];
        $SelectedExamId=$_POST['edit_SelectedExamId'];
        $SelectedExamId=json_encode($SelectedExamId);
        $edit_id=$_POST['edit_id'];
    
        $sql="SELECT * FROM notes_subject_content WHERE notes_subject_content_id ='".$edit_id."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
        
            $name='notes_image';
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = $check->image_url;//'study1.png';
            }
        
            $name='notes_pdf';
        
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_pdf();
                $pdf = $newname;
            } else {
                $pdf = $check->pdf_url;//'pdf1.pdf';
            }
        
            $sql="UPDATE notes_subject_content SET `notes_subject_id`='".$NotesSubjectId."', `selected_exams_id`='".$SelectedExamId."', `title`='".$NotesTitle."', `description`='".$Description."', `image_url`='".$image."', `pdf_url`='".$pdf."', `status`='".$NotesStatus."' WHERE notes_subject_content_id='".$edit_id."' ";
            // echo $sql;exit(0);
            $insert=$this->common_model->executeNonQuery($sql);
            if($insert)
            {
                $art_msg['msg'] = 'Notes Updated.';
                $art_msg['type'] = 'success';
            }
            else
            {
                $art_msg['msg'] = 'Error to update Notes.';
                $art_msg['type'] = 'error';
            }
        
        }
        else
        {
            $art_msg['msg'] = 'All feilds are compulsory.';
            $art_msg['type'] = 'warning';
        
        }
    
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Notes', 'refresh');
    
    }
    
    function deleteNotes()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM notes_subject_content WHERE notes_subject_content_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM notes_subject_content WHERE notes_subject_content_id='".$id."'";
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
    
    public function notesById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM notes_subject_content WHERE notes_subject_content_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
               
                $return_array=array("id"=>$check->notes_subject_content_id , "notes_subject_id"=>$check->notes_subject_id, "title"=>$check->title, "selected_exams_id"=>$check->selected_exams_id, "image_url"=>$check->image_url, "description"=>$check->description, "pdf_url"=>$check->pdf_url, "status"=>$check->status);
            }
        }
        else
        {
        
        }
        echo json_encode($return_array);
    }
    
}
?>
