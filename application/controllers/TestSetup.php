<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// require_once APPPATH.'vendor/autoload.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

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
                                    $question_type = $worksheet->getCell('B' . $row)->getValue();
                                    $options_1 = $worksheet->getCell('C' . $row)->getValue();
                                    $options_2 = $worksheet->getCell('D' . $row)->getValue();
                                    $options_3 = $worksheet->getCell('E' . $row)->getValue();
                                    $options_4 = $worksheet->getCell('F' . $row)->getValue();
                                    $answer_column = $worksheet->getCell('G' . $row)->getValue();
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
                                    $solution = $worksheet->getCell('H' . $row)->getValue();
                                    $positive_marks = (int)$worksheet->getCell('I' . $row)->getValue();
                                    $negative_marks = (int)$worksheet->getCell('J' . $row)->getValue();
                                    $bulk_data[] = array(
                                        'question'          => $question,
                                        'question_type'     => $question_type,
                                        'option_1'          => $options_1,
                                        'option_2'          => $options_2,
                                        'option_3'          => $options_3,
                                        'option_4'          => $options_4,
                                        'answer'            => $answer,
                                        'answer_column'     => $answer_column,
                                        'solution'          => $solution,
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
                                $question_type = $worksheet->getCell('B' . $row)->getValue();
                                $options_1 = $worksheet->getCell('C' . $row)->getValue();
                                $options_2 = $worksheet->getCell('D' . $row)->getValue();
                                $options_3 = $worksheet->getCell('E' . $row)->getValue();
                                $options_4 = $worksheet->getCell('F' . $row)->getValue();
                                $answer_column = $worksheet->getCell('G' . $row)->getValue();
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
                                $solution = $worksheet->getCell('H' . $row)->getValue();
                                $positive_marks = (int)$worksheet->getCell('I' . $row)->getValue();
                                $negative_marks = (int)$worksheet->getCell('J' . $row)->getValue();
                                $bulk_data[] = array(
                                    'question'          => $question,
                                    'question_type'     => $question_type,
                                    'option_1'          => $options_1,
                                    'option_2'          => $options_2,
                                    'option_3'          => $options_3,
                                    'option_4'          => $options_4,
                                    'answer'            => $answer,
                                    'answer_column'     => $answer_column,
                                    'solution'          => $solution,
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
                    echo '<pre>'; print_r($error);
                    exit;
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
                    'upload_path'   => "assets/uploads/question_images",
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
}
