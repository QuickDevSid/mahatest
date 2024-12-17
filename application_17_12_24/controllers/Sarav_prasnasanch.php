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

class Sarav_prasnasanch extends CI_Controller
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
        $this->load->view('sarav_prasnasanch/index', $data);
        $this->load->view('sarav_prasnasanch/add',$data);
        $this->load->view('sarav_prasnasanch/add_quize_qua',$data);
        $this->load->view('sarav_prasnasanch/show_quize',$data);
        $this->load->view('sarav_prasnasanch/import_quiz_question',$data);
        $this->load->view('sarav_prasnasanch/edit',$data);

        $this->load->view('templates/footer1', $data);
        $this->load->view('sarav_prasnasanch/jscript.php', $data);
    }

    function fetch_data()
   {
       $sql="SELECT * FROM sarav_prasnasanch ORDER BY sarav_prasnasanch_id DESC";
       $fetch_data=$this->common_model->executeArray($sql);
       $data = array();
       foreach ($fetch_data as $row) {
           $sub_array = array();

           $sql="SELECT * FROM sarav_prashnasanch_subjects WHERE sarav_prashnasanch_subjects_id='".$row->sarav_prashnasanch_subjects_id."' ";
           // echo $sql;
           $exam=$this->common_model->executeRow($sql);
          // print_r($exam);
         //   $sub_array[] = '<button type="button" name="Details" onclick="getquizDetails(this.id)" id="details_' . $row->sarav_prasnasanch_id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showquiz">
         // <i class="material-icons">visibility</i> </button>';
         
         
$sub_array[] = '
          <button type="button" name="Edit" onclick="getquizeEdit(this.id)" id="client_' . $row->sarav_prasnasanch_id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#editquiz" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deletequizDetails(this.id)" id="delete_' . $row->sarav_prasnasanch_id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          <button type="button" name="Add" onclick="addquizQuaDetails(this.id)" id="Add_' . $row->sarav_prasnasanch_id . '" data-type="confirm" class="btn bg-green waves-effect btn-xs" data-toggle="modal" data-target="#addquizqua">
        <i class="material-icons">add</i></button>
        <button type="button" name="Import" onclick="importExcel(this.id)" id="Import_' . $row->sarav_prasnasanch_id . '" data-type="confirm" class="btn bg-green waves-effect btn-xs" data-toggle="modal" data-target="#importQuestion">
        <i class="material-icons">cloud_upload</i></button>
          ';

           
           $sub_array[] = $row->quiz_title;
           $sub_array[] = $exam->subject_name;
           $sub_array[] = $row->quiz_questions;
           $sub_array[] = $row->quiz_duration;
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
            $sql="SELECT * FROM sarav_prasnasanch WHERE sarav_prasnasanch_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {


                $exam_id="";
                $sql="SELECT * FROM `sarav_prashnasanch_subjects` WHERE sarav_prashnasanch_subjects_id='".$check->sarav_prashnasanch_subjects_id."' ";
                $exam=$this->common_model->executeRow($sql);
                if($exam)
                {
                    $exam_id=json_decode($exam->selected_exams_id);
                }

                $return_array=array("selected_exams_id"=>$exam_id, "quiz_id"=>$check->sarav_prasnasanch_id, "sarav_prashnasanch_subjects_id"=>$check->sarav_prashnasanch_subjects_id,"selected_exams_id1"=>$check->selected_exams_id, "quiz_title"=>$check->quiz_title, "quiz_duration"=>$check->quiz_duration, "quiz_questions"=>$check->quiz_questions, "status"=>$check->status, "created_at"=>date('Y-m-d',strtotime($check->created_at)), "correct_answer_mark"=>$check->correct_answer_mark, "wrong_answer_mark"=>$check->wrong_answer_mark, "instructions"=>$check->instructions);
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
      $sql="SELECT * FROM sarav_prashnasanch_question WHERE sarav_prasnasanch_id='".$id."' ";
       $fetch_data = $this->common_model->executeArray($sql);
       $data = array();
       foreach ($fetch_data as $row) {
           $sub_array = array();
    
           $sql="SELECT * FROM `quiz_subject` WHERE subject_id='".$row->subject_id."' ";
           $subject=$this->common_model->executeRow($sql);
           
           $sub_array[] = '

          <button type="button" name="Delete" onclick="deletequaDetails(this.id,this.value)" value="'.$row->user_id.'"  id="delete_' . $row->sarav_prashnasanch_question_id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>

          <button type="button" name="edit" onclick="edit_qtn('.$row->sarav_prashnasanch_question_id.')"  data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">edit</i></button>


          ';
           $sub_array[] = $subject->subject_name;
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
        $e_subject_id= $_POST['e_subject_name'];
        $e_exams=  json_encode($_POST['e_exams']);


        $e_quiz_title= $this->db->escape_str($_POST['e_quiz_title']);
        $e_quiz_questions= $_POST['e_quiz_questions'];
        $e_quiz_duration= $_POST['e_quiz_duration'];
        $e_correct_answer_mark= $_POST['e_correct_answer_mark'];
        $e_wrong_answer_mark= $_POST['e_wrong_answer_mark'];
        $e_instructions=$this->db->escape_str($_POST['e_instructions']);
        $e_status= $_POST['e_status'];

        $sql="UPDATE sarav_prasnasanch SET `sarav_prashnasanch_subjects_id`='".$e_subject_id."',`selected_exams_id`='".$e_exams."',`quiz_title`='".$e_quiz_title."',`quiz_questions`='".$e_quiz_questions."',`quiz_duration`='".$e_quiz_duration."',`correct_answer_mark`='".$e_correct_answer_mark."',`wrong_answer_mark`='".$e_wrong_answer_mark."',`instructions`='".$e_instructions."',`status`='".$e_status."' WHERE sarav_prasnasanch_id='".$e_quiz_id."' ";

        $update=$this->common_model->executeNonQuery($sql);
        if($update)
        {
            $art_msg['msg'] = 'Sarav prasnasanch Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $art_msg['msg'] = 'Error to update sarav prasnasanch.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }

        redirect(base_url() . 'Sarav_prasnasanch', 'refresh');

   }

   public function add_exam()
   {

        $a_subject_id= $_POST['a_subject_name'];
        $a_exams=  json_encode($_POST['a_exams']);

        $a_quiz_title= $this->db->escape_str($_POST['a_quiz_title']);
        $a_quiz_questions= $_POST['a_quiz_questions'];
        $a_quiz_duration= $_POST['a_quiz_duration'];
        $a_correct_answer_mark= $_POST['a_correct_answer_mark'];
        $a_wrong_answer_mark= $_POST['a_wrong_answer_mark'];
        $a_instructions=$this->db->escape_str($_POST['a_instructions']);
        $a_status= $_POST['a_status'];


        $sql="SELECT * FROM sarav_prasnasanch WHERE quiz_title='".$a_quiz_title."' AND selected_exams_id='".$a_exam."' AND sarav_prashnasanch_subjects_id='".$a_subject_id."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            $art_msg['msg'] = 'Sarav prasnasanch already present.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $sql="INSERT INTO `sarav_prasnasanch`(`sarav_prashnasanch_subjects_id`, `selected_exams_id`, `quiz_title`, `quiz_questions`, `quiz_duration`, `correct_answer_mark`, `wrong_answer_mark`, `instructions`, `status`, `created_at`) VALUES ('".$a_subject_id."', '".$a_exams."' ,'".$a_quiz_title."', '".$a_quiz_questions."', '".$a_quiz_duration."', '".$a_correct_answer_mark."', '".$a_wrong_answer_mark."', '".$a_instructions."', '".$a_status."', '".date('Y-m-d H:i:s')."')";
            $update=$this->common_model->executeNonQuery($sql);
            if($update)
            {
                $art_msg['msg'] = 'New sarav prasnasanch Updated.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
            else
            {
                $art_msg['msg'] = 'Error to update sarav prasnasanch.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        }
        redirect(base_url() . 'Sarav_prasnasanch', 'refresh');
   }


    function upload()
    {
        $name='image';
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config2['upload_path'] = 'AppAPI/sarav-prashnasanch-question-images';
            $config2['upload_url'] = base_url() . 'AppAPI/sarav-prashnasanch-question-images';
            $config2['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config2['max_size'] = '2000000';
            $config2['file_name'] = $newname;
            $this->load->library('upload', $config2);
            move_uploaded_file($tmpname, "AppAPI/sarav-prashnasanch-question-images/" . $newname);
            return $newname;
    }

   public function addquation()
   {
     $quiz_id=($this->input->post('quiz_id'));
     $quiz_quation=( $this->input->post('quiz_quation'));
     $quiz_opt1=( $this->input->post('quiz_opt1'));
     $quiz_opt2=( $this->input->post('quiz_opt2'));
     $quiz_opt3=( $this->input->post('quiz_opt3'));
     $quiz_opt4=($this->input->post('quiz_opt4'));
    
       $explanation=($this->input->post('explanation'));
       
     $quiz_status=( $this->input->post('quiz_status'));
     $quiz_ans=( $this->input->post('quiz_ans'));
     $image = 'study1.png';
     $edit_id= $this->input->post('edit_id');
    $subject_id= $this->input->post('subject_id');
    $type= $this->input->post('type');

    // $name='image';
    // if (!empty($_FILES[$name]['name']))
    // {
    //     $newname = $this->upload();
    //     $image = $newname;
    // }
    // else
    // {
    //     $image = 'study1.png';
    // }

      if($edit_id==0)
      {
         $sql="SELECT * FROM sarav_prashnasanch_question WHERE sarav_prasnasanch_id='".$quiz_id."' AND question='".$quiz_quation."' ";
         $check=$this->common_model->executeRow($sql);
         if(!$check)
         {
          $sql="INSERT INTO `sarav_prashnasanch_question`( `sarav_prasnasanch_id`,`subject_id` ,`question`, `option1`, `option2`, `option3`, `option4`, `answer`, `explanation`, `status`, `created_at`, `question_type`, `question_image`) VALUES ('".$quiz_id."','".$subject_id."', '".$quiz_quation."', '".$quiz_opt1."', '".$quiz_opt2."', '".$quiz_opt3."', '".$quiz_opt4."', '".$quiz_ans."', '".$explanation."', '".$quiz_status."', '".date('Y-m-d H:i:s')."', '".$type."', '".$image."' )";
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
        $sql="UPDATE sarav_prashnasanch_question SET `question`='".$quiz_quation."', `option1`='".$quiz_opt1."', `option2`='".$quiz_opt2."', `option3`='".$quiz_opt3."', `option4`='".$quiz_opt4."', `answer`='".$quiz_ans."', `explanation`='', `status`='".$quiz_status."', `subject_id`='".$subject_id."', `explanation`='".$explanation."' WHERE sarav_prashnasanch_question_id='".$edit_id."' ";

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
    function get_qtn_details()
    {
      $return_array=array();
      if(isset($_POST['id']))
      {
        $id=$_POST['id'];

         $sql="SELECT * FROM sarav_prashnasanch_question WHERE sarav_prashnasanch_question_id='".$id."' ";
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

            $return_array=array("id"=>$check->sarav_prashnasanch_question_id, "subject_id"=>$check->subject_id, "quiz_id"=>$check->sarav_prasnasanch_id, "question"=>$check->question, "question_image"=>$check->question_image, "question_type"=>$check->question_type, "option1"=>$check->option1, "option2"=>$check->option2, "option3"=>$check->option3, "option4"=>$check->option4, "answer"=>$check->answer, "explanation"=>$check->explanation, "status"=>$check->status, "select_ans"=>$cnt, "type"=>$check->question_type);
         }

      }


      echo json_encode($return_array);
    }



   public function deletequiz($id)
   {

        $sql="DELETE FROM sarav_prasnasanch WHERE sarav_prasnasanch_id=".$id." ";
        $delete=$this->common_model->executeNonQuery($sql);
        if($delete)
        {
            $sql="DELETE FROM sarav_prashnasanch_question WHERE sarav_prasnasanch_id='".$id."' ";
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
            $sql="DELETE FROM sarav_prashnasanch_question WHERE sarav_prashnasanch_question_id='".$id."' ";
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

    public function get_select()
    {
        $response_array=array();
        $data_array=array();

        if(isset($_POST['id']))
        {
            $id=$_POST['id'];
            // $sql="SELECT * FROM `abhyas_sahitya_category` WHERE selected_exams_id='".$id."' ";

            $sql="SELECT * FROM `sarav_prashnasanch_subjects` WHERE JSON_CONTAINS(selected_exams_id, '[\"".$id."\"]') ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $response_array[]=array("id"=>$value->sarav_prashnasanch_subjects_id, "name"=>$value->subject_name);
                }
            }
        }
        echo json_encode($response_array);
    }
    
    
    public function importQuestions(){
        $this->load->model("Sarav_prasnasanch_model");
        
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
                   
                    $inserdata[$i]['sarav_prasnasanch_id'] = $quiz_id;
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
                $result = $this->Sarav_prasnasanch_model->insert($inserdata);
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
        redirect(base_url() . 'Sarav_prasnasanch', 'refresh');
        
    }
}
