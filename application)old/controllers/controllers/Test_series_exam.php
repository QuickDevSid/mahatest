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

class Test_series_exam extends CI_Controller
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
        $this->load->view('templates/menu', $data)
        ;
        $this->load->view('test_series_exam/index', $data);
        $this->load->view('test_series_exam/add',$data);
        $this->load->view('test_series_exam/add_quize_qua',$data);
        $this->load->view('test_series_exam/show_quize',$data);
        $this->load->view('test_series_exam/import_quiz_question',$data);
        $this->load->view('test_series_exam/edit',$data);

        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series_exam/jscript.php', $data);
    }

    function fetch_data()
   {
       $sql="SELECT * FROM test_series_exam_list ORDER BY test_series_exam_list_id DESC";
       $fetch_data=$this->common_model->executeArray($sql);
       $data = array();
       foreach ($fetch_data as $row) {
           $sub_array = array();

           $sql="SELECT * FROM test_series WHERE test_series='".$row->test_series."' ";
           // echo $sql;
           $exam=$this->common_model->executeRow($sql);
          // print_r($exam);
         //   $sub_array[] = '<button type="button" name="Details" onclick="getquizDetails(this.id)" id="details_' . $row->test_series_exam_list_id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showquiz">
         // <i class="material-icons">visibility</i> </button>
 $sub_array[] = '
          <button type="button" name="Edit" onclick="getquizeEdit(this.id)" id="client_' . $row->test_series_exam_list_id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#editquiz" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deletequizDetails(this.id)" id="delete_' . $row->test_series_exam_list_id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          <button type="button" name="Add" onclick="addquizQuaDetails(this.id)" id="Add_' . $row->test_series_exam_list_id . '" data-type="confirm" class="btn bg-green waves-effect btn-xs" data-toggle="modal" data-target="#addquizqua">
        <i class="material-icons">add</i></button>
        <button type="button" name="Import" onclick="importExcel(this.id)" id="Import_' . $row->test_series_exam_list_id . '" data-type="confirm" class="btn bg-green waves-effect btn-xs" data-toggle="modal" data-target="#importQuestion">
        <i class="material-icons">cloud_upload</i></button>
          ';
    
           $sub_array[] = $row->exam_title;
           $sub_array[] = $exam->test_title;
           $sub_array[] = $row->exam_questions;
           $sub_array[] = $row->exam_duration;
           $sub_array[] = $row->status;
           $sub_array[] = $row->created_at;

           $data[] = $sub_array;
       }
       $output = array("recordsTotal" => sizeof($fetch_data), "recordsFiltered" => $fetch_data, "data" => $data);
       echo json_encode($output);
   }

   //API - licenses sends id and on valid id licenses information is sent back editbyId

   public function QuizById($id=0)
   {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM test_series_exam_list WHERE test_series_exam_list_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {

                $exam_id="";
                $sql="SELECT * FROM `test_series` WHERE test_series='".$check->test_series."' ";
                $exam=$this->common_model->executeRow($sql);
                if($exam)
                {
                    $exam_id=json_decode($exam->selected_exams_id);
                }


                $return_array=array("selected_exams_id"=>$exam_id,"quiz_id"=>$check->test_series_exam_list_id, "test_series_id"=>$check->test_series, "s_quiz_title"=>$check->exam_title, "quiz_duration"=>$check->exam_duration, "quiz_questions"=>$check->exam_questions, "status"=>$check->status, "created_at"=>date('Y-m-d',strtotime($check->created_at)), "correct_answer_mark"=>$check->correct_answer_mark, "wrong_answer_mark"=>$check->wrong_answer_mark, "instructions"=>$check->instructions);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
   }

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
      $sql="SELECT * FROM test_series_questions WHERE test_series='".$id."' ORDER BY test_series_questions_id DESC ";
       $fetch_data = $this->common_model->executeArray($sql);
       $data = array();
       foreach ($fetch_data as $row) {
           $sql="SELECT * FROM test_series_exam_list WHERE test_series_exam_list_id ='".$row->test_series."' ";
           // echo $sql;
           $exam=$this->common_model->executeRow($sql);
           
           $sub_array = array();
           $sub_array[] = '<button type="button" name="Delete" onclick="deletequaDetails(this.id,this.value)" value="'.$row->test_series_questions_id.'"  id="delete_' . $row->test_series_questions_id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          <button type="button" name="edit" onclick="edit_qtn('.$row->test_series_questions_id.')"  data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">edit</i></button>';
           $sub_array[] = $exam->exam_title;
           $sub_array[] = $row->question;
           $sub_array[] = $row->option1;
           $sub_array[] = $row->option2;
           $sub_array[] = $row->option3;
           $sub_array[] = $row->option4;
           $sub_array[] = $row->answer;
           $sub_array[] = $row->status;
           $data[] = $sub_array;
       }
       $output = array(
           "recordsTotal" => sizeof($fetch_data),
           "recordsFiltered" => $fetch_data,
           "data" => $data
       );
       echo json_encode($output);
   }

   public function update_exam()
   {
    
        $e_quiz_id= $_POST['e_quiz_id'];
        $e_quiz_title= $this->db->escape_str($_POST['e_quiz_title']);
        $e_quiz_questions= $_POST['e_quiz_questions'];
        $e_quiz_duration= $_POST['e_quiz_duration'];
        $e_test_series= $_POST['e_test_series'];
        $e_correct_answer_mark= $_POST['e_correct_answer_mark'];
        $e_wrong_answer_mark= $_POST['e_wrong_answer_mark'];
        $e_instructions=$this->db->escape_str($_POST['e_instructions']);
        $e_status= $_POST['e_status'];

        $sql="UPDATE test_series_exam_list SET `test_series`='".$e_test_series."',`exam_title`='".$e_quiz_title."',`exam_questions`='".$e_quiz_questions."',`exam_duration`='".$e_quiz_duration."',`correct_answer_mark`='".$e_correct_answer_mark."',`wrong_answer_mark`='".$e_wrong_answer_mark."',`instructions`='".$e_instructions."',`status`='".$e_status."' WHERE test_series_exam_list_id='".$e_quiz_id."' ";

        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Test series exam Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update test series exam.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

        redirect(base_url() . 'Test_series_exam', 'refresh');

   }

   public function add_exam()
   {
        $a_quiz_title= $this->db->escape_str($_POST['a_quiz_title']);
        $a_quiz_questions= $_POST['a_quiz_questions'];
        $a_quiz_duration= $_POST['a_quiz_duration'];
        $a_test_series= $_POST['a_test_series'];
        $a_correct_answer_mark= $_POST['a_correct_answer_mark'];
        $a_wrong_answer_mark= $_POST['a_wrong_answer_mark'];
        $a_instructions=$this->db->escape_str($_POST['a_instructions']);
        $a_status= $_POST['a_status'];


        $sql="SELECT * FROM test_series_exam_list WHERE exam_title='".$a_quiz_title."' AND test_series='".$a_test_series."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            $art_msg['msg'] = 'Test series exam already present.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $sql="INSERT INTO `test_series_exam_list`(`test_series`, `exam_title`, `exam_questions`, `exam_duration`, `correct_answer_mark`, `wrong_answer_mark`, `instructions`, `status`, `created_at`) VALUES ('".$a_test_series."', '".$a_quiz_title."', '".$a_quiz_questions."', '".$a_quiz_duration."', '".$a_correct_answer_mark."', '".$a_wrong_answer_mark."', '".$a_instructions."', '".$a_status."', '".date('Y-m-d H:i:s')."')";
            $update=$this->common_model->executeNonQuery($sql);
            if($update)
            {
                $art_msg['msg'] = 'New Test series exam Updated.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
            else
            {
                $art_msg['msg'] = 'Error to update test series exam.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        }
        redirect(base_url() . 'Test_series_exam', 'refresh');
   }

   public function addquation()
   {
     $quiz_id= $this->input->post('quiz_id');
     $quiz_quation= $this->input->post('quiz_quation');
     $quiz_opt1= $this->input->post('quiz_opt1');
     $quiz_opt2= $this->input->post('quiz_opt2');
     $quiz_opt3= $this->input->post('quiz_opt3');
     $quiz_opt4= $this->input->post('quiz_opt4');
     $quiz_status= $this->input->post('quiz_status');
     $quiz_ans= $this->input->post('quiz_ans');
     $section= $this->input->post('section');
     $edit_id= $this->input->post('edit_id');
     $explanation=$this->input->post('explanation');


     if($edit_id==0)
     {

         $sql="SELECT * FROM test_series_questions WHERE test_series='".$quiz_id."' AND question='".$quiz_quation."' ";
         $check=$this->common_model->executeRow($sql);
         if(!$check)
         {
          $sql="INSERT INTO `test_series_questions`( `test_series`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `explanation`, `status`, `created_at`, `subject_id`) VALUES ('".$quiz_id."', '".$quiz_quation."', '".$quiz_opt1."', '".$quiz_opt2."', '".$quiz_opt3."', '".$quiz_opt4."', '".$quiz_ans."', '".$explanation."', '".$quiz_status."', '".date('Y-m-d H:i:s')."', '".$section."')";
            // echo $sql;
            // exit(0);
            $insert=$this->common_model->executeNonQuery($sql);
            if($insert)
            {
              echo "Success";
            }
            else
            {
              echo "Operation failed";
            }
         }
         else
         {
           echo "Exists";
         }
     }
     else
     {
        $sql="UPDATE test_series_questions SET `question`='".$quiz_quation."', `option1`='".$quiz_opt1."', `option2`='".$quiz_opt2."', `option3`='".$quiz_opt3."', `option4`='".$quiz_opt4."', `answer`='".$quiz_ans."', `explanation`='', `status`='".$quiz_status."', `subject_id`='".$section."', `explanation`='".$explanation."' WHERE test_series_questions_id='".$edit_id."' ";

            $insert=$this->common_model->executeNonQuery($sql);
            if($insert)
            {
              echo "Success";
            }
            else
            {
              echo "Operation failed";
            }
     }
   }
    
    public function deletequiz($id)
    {
        
        $sql="DELETE FROM test_series_exam_list WHERE test_series_exam_list_id =".$id." ";
        $delete=$this->common_model->executeNonQuery($sql);
        if($delete)
        {
            $sql="DELETE FROM test_series_questions WHERE test_series='".$id."' ";
            $delete=$this->common_model->executeNonQuery($sql);
            echo "Success";
        }
        else
        {
            echo "Error";
        }
    }
    
   public function deletequizqua($id)
   {
      if(isset($_REQUEST['id']))
      {
        $id=$_REQUEST['id'];

         $sql="DELETE FROM test_series_questions WHERE test_series_questions_id='".$id."' ";
         $delete=$this->common_model->executeNonQuery($sql);
         if($delete)
         {
            echo 'Success';

         }
         else
         {
            echo "FALSE 1";
         }
      }
      else
      {
        echo "FALSE 2";
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

    function get_qtn_details()
    {
      $return_array=array();
      if(isset($_POST['id']))
      {
        $id=$_POST['id'];

         $sql="SELECT * FROM test_series_questions WHERE test_series_questions_id='".$id."' ";
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

            $return_array=array("test_series_questions_id"=>$check->test_series_questions_id, "subject_id"=>$check->subject_id, "test_series"=>$check->test_series, "question"=>$check->question, "question_image"=>$check->question_image, "question_type"=>$check->question_type, "option1"=>$check->option1, "option2"=>$check->option2, "option3"=>$check->option3, "option4"=>$check->option4, "answer"=>$check->answer, "explanation"=>$check->explanation, "status"=>$check->status, "select_ans"=>$cnt);
         }

      }


      echo json_encode($return_array);
    }
    
    public function importQuestions(){
        $this->load->model("Test_series_exam_model");
        
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
                   
                    $inserdata[$i]['test_series'] = $quiz_id;
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
                $result = $this->Test_series_exam_model->insert($inserdata);
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
        redirect(base_url() . 'Test_series_exam', 'refresh');
        
    }
}