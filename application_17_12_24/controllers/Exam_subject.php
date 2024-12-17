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

class Exam_subject extends CI_Controller
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
        $this->load->model('Exam_section_model');
        $examSection=$this->Exam_section_model->getAllData();
        $data['title'] = ucfirst('Exam Subject'); // Capitalize the first letter
        $data['examSectionArr']=$examSection;

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('exam_subject/index', $data);
        $this->load->view('exam_subject/add', $data);
        $this->load->view('exam_subject/edit', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_subject/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $this->load->model("Exam_subject_model");
        $fetch_data = $this->Exam_subject_model->make_datatables();
        //print_r($fetch_data);die;
        $data = array();
        if($fetch_data)
        {
            // print_r($fetch_data);
            foreach($fetch_data as $subject)
            {
                /////////////////////////////////////////////////////////
                $sub_array = array();
                $sub_array[] = '
                    <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $subject->subject_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                    <i class="material-icons">mode_edit</i></button>

                    <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $subject->subject_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                    <i class="material-icons">delete</i></button>
                    ';

                $sub_array[] = $subject->subject_name;
                $sub_array[] = $subject->section;
                // $sub_array[] = $List;
                $sub_array[] = $subject->status;     
                $data[] = $sub_array;

                /////////////////////////////////////////////////////////
            }
        }        


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);          
    }
    public function add_data()
    {
        if(isset($_POST))
        {
            
            $Title=$this->db->escape_str($_POST['Title']);
            $description=$this->db->escape_str($_POST['description']);
            $status=$_POST['status'];

            $this->load->model("Exam_subject_model");



            $check=$this->Exam_subject_model->getDataByWhereCondition(['subject_name'=>$Title]);
            if(!$check)
            {
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
                }
                $icon = $data['file_name'];*/
                $section = $this->input->post('section');

                $data = ['subject_name'=>$Title,
                    'status'=>$status,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'description'=>$description,
                    'section'=>$section];

                if (!empty($_FILES['iconfile']['name'])) {
                    $path = 'AppAPI/category-icon/';
                    $images = upload_file('iconfile', $path);
                    if (empty($images['error'])) {
                        $data['icon'] = $images;
                    }
                }
                $insert=$this->Exam_subject_model->save($data);
                if($insert=='Inserted')
                {
                    $art_msg['msg'] = 'New subjects updated.';
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
                $art_msg['msg'] = 'New subject already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subject', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $this->load->model("Exam_subject_model");
            $check=$this->Exam_subject_model->getDataById($id);
            if($check)
            {
                $return_array=array("id"=>$check['subject_id'],
                    "title"=>$check['subject_name'],
                    "status"=>$check['status'],
                    'description'=>$check['description'],
                    "section"=>$check['section'],
                    "icon"=>$check['icon'],
                    "icon_img"=>$check['icon_img']);
            }
        }
        
        echo json_encode($return_array);
    }

    public function update_data()
    {
        $Title=$this->db->escape_str($_POST['Title']);
        $description=$this->db->escape_str($_POST['description']);
        $status=$_POST['status'];
        $edit_id=$_POST['edit_id'];

        $this->load->model("Exam_subject_model");

        if (!is_dir('AppAPI/category-icon/')) {
            mkdir('AppAPI/category-icon/', 0777, TRUE);
        }

       /* $icon=$this->input->post('old_iconfile');

        if(!empty($_FILES['edit_iconfile']['name'])){
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

        $section = $this->input->post('section');
        // echo $sql;
        // exit(0);
        $data = ['subject_name'=>$Title,
                'status'=>$status,
                'description'=>$description,
                'section'=>$section];

        if (!empty($_FILES['edit_iconfile']['name'])) {
            $path = 'AppAPI/category-icon/';
            $images = upload_file('edit_iconfile', $path);
            if (empty($images['error'])) {
                $data['icon'] = $images;
            }
        }

        $update=$this->Exam_subject_model->update($edit_id,$data);
        if($update=='Updated')
        {
            $art_msg['msg'] = 'Subjects Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }
        else
        {
            $art_msg['msg'] = 'Error to update subjects.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }

        redirect(base_url() . 'Exam_subject', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
            $this->load->model("Exam_subject_model");
            $delete=$this->Exam_subject_model->delete($id);
            if($delete)
            {
                echo 'success';
            }
            else
            {
                echo 'error';
            }        

        }
        
    }

    function classes()
    {
        $data=[];
        $this->load->model('Exam_subject_model');
        $fetch_data = $this->Exam_subject_model->make_datatables();
        $data['title'] = ucfirst('Classes'); // Capitalize the first letter
        $data['examSectionArr']=$fetch_data;

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('exam_subject/classes_index', $data);
        //$this->load->view('exam_subject/add', $data);
        //$this->load->view('exam_subject/edit', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_subject/classes_jscript.php', $data);

    }

    function fetch_data_classes()
    {

        $this->load->model("Classes_model");
        $fetch_data = $this->Classes_model->make_datatables();
       // print_r($fetch_data);die;
        $data = array();
        if($fetch_data)
        {
            // print_r($fetch_data);
            foreach($fetch_data as $subject)
            {
                /////////////////////////////////////////////////////////
                $sub_array = array();
                $sub_array[] = '
                    <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $subject->id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                    <i class="material-icons">mode_edit</i></button>

                    <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $subject->id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                    <i class="material-icons">delete</i></button>
                    ';

                $sub_array[] = $subject->title;
                $sub_array[] = $subject->subject_name;
                // $sub_array[] = $List;
                $sub_array[] = $subject->status;
                $data[] = $sub_array;

                /////////////////////////////////////////////////////////
            }
        }


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);
    }

    public function add_data_classes()
    {
        if(isset($_POST))
        {

            $Title=$this->db->escape_str($_POST['Title']);
            $description=$this->db->escape_str($_POST['description']);
            $status=$_POST['status'];

            $this->load->model("Classes_model");

            $check=$this->Classes_model->getDataByWhereCondition(['title'=>$Title]);
            if(!$check)
            {
                if (!is_dir('AppAPI/category-icon/')) {
                    mkdir('AppAPI/category-icon/', 0777, TRUE);
                }

                $section = $this->input->post('subject');

                $data = ['title'=>$Title,
                    'status'=>$status,
                    'description'=>$description,
                    'subject_id'=>$section];

                if (!empty($_FILES['iconfile']['name'])) {
                    $path = 'AppAPI/category-icon/';
                    $images = upload_file('iconfile', $path);
                    if (empty($images['error'])) {
                        $data['icon'] = $images;
                    }
                }
                $insert=$this->Classes_model->save($data);
                if($insert=='Inserted')
                {
                    $art_msg['msg'] = 'New Class updated.';
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
                $art_msg['msg'] = 'New Class already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        //print_r($art_msg);
        //die();
        redirect(base_url() . 'classes', 'refresh');

    }

    public function ClassesById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $this->load->model("Classes_model");
            $check=$this->Classes_model->getDataById($id);
            if($check)
            {
                $return_array=array("id"=>$check['id'],
                    "title"=>$check['title'],
                    "status"=>$check['status'],
                    'description'=>$check['description'],
                    "subject_id"=>$check['subject_id'],
                    "icon"=>$check['icon'],
                    "icon_img"=>$check['icon_img']);
            }
        }

        echo json_encode($return_array);
    }

    public function update_data_classes()
    {
        $Title=$this->db->escape_str($_POST['Title']);
        $description=$this->db->escape_str($_POST['description']);
        $status=$_POST['status'];
        $edit_id=$_POST['edit_id'];

        $this->load->model("Classes_model");

        if (!is_dir('AppAPI/category-icon/')) {
            mkdir('AppAPI/category-icon/', 0777, TRUE);
        }

        $section = $this->input->post('subject');
        // echo $sql;
        // exit(0);
        $data = ['title'=>$Title,
            'status'=>$status,
            'description'=>$description,
            'subject_id'=>$section];

        if (!empty($_FILES['edit_iconfile']['name'])) {
            $path = 'AppAPI/category-icon/';
            $images = upload_file('edit_iconfile', $path);
            if (empty($images['error'])) {
                $data['icon'] = $images;
            }
        }

        $update=$this->Classes_model->update($edit_id,$data);
        if($update=='Updated')
        {
            $art_msg['msg'] = 'Class Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update class.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

        redirect(base_url() . 'classes', 'refresh');
    }

    function deleteClass()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
            $this->load->model("Classes_model");
            $delete=$this->Classes_model->delete($id);
            if($delete)
            {
                echo 'success';
            }
            else
            {
                echo 'error';
            }

        }

    }

    function chapters()
    {
        $data=[];
        $this->load->model('Classes_model');
        $fetch_data = $this->Classes_model->make_datatables();
        $data['title'] = ucfirst('Chapters'); // Capitalize the first letter
        $data['examSectionArr']=$fetch_data;

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('exam_subject/chapters_index', $data);
        //$this->load->view('exam_subject/add', $data);
        //$this->load->view('exam_subject/edit', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_subject/chapters_jscript.php', $data);

    }


    function fetch_data_chapters()
    {

        $this->load->model("Chapters_model");
        $fetch_data = $this->Chapters_model->make_datatables();
        // print_r($fetch_data);die;
        $data = array();
        if($fetch_data)
        {
            // print_r($fetch_data);
            foreach($fetch_data as $subject)
            {
                /////////////////////////////////////////////////////////
                $sub_array = array();
                $sub_array[] = '
                    <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $subject->id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                    <i class="material-icons">mode_edit</i></button>

                    <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $subject->id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                    <i class="material-icons">delete</i></button>
                    ';

                $sub_array[] = $subject->title;
                $sub_array[] = $subject->class;
                // $sub_array[] = $List;
                $sub_array[] = $subject->status;
                $data[] = $sub_array;

                /////////////////////////////////////////////////////////
            }
        }


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);
    }

    public function add_data_chapters()
    {
        if(isset($_POST))
        {

            $Title=$this->db->escape_str($_POST['Title']);
            $description=$this->db->escape_str($_POST['description']);
            $status=$_POST['status'];

            $this->load->model("Chapters_model");

            $check=$this->Chapters_model->getDataByWhereCondition(['title'=>$Title]);
            if(!$check)
            {
                if (!is_dir('AppAPI/category-icon/')) {
                    mkdir('AppAPI/category-icon/', 0777, TRUE);
                }

                $section = $this->input->post('class_id');

                $data = ['title'=>$Title,
                    'status'=>$status,
                    'description'=>$description,
                    'class_id'=>$section];

                if (!empty($_FILES['iconfile']['name'])) {
                    $path = 'AppAPI/category-icon/';
                    $images = upload_file('iconfile', $path);
                    if (empty($images['error'])) {
                        $data['icon'] = $images;
                    }
                }
                $insert=$this->Chapters_model->save($data);
                if($insert=='Inserted')
                {
                    $art_msg['msg'] = 'New Chapter updated.';
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
                $art_msg['msg'] = 'New Chapter already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        //print_r($art_msg);
        //die();
        redirect(base_url() . 'chapters', 'refresh');

    }

    public function ChaptersById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $this->load->model("Chapters_model");
            $check=$this->Chapters_model->getDataById($id);
            if($check)
            {
                $return_array=array("id"=>$check['id'],
                    "title"=>$check['title'],
                    "status"=>$check['status'],
                    'description'=>$check['description'],
                    "class_id"=>$check['class_id'],
                    "icon"=>$check['icon'],
                    "icon_img"=>$check['icon_img']);
            }
        }

        echo json_encode($return_array);
    }

    public function update_data_chapters()
    {
        $Title=$this->db->escape_str($_POST['Title']);
        $description=$this->db->escape_str($_POST['description']);
        $status=$_POST['status'];
        $edit_id=$_POST['edit_id'];

        $this->load->model("Chapters_model");

        if (!is_dir('AppAPI/category-icon/')) {
            mkdir('AppAPI/category-icon/', 0777, TRUE);
        }

        $section = $this->input->post('class_id');
        // echo $sql;
        // exit(0);
        $data = ['title'=>$Title,
            'status'=>$status,
            'description'=>$description,
            'class_id'=>$section];

        if (!empty($_FILES['edit_iconfile']['name'])) {
            $path = 'AppAPI/category-icon/';
            $images = upload_file('edit_iconfile', $path);
            if (empty($images['error'])) {
                $data['icon'] = $images;
            }
        }

        $update=$this->Chapters_model->update($edit_id,$data);
        if($update=='Updated')
        {
            $art_msg['msg'] = 'Chapter Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update chapter.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

        redirect(base_url() . 'chapters', 'refresh');
    }

    function deleteChapter()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
            $this->load->model("Chapters_model");
            $delete=$this->Chapters_model->delete($id);
            if($delete)
            {
                echo 'success';
            }
            else
            {
                echo 'error';
            }

        }

    }
}