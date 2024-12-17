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

class Exam_Material extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Exam_Material_model");
    }

    public function exam_material_list()
    {
        $data['category'] = $this->Exam_Material_model->get_exam_material_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('exam_material/exam_material_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/newscript.php', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }

    public function get_duplicate_exam_subject_title()
    {
        $this->Exam_Material_model->get_duplicate_exam_subject_title();
    }

    public function add_subject()
    {

        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Exam_Material_model->get_single_exam_subject();
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('exam_material/add_subject', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('exam_material/subjectscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Exam Subject.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/exam_material/images",
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
                    echo "new error";
                    exit;
                    redirect('exam_material/subject_list');
                    return;
                }
            }

            $res = $this->Exam_Material_model->set_exam_subject_details($upload_image);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Exam Subject details added successfully!");
                // echo "inserted";
                // exit;
                redirect('exam_material/subject_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Exam Subject entry updated!");
                // echo "updated";
                // exit;
                redirect('exam_material/subject_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Exam Subject.");
                redirect('exam_material/subject_list');
            }
        }
    }

    public function subject_list()
    {
        $data['category'] = $this->Exam_Material_model->get_single_subject_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('exam_material/subject_list', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_material/subjectscript.php', $data);
    }

    public function delete_subject_list($id)
    {
        $this->Exam_Material_model->delete_subject_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('exam_material/subject_list');
    }

    public function get_duplicate_exam_title()
    {
        $this->Exam_Material_model->get_duplicate_exam_title();
    }

    public function add_exam()
    {

        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Exam_Material_model->get_single_exam();
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('exam_material/add_exam', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('exam_material/examscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Exam.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/exam_material/images",
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
                    echo "new error";
                    exit;
                    redirect('exam_material/exam_list');
                    return;
                }
            }

            $res = $this->Exam_Material_model->set_exam_exam_details($upload_image);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Exam details added successfully!");
                // echo "inserted";
                // exit;
                redirect('exam_material/exam_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Exam entry updated!");
                // echo "updated";
                // exit;
                redirect('exam_material/exam_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Exam.");
                redirect('exam_material/exam_list');
            }
        }
    }

    public function exam_list()
    {
        $data['category'] = $this->Exam_Material_model->get_single_exam_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('exam_material/exam_list', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_material/examscript.php', $data);
    }

    public function delete_exam_list($id)
    {
        $this->Exam_Material_model->delete_exam_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('exam_material/exam_list');
    }


    public function get_duplicate_exam_sub_title()
    {
        $this->Exam_Material_model->get_duplicate_exam_sub_title();
    }

    public function add_exam_sub()
    {

        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Exam_Material_model->get_single_exam_sub();
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('exam_material/add_exam_sub', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('exam_material/exam_subscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Exam Sub Type.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/exam_material/images",
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
                    echo "new error";
                    exit;
                    redirect('exam_material/exam_sub_list');
                    return;
                }
            }

            $res = $this->Exam_Material_model->set_exam_sub_details($upload_image);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Exam Sub Type details added successfully!");
                // echo "inserted";
                // exit;
                redirect('exam_material/exam_sub_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Exam Sub Type entry updated!");
                // echo "updated";
                // exit;
                redirect('exam_material/exam_sub_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Exam Sub Type.");
                redirect('exam_material/exam_sub_list');
            }
        }
    }

    public function exam_sub_list()
    {
        $data['category'] = $this->Exam_Material_model->get_single_exam_sub_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('exam_material/exam_sub_list', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_material/exam_subscript.php', $data);
    }

    public function delete_exam_sub_list($id)
    {
        $this->Exam_Material_model->delete_exam_sub_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('exam_material/exam_sub_list');
    }

    public function get_duplicate_exam_year_title()
    {
        $this->Exam_Material_model->get_duplicate_exam_year_title();
    }

    public function add_exam_year()
    {

        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Exam_Material_model->get_single_exam_year();
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('exam_material/add_exam_year', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('exam_material/exam_yearscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Exam year.");
        } else {

            $res = $this->Exam_Material_model->set_exam_year_details();

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Exam Year details added successfully!");
                // echo "inserted";
                // exit;
                redirect('exam_material/exam_year_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Exam Year entry updated!");
                // echo "updated";
                // exit;
                redirect('exam_material/exam_year_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Exam Year.");
                redirect('exam_material/exam_year_list');
            }
        }
    }

    public function exam_year_list()
    {
        $data['category'] = $this->Exam_Material_model->get_single_exam_year_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('exam_material/exam_year_list', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_material/exam_yearscript.php', $data);
    }

    public function delete_exam_year_list($id)
    {
        $this->Exam_Material_model->delete_exam_year_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('exam_material/exam_year_list');
    }


    public function add_examwise_pdf()
    {
        $validate = $this->input->post('validate');
        $this->form_validation->set_rules('validate', 'Previous Year Pdf', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Exam_Material_model->get_single_exam_year_pdf();
            $exam_material_id = $id = $this->uri->segment(3);
            $data['exam_material_id'] = $exam_material_id;
            $this->load->view('exam_material/add_examwise_pdf', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('exam_material/previous_pdfscript.php', $data);
        } else {
            $indices = $this->input->post('indices');
            $upload_image = $this->input->post('current_image');
            $upload_pdf = $this->input->post('current_pdf');
            $image_uploads = [];
            $pdf_uploads = [];
            if (!empty($indices)) {
                for ($i = 0; $i < count($indices); $i++) {
                    // Handle chapter image upload
                    if (isset($_FILES['image_' . $indices[$i]]) && $_FILES['image_' . $indices[$i]]['name'] != "") {
                        $gst_config = array(
                            'upload_path'   => "assets/uploads/exam_material/images/",
                            'allowed_types' => "*",  // You can specify the types if needed
                            'encrypt_name'  => true,
                        );
                        $this->upload->initialize($gst_config);
                        if ($this->upload->do_upload('image_' . $indices[$i])) {
                            $data = $this->upload->data();
                            $image_uploads[] = $data['file_name'];  // Store uploaded chapter image
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata("error", $error['error']);
                            echo "problem in second image";
                            exit;
                            redirect('exam_material/examwise_pdf_list');
                            return;
                        }
                    }

                    if (isset($_FILES['pdf_' . $indices[$i]]) && $_FILES['pdf_' . $indices[$i]]['name'] != "") {
                        $gst_config = array(
                            'upload_path'   => "assets/uploads/exam_material/pdf/",  // Path to save PDFs
                            'allowed_types' => 'pdf',  // Allow only PDF files
                            'encrypt_name'  => true,
                        );
                        $this->upload->initialize($gst_config);

                        if ($this->upload->do_upload('pdf_' . $indices[$i])) {
                            $data = $this->upload->data();
                            $pdf_uploads[] = $data['file_name'];  // Store uploaded chapter PDF file name
                        } else {
                            // Handle PDF upload error
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata("error", $error['error']);
                            echo "problem in second PDF";
                            exit;
                            redirect('exam_material/examwise_pdf_list');
                            return;
                        }
                    }
                }

                // Combine image and video uploads if they exist
                $upload_image = implode(',', $image_uploads);
                $upload_pdf = implode(',', $pdf_uploads);
            }

            $upload_image_update = $this->input->post('current_image_update');  // Get the current image from the hidden field

            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/exam_material/images/",
                    'allowed_types' => "*",  // You can specify the types if needed
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);

                // Handle file upload
                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $upload_image_update = $data['file_name'];  // Store the uploaded image's file name
                } else {
                    // Handle upload error
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    echo "problem in main image";
                    exit;
                    redirect('exam_material/examwise_pdf_list');
                    return;
                }
            }

            $upload_pdf_update = $this->input->post('current_pdf_update');  // Get the current PDF from the hidden field

            if (isset($_FILES['pdf']) && $_FILES['pdf']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/exam_material/pdf/",  // Path to save the main PDF
                    'allowed_types' => 'pdf',  // Allow only PDF files
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);

                // Handle file upload
                if ($this->upload->do_upload('pdf')) {
                    $data = $this->upload->data();
                    $upload_pdf_update = $data['file_name'];  // Store the uploaded PDF's file name
                } else {
                    // Handle upload error
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    echo "problem in main PDF";
                    exit;
                    redirect('exam_material/examwise_pdf_list');
                    return;
                }
            }

            $res = $this->Exam_Material_model->set_examwise_pdf_details($upload_image, $upload_image_update, $upload_pdf, $upload_pdf_update);
            if ($res == "1") {
                // echo "1";
                // exit;
                $this->session->set_flashdata("success", "Ebook Setup details added successfully!");
                redirect('exam_material/examwise_pdf_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Ebook Setup entry updated!");
                // echo "2";
                // exit;
                redirect('exam_material/examwise_pdf_list');
            } else {
                echo "0";
                exit;
                $this->session->set_flashdata("error", "Error updating Ebook Sub Category.");
            }
        }
    }

    public function examwise_pdf_list()
    {
        $data['category'] = $this->Exam_Material_model->get_examwise_pdf_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('exam_material/examwise_pdf_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_material/previous_pdfscript.php', $data);
    }

    public function delete_examwise_pdf($id)
    {
        $this->Exam_Material_model->delete_examwise_pdf($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('exam_material/examwise_pdf_list');
    }
}
