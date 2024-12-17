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

class Courses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("DocsVideos_model");
        $this->load->model("Courses_model");
    }
    //functions

    public function documents()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('courses/document', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/jscript.php', $data);
    }
    public function texts()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('courses/texts', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/jscript.php', $data);
    }
    public function pdf()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('courses/pdf', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/jscript.php', $data);
    }
    public function quizs()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('courses/quizs', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/jscript.php', $data);
    }
    public function add_test()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['single'] = $this->Courses_model->get_single_course_tests($this->uri->segment(3));
        // echo 'hiii'; print_r($data['single']);  exit;
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('courses/add_test', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/jscript.php', $data);
    }
    public function tests()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['tests'] = $this->Courses_model->get_course_tests();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('courses/tests', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/tests_script.php', $data);
    }
    public function videos()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['course_videos'] = $this->Courses_model->get_course_videos();
        // echo '<pre>'; print_r($data['course_videos']); exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('courses/videos', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/jscript.php', $data);
    }
    public function add_course_tests()
    {
        if (isset($_POST)) {
            $this->form_validation->set_rules('course_id', 'Course', 'required');
            if ($this->form_validation->run() === FALSE) {
                echo validation_errors();
                return false;
            }

            $insert = $this->Courses_model->save_course_tests();
            redirect('courses/tests');
        }
    }
    public function delete_test()
    {
        $insert = $this->Courses_model->delete_test($this->uri->segment(3));
        redirect('courses/tests');
    }
    public function add_doc_data()
    {
        if (isset($_POST)) {
            /*$this->form_validation->set_rules('title','Title','required');
            $this->form_validation->set_rules('description','Description','required');
            $this->form_validation->set_rules('no_of_months','No Of Months','required');
            if ($this->form_validation->run() === FALSE) {
                echo validation_errors();
                return false;
            }*/

            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            $ImagePath = '';
            $pdf_url = '';
            //            $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath = $path . '/' . $images;
                }
            }
            if (!empty($_FILES['pdf']['name'])) {
                $path = 'assets/uploads/courses/documents';
                $pdf = upload_file('pdf', $path, 'pdf');
                if (empty($pdf['error'])) {
                    $pdf_url = $path . '/' . $pdf;
                }
            }
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Docs',
                'source_type' => $source_type,
                'source_id' => $source_id,
                'description' => $description,
                'status' => $status,
                'can_download' => $can_download,
                'image_url' => $ImagePath,
                'pdf_url' => $pdf_url,
            ];
            $insert = $this->DocsVideos_model->save($data);
            if ($insert == 'Inserted') {
                echo json_encode([
                    'Status' => "Success",
                    'msg' => $insert
                ]);
                return true;
            } else {
                echo json_encode([
                    'Status' => "Failed",
                    'msg' => 'Something Error'
                ]);
                return false;
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subject', 'refresh');
    }
    public function update_doc_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            //            $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Docs',
                'source_type' => $source_type,
                'source_id' => $source_id,
                'status' => $status,
                'can_download' => $can_download,
                'description' => $description
            ];
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] = $path . '/' . $images;
                }
            }
            if (!empty($_FILES['pdf']['name'])) {
                $path = 'assets/uploads/courses/documents';
                $pdf = upload_file('pdf', $path, 'pdf');
                if (empty($pdf['error'])) {
                    $data['pdf_url'] = $path . '/' . $pdf;
                }
            }
            $id = $_POST['id'];
            $insert = $this->DocsVideos_model->update($id, $data);
            if ($insert == 'Updated') {
                echo json_encode([
                    'Status' => "Success",
                    'msg' => 'Updated'
                ]);
                return true;
            } else {
                echo json_encode([
                    'Status' => "Failed",
                    'msg' => 'Something Error'
                ]);
                return false;
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'courses/document', 'refresh');
    }

    // public function add_course_data()
    // {
    //     if (!empty($_POST)) {
    //         $this->form_validation->set_rules('title', 'Title', 'required');

    //         if (empty($_FILES['image']['name'])) {
    //             $this->form_validation->set_rules('image', 'Image', 'required');
    //         }

    //         $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

    //         if ($this->form_validation->run() === FALSE) {
    //             $error = [
    //                 'title' => form_error('title'),
    //                 'description' => form_error('description'),
    //                 'image' => form_error('image'),
    //                 'num_of_question' => form_error('num_of_question'),
    //             ];
    //             echo json_encode([
    //                 'success' => "Failed",
    //                 'error' => $error
    //             ]);
    //             return false;
    //         }
    //         $title = $this->db->escape_str($_POST['title']);
    //         $status = $this->db->escape_str($_POST['status']);
    //         $sub_headings = $this->db->escape_str($_POST['sub_title']);
    //         $mrp = $this->db->escape_str($_POST['mrp']);
    //         $sale_price = $this->db->escape_str($_POST['sale_price']);
    //         $discount = $this->db->escape_str($_POST['discount']);
    //         $description = $this->db->escape_str($_POST['description']);
    //         $banner_image = '';
    //         $pdf_url = '';

    //         //    $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
    //         $description = str_replace('\r\n', '', $description);
    //         $data = [
    //             'title' => $title,
    //             'sub_headings' => $sub_headings,
    //             'mrp' => $mrp,
    //             'sale_price' => $sale_price,
    //             'discount' => $discount,
    //             'description' => $description,
    //             'status' => $status,
    //         ];
    //         // $this->load->view('app_users', $data);
    //         // exit;
    //         if (!empty($_FILES['image']['name'])) {
    //             $path = 'assets/uploads/courses/images';
    //             $images = upload_file('image', $path);
    //             if (empty($images['error'])) {
    //                 $data['banner_image'] = $path . '/' . $images;
    //             }
    //         }
    //         $insert = $this->Courses_model->save($data);
    //         if ($insert) {
    //             echo json_encode([
    //                 'Status' => "Success",
    //                 'msg' => 'Updated'
    //             ]);
    //             return true;
    //         } else {
    //             echo json_encode([
    //                 'Status' => "Failed",
    //                 'msg' => 'Something Error'
    //             ]);
    //             return false;
    //         }
    //     }

    //     $this->session->set_userdata('alert_msg', $art_msg);

    //     redirect(base_url() . 'Exam_subject', 'refresh');
    // }

    function index()
    {

        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        // echo "inserted";
        // exit;
        $this->load->view('courses/courses', $data);
        //        $this->load->view('membership_plans/details', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/newjscript.php', $data);
    }

    public function add_course_data()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Courses_model->get_single_courses(); //
            $this->load->view('courses/courses', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            // $this->load->view('courses/jscript.php', $data);
            $this->load->view('courses/newjscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Courses.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/courses/images",
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
                    redirect('courses/courses_list');
                    return;
                }
            }

            $upload_inner_image = $this->input->post('current_inner_banner_image');
            if (isset($_FILES['inner_banner_image']) && $_FILES['inner_banner_image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/courses/images",
                    'allowed_types' => "*",
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);

                if ($this->upload->do_upload('inner_banner_image')) {
                    $data = $this->upload->data();
                    $upload_inner_image = $data['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    echo "new error inner";
                    exit;
                    redirect('courses/courses_list');
                    return;
                }
            }

            $res = $this->Courses_model->set_courses_details($upload_image, $upload_inner_image);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Courses details added successfully!");
                redirect('courses/courses_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Courses entry updated!");
                redirect('courses/courses_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Courses.");
                redirect('courses/courses_list');
            }
        }
    }




    public function courses_list()
    {
        $data['category'] = $this->Courses_model->get_single_courses_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('courses/courses_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/course_list_script.php', $data);
    }


    public function delete_courses_list($id)
    {
        $this->Courses_model->delete_courses_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('courses/courses_list');
    }

    public function status_courses_list_active($id)
    {
        $this->Courses_model->status_courses_list_active($id);
        // $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('courses/courses_list');
    }

    public function status_courses_list_in_active($id)
    {
        $this->Courses_model->status_courses_list_in_active($id);
        // $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('courses/courses_list');
    }

    public function add_course_videos()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Courses_model->get_single_video_courses();
            $this->load->view('courses/add_course_videos', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('courses/newjscriptvideo.php', $data);
            $this->session->set_flashdata("error", "Error updating Courses Video.");
        } else {
            $upload_image = $this->input->post('current_image');
            $video_url = null;
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/courses/images",
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
                    redirect('courses/courses_video_list');
                    return;
                }
            }

            $video_url = $this->input->post('current_video');
            if ($this->input->post('video_source') === "Hosted") {
                if (isset($_FILES['video_file']) && $_FILES['video_file']['name'] != "") {
                    $target_dir = 'assets/uploads/courses/videos';
                    $target_file = $target_dir . basename($_FILES['video_file']['name']);
                    $allowed_types = ['mp4', 'avi', 'mov'];
                    $file_ext = pathinfo($target_file, PATHINFO_EXTENSION);
                    if (!in_array(strtolower($file_ext), $allowed_types)) {
                        $this->session->set_flashdata("error", "Invalid video file type. Allowed types: MP4, AVI, MOV.");
                        redirect('courses/courses_video_list');
                        return;
                    }

                    $target_file = $target_dir . uniqid() . '.' . $file_ext;

                    if (move_uploaded_file($_FILES['video_file']['tmp_name'], $target_file)) {
                        $video_url = $target_file;
                    } else {
                        $this->session->set_flashdata("error", "Error uploading video.");
                        redirect('courses/courses_video_list');
                        return;
                    }
                } else {
                    if ($this->input->post('current_video')) {
                        $video_url = $this->input->post('current_video');
                    }
                }
            } elseif ($this->input->post('video_source') === "YouTube") {
                $youtube_url = $this->input->post('youtube_url');
                if (!empty($youtube_url)) {
                    if (filter_var($youtube_url, FILTER_VALIDATE_URL)) {
                        $video_url = $youtube_url;
                    } else {
                        $this->session->set_flashdata("error", "Invalid YouTube URL.");
                        redirect('courses/courses_video_list');
                        return;
                    }
                }
            }
            $res = $this->Courses_model->set_courses_video($upload_image, $video_url);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Courses Video details added successfully!");
                // echo "inserted";
                // exit;
                redirect('courses/courses_video_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Courses Video entry updated!");
                // echo "updated";
                // exit;
                redirect('courses/courses_video_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Courses Video.");
                redirect('courses/courses_video_list');
            }
        }
    }

    public function courses_video_list()
    {
        $data['category'] = $this->Courses_model->get_single_video_courses_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('courses/courses_video_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/course_video_list_script.php', $data);
    }


    public function update_course_data()
    {
        if (isset($_POST)) {
            $id = $this->db->escape_str($_POST['id']);
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('sub_title', 'sub title', 'required');
            $this->form_validation->set_rules('mrp', 'MRP', 'required');
            $this->form_validation->set_rules('sale_price', 'sale price', 'required');
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
            if ($this->form_validation->run() === FALSE) {
                $error = [
                    'title' => form_error('title'),
                    'description' => form_error('description'),
                    'image' => form_error('image'),
                    'num_of_question' => form_error('num_of_question'),
                ];
                echo json_encode([
                    'success' => "Failed",
                    'error' => $error
                ]);
                return false;
            }

            $title = $this->db->escape_str($_POST['title']);
            $status = $this->db->escape_str($_POST['status']);
            $sub_headings = $this->db->escape_str($_POST['sub_title']);
            $mrp = $this->db->escape_str($_POST['mrp']);
            $sale_price = $this->db->escape_str($_POST['sale_price']);
            $discount = $this->db->escape_str($_POST['discount']);
            $description = $this->db->escape_str($_POST['description']);
            $banner_image = '';
            //    $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);

            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'sub_headings' => $sub_headings,
                'mrp' => $mrp,
                'sale_price' => $sale_price,
                'discount' => $discount,
                'description' => $description,
                'status' => $status,
            ];
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['banner_image'] = $path . '/' . $images;
                }
            }
            $insert = $this->Courses_model->update($id, $data);
            if ($insert == 'Updated') {
                echo json_encode([
                    'Status' => "Success",
                    'msg' => 'Updated'
                ]);
                return true;
            } else {
                echo json_encode([
                    'Status' => "Failed",
                    'msg' => 'Something Error'
                ]);
                return false;
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subject', 'refresh');
    }
    public function add_texts_data()
    {
        if (isset($_POST)) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('num_of_question', 'Number Of Question', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            $this->form_validation->set_rules('num_of_question', 'No Of Question', 'required');
            if (empty($_FILES['image']['name'])) {
                $this->form_validation->set_rules('image', 'Image', 'required');
            }
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
            if ($this->form_validation->run() === FALSE) {
                $error = [
                    'title' => form_error('title'),
                    'description' => form_error('description'),
                    'image' => form_error('image'),
                    'num_of_question' => form_error('num_of_question'),
                ];
                echo json_encode([
                    'success' => "Failed",
                    'error' => $error
                ]);
                return false;
            }
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $num_of_questions = $this->db->escape_str($_POST['num_of_question']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            $ImagePath = '';
            $pdf_url = '';
            //            $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath = $path . '/' . $images;
                }
            }
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'source_id' => $source_id,
                'type' => 'Texts',
                'source_type' => $source_type,
                'description' => $description,
                'status' => $status,
                'image_url' => $ImagePath,
                'num_of_questions' => $num_of_questions,
            ];
            $insert = $this->DocsVideos_model->save($data);
            if ($insert == 'Inserted') {
                echo json_encode([
                    'Status' => "Success",
                    'msg' => 'Inserted'
                ]);
                return true;
            } else {
                echo json_encode([
                    'Status' => "Failed",
                    'msg' => 'Something Error'
                ]);
                return false;
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Exam_subject', 'refresh');
    }
    public function update_texts_data()
    {
        if (isset($_POST)) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('num_of_question', 'Number Of Question', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            $this->form_validation->set_rules('num_of_question', 'No Of Question', 'required');
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
            if ($this->form_validation->run() === FALSE) {
                $error = [
                    'title' => form_error('title'),
                    'description' => form_error('description'),
                    'image' => form_error('image'),
                    'num_of_question' => form_error('num_of_question'),
                ];
                echo json_encode([
                    'success' => "Failed",
                    'error' => $error
                ]);
                return false;
            }
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            $num_of_question = $this->db->escape_str($_POST['num_of_question']);
            //            $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Texts',
                'source_type' => $source_type,
                'source_id' => $source_id,
                'description' => $description,
                'status' => $status,
                'can_download' => $can_download,
                'num_of_questions' => $num_of_question
            ];
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] = $path . '/' . $images;
                }
            }
            $id = $_POST['id'];
            $insert = $this->DocsVideos_model->update($id, $data);
            if ($insert == 'Updated') {
                echo json_encode([
                    'Status' => "Success",
                    'msg' => 'Updated'
                ]);
                return true;
            } else {
                echo json_encode([
                    'Status' => "Failed",
                    'msg' => 'Something Error'
                ]);
                return false;
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'courses/document', 'refresh');
    }
    public function add_quiz_data()
    {
        if (isset($_POST)) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('num_of_question', 'Number Of Question', 'required');
            $this->form_validation->set_rules('marks', 'marks', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            $this->form_validation->set_rules('time', 'time', 'required');
            //            print_r($_FILES);
            //            die;
            if (empty($_FILES['image']['name'])) {
                $this->form_validation->set_rules('image', 'Image', 'required');
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

            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $num_of_questions = $this->db->escape_str($_POST['num_of_question']);
            $marks = $this->db->escape_str($_POST['marks']);
            $time = $this->db->escape_str($_POST['time']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            $ImagePath = '';
            $pdf_url = '';
            //            $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath = $path . '/' . $images;
                }
            }
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'marks' => $marks,
                'time' => $time,
                'type' => 'Quiz',
                'source_type' => $source_type,
                'source_id' => $source_id,
                'description' => $description,
                'status' => $status,
                'image_url' => $ImagePath,
                'num_of_questions' => $num_of_questions,
            ];
            $insert = $this->DocsVideos_model->save($data);
            if ($insert == 'Inserted') {
                echo json_encode([
                    'Status' => "Success",
                    'msg' => 'Inserted'
                ]);
                return true;
            } else {
                echo json_encode([
                    'Status' => "Failed",
                    'msg' => 'Something Error'
                ]);
                return false;
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subject', 'refresh');
    }
    public function update_quiz_data()
    {
        if (isset($_POST)) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('num_of_question', 'Number Of Question', 'required');
            $this->form_validation->set_rules('marks', 'marks', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            $this->form_validation->set_rules('time', 'time', 'required');
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
            if ($this->form_validation->run() === FALSE) {
                $error = [
                    'title' => form_error('title'),
                    'description' => form_error('description'),
                    'image' => form_error('image'),
                    'num_of_question' => form_error('num_of_question'),
                ];
                echo json_encode([
                    'success' => "Failed",
                    'error' => $error
                ]);
                return false;
            }
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            $num_of_question = $this->db->escape_str($_POST['num_of_question']);
            //            $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Quiz',
                'source_type' => $source_type,
                'source_id' => $source_id,
                'description' => $description,
                'status' => $status,
                'can_download' => $can_download,
                'num_of_questions' => $num_of_question
            ];
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] = $path . '/' . $images;
                }
            }
            $id = $_POST['id'];
            $insert = $this->DocsVideos_model->update($id, $data);
            if ($insert == 'Updated') {
                echo json_encode([
                    'Status' => "Success",
                    'msg' => 'Updated'
                ]);
                return true;
            } else {
                echo json_encode([
                    'Status' => "Failed",
                    'msg' => 'Something Error'
                ]);
                return false;
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'courses/document', 'refresh');
    }
    // add pdf data
    public function add_pdf_data()
    {
        if (isset($_POST)) {
            /*$this->form_validation->set_rules('title','Title','required');
            $this->form_validation->set_rules('description','Description','required');
            $this->form_validation->set_rules('no_of_months','No Of Months','required');
            if ($this->form_validation->run() === FALSE) {
                echo validation_errors();
                return false;
            }*/
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            // Extract the time value from the form input
            $time = $_POST['time']; // Assuming 'time' is the name attribute of your time input field
            // Sanitize and escape the time value
            $time = $this->db->escape_str($time);
            $ImagePath = '';
            $pdf_url = '';
            // $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath = $path . '/' . $images;
                }
            }
            if (!empty($_FILES['pdf']['name'])) {
                $path = 'assets/uploads/courses/pdf';
                $pdf = upload_file('pdf', $path, 'pdf');
                if (empty($pdf['error'])) {
                    $pdf_url = $path . '/' . $pdf;
                }
            }
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Pdf',
                'source_type' => $source_type,
                'source_id' => $source_id,
                'status' => $status,
                'can_download' => $can_download,
                'image_url' => $ImagePath,
                'pdf_url' => $pdf_url,
                'description' => $description,
                'time' => $time
            ];
            $insert = $this->DocsVideos_model->save($data);
            if ($insert == 'Inserted') {
                echo json_encode([
                    'Status' => "Success",
                    'msg' => 'Inserted'
                ]);
                return true;
            } else {
                echo json_encode([
                    'Status' => "Failed",
                    'msg' => 'Something Error'
                ]);
                return false;
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'Exam_subject', 'refresh');
    }
    // end pdf add data
    // update pdf
    public function update_pdf_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            //$check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);  
            $time = $_POST['time'];
            // Sanitize and escape the time value
            $time = $this->db->escape_str($time);
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Pdf',
                'source_type' => $source_type,
                'source_id' => $source_id,
                'status' => $status,
                'can_download' => $can_download,
                'description' => $description,
                'time' => $time
            ];
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] = $path . '/' . $images;
                }
            }
            if (!empty($_FILES['pdf']['name'])) {
                $path = 'assets/uploads/courses/pdf';
                $pdf = upload_file('pdf', $path, 'pdf');
                if (empty($pdf['error'])) {
                    $data['pdf_url'] = $path . '/' . $pdf;
                }
            }
            $id = $_POST['id'];
            $insert = $this->DocsVideos_model->update($id, $data);
            if ($insert == 'Updated') {
                echo json_encode([
                    'Status' => "Success",
                    'msg' => 'Updated'
                ]);
                return true;
            } else {
                echo json_encode([
                    'Status' => "Failed",
                    'msg' => 'Something Error'
                ]);
                return false;
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'courses/pdf', 'refresh');
    }
    // end pdf update

    public function add_video_data()
    {
        if (isset($_POST)) {

            $title = $this->db->escape_str($_POST['title']);
            $video_source = $this->db->escape_str($_POST['video_source']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            $description = $this->db->escape_str($_POST['description']);
            $video_url = $this->db->escape_str($_POST['video_url']);
            $pdf_url = '';
            //            $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            if (!empty($_FILES['video_url']['name'])) {
                $path = 'assets/uploads/courses/videos/' . $_FILES['video_url']['name'];
                move_uploaded_file($_FILES['video_url']['tmp_name'], $path);
                $video_url = $path;
            }
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath = $path . '/' . $images;
                }
            }
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Video',
                'source_type' => $source_type,
                'source_id' => $source_id,
                'description' => $description,
                'status' => $status,
                'video_source' => $video_source,
                'image_url' => $ImagePath,
                'video_url' => $video_url
            ];
            $insert = $this->DocsVideos_model->save($data);
            if ($insert == 'Inserted') {
                // echo "inserted";
                $art_msg['msg'] = 'New subjects updated.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
            $this->session->set_userdata('alert_msg', $art_msg);

            echo json_encode($art_msg);
        }

        // redirect(base_url() . 'courses/course-videos', 'refresh');

    }
    public function update_video_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $video_source = $this->db->escape_str($_POST['video_source']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            $description = $this->db->escape_str($_POST['description']);
            $video_url = $this->db->escape_str($_POST['video_url']);
            //            $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Video',
                'source_type' => $source_type,
                'source_id' => $source_id,
                'description' => $description,
                'status' => $status,
                'video_source' => $video_source,
                'video_url' => $video_url
            ];
            if (!empty($_FILES['video_url']['name'])) {
                $path = 'assets/uploads/courses/videos/' . $_FILES['video_url']['name'];
                move_uploaded_file($_FILES['video_url']['tmp_name'], $path);
                $video_url = $path;
                $data['video_url'] = $video_url;
            }
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/courses/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath = $path . '/' . $images;
                    $data['image_url'] = $ImagePath;
                }
            }
            $id = $_POST['id'];
            $insert = $this->DocsVideos_model->update($id, $data);
            if ($insert == 'Updated') {
                echo "Updated";
                $art_msg['msg'] = 'New subjects updated.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'courses/course-videos', 'refresh');
    }

    //API - licenses sends id and on valid id licenses information is sent back
    public function add_data()
    {
        if (isset($_POST)) {
            /*$this->form_validation->set_rules('title','Title','required');
            $this->form_validation->set_rules('description','Description','required');
            $this->form_validation->set_rules('no_of_months','No Of Months','required');
            if ($this->form_validation->run() === FALSE) {
                echo validation_errors();
                return false;
            }*/

            $Title = $this->db->escape_str($_POST['title']);
            $sub_heading = $this->db->escape_str($_POST['sub_heading']);
            $price = $this->db->escape_str($_POST['price']);
            $actual_price = $this->db->escape_str($_POST['actual_price']);
            $discount_per = $this->db->escape_str($_POST['discount_per']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $no_of_months = $this->db->escape_str($_POST['no_of_months']);
            $check = $this->DocsVideos_model->getDataByWhereCondition(['title' => $Title]);
            if (!$check) {
                $description = str_replace('\r\n', '', $description);
                $data = [
                    'title' => $Title,
                    'sub_heading' => $sub_heading,
                    'price' => $price,
                    'actual_price' => $actual_price,
                    'discount_per' => $discount_per,
                    'status' => $status,
                    'no_of_months' => $no_of_months,
                    'description' => $description
                ];
                $insert = $this->DocsVideos_model->save($data);
                if ($insert == 'Inserted') {
                    echo "inserted";
                    $art_msg['msg'] = 'New subjects updated.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }
            } else {
                echo "false";
                die;
                $art_msg['msg'] = 'New subject already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subject', 'refresh');
    }
    public function get_courses_details()
    {
        $condition = null;
        $type = $_GET['type'];
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $condition = ['type' => $_GET['type']];
        }
        $condition['source_type'] = 'courses';
        $fetch_data = $this->DocsVideos_model->make_datatables($condition);
        //         echo $this->db->last_query();
        //        print_r($fetch_data);die;
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            if ($row->type == 'Quiz') {
                $html = '
                <button type="button" name="Details" onclick="getExamSectionDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
                 <i class="material-icons">visibility</i> </button>
                  <button type="button" name="Edit" onclick="getExamSectionDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                  <i class="material-icons">mode_edit</i></button>
                  <button type="button" name="Edit" onclick="getQuestions(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#manage-questions" >
                  <i class="material-icons">question_mark</i></button>
        
                  <button type="button" name="Delete" onclick="deleteExamSectionDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                  <i class="material-icons">delete</i></button>';
            } else {
                $html = '
                <button type="button" name="Details" onclick="getExamSectionDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
                 <i class="material-icons">visibility</i> </button>
                  <button type="button" name="Edit" onclick="getExamSectionDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                  <i class="material-icons">mode_edit</i></button>
        
                  <button type="button" name="Delete" onclick="deleteExamSectionDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                  <i class="material-icons">delete</i></button>';
            }
            $sub_array[] = $html;

            $sub_array[] = $row->title;

            if ($type == 'Docs' || $type == 'Pdf') {
                if ($type == 'Pdf') {
                    $sub_array[] = $row->time;
                }
                $sub_array[] = $row->can_download;
                $sub_array[] = '<a href="' . base_url($row->pdf_url) . '" target="_blank"><i class="material-icons">picture_as_pdf</i></a>';
            } elseif ($type == 'Video') {
                if ($row->video_source == 'Hosted') {
                    $sub_array[] = '
                    <video width="60%" height="150" controls class="img-fluid rounded" >
                        <source src="' . base_url($row->video_url) . '">
                    </video>';
                } else {
                    $sub_array[] = '<a href="' . $row->video_url . '" target="_blank"><i class="material-icons">link</i></a>';
                }
                $sub_array[] = $row->video_source;
            } elseif ($type == 'Quiz') {
                $sub_array[] = $row->num_of_questions;
                $sub_array[] = $row->marks;
                $sub_array[] = $row->time;
            }
            $sub_array[] = '<img src="' . base_url($row->image_url) . '" class="img-fluid rounded" style="width: 50%;" >';
            $sub_array[] = $row->status;
            $sub_array[] = date("d-m-Y H:i:s", strtotime($row->created_at));

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->DocsVideos_model->get_all_data(), "recordsFiltered" => $this->DocsVideos_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }
    public function get_courses()
    {
        $fetch_data = $this->Courses_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getSingleCourseDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getCoursesDetailsEdit(this.id)" id="edit_' . $row->id . '" class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteCourseSectionDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

            $sub_array[] = $row->title;
            $sub_array[] = $row->sub_headings;
            $sub_array[] = $row->sale_price;
            $sub_array[] = $row->mrp;
            $sub_array[] = $row->discount;
            $sub_array[] = '<img src="' . base_url($row->banner_image) . '" class="img-fluid rounded" style="width: 50%;" >';
            $sub_array[] = $row->status;
            $sub_array[] = date("d-m-Y H:i:s", strtotime($row->created_at));

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->Courses_model->get_all_data(), "recordsFiltered" => $this->Courses_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }
    public function get_single_course_detail($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->Courses_model->getPostById($id);
        // echo $this->db->last_query();
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

    public function delete_course_data($id)
    {
        //echo $id;die;
        if (!$id) {
            echo "Parameter missing";
            return false;
        }
        // $result = $this->DocsVideos_model->checkUserSelectedPlan($id);
        if ($this->Courses_model->delete($id)) {
            echo "Success";
            return true;
        } else {
            echo "Failed";
            return false;
        }
    }

    public function get_single_video_doc($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->Courses_model->getPostById($id);
        //        echo $this->db->last_query();
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

    public function get_single_course($id)
    {
        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->Courses_model->getPostById($id);
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
    public function delete_doc_video_data($id)
    {
        //echo $id;die;
        if (!$id) {
            echo "Parameter missing";
            return false;
        }
        // $result = $this->DocsVideos_model->checkUserSelectedPlan($id);
        if ($this->DocsVideos_model->delete($id)) {
            echo "Success";
            return true;
        } else {
            echo "Failed";
            return false;
        }
    }
    public  function getQuestions($quiz_id)
    {
        /*$fetch_data = $this->Courses_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getSingleCourseDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getCoursesDetailsEdit(this.id)" id="edit_' . $row->id . '" class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteExamSectionDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

            $sub_array[] = $row->title;
            $sub_array[] = $row->sub_headings;
            $sub_array[] = $row->sale_price;
            $sub_array[] = $row->mrp;
            $sub_array[] = $row->discount;
            $sub_array[] = '<img src="' . base_url($row->banner_image) . '" class="img-fluid rounded" style="width: 50%;" >';
            $sub_array[] = $row->status;
            $sub_array[] = date("d-m-Y H:i:s",strtotime($row->created_at));

            $data[] = $sub_array;
        }*/
        $output = array("recordsTotal" => 0, "recordsFiltered" => 0, "data" => []);
        //        $output = array("recordsTotal" => $this->Courses_model->get_all_data(), "recordsFiltered" => $this->Courses_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }

    public function delete_video_courses_list($id)
    {
        $this->Courses_model->delete_video_courses_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('courses/courses_video_list');
    }

    // public function add_texts()
    // {
    //     $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
    //     $this->load->view('templates/header1', $data);
    //     $this->load->view('templates/menu', $data);
    //     $this->load->view('courses/add_texts', $data);
    //     $this->load->view('templates/footer1', $data);
    //     $this->load->view('courses/jscript.php', $data);
    // }

    public function add_texts()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Courses_model->get_single_texts_courses(); //
            $this->load->view('courses/add_texts', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            // $this->load->view('courses/jscript.php', $data);
            $this->load->view('courses/textsscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Courses.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/courses/images",
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
                    redirect('courses/texts_list');
                    return;
                }
            }

            $res = $this->Courses_model->set_courses_texts_details($upload_image);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Courses details added successfully!");
                // echo "inserted";
                // exit;
                redirect('courses/texts_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Courses entry updated!");
                // echo "updated";
                // exit;
                redirect('courses/texts_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Courses.");
                redirect('courses/texts_list');
            }
        }
    }

    public function texts_list()
    {
        $data['category'] = $this->Courses_model->get_single_courses_texts_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('courses/texts_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/texts_list_script.php', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }

    public function delete_courses_texts_list($id)
    {
        $this->Courses_model->delete_courses_texts_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('courses/texts_list');
    }
    public function get_duplicate_courses_text_title()
    {
        $this->Courses_model->get_duplicate_courses_text_title();
    }

    public function add_pdfs()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Courses_model->get_single_pdfs_courses(); //
            $this->load->view('courses/add_pdfs', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            // $this->load->view('courses/jscript.php', $data);
            $this->load->view('courses/pdfsscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Courses.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/courses/images",
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
                    redirect('courses/pdfs_list');
                    return;
                }
            }

            $upload_pdf = $this->input->post('current_pdf');
            if (isset($_FILES['pdf']) && $_FILES['pdf']['name'] != "") {
                $config = array(
                    'upload_path'   => "assets/uploads/courses/pdfs",
                    'allowed_types' => "pdf",
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($config);

                if ($this->upload->do_upload('pdf')) {
                    $data = $this->upload->data();
                    $upload_pdf = $data['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    redirect('courses/pdfs_list');
                    return;
                }
            }

            $res = $this->Courses_model->set_courses_pdfs_details($upload_image, $upload_pdf);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Courses Pdf details added successfully!");
                // echo "inserted";
                // exit;
                redirect('courses/pdfs_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Courses Pdf entry updated!");
                // echo "updated";
                // exit;
                redirect('courses/pdfs_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Courses.");
                redirect('courses/pdfs_list');
            }
        }
    }

    public function pdfs_list()
    {
        $data['category'] = $this->Courses_model->get_single_courses_pdfs_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('courses/pdfs_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/pdf_list_script.php', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }

    public function delete_courses_pdfs_list($id)
    {
        $this->Courses_model->delete_courses_pdfs_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('courses/pdfs_list');
    }

    public function get_duplicate_courses_pdf_title()
    {
        $this->Courses_model->get_duplicate_courses_pdf_title();
    }

    public function get_duplicate_courses_title()
    {
        $this->Courses_model->get_duplicate_courses_title();
    }
}
