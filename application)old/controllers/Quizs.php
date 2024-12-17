<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */


defined('BASEPATH') or exit('No direct script access allowed');

class Quizs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Quiz_model");
        $this->load->model('Question_model');
    }

    //functions
    function index()
    {

        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('quiz/index', $data);
//        $this->load->view('membership_plans/details', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('quiz/jscript.php', $data);
    }

    //API - licenses sends id and on valid id licenses information is sent back
    public function add_data()
    {
        if(isset($_POST))
        {
            $this->form_validation->set_rules('title','Title','required');
            $this->form_validation->set_rules('description','Description','required');
            $this->form_validation->set_rules('num_of_question','Number Of Question','required');
            $this->form_validation->set_rules('marks_per_question','Marks Per Question','required');
            $this->form_validation->set_rules('status','Status','required');
            $this->form_validation->set_rules('time','time','required');
//            print_r($_FILES);
//            die;
            if (empty($_FILES['image']['name'])){
                $this->form_validation->set_rules('image','Image','required');
            }
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
            if ($this->form_validation->run() === FALSE) {
                $error = [
                    'title' => form_error('title'),
                    'description' => form_error('description'),
                    'image' => form_error('image'),
                    'num_of_question' => form_error('num_of_question'),
                    'marks' => form_error('marks'),
                    'time' => form_error('time'),
                ];
                echo json_encode([
                    'success' => "Failed",
                    'error' => $error
                ]);
                return false;
            }

            $title=$this->db->escape_str($_POST['title']);
            $can_download=$this->db->escape_str($_POST['can_download']);
            $status=$this->db->escape_str($_POST['status']);
            $description=$this->db->escape_str($_POST['description']);
            $num_of_questions=$this->db->escape_str($_POST['num_of_question']);
            $marks=$this->db->escape_str($_POST['marks_per_question']);
            $time=$this->db->escape_str($_POST['time']);
            $source_id=$this->db->escape_str($_POST['source_id']);
            $section_type=$this->db->escape_str($_POST['source_type']);
            $ImagePath = '';
            $pdf_url = '';
//            $check=$this->Quiz_model->getDataByWhereCondition(['title'=>$Title]);
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath = $path . '/' . $images;
                }
            }
            if (!empty($_FILES['pdf']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('pdf', $path,"pdf");
                if (empty($images['error'])) {
                    $pdf_url = $path . '/' . $images;
                }
            }
            if(true)
            {
                $data = [
                    'title'=>$title,
                    'marks_per_question'=>$marks,
                    'time'=>$time,
                    'section'=>$section_type,
                    'section_id'=>$source_id,
                    'description'=>$description,
                    'status'=>$status,
                    'image_url'=>$ImagePath,
                    'pdf_url'=>$pdf_url,
                    'no_of_question'=>$num_of_questions,
                    'can_download'=>$can_download,
                    'total_mark'=>$num_of_questions*$marks,
                ];
                $insert=$this->Quiz_model->save($data);
                if($insert=='Inserted')
                {
                    echo json_encode([
                        'Status' => "Success",
                        'msg'=>'Inserted'
                    ]);
                    return true;
                }
                else
                {
                    echo json_encode([
                        'Status' => "Failed",
                        'msg'=>'Something Error'
                    ]);
                    return false;
                }
            }
            else
            {
                echo "false";
                die;
                $art_msg['msg'] = 'New subject already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subject', 'refresh');

    }
    public function update_data()
    { 
        if(isset($_POST))
        {
            $id=$this->db->escape_str($_POST['id']);
            $this->form_validation->set_rules('title','Title','required');
            $this->form_validation->set_rules('description','Description','required');
            $this->form_validation->set_rules('num_of_question','Number Of Question','required');
            $this->form_validation->set_rules('marks_per_question','Marks Per Question','required');
            $this->form_validation->set_rules('status','Status','required');
            $this->form_validation->set_rules('time','time','required');
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
            if ($this->form_validation->run() === FALSE) {
                $error = [
                    'title' => form_error('title'),
                    'description' => form_error('description'),
                    'image' => form_error('image'),
                    'num_of_question' => form_error('num_of_question'),
                    'marks' => form_error('marks'),
                    'time' => form_error('time'),
                ];
                echo json_encode([
                    'success' => "Failed",
                    'error' => $error
                ]);
                return false;
            }
            $title=$this->db->escape_str($_POST['title']);
            $can_download=$this->db->escape_str($_POST['can_download']);
            $status=$this->db->escape_str($_POST['status']);
            $description=$this->db->escape_str($_POST['description']);
            $num_of_questions=$this->db->escape_str($_POST['num_of_question']);
            $marks=$this->db->escape_str($_POST['marks_per_question']);
            $time=$this->db->escape_str($_POST['time']);
            $source_id=$this->db->escape_str($_POST['source_id']);
            $marks_per_question=$this->db->escape_str($_POST['marks_per_question']);
            $ImagePath = '';
            $pdf_url = '';
            // $check=$this->Quiz_model->getDataByWhereCondition(['title'=>$Title]);

            if(true)
            {
                $data = [
                    'title'=>$title,
                    'marks_per_question'=>$marks,
                    'time'=>$time, 
                    // 'source_type'=>$source_type,
                    'section_id'=>$source_id,
                    'description'=>$description,
                    'status'=>$status,
                    'no_of_question'=>$num_of_questions,
                    'can_download'=>$can_download,
                    'total_mark'=>$num_of_questions*$marks,
                ];
                if (!empty($_FILES['image']['name'])) {
                    $path = 'assets/uploads/quiz/images';
                    $images = upload_file('image', $path);
                    if (empty($images['error'])) {
                        $data['image_url'] = $path . '/' . $images;
                    }
                }
                if (!empty($_FILES['pdf']['name'])) {
                    $path = 'assets/uploads/courses/images';
                    $images = upload_file('pdf', $path,"pdf");
                    if (empty($images['error'])) {
                        $data['pdf_url'] = $path . '/' . $images;
                    }
                }
                $insert=$this->Quiz_model->update($id,$data);
                if($insert=='Updated')
                {
                    echo json_encode([
                        'Status' => "Success",
                        'msg'=>'Updated'
                    ]);
                    return true;
                }
                else
                {
                    echo json_encode([
                        'Status' => "Failed",
                        'msg'=>'Something Error'
                    ]);
                    return false;
                }
            }
            else
            {
                echo "false";
                die;
                $art_msg['msg'] = 'New subject already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Exam_subject', 'refresh');
    }

    public function get_quiz_details()
    {
        $condition = null;
        $type = $_GET['section'];
        if (isset($_GET['section']) && !empty($_GET['section'])) {
            $condition = ['section' => $_GET['section']];
        }
        $fetch_data = $this->Quiz_model->make_datatables($condition);
//         echo $this->db->last_query();
        //print_r($fetch_data);die;
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getSingleQuizDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
         <i class="material-icons">visibility</i> </button>
         <button type="button" name="Edit" onclick="getQuestions(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#manage-questions" >
                  <i class="material-icons">question_mark</i></button>
          <button type="button" name="Edit" onclick="getQuizDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="showConfirmMessage(this.id,this.getAttribute(\'data-url\'))" data-url="'.base_url('Quizs/delete_quiz_data').'"  id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

            $sub_array[] = $row->title;

            $sub_array[]=$row->no_of_question;
            $sub_array[]=$row->marks_per_question;
            $sub_array[]=$row->time;
//            $sub_array[]='';
            $sub_array[] = '<img src="' . base_url($row->image_url) . '" class="img-fluid rounded" style="width: 50%;" >';
            $sub_array[] = $row->status;
            $sub_array[] = date("d-m-Y H:i:s", strtotime($row->created_at));

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->Quiz_model->get_all_data(), "recordsFiltered" => $this->Quiz_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }

    public function get_single_quiz($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->Quiz_model->getPostById($id);
        if ($result) {
            $row = [];
            $row = $result[0];
            $row['created_at'] = date("d-m-Y H:i:s", strtotime($result[0]['created_at']));
            echo json_encode($row);
            exit;
        } else {
            echo "Invalid ID";
            exit;
        }
    }

    public function add_question()
    {
        if(isset($_POST))
        {
            $id=$this->db->escape_str($_POST['id']);
            $this->form_validation->set_rules('question','Question','required');
            $this->form_validation->set_rules('option1','option1','required');
            $this->form_validation->set_rules('option2','option2','required');
            $this->form_validation->set_rules('option3','option3','required');
            $this->form_validation->set_rules('option4','option4','required');
            $this->form_validation->set_rules('answer','answer','required');
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
            if ($this->form_validation->run() === FALSE) {
                $error = [
                    'question' => form_error('question'),
                    'option1' => form_error('option1'),
                    'option2' => form_error('option2'),
                    'option3' => form_error('option3'),
                    'option4' => form_error('option4'),
                    'answer' => form_error('answer'),
                ];
                echo json_encode([
                    'success' => "Failed",
                    'error' => $error
                ]);
                return false;
            }

            $question=$this->db->escape_str($_POST['question']);
            $quiz_id=$this->db->escape_str($_POST['quiz_id']);
            $description=$this->db->escape_str($_POST['description']);
            $option1=$this->db->escape_str($_POST['option1']);
            $option2=$this->db->escape_str($_POST['option2']);
            $option3=$this->db->escape_str($_POST['option3']);
            $option4=$this->db->escape_str($_POST['option4']);
            $status=$this->db->escape_str($_POST['status']);
            $answer=$this->db->escape_str($_POST['answer']);

            if(true)
            {
                $data = [
                    'quiz_id'=>$quiz_id,
                    'question'=>$question,
                    'option1'=>$option1,
                    'option2'=>$option2,
                    'option3'=>$option3,
                    'option4'=>$option4,
                    'answer'=>$answer,
                    'status'=>$status,
                ];
                if (!empty($_FILES['image']['name'])) {
                    $path = 'assets/uploads/quiz/images';
                    $images = upload_file('image', $path);
                    if (empty($images['error'])) {
                        $data['image_url'] = $path . '/' . $images;
                    }
                }
                if (!empty($_FILES['pdf']['name'])) {
                    $path = 'assets/uploads/courses/images';
                    $images = upload_file('pdf', $path,"pdf");
                    if (empty($images['error'])) {
                        $data['pdf_url'] = $path . '/' . $images;
                    }
                }
                $this->load->model('Question_model');
                if($id==''){
                    $insert=$this->Question_model->save($data);
                }else{
                    $insert = $this->Question_model->update($id,$data);
                }
                if($insert=='Inserted' || $insert=='Updated')
                {
                    echo json_encode([
                        'Status' => "Success",
                        'msg'=>$insert
                    ]);
                    return true;
                }
                else
                {
                    echo json_encode([
                        'Status' => "Failed",
                        'msg'=>'Something Error'
                    ]);
                    return false;
                }
            }
            else
            {
                echo "false";
                die;
                $art_msg['msg'] = 'New subject already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subject', 'refresh');

    }
    public  function getQuestions(){
        $condition = null;
        $quiz_id = $_GET['quiz_id'];
        if($quiz_id){
            $condition = ['quiz_id' => $quiz_id];
        }
        
        $fetch_data = $this->Question_model->make_datatables($condition);
        // echo $this->db->last_query();
        // print_r($fetch_data);
        // die;
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '
          <button type="button" name="Edit" onclick="getSingleQuestionDetail(this.id)" id="edit_' . $row->id . '" class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit-question" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="showConfirmMessage(this.id,this.getAttribute(\'data-url\'))" data-url="'.base_url('Quizs/delete_question_data').'"  id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

            $sub_array[] = $row->question;
            $sub_array[] = $row->option1;
            $sub_array[] = $row->option2;
            $sub_array[] = $row->option3;
            $sub_array[] = $row->option4;
            $sub_array[] = $row->{$row->answer};
            $sub_array[] = $row->status;
            $sub_array[] = date("d-m-Y H:i:s",strtotime($row->created_at));

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->Question_model->get_all_data(), "recordsFiltered" => $this->Question_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }
    public function get_single_question($id){
        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->Question_model->getPostById($id);
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

    public function delete_quiz_data($id)
    {
        //echo $id;die;
        if (!$id) {
            echo "Parameter missing";
            return false;
        }
        // $result = $this->Quiz_model->checkUserSelectedPlan($id);
        if ($this->Quiz_model->delete($id)) {
            echo "Success";
            return true;
        } else {
            echo "Failed";
            return false;
        }
    }
    public function delete_question_data($id)
    {
        //echo $id;die;
        if (!$id) {
            echo "Parameter missing";
            return false;
        }
        // $result = $this->Quiz_model->checkUserSelectedPlan($id);
        if ($this->Question_model->delete($id)) {
            echo "Success";
            return true;
        } else {
            echo "Failed";
            return false;
        }
    }

}
