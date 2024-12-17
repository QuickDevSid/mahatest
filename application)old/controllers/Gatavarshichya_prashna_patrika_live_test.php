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

class Gatavarshichya_prashna_patrika_live_test extends CI_Controller
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
        $this->load->view('gatavarshichya_prashna_patrika_year_title/index', $data);
        $this->load->view('gatavarshichya_prashna_patrika_year_title/add',$data);
      //  $this->load->view('gatavarshichya_prashna_patrika_live_test/add_quize_qua',$data);
        $this->load->view('gatavarshichya_prashna_patrika_year_title/add_quize_qua',$data);
        $this->load->view('gatavarshichya_prashna_patrika_year_title/import_quiz_question',$data);
        $this->load->view('gatavarshichya_prashna_patrika_year_title/show_quize',$data);
        $this->load->view('gatavarshichya_prashna_patrika_year_title/edit',$data);

        $this->load->view('templates/footer1', $data);
        
        $this->load->view('gatavarshichya_prashna_patrika_year_title/jscript.php', $data);
       // $this->load->view('gatavarshichya_prashna_patrika_live_test/jscript_quiz', $data);
    }

    function fetch_data()
   {
       $sql="SELECT * FROM gatavarshichya_prashna_patrika_year_title ORDER BY question_papers_id DESC";
       $fetch_data=$this->common_model->executeArray($sql);
       $data = array();
       foreach ($fetch_data as $row) {
           $sub_array = array();

           $sql="SELECT * FROM gatavarshichya_prashna_patrika_year WHERE year_id='".$row->question_paper_year."' ";
           // echo $sql;
           $year=$this->common_model->executeRow($sql);
          // print_r($exam);
         //   $sub_array[] = '<button type="button" name="Details" onclick="getquizDetails(this.id)" id="details_' . $row->test_series_exam_list_id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showquiz">
         // <i class="material-icons">visibility</i> </button>';
         $sub_array[] = '
          <button type="button" name="Edit" onclick="getquizeEdit(this.id)" id="client_' . $row->question_papers_id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#editquiz" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deletequizDetails(this.id)" id="delete_' . $row->question_papers_id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>

          <button type="button" name="Add" onclick="addquizQuaDetails(this.id)" id="Add_' . $row->question_papers_id . '" data-type="confirm" class="btn bg-green waves-effect btn-xs" data-toggle="modal" data-target="#addquizqua">
        <i class="material-icons">add</i></button>
        <button type="button" name="Import" onclick="importExcel(this.id)" id="Import_' . $row->question_papers_id . '" data-type="confirm" class="btn bg-green waves-effect btn-xs" data-toggle="modal" data-target="#importQuestion">
        <i class="material-icons">cloud_upload</i></button>
          ';

           $sub_array[] = $year->question_paper_year;
           $sub_array[] = $row->paper_title;
           $sub_array[] = $row->total_questions;
           $sub_array[] = $row->duration;
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
            $sql="SELECT * FROM gatavarshichya_prashna_patrika_year_title WHERE question_papers_id='".$id."' LIMIT 1 ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="SELECT * FROM gatavarshichya_prashna_patrika_year WHERE question_paper_id='".$check->question_papers_id."'";
                $year=$this->common_model->executeRow($sql);

                if($check->pdf_url!="")
                {
                    $file='<a target="_blank" href="'.base_url().'AppAPI/gatavarshichya_prashna_patrika_year_title/'.$check->pdf_url.'">View Uploaded File</a>';
                }

                $return_array=array("quiz_id"=>$check->question_papers_id, "s_quiz_title"=>$check->paper_title, "quiz_duration"=>$check->duration, "quiz_questions"=>$check->total_questions, "status"=>$check->status, "created_at"=>date('Y-m-d',strtotime($check->created_at)), "correct_answer_mark"=>$check->correct_answer_mark, "wrong_answer_mark"=>$check->wrong_answer_mark, "instructions"=>$check->instructions, "year"=>$year->question_paper_year, "file"=>$file );
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
      $sql="SELECT * FROM gatavarshichya_prashna_patrika_live_test WHERE question_papers_id='".$id."' ";
       $fetch_data = $this->common_model->executeArray($sql);
       $data = array();
       foreach ($fetch_data as $row) {

            $sql="SELECT * FROM `quiz_subject` WHERE subject_id='".$row->subject_id."' ";
            $subject=$this->common_model->executeRow($sql);
           $sub_array = array();
           $sub_array[] = '

          <button type="button" name="Delete" onclick="deletequaDetails(this.id,this.value)" value="'.$row->live_test_id.'"  id="delete_' . $row->live_test_id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>

          <button type="button" name="edit" onclick="edit_qtn('.$row->live_test_id.')"  data-type="confirm" class="btn bg-red waves-effect btn-xs">
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
    
        $a_year= $this->db->escape_str($_POST['a_year']);
        $a_quiz_title= $this->db->escape_str($_POST['a_quiz_title']);
        $a_quiz_questions= $_POST['a_quiz_questions'];
        $a_quiz_duration= $_POST['a_quiz_duration'];
        $a_test_series= $_POST['a_test_series'];
        $a_correct_answer_mark= $_POST['a_correct_answer_mark'];
        $a_wrong_answer_mark= $_POST['a_wrong_answer_mark'];
        $a_instructions=$this->db->escape_str($_POST['a_instructions']);
        $a_status= $_POST['a_status'];
        $id= $_POST['a_quiz_id'];
        $sql="SELECT * FROM gatavarshichya_prashna_patrika_year_title WHERE question_papers_id='".$id."' ";
        $check=$this->common_model->executeRow($sql);

        if($check)
        {

            $name='pdf_file';

            if (!empty($_FILES[$name]['name']))
            {
                $newname = $this->upload();
                $pdf = $newname;
            }
            else
            {
                $pdf = $check->pdf_url;
            }

            $sql="UPDATE gatavarshichya_prashna_patrika_year_title SET `paper_title`='".$a_quiz_title."', `total_questions`='".$a_quiz_questions."', `duration`='".$a_quiz_duration."', `correct_answer_mark`='".$a_correct_answer_mark."', `wrong_answer_mark`='".$a_wrong_answer_mark."', `instructions`='".$a_instructions."', `status`='".$a_status."', `pdf_url`='".$pdf."',`question_paper_year`='".$a_year."' WHERE question_papers_id='".$id."' ";

            $update=$this->common_model->executeNonQuery($sql);
            if($update)
            {
              //  $sql="UPDATE gatavarshichya_prashna_patrika_year SET question_paper_year='".$a_year."' WHERE question_paper_id='".$id."' AND year_id='".$check->question_paper_year."' ";
              //  $this->common_model->executeNonQuery($sql);

                $art_msg['msg'] = 'Title Updated.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
            else
            {
                $art_msg['msg'] = 'Error to update title.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        }
        else
        {
            $art_msg['msg'] = 'Something error.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        redirect(base_url() . 'Gatavarshichya_prashna_patrika_live_test', 'refresh');

   }
    function upload()
    {
        $name='pdf_file';
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/gatavarshichya_prashna_patrika_year_title';
            $config['upload_url'] = base_url() . 'AppAPI/gatavarshichya_prashna_patrika_year_title';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/gatavarshichya_prashna_patrika_year_title/" . $newname);
            return $newname;
        }
    }

   public function add_exam()
   {
        $a_year= $this->db->escape_str($_POST['a_year']);
        $a_quiz_title= $this->db->escape_str($_POST['a_quiz_title']);
        $a_quiz_questions= $_POST['a_quiz_questions'];
        $a_quiz_duration= $_POST['a_quiz_duration'];
        $a_test_series= $_POST['a_test_series'];
        $a_correct_answer_mark= $_POST['a_correct_answer_mark'];
        $a_wrong_answer_mark= $_POST['a_wrong_answer_mark'];
        $a_instructions=$this->db->escape_str($_POST['a_instructions']);
        $a_status= $_POST['a_status'];
        $name='pdf_file';

        if (!empty($_FILES[$name]['name']))
        {
            $newname = $this->upload();
            $pdf = $newname;
        }
        else
        {
            $pdf = 'study1.png';
        }

        $sql="SELECT * FROM gatavarshichya_prashna_patrika_year_title WHERE paper_title='".$a_quiz_title."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            $art_msg['msg'] = 'Title already present.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $sql="INSERT INTO `gatavarshichya_prashna_patrika_year_title`( `paper_title`, `total_questions`, `duration`, `correct_answer_mark`, `wrong_answer_mark`, `instructions`, `status`, `created_at`, `pdf_url`, `question_paper_year`) VALUES ('".$a_quiz_title."', '".$a_quiz_questions."', '".$a_quiz_duration."', '".$a_correct_answer_mark."', '".$a_wrong_answer_mark."', '".$a_instructions."', '".$a_status."', '".date('Y-m-d H:i:s')."', '".$pdf."', '".$a_year."')";
            $update=$this->common_model->executeNonQuery($sql);
            if($update)
            {
                $id=$this->db->insert_id();

              //  $sql="INSERT INTO `gatavarshichya_prashna_patrika_year`(`question_paper_id`, `question_paper_year`, `status`, `created_at`) VALUES ('".$id."', '".$a_year."', 'Active', '".date('Y-m-d H:i:s')."')";
              //  $year_data=$this->common_model->executeNonQuery($sql);
               // $year_id=$this->db->insert_id();


               // $sql="UPDATE gatavarshichya_prashna_patrika_year_title SET question_paper_year='".$year_id."' WHERE question_papers_id='".$id."' ";
               // $this->common_model->executeNonQuery($sql);

                $art_msg['msg'] = 'New Title Updated.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
            else
            {
                $art_msg['msg'] = 'Error to update title.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        }
        redirect(base_url() . 'Gatavarshichya_prashna_patrika_live_test', 'refresh');
   }

    function upload_exam()
    {
        $name='image';
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config2['upload_path'] = 'AppAPI/Gatavarshichya_prashna_patrika_live_test';
            $config2['upload_url'] = base_url() . 'AppAPI/Gatavarshichya_prashna_patrika_live_test';
            $config2['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config2['max_size'] = '2000000';
            $config2['file_name'] = $newname;
            $this->load->library('upload', $config2);
            move_uploaded_file($tmpname, "AppAPI/Gatavarshichya_prashna_patrika_live_test/" . $newname);
            return $newname;
    }

   public function addquation()
   {
     $quiz_id=$this->db->escape_str( $this->input->post('quiz_id'));
     $quiz_quation=$this->db->escape_str( $this->input->post('quiz_quation'));
     $quiz_opt1=$this->db->escape_str( $this->input->post('quiz_opt1'));
     $quiz_opt2=$this->db->escape_str( $this->input->post('quiz_opt2'));
     $quiz_opt3=$this->db->escape_str( $this->input->post('quiz_opt3'));
     $quiz_opt4= $this->db->escape_str($this->input->post('quiz_opt4'));
     $quiz_status=$this->db->escape_str( $this->input->post('quiz_status'));
     $quiz_ans=$this->db->escape_str( $this->input->post('quiz_ans'));
     $explanation=$this->db->escape_str( $this->input->post('explanation'));
     $image = 'study1.png';
     $edit_id= $this->input->post('edit_id');


    $subject_id= $this->input->post('subject_id');
    $type= $this->input->post('type');

    // $name='image';
    // if (!empty($_FILES[$name]['name']))
    // {
    //     $newname = $this->upload_exam();
    //     $image = $newname;
    // }
    // else
    // {
    //     $image = 'study1.png';
    // }


    // print_r($_POST);
    if($edit_id==0)
    {
       $sql="SELECT * FROM gatavarshichya_prashna_patrika_live_test WHERE question_papers_id='".$quiz_id."' AND question='".$quiz_quation."' ";
       $check=$this->common_model->executeRow($sql);
       if(!$check)
       {
        $sql="INSERT INTO `gatavarshichya_prashna_patrika_live_test`( `question_papers_id`,`subject_id` ,`question`, `option1`, `option2`, `option3`, `option4`, `answer`, `explanation`, `status`, `question_type`, `question_image`) VALUES ('".$quiz_id."','".$subject_id."', '".$quiz_quation."', '".$quiz_opt1."', '".$quiz_opt2."', '".$quiz_opt3."', '".$quiz_opt4."', '".$quiz_ans."', '".$explanation."' ,'".$quiz_status."', '".$type."', '".$image."' )";
  //        echo $sql;
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
        $sql="UPDATE gatavarshichya_prashna_patrika_live_test SET `question`='".$quiz_quation."', `option1`='".$quiz_opt1."', `option2`='".$quiz_opt2."', `option3`='".$quiz_opt3."', `option4`='".$quiz_opt4."', `answer`='".$quiz_ans."', `explanation`='".$explanation."', `status`='".$quiz_status."', `subject_id`='".$subject_id."', `question_papers_id`='".$quiz_id."' WHERE live_test_id='".$edit_id."' ";

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

         $sql="SELECT * FROM gatavarshichya_prashna_patrika_live_test WHERE live_test_id='".$id."' ";
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

            $return_array=array("id"=>$check->live_test_id, "subject_id"=>$check->subject_id, "quiz_id"=>$check->question_papers_id, "question"=>$check->question, "question_image"=>$check->question_image, "question_type"=>$check->question_type, "option1"=>$check->option1, "option2"=>$check->option2, "option3"=>$check->option3, "option4"=>$check->option4, "answer"=>$check->answer, "explanation"=>$check->explanation, "status"=>$check->status, "select_ans"=>$cnt, "type"=>$check->question_type);
         }

      }


      echo json_encode($return_array);
    }



   public function deletequizqua($id)
   {
        $sql="SELECT * FROM gatavarshichya_prashna_patrika_live_test WHERE live_test_id='".$id."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            $sql="DELETE FROM gatavarshichya_prashna_patrika_live_test WHERE live_test_id='".$id."'";
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
            
            $sql="SELECT * FROM `gatavarshichya_prashna_patrika` WHERE JSON_CONTAINS(selected_exam_id, '[\"".$id."\"]') ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $response_array[]=array("id"=>$value->gatavarshichya_prashna_patrika_id , "name"=>$value->exam_name);
                }
            }
        }
        echo json_encode($response_array);
    }
    
    public function get_select_1()
    {
        $response_array=array();
        $data_array=array();
        
        if(isset($_POST['id']))
        {
            $id=$_POST['id'];
            
            $sql="SELECT * FROM `gatavarshichya_prashna_patrika_year` WHERE question_paper_id='".$id."' ";
            $check=$this->common_model->executeArray($sql);
            if($check)
            {
                foreach ($check as $value)
                {
                    $response_array[]=array("id"=>$value->year_id  , "name"=>$value->question_paper_year);
                }
            }
        }
        echo json_encode($response_array);
    }
    
    
    public function importQuestions(){
        $this->load->model("Gatavarshichya_prashna_patrika_live_test_model");
        
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
                    
                    $inserdata[$i]['question_papers_id'] = $quiz_id;
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
                $result = $this->Gatavarshichya_prashna_patrika_live_test_model->insert($inserdata);
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
        redirect(base_url() . 'Gatavarshichya_prashna_patrika_live_test', 'refresh');
        
    }
}
