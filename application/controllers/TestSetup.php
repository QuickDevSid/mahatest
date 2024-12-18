<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// require_once APPPATH.'vendor/autoload.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Firebase\JWT\JWT;

class TestSetup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("TestSetup_Model");
    }
    public function test_setup()
    {
        // $data['title'] = ucfirst('Test Setup');
        $data['single'] = $this->TestSetup_Model->get_single_test_setup(); //
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('testSetup/test_setup', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('testSetup/jscript.php', $data);
    }
    public function test_gallary()
    {
        // $data['title'] = ucfirst('Test Setup');
        $data['videos'] = $this->TestSetup_Model->get_all_master_images();
        // echo '<pre>'; print_r($data['videos']); exit;
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('testSetup/add_test_gallary', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('testSetup/test_gallary_script.php', $data);
    }
    public function add_test_passages()
    {
        // $data['title'] = ucfirst('Test Setup');
        $data['single'] = $this->TestSetup_Model->get_single_test_setup(); //
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('testSetup/add_test_passages', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('testSetup/jscript.php', $data);
    }
    public function test_list()
    {
        $data['title'] = ucfirst('Test List');
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('testSetup/test_list', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('testSetup/test_list_script.php', $data);
    }
    public function questions_list()
    {
        $data['title'] = ucfirst('Test Questions List');
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('testSetup/questions_list', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('testSetup/jscript.php', $data);
    }
    public function add_data()
    {
        $this->form_validation->set_rules('topic', 'Topic', 'required');
        $data['single'] = $this->TestSetup_Model->get_single_test_setup();
        // $this->load->view('testSetup/test_setup', $data);

        if ($this->form_validation->run() === TRUE) {

            $status = false;
            $bulk_data = array();
            $total_questions = 0;
            $total_marks = 0;
            $questions_file = $this->input->post('current_file');
            // echo $questions_file;
            // exit;

            if (isset($_FILES['bulk_file']) && $_FILES['bulk_file']['name'] != "") {
                // echo "inside bulk_file"; // Debugging statement for checking if the file upload section is reached
                // exit;
                // File upload configuration
                $upload_dir = 'assets/uploads/questions_bulk/';
                $questions_file = $_FILES['bulk_file']['name'];
                // Create directory if it doesn't exist
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $file_path = $_FILES['bulk_file']['tmp_name'];
                $destination = $upload_dir . $questions_file;
                if (move_uploaded_file($file_path, $destination)) {
                    // File upload successful, process the Excel file
                    try {
                        $spreadsheet = IOFactory::load($destination);
                        // Process the uploaded file (same as your logic to extract questions from the file)
                        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                            $highestRow = $worksheet->getHighestRow();
                            $highestColumn = $worksheet->getHighestColumn();
                            for ($row = 2; $row <= $highestRow; $row++) {
                                if ($worksheet->getCell('A' . $row)->getValue() != '') {
                                    $question = $worksheet->getCell('A' . $row)->getValue();
                                    $question_type = $worksheet->getCell('K' . $row)->getValue();
                                    $options_1 = $worksheet->getCell('B' . $row)->getValue();
                                    $options_2 = $worksheet->getCell('C' . $row)->getValue();
                                    $options_3 = $worksheet->getCell('D' . $row)->getValue();
                                    $options_4 = $worksheet->getCell('E' . $row)->getValue();
                                    $answer_column = $worksheet->getCell('F' . $row)->getValue();
                                    $solution = $worksheet->getCell('G' . $row)->getValue();
                                    $asked_exam = $worksheet->getCell('H' . $row)->getValue();
                                    $positive_marks = (int)$worksheet->getCell('I' . $row)->getValue();
                                    $negative_marks = (int)$worksheet->getCell('J' . $row)->getValue();
                                    $passage = $worksheet->getCell('L' . $row)->getValue();

                                    if($question_type == 'image_question_text_option'){
                                        $passage = '';
                                        $question_image = $question;
                                        $question = '';
                                        $options_4_image = '';
                                        $options_4 = $options_4;
                                        $options_3_image = '';
                                        $options_3 = $options_3;
                                        $options_2_image = '';
                                        $options_2 = $options_2;
                                        $options_1_image = '';
                                        $options_1 = $options_1;
                                        $type = '1';
                                        
                                        if ($answer_column == 'Option 1') {
                                            $answer = $options_1;
                                            $answer_column = 'option_1';
                                        } elseif ($answer_column == 'Option 2') {
                                            $answer = $options_2;
                                            $answer_column = 'option_2';
                                        } elseif ($answer_column == 'Option 3') {
                                            $answer = $options_3;
                                            $answer_column = 'option_3';
                                        } elseif ($answer_column == 'Option 4') {
                                            $answer = $options_4;
                                            $answer_column = 'option_4';
                                        } else {
                                            $answer = '';
                                            $answer_column = '';
                                        }
                                    }elseif($question_type == 'text_question_image_option'){
                                        $passage = '';
                                        $question_image = '';
                                        $question = $question;
                                        $options_4_image = $options_4;
                                        $options_4 = '';
                                        $options_3_image = $options_3;
                                        $options_3 = '';
                                        $options_2_image = $options_2;
                                        $options_2 = '';
                                        $options_1_image = $options_1;
                                        $options_1 = '';
                                        $type = '1';

                                        if ($answer_column == 'Option 1') {
                                            $answer = $options_1_image;
                                            $answer_column = 'option_1';
                                        } elseif ($answer_column == 'Option 2') {
                                            $answer = $options_2_image;
                                            $answer_column = 'option_2';
                                        } elseif ($answer_column == 'Option 3') {
                                            $answer = $options_3_image;
                                            $answer_column = 'option_3';
                                        } elseif ($answer_column == 'Option 4') {
                                            $answer = $options_4_image;
                                            $answer_column = 'option_4';
                                        } else {
                                            $answer = '';
                                            $answer_column = '';
                                        }
                                    }elseif($question_type == 'image_question_image_option'){
                                        $passage = '';
                                        $question_image = $question;
                                        $question = '';
                                        $options_4_image = $options_4;
                                        $options_4 = '';
                                        $options_3_image = $options_3;
                                        $options_3 = '';
                                        $options_2_image = $options_2;
                                        $options_2 = '';
                                        $options_1_image = $options_1;
                                        $options_1 = '';
                                        $type = '1';

                                        if ($answer_column == 'Option 1') {
                                            $answer = $options_1_image;
                                            $answer_column = 'option_1';
                                        } elseif ($answer_column == 'Option 2') {
                                            $answer = $options_2_image;
                                            $answer_column = 'option_2';
                                        } elseif ($answer_column == 'Option 3') {
                                            $answer = $options_3_image;
                                            $answer_column = 'option_3';
                                        } elseif ($answer_column == 'Option 4') {
                                            $answer = $options_4_image;
                                            $answer_column = 'option_4';
                                        } else {
                                            $answer = '';
                                            $answer_column = '';
                                        }
                                    }elseif($question_type == 'passage'){
                                        $passage = $passage;
                                        $question_image = '';
                                        $question = $question;
                                        $options_4_image = '';
                                        $options_4 = $options_4;
                                        $options_3_image = '';
                                        $options_3 = $options_3;
                                        $options_2_image = '';
                                        $options_2 = $options_2;
                                        $options_1_image = '';
                                        $options_1 = $options_1;
                                        $type = '2';

                                        if ($answer_column == 'Option 1') {
                                            $answer = $options_1;
                                            $answer_column = 'option_1';
                                        } elseif ($answer_column == 'Option 2') {
                                            $answer = $options_2;
                                            $answer_column = 'option_2';
                                        } elseif ($answer_column == 'Option 3') {
                                            $answer = $options_3;
                                            $answer_column = 'option_3';
                                        } elseif ($answer_column == 'Option 4') {
                                            $answer = $options_4;
                                            $answer_column = 'option_4';
                                        } else {
                                            $answer = '';
                                            $answer_column = '';
                                        }
                                    }else{
                                        $passage = '';
                                        $question_image = '';
                                        $question = $question;
                                        $options_4_image = '';
                                        $options_4 = $options_4;
                                        $options_3_image = '';
                                        $options_3 = $options_3;
                                        $options_2_image = '';
                                        $options_2 = $options_2;
                                        $options_1_image = '';
                                        $options_1 = $options_1;
                                        $type = '0';

                                        if ($answer_column == 'Option 1') {
                                            $answer = $options_1;
                                            $answer_column = 'option_1';
                                        } elseif ($answer_column == 'Option 2') {
                                            $answer = $options_2;
                                            $answer_column = 'option_2';
                                        } elseif ($answer_column == 'Option 3') {
                                            $answer = $options_3;
                                            $answer_column = 'option_3';
                                        } elseif ($answer_column == 'Option 4') {
                                            $answer = $options_4;
                                            $answer_column = 'option_4';
                                        } else {
                                            $answer = '';
                                            $answer_column = '';
                                        }
                                    }

                                    $bulk_data[] = array(
                                        'passage'           => $passage != "" ? $passage : null,
                                        'question'          => $question != "" ? $question : null,
                                        'question_image'    => $question_image != "" ? $question_image : null,
                                        'question_type'     => $question_type,
                                        'type'              => $type,
                                        'option_1'          => $options_1 != "" ? $options_1 : null,
                                        'option_1_image'    => $options_1_image != "" ? $options_1_image : null,
                                        'option_2'          => $options_2 != "" ? $options_2 : null,
                                        'option_2_image'    => $options_2_image != "" ? $options_2_image : null,
                                        'option_3'          => $options_3 != "" ? $options_3 : null,
                                        'option_3_image'    => $options_3_image != "" ? $options_3_image : null,
                                        'option_4'          => $options_4 != "" ? $options_4 : null,
                                        'option_4_image'    => $options_4_image != "" ? $options_4_image : null,
                                        'answer'            => $answer != "" ? $answer : null,
                                        'answer_column'     => $answer_column != "" ? $answer_column : null,
                                        'solution'          => $solution != "" ? $solution : null,
                                        'asked_exam'        => $asked_exam != "" ? $asked_exam : null,
                                        'positive_marks'    => $positive_marks,
                                        'negative_marks'    => $negative_marks
                                    );
                                    $total_questions++;
                                    $total_marks += $positive_marks;
                                    $status = true;
                                }
                            }
                        }
                    } catch (Exception $e) {
                        // Handle error if the Excel file cannot be loaded
                    }
                } else {
                    // Handle file upload failure
                    $art_msg = array(
                        'msg' => 'File upload failed, please try again.',
                        'type' => 'error'
                    );
                    $this->session->set_userdata('alert_msg', $art_msg);
                    redirect('test-setup', $data);
                    return;
                }
            } else {
                if (!empty($questions_file)) {
                    $upload_dir = 'assets/uploads/questions_bulk/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    $destination = $upload_dir . $questions_file;

                    $spreadsheet = IOFactory::load($destination);
                    foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                        $highestRow = $worksheet->getHighestRow();
                        $highestColumn = $worksheet->getHighestColumn();
                        for ($row = 2; $row <= $highestRow; $row++) {
                            if ($worksheet->getCell('A' . $row)->getValue() != '') {
                                $question = $worksheet->getCell('A' . $row)->getValue();
                                $question_type = $worksheet->getCell('K' . $row)->getValue();
                                $options_1 = $worksheet->getCell('B' . $row)->getValue();
                                $options_2 = $worksheet->getCell('C' . $row)->getValue();
                                $options_3 = $worksheet->getCell('D' . $row)->getValue();
                                $options_4 = $worksheet->getCell('E' . $row)->getValue();
                                $answer_column = $worksheet->getCell('F' . $row)->getValue();
                                $solution = $worksheet->getCell('G' . $row)->getValue();
                                $asked_exam = $worksheet->getCell('H' . $row)->getValue();
                                $positive_marks = (int)$worksheet->getCell('I' . $row)->getValue();
                                $negative_marks = (int)$worksheet->getCell('J' . $row)->getValue();
                                $passage = $worksheet->getCell('L' . $row)->getValue();

                                if($question_type == 'image_question_text_option'){
                                    $passage = '';
                                    $question_image = $question;
                                    $question = '';
                                    $options_4_image = '';
                                    $options_4 = $options_4;
                                    $options_3_image = '';
                                    $options_3 = $options_3;
                                    $options_2_image = '';
                                    $options_2 = $options_2;
                                    $options_1_image = '';
                                    $options_1 = $options_1;
                                    $type = '1';
                                    
                                    if ($answer_column == 'Option 1') {
                                        $answer = $options_1;
                                        $answer_column = 'option_1';
                                    } elseif ($answer_column == 'Option 2') {
                                        $answer = $options_2;
                                        $answer_column = 'option_2';
                                    } elseif ($answer_column == 'Option 3') {
                                        $answer = $options_3;
                                        $answer_column = 'option_3';
                                    } elseif ($answer_column == 'Option 4') {
                                        $answer = $options_4;
                                        $answer_column = 'option_4';
                                    } else {
                                        $answer = '';
                                        $answer_column = '';
                                    }
                                }elseif($question_type == 'text_question_image_option'){
                                    $passage = '';
                                    $question_image = '';
                                    $question = $question;
                                    $options_4_image = $options_4;
                                    $options_4 = '';
                                    $options_3_image = $options_3;
                                    $options_3 = '';
                                    $options_2_image = $options_2;
                                    $options_2 = '';
                                    $options_1_image = $options_1;
                                    $options_1 = '';
                                    $type = '1';

                                    if ($answer_column == 'Option 1') {
                                        $answer = $options_1_image;
                                        $answer_column = 'option_1';
                                    } elseif ($answer_column == 'Option 2') {
                                        $answer = $options_2_image;
                                        $answer_column = 'option_2';
                                    } elseif ($answer_column == 'Option 3') {
                                        $answer = $options_3_image;
                                        $answer_column = 'option_3';
                                    } elseif ($answer_column == 'Option 4') {
                                        $answer = $options_4_image;
                                        $answer_column = 'option_4';
                                    } else {
                                        $answer = '';
                                        $answer_column = '';
                                    }
                                }elseif($question_type == 'image_question_image_option'){
                                    $passage = '';
                                    $question_image = $question;
                                    $question = '';
                                    $options_4_image = $options_4;
                                    $options_4 = '';
                                    $options_3_image = $options_3;
                                    $options_3 = '';
                                    $options_2_image = $options_2;
                                    $options_2 = '';
                                    $options_1_image = $options_1;
                                    $options_1 = '';
                                    $type = '1';

                                    if ($answer_column == 'Option 1') {
                                        $answer = $options_1_image;
                                        $answer_column = 'option_1';
                                    } elseif ($answer_column == 'Option 2') {
                                        $answer = $options_2_image;
                                        $answer_column = 'option_2';
                                    } elseif ($answer_column == 'Option 3') {
                                        $answer = $options_3_image;
                                        $answer_column = 'option_3';
                                    } elseif ($answer_column == 'Option 4') {
                                        $answer = $options_4_image;
                                        $answer_column = 'option_4';
                                    } else {
                                        $answer = '';
                                        $answer_column = '';
                                    }
                                }elseif($question_type == 'passage'){
                                    $passage = $passage;
                                    $question_image = '';
                                    $question = $question;
                                    $options_4_image = '';
                                    $options_4 = $options_4;
                                    $options_3_image = '';
                                    $options_3 = $options_3;
                                    $options_2_image = '';
                                    $options_2 = $options_2;
                                    $options_1_image = '';
                                    $options_1 = $options_1;
                                    $type = '2';

                                    if ($answer_column == 'Option 1') {
                                        $answer = $options_1;
                                        $answer_column = 'option_1';
                                    } elseif ($answer_column == 'Option 2') {
                                        $answer = $options_2;
                                        $answer_column = 'option_2';
                                    } elseif ($answer_column == 'Option 3') {
                                        $answer = $options_3;
                                        $answer_column = 'option_3';
                                    } elseif ($answer_column == 'Option 4') {
                                        $answer = $options_4;
                                        $answer_column = 'option_4';
                                    } else {
                                        $answer = '';
                                        $answer_column = '';
                                    }
                                }else{
                                    $passage = '';
                                    $question_image = '';
                                    $question = $question;
                                    $options_4_image = '';
                                    $options_4 = $options_4;
                                    $options_3_image = '';
                                    $options_3 = $options_3;
                                    $options_2_image = '';
                                    $options_2 = $options_2;
                                    $options_1_image = '';
                                    $options_1 = $options_1;
                                    $type = '0';

                                    if ($answer_column == 'Option 1') {
                                        $answer = $options_1;
                                        $answer_column = 'option_1';
                                    } elseif ($answer_column == 'Option 2') {
                                        $answer = $options_2;
                                        $answer_column = 'option_2';
                                    } elseif ($answer_column == 'Option 3') {
                                        $answer = $options_3;
                                        $answer_column = 'option_3';
                                    } elseif ($answer_column == 'Option 4') {
                                        $answer = $options_4;
                                        $answer_column = 'option_4';
                                    } else {
                                        $answer = '';
                                        $answer_column = '';
                                    }
                                }

                                $bulk_data[] = array(
                                    'passage'           => $passage != "" ? $passage : null,
                                    'question'          => $question != "" ? $question : null,
                                    'question_image'    => $question_image != "" ? $question_image : null,
                                    'question_type'     => $question_type,
                                    'type'              => $type,
                                    'option_1'          => $options_1 != "" ? $options_1 : null,
                                    'option_1_image'    => $options_1_image != "" ? $options_1_image : null,
                                    'option_2'          => $options_2 != "" ? $options_2 : null,
                                    'option_2_image'    => $options_2_image != "" ? $options_2_image : null,
                                    'option_3'          => $options_3 != "" ? $options_3 : null,
                                    'option_3_image'    => $options_3_image != "" ? $options_3_image : null,
                                    'option_4'          => $options_4 != "" ? $options_4 : null,
                                    'option_4_image'    => $options_4_image != "" ? $options_4_image : null,
                                    'answer'            => $answer != "" ? $answer : null,
                                    'answer_column'     => $answer_column != "" ? $answer_column : null,
                                    'solution'          => $solution != "" ? $solution : null,
                                    'asked_exam'        => $asked_exam != "" ? $asked_exam : null,
                                    'positive_marks'    => $positive_marks,
                                    'negative_marks'    => $negative_marks
                                );
                                $total_questions++;
                                $total_marks += $positive_marks;
                                $status = true;
                            }
                        }
                    }
                    // print_r($data);
                    // exit;
                } else {
                    echo "No file uploaded, please upload a file.";
                }
            }
            // Continue with bulk data processing
            $bulk_upload_data = array(
                'status' => $status,
                'total_questions' => $total_questions,
                'total_marks' => $total_marks,
                'bulk_data' => $bulk_data,
            );
            // print_r($bulk_upload_data);
            // exit;
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/test_setup/images",
                    'allowed_types' => "*",
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);
                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $upload_image = $data['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    exit;
                    // redirect('courses/courses_list');
                    return;
                }
            }
            $upload_test_pdf = $this->input->post('current_test_pdf');
            $upload_path = "assets/uploads/test_pdfs/";            
            if (isset($_FILES['test_pdf']) && $_FILES['test_pdf']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => $upload_path,
                    'allowed_types' => "*",
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);
                if ($this->upload->do_upload('test_pdf')) {
                    $data = $this->upload->data();
                    $upload_test_pdf = $data['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    // echo '<pre>';
                    // print_r($error);
                    // exit;
                    // redirect('courses/courses_list');
                    return;
                }
            }
            $result = $this->TestSetup_Model->add_test_data($bulk_upload_data, $questions_file, $upload_image, $upload_test_pdf);
            if ($result == 1) {
                $art_msg = array(
                    'msg' => 'Test added successfully!!!',
                    'type' => 'success'
                );
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect('test-list', $data);
            } elseif ($result == 0) {
                $art_msg = array(
                    'msg' => 'Questions data not available, please try again!!!',
                    'type' => 'error'
                );
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect('test-setup', $data);
            } else {
                $art_msg = array(
                    'msg' => 'Something went wrong, please try again!!!',
                    'type' => 'error'
                );
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect('test-setup', $data);
            }
        }
    }
    
    public function add_passage_data()
    {
        // echo '<pre>'; print_r($_POST); exit();
        $this->form_validation->set_rules('question_type', 'Question Type', 'required');
        if ($this->form_validation->run() === TRUE) {
            $upload_image = $this->input->post('current_group_image');
            if (isset($_FILES['group_image']) && $_FILES['group_image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/master_gallary",
                    'allowed_types' => "*",
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);
                if ($this->upload->do_upload('group_image')) {
                    $data = $this->upload->data();
                    $upload_image = $data['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    exit;
                    // redirect('courses/courses_list');
                    return;
                }
            }
            $result = $this->TestSetup_Model->add_test_passage_data($upload_image);
            if ($result == 1) {
                $art_msg = array(
                    'msg' => 'Test passage added successfully!!!',
                    'type' => 'success'
                );
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect('test-list', $data);
            } elseif ($result == 0) {
                $art_msg = array(
                    'msg' => 'Questions data not available, please try again!!!',
                    'type' => 'error'
                );
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect('test-setup', $data);
            } else {
                $art_msg = array(
                    'msg' => 'Something went wrong, please try again!!!',
                    'type' => 'error'
                );
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect('test-setup', $data);
            }
        }
    }
    
    public function delete_question()
    {
        $result = $this->TestSetup_Model->delete_question($this->uri->segment(3),$this->uri->segment(2));
        redirect('test-questions?test_id=' . $this->uri->segment(2));
    }
    public function delete_image()
    {
        if (isset($_GET['path']) && $_GET['path'] != "") {
            $path = $_GET['path'];

            $file_path = FCPATH . $path;

            if (file_exists($file_path)) {
                if (unlink($file_path)) {
                    $this->session->set_flashdata("success", "Image deleted successfully.");
                } else {
                    $this->session->set_flashdata("error", "Error deleting the image.");
                }
            } else {
                $this->session->set_flashdata("error", "File not found.");
            }
        } else {
            $this->session->set_flashdata("error", "No file specified for deletion.");
        }

        redirect('test-gallary');
    }

    public function add_test_gallary()
    {
        $this->form_validation->set_rules('zipfile', 'File', 'required');
        if ($this->form_validation->run() === FALSE) {
            $upload_image = $this->input->post('current_group_image');
            if (isset($_FILES['zipfile']) && $_FILES['zipfile']['name'] != "") {
                $file_type = strtolower(pathinfo($_FILES['zipfile']['name'], PATHINFO_EXTENSION));
                if ($file_type == 'zip') {
                    $gst_config = array(
                        'upload_path'   => "assets/uploads/master_gallary_files",
                        'allowed_types' => "zip",
                        'encrypt_name'  => true,
                    );
                } else if (in_array($file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    // echo '<pre>'; print_r($file_type);
                    $gst_config = array(
                        'upload_path'   => "assets/uploads/master_gallary",
                        'allowed_types' => "jpg|jpeg|png|gif",
                        'encrypt_name'  => true,
                    );
                } else {
                    $error = array('error' => 'Unsupported file type. Please upload a ZIP or an image file.');
                    $this->session->set_flashdata("error", $error['error']);
                    // echo '<pre>'; print_r($error);
                    // exit;
                    return;
                }
                $this->upload->initialize($gst_config);
                if ($this->upload->do_upload('zipfile')) {
                    $data = $this->upload->data();
                    $upload_image = $data['file_name'];
                    if ($file_type == 'zip') {
	                    $zip_file_path = $data['full_path']; 
	                    $zip = new ZipArchive;
	                    if ($zip->open($zip_file_path) === TRUE) {
	                        $extracted_folder = 'assets/uploads/master_gallary/';
    
	                        $zip->extractTo($extracted_folder);
	                        $zip->close();
	                    } else {    
	                        $error = array('error' => 'Failed to extract the ZIP file');
	                        $this->session->set_flashdata("error", $error['error']);
	                        exit;
	                        return;
	                    }
			}
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    exit;
                    return;
                }
            }
            $result = $this->TestSetup_Model->add_master_gallary_data($upload_image);
            redirect('test-gallary');
        }
    }
    public function delete_test()
    {
        $result = $this->TestSetup_Model->delete_test();
        if ($result == 1) {
            $art_msg = array(
                'msg' => 'Test deleted successfully!!!',
                'type' => 'success'
            );
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect('test-list');
        } else {
            $art_msg = array(
                'msg' => 'Something went wrong, please try again!!!',
                'type' => 'error'
            );
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect('test-list');
        }
    }


    public function test_notification()
    {
        $client = new Client();
        $title = 'Test Notification Title';
        $message = 'Description';
        $serviceAccountPath = 'ms-saloon-d57c7b983485.json';
		
		$device_token = 'f9GQ2s92T52jw1TQeVPp7V:APA91bHGkcyx-KwdG7MgkxnNFHeznPcebNroTr6yGC93UaZU4SM59dlHW1AsRIDhaUF6eXvf83jTg_IN1sxcljh9RBMBOaZBmkXOzlOUvK4ANMLaORfSnpGN4ke8ntLU4QOQ8Q6CDctV';

        $jsonKey = json_decode(file_get_contents($serviceAccountPath), true);
        $jwt = $this->generate_jwt($jsonKey);

        $url = 'https://fcm.googleapis.com/v1/projects/ms-saloon/messages:send';
        
        $body = [
			"message" => [
				"token" => $device_token,
				"notification" => [
					"title" => $title,
					"body" => $message,
				],
				"data" => [
					"landing_page" => '',
					"order_id" => ''
				]
			]
		];		

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwt,
                    'Content-Type' => 'application/json'
                ],
                'json' => $body
            ]);
            
           echo $response->getBody();
        } catch (RequestException $e) {
           echo 'Error: ' . $e->getMessage();
        }
    }
    public function send_app_notification($device_token, $title, $message, $data)
    {
        $client = new Client();

		$serviceAccountPath = 'ms-saloon-d57c7b983485.json';

		$jsonKey = json_decode(file_get_contents($serviceAccountPath), true);
		$jwt = $this->generate_jwt($jsonKey);

		$url = 'https://fcm.googleapis.com/v1/projects/ms-saloon/messages:send';
		
		$body = [
			"message" => [
				"token" => $device_token,
				"notification" => [
					"title" => $title,
					"body" => urldecode(str_replace('%0a', '\n', $message)),
				],
				"data" => $data
			]
		];

		try {
			$response = $client->post($url, [
				'headers' => [
					'Authorization' => 'Bearer ' . $jwt,
					'Content-Type' => 'application/json',
				],
				'json' => $body,
			]);
			
			// Check if the response status code is in the 2xx range
			if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
				// echo "Notification sent successfully: " . $response->getBody();
				// return true;
				return "Notification sent successfully: " . $response->getBody();
			} else {
				// echo "Failed to send notification: " . $response->getBody();
				// return false;
				return "Failed to send notification: " . $response->getBody();
			}
		} catch (RequestException $e) {
			// Handle any errors that occur during the request
			if ($e->hasResponse()) {
				$errorResponse = $e->getResponse();
				// echo "Error occurred: " . $errorResponse->getBody();
				return "Error occurred: " . $errorResponse->getBody();
			} else {
				// echo "Error occurred: " . $e->getMessage();
				return "Error occurred: " . $e->getMessage();
			}
			// return false;
		}
	}

    private function generate_jwt($jsonKey)
    {
        $now_seconds = time();
        $payload = array(
            "iss" => $jsonKey['client_email'],
            "sub" => $jsonKey['client_email'],
            "aud" => "https://oauth2.googleapis.com/token",
            "iat" => $now_seconds,
            "exp" => $now_seconds + 3600,
            "scope" => "https://www.googleapis.com/auth/cloud-platform"
        );

        $jwt = JWT::encode($payload, $jsonKey['private_key'], 'RS256');

        $client = new Client();
        $response = $client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]
        ]);

        $accessToken = json_decode($response->getBody(), true);

        return $accessToken['access_token'];
    }
}
