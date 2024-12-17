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

class Daily_quiz extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('quiz/index', $data);
        // $this->load->view('quiz/add_quiz',$data);
        $this->load->view('quiz/add',$data);
        $this->load->view('quiz/add_quize_qua',$data);
        $this->load->view('quiz/import_quiz_question',$data);
        $this->load->view('quiz/show_quize',$data);
        $this->load->view('quiz/edit',$data);
        // $this->load->view('quiz/edit_quiz',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('quiz/jscript.php', $data);
    }

    function fetch_user()
   {
       $this->load->model("Daily_quiz_model");
       $sql="SELECT * FROM `daily_quiz`  ORDER BY quiz_id DESC";
       // $fetch_data = $this->Daily_quiz_model->make_datatables();
       $fetch_data = $this->common_model->executeArray($sql);
       $data = array();
       foreach ($fetch_data as $row) {
           $sub_array = array();

         //   $sub_array[] = '<button type="button" name="Details" onclick="getquizDetails(this.id)" id="details_' . $row->quiz_id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showquiz">

         
         // <i class="material-icons">visibility</i> </button>
         $sub_array[] = '
          <button type="button" name="Edit" onclick="getquizeEdit(this.id)" id="client_' . $row->quiz_id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#editquiz" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deletequizDetails(this.id)" id="delete_' . $row->quiz_id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          <button type="button" name="Add" onclick="addquizQuaDetails(this.id)" id="Add_' . $row->quiz_id . '" data-type="confirm" class="btn bg-green waves-effect btn-xs" data-toggle="modal" data-target="#addquizqua">
        <i class="material-icons">add</i></button>
        <button type="button" name="Import" onclick="importExcel(this.id)" id="Import_' . $row->quiz_id . '" data-type="confirm" class="btn bg-green waves-effect btn-xs" data-toggle="modal" data-target="#importQuestion">
        <i class="material-icons">cloud_upload</i></button>
          ';

                    $array=json_decode($row->selected_exams_id);
                    if (is_array($array))
                    {
                    }
                    else
                    {
                        $array=array();
                        array_push($array, $row->selected_exams_id);
                    }
                    $exam_name=array();
                    for($i=0; $i<sizeof($array);$i++)
                    {
                       $sql="SELECT * FROM exams WHERE exam_id='".$array[$i]."' ";
                       $exam=$this->common_model->executeRow($sql);
                       $exam_name[]=$exam->exam_name;
                    }
                    $List = implode(', ', $exam_name);
    
           $sub_array[] = $row->quiz_title;
            $sub_array[] = $List;
           $sub_array[] = $row->quiz_questions;
           $sub_array[] = $row->quiz_duration;
           $sub_array[] = $row->status;
           $sub_array[] = $row->created_at;

           $data[] = $sub_array;
       }
       $output = array("recordsTotal" => sizeof($sub_array), "recordsFiltered" => $sub_array, "data" => $data);
       echo json_encode($output);
   }

   //API - licenses sends id and on valid id licenses information is sent back editbyId

   function StudyById($pid = NULL)
   {
       $id = $pid;
       if (!$id) {
           echo json_encode("No ID specified");
           exit;
       }
       $this->load->model("Study_Material_Model_Api");
       $result = $this->Study_Material_Model_Api->getStudyById($id);
       if ($result) {
           echo json_encode($result);
           exit;
       } else {
           echo json_encode("Invalid ID");
           exit;
       }

   }
   //this code for fetch recored in table format in add section table
   function fetch_qua_ans( $cid = NULL )
   {
      $id      = $cid;
       $this->load->model("Daily_quiz_model");
       $fetch_data = $this->Daily_quiz_model->make_datatables_qua($id);
       $data = array();
       foreach ($fetch_data as $row) {
           $sub_array = array();
           $sub_array[] = '

          <button type="button" name="Delete" onclick="deletequaDetails(this.id,this.value)" value="'.$row->id.'"  id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>


          <button type="button" name="edit" onclick="edit_qtn('.$row->id.')"  data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">edit</i></button>

          ';

          $sql="SELECT * FROM `quiz_subject` WHERE subject_id='".$row->subject_id."' ";
          $sub=$this->common_model->executeRow($sql);
          $subject="";
          if($sub)
          {
            $subject=$sub->subject_name;
          }
           $sub_array[] = $row->title;
           $sub_array[] = $subject;
           $sub_array[] = $row->question;
           $sub_array[] = $row->option1;
           $sub_array[] = $row->option2;
           $sub_array[] = $row->option3;
           $sub_array[] = $row->option4;
           $sub_array[] = $row->answer;
           $sub_array[] = $row->st;



           $data[] = $sub_array;
       }
       $output = array(
           "recordsTotal" => $this->Daily_quiz_model->get_all_data_qua($id),
           "recordsFiltered" => $this->Daily_quiz_model->get_filtered_data_qua($id),
           "data" => $data
       );
       echo json_encode($output);
   }




   public function add_exam()
   {

        $a_exams= json_encode($_POST['a_exams']);
        $a_quiz_title= $this->db->escape_str($_POST['a_quiz_title']);
        $a_quiz_questions= $_POST['a_quiz_questions'];
        $a_quiz_duration= $_POST['a_quiz_duration'];
        $a_correct_answer_mark= $_POST['a_correct_answer_mark'];
        $a_wrong_answer_mark= $_POST['a_wrong_answer_mark'];
        $a_instructions=$this->db->escape_str($_POST['a_instructions']);
        $a_status= $_POST['a_status'];


        $sql="SELECT * FROM daily_quiz WHERE quiz_title='".$a_quiz_title."' AND selected_exams_id='".$a_exam."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            $art_msg['msg'] = 'Sarav prasnasanch already present.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $sql="INSERT INTO `daily_quiz`( `selected_exams_id`, `quiz_title`, `quiz_questions`, `quiz_duration`, `correct_answer_mark`, `wrong_answer_mark`, `instructions`, `status`, `created_at`) VALUES ('".$a_exams."' ,'".$a_quiz_title."', '".$a_quiz_questions."', '".$a_quiz_duration."', '".$a_correct_answer_mark."', '".$a_wrong_answer_mark."', '".$a_instructions."', '".$a_status."', '".date('Y-m-d H:i:s')."')";
            $update=$this->common_model->executeNonQuery($sql);
            if($update)
            {
                $art_msg['msg'] = 'New daily quiz updated.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
            else
            {
                $art_msg['msg'] = 'Error to update daily quiz.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        }
        redirect(base_url() . 'Daily_quiz', 'refresh');
   }

   public function QuizById($id=0)
   {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM daily_quiz WHERE quiz_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {

                $return_array=array("quiz_id"=>$check->quiz_id, "selected_exams_id"=>json_decode($check->selected_exams_id), "quiz_title"=>$check->quiz_title, "quiz_duration"=>$check->quiz_duration, "quiz_questions"=>$check->quiz_questions, "status"=>$check->status, "created_at"=>date('Y-m-d',strtotime($check->created_at)), "correct_answer_mark"=>$check->correct_answer_mark, "wrong_answer_mark"=>$check->wrong_answer_mark, "instructions"=>$check->instructions);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
   }
   public function update_exam()
   {
    
        $e_quiz_id= $_POST['e_quiz_id'];
        $e_exams= json_encode($_POST['e_exams']);
        $e_quiz_title= $this->db->escape_str($_POST['e_quiz_title']);
        $e_quiz_questions= $_POST['e_quiz_questions'];
        $e_quiz_duration= $_POST['e_quiz_duration'];
        $e_correct_answer_mark= $_POST['e_correct_answer_mark'];
        $e_wrong_answer_mark= $_POST['e_wrong_answer_mark'];
        $e_instructions=$this->db->escape_str($_POST['e_instructions']);
        $e_status= $_POST['e_status'];

        $sql="UPDATE daily_quiz SET `selected_exams_id`='".$e_exams."',`quiz_title`='".$e_quiz_title."',`quiz_questions`='".$e_quiz_questions."',`quiz_duration`='".$e_quiz_duration."',`correct_answer_mark`='".$e_correct_answer_mark."',`wrong_answer_mark`='".$e_wrong_answer_mark."',`instructions`='".$e_instructions."',`status`='".$e_status."' WHERE quiz_id='".$e_quiz_id."' ";

        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Daily quiz Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update daily quiz.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

        redirect(base_url() . 'Daily_quiz', 'refresh');

   }

    function get_qtn_details()
    {
      $return_array=array();
      if(isset($_POST['id']))
      {
        $id=$_POST['id'];

         $sql="SELECT * FROM daily_quiz_questions WHERE daily_quiz_questions_id='".$id."' ";
         // echo $sql;
         $check=$this->common_model->executeRow($sql);
         if($check)
         {
            $cnt=0;
            if($check->option1==$check->answer)
            {
              $cnt=1;
            }
            if($check->option2==$check->answer)
            {
              $cnt=2;
            }
            if($check->option3==$check->answer)
            {
              $cnt=3;
            }
            if($check->option4==$check->answer)
            {
              $cnt=4;
            }

            $return_array=array("id"=>$check->daily_quiz_questions_id, "subject_id"=>$check->subject_id, "quiz_id"=>$check->quiz_id, "question"=>$check->question, "question_image"=>$check->question_image, "question_type"=>$check->question_type, "option1"=>$check->option1, "option2"=>$check->option2, "option3"=>$check->option3, "option4"=>$check->option4, "answer"=>$check->answer, "explanation"=>$check->explanation, "status"=>$check->status, "select_ans"=>$cnt, "type"=>$check->question_type);
         }

      }


      echo json_encode($return_array);
    }
    
    
    public function deletequiz($id)
    {
        
        $sql="DELETE FROM daily_quiz WHERE quiz_id=".$id." ";
        $delete=$this->common_model->executeNonQuery($sql);
        if($delete)
        {
            echo "Success";
        }
        else
        {
            echo "Error";
        }
    }
    
    
    
    public function importQuestions(){
        $this->load->model("Daily_quiz_model");
      
            $quiz_id= $this->input->post('import_quiz_id');
            $subject_id= $this->input->post('import_subject_id');
            
            $path = 'assets/uploads/';
            require_once APPPATH . "/third_party/PHPExcel/Classes/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error)){
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i=0;
                    foreach ($allDataInSheet as $value) {
                        if($flag){
                            $flag =false;
                            continue;
                        }
                        
                        $inserdata[$i]['quiz_id'] = $quiz_id;
                        $inserdata[$i]['subject_id'] = $subject_id;
                        $inserdata[$i]['question'] = $value['A'];
                        $inserdata[$i]['option1'] = $value['B'];
                        $inserdata[$i]['option2'] = $value['C'];
                        $inserdata[$i]['option3'] = $value['D'];
                        $inserdata[$i]['option4'] = $value['E'];
                        $inserdata[$i]['answer'] = $value['F'];
                        $inserdata[$i]['explanation'] = $value['G'];
                        $inserdata[$i]['status'] = 'Active';
                        
                        $i++;
                    }
                    $result = $this->Daily_quiz_model->insert($inserdata);
                    if($result){
                        $art_msg['msg'] = 'Imported successfully.';
                        $art_msg['type'] = 'success';
                    }else{
                        $art_msg['msg'] = 'Error in importing.';
                        $art_msg['type'] = 'error';
                    }
                } catch (Exception $e) {
                    $art_msg['msg'] = 'Error in importing..';
                    $art_msg['type'] = 'error';
                }
            }else{
                $art_msg['msg'] = 'Error in importing...';
                $art_msg['type'] = 'error';
            }
        
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Daily_quiz', 'refresh');

    }

}
