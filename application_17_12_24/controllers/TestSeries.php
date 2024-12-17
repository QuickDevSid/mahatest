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

class TestSeries extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("DocsVideos_model");
        $this->load->model("Test_series_model");
    }
    //functions
    function index()
    {

        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('test_series/test_series', $data);
        //        $this->load->view('test_series/details', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/jscript.php', $data);
    }

    public function documents()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('courses/document', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('courses/jscript.php', $data);
    }
    public function quizs()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('test_series/quizs', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/jscript.php', $data);
    }
    public function videos()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('test_series/videos', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/jscript.php', $data);
    }
    public function pdf()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('test_series/pdf', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/jscript.php', $data);
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
            if (true) {
                $data = [
                    'title' => $title,
                    'type' => 'Docs',
                    'source_type' => $source_type,
                    'source_type' => $source_type,
                    'description' => $description,
                    'status' => $status,
                    'can_download' => $can_download,
                    'image_url' => $ImagePath,
                    'pdf_url' => $pdf_url,
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
                $path = 'assets/uploads/test_series/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath = $path . '/' . $images;
                }
            }
            if (!empty($_FILES['pdf']['name'])) {
                $path = 'assets/uploads/test_series/pdf';
                $pdf = upload_file('pdf', $path, 'pdf');
                if (empty($pdf['error'])) {
                    $pdf_url = $path . '/' . $pdf;
                }
            }
            if (true) {
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
    // end pdf add data
    // update pdf 
    public function update_pdf_data()
    {
        if (isset($_POST)) {
            $id = $this->db->escape_str($_POST['id']);
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            //$check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);   
            $time = $_POST['time'];

            // Sanitize and escape the time value
            $time = $this->db->escape_str($time);
            if (true) {
                $data = [
                    'title' => $title,
                    'type' => 'Pdf',
                    'source_type' => $source_type,
                    'source_type' => $source_type,
                    'description' => $description,
                    'status' => $status,
                    'can_download' => $can_download,
                    'description' => $description,
                    'time' => $time
                ];
                if (!empty($_FILES['image']['name'])) {
                    $path = 'assets/uploads/test_series/images';
                    $images = upload_file('image', $path);
                    if (empty($images['error'])) {
                        $data['image_url'] = $path . '/' . $images;
                    }
                }
                if (!empty($_FILES['pdf']['name'])) {
                    $path = 'assets/uploads/test_series/pdf';
                    $pdf = upload_file('pdf', $path, 'pdf');
                    if (empty($pdf['error'])) {
                        $data['pdf_url'] = $path . '/' . $pdf;
                    }
                }
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
            } else {
                echo "false";
                die;
                $art_msg['msg'] = 'New subject already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'courses/pdf', 'refresh');
    }
    // end pdf update
    public function update_doc_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            //    $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            if (true) {
                $data = [
                    'title' => $title,
                    'type' => 'Pdf',
                    'source_type' => $source_type,
                    'source_type' => $source_type,
                    'description' => $description,
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
                    echo "Updated";
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

        redirect(base_url() . 'courses/document', 'refresh');
    }
    public function add_video_data()
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
            $video_source = $this->db->escape_str($_POST['video_source']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $video_url = $this->db->escape_str($_POST['video_url']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            //    $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            if (!empty($_FILES['video_url']['name'])) {
                $path = 'assets/uploads/test_series/videos/' . $_FILES['video_url']['name'];
                move_uploaded_file($_FILES['video_url']['tmp_name'], $path);
                $video_url = $path;
            }
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/uploads/test_series/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath = $path . '/' . $images;
                }
            }
            if (true) {
                $data = [
                    'title' => $title,
                    'type' => 'Video',
                    'source_type' => $source_type,
                    'source_id' => $source_id,
                    'description' => $description,
                    'status' => $status,
                    'video_source' => $video_source,
                    'image_url' => $ImagePath,
                    'video_url' => $video_url,
                    'description' => $description
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
    public function update_video_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $video_source = $this->db->escape_str($_POST['video_source']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $video_url = $this->db->escape_str($_POST['video_url']);
            $source_id = $this->db->escape_str($_POST['source_id']);
            //            $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            if (true) {
                $data = [
                    'title' => $title,
                    'type' => 'Video',
                    'source_id' => $source_id,
                    'source_type' => $source_type,
                    'description' => $description,
                    'status' => $status,
                    'video_source' => $video_source,
                    'video_url' => $video_url,
                    'description' => $description
                ];
                if (!empty($_FILES['video_url']['name'])) {
                    $path = 'assets/uploads/test_series/videos/' . $_FILES['video_url']['name'];
                    move_uploaded_file($_FILES['video_url']['tmp_name'], $path);
                    $video_url = $path;
                    $data['video_url'] = $video_url;
                }
                if (!empty($_FILES['image']['name'])) {
                    $path = 'assets/uploads/test_series/images';
                    $images = upload_file('image', $path);
                    if (empty($images['error'])) {
                        $ImagePath = $path . '/' . $images;
                        $data['image_url'] = $ImagePath;
                    }
                }
                $id = $_POST['id'];
                // echo "<pre>";
                // print_r($id);
                // die;
                $insert = $this->DocsVideos_model->update($id, $data);
                // echo $this->db->last_query();
                if ($insert == 'Updated') {
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
            } else {
                echo "false";
                die;
                $art_msg['msg'] = 'New subject already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'courses/document', 'refresh');
    }
    public function add_series_data()
    {
        if (isset($_POST)) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('sub_title', 'sub title', 'required');
            $this->form_validation->set_rules('mrp', 'MRP', 'required');
            $this->form_validation->set_rules('sale_price', 'sale price', 'required');
            //    print_r($_FILES);
            //    die;
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
            $status = $this->db->escape_str($_POST['status']);
            $sub_headings = $this->db->escape_str($_POST['sub_title']);
            $mrp = $this->db->escape_str($_POST['mrp']);
            $sale_price = $this->db->escape_str($_POST['sale_price']);
            $discount = $this->db->escape_str($_POST['discount']);
            $description = $this->db->escape_str($_POST['description']);
            $banner_image = '';
            $pdf_url = '';
            //    $check=$this->DocsVideos_model->getDataByWhereCondition(['title'=>$Title]);
            if (true) {
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
                $insert = $this->Test_series_model->save($data);
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
    public function update_series_data()
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

            if (true) {
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
                $insert = $this->Test_series_model->update($id, $data);
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
    public function get_test_series_details()
    {
        $condition = null;
        $type = $_GET['type'];

        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $condition = ['type' => $_GET['type']];
        }
        $condition['source_type'] = 'test_series';

        $fetch_data = $this->DocsVideos_model->make_datatables($condition);
        // echo $this->db->last_query();
        // print_r($fetch_data);die;
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getExamSectionDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
            <i class="material-icons">visibility</i> </button>
            <button type="button" name="Edit" onclick="getExamSectionDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
            <i class="material-icons">mode_edit</i></button>

            <button type="button" name="Delete" onclick="deleteExamSectionDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
            <i class="material-icons">delete</i></button>
            ';

            $sub_array[] = $row->title;
            if ($row->time != null) {
                $sub_array[] = $row->time;
            }

            if ($type == 'Docs' || $type == 'Pdf') {
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
            }
            $sub_array[] = '<img src="' . base_url($row->image_url) . '" class="img-fluid rounded" style="width: 50%;" >';
            $sub_array[] = $row->status;
            $sub_array[] = date("d-m-Y H:i:s", strtotime($row->created_at));

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->DocsVideos_model->get_all_data(), "recordsFiltered" => $this->DocsVideos_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }
    public function get_single_video_doc($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->DocsVideos_model->getPostById($id);
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
    public function get_series()
    {
        $fetch_data = $this->Test_series_model->make_datatables();
        /* echo $this->db->last_query();
        die; */
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getSingleSeriesDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
            <i class="material-icons">visibility</i> </button>
            <button type="button" name="Edit" onclick="getSeriesDetailsEdit(this.id)" id="edit_' . $row->id . '" class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
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
            $sub_array[] = date("d-m-Y H:i:s", strtotime($row->created_at));

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->Test_series_model->get_all_data(), "recordsFiltered" => $this->Test_series_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }
    public function get_single_series_detail($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->Test_series_model->getPostById($id);
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

    public function add_test_series()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Test_series_model->get_single_test_series(); //pending
            $this->load->view('test_series/add_test_series', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('test_series/testseriesjscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Courses.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/test_series/images",
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
                    redirect('test_series/test_series_list');
                    return;
                }
            }


            $upload_inner_image = $this->input->post('current_inner_banner_image');
            if (isset($_FILES['inner_banner_image']) && $_FILES['inner_banner_image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/test_series/images",
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


            $res = $this->Test_series_model->set_test_series_details($upload_image, $upload_inner_image);  //pending

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Test Series details added successfully!");
                redirect('test_series/test_series_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Test Series entry updated!");
                redirect('test_series/test_series_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Test Series.");
                redirect('test_series/test_series_list');
            }
        }
    }

    public function test_series_list()
    {
        $data['category'] = $this->Test_series_model->get_single_test_series_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('test_series/test_series_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/test_series_list_script.php', $data);
    }

    public function delete_test_series_list($id)
    {
        $this->Test_series_model->delete_test_series_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('test_series/test_series_list');
    }

    public function status_test_series_list_active($id)
    {
        $this->Test_series_model->status_test_series_list_active($id);
        // $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('test_series/test_series_list');
    }

    public function status_test_series_list_in_active($id)
    {
        $this->Test_series_model->status_test_series_list_in_active($id);
        // $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('test_series/test_series_list');
    }

    public function test_series_pdf()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Test_series_model->get_single_test_series_pdf(); //pending
            $this->load->view('test_series/test_series_pdf', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('test_series/pdfjscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Courses.");
        } else {
            $upload_pdf = $this->input->post('current_pdf');
            if (isset($_FILES['pdf']) && $_FILES['pdf']['name'] != "") {
                $config = array(
                    'upload_path'   => "assets/uploads/test_series/pdf",
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
                    redirect('test_series/test_series_pdf_list');
                    return;
                }
            }

            $res = $this->Test_series_model->set_test_series_pdf_details($upload_pdf);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Test Series PDF details added successfully!");
                redirect('test_series/test_series_pdf_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Test Series PDF entry updated!");
                redirect('test_series/test_series_pdf_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Test Series PDF.");
                redirect('test_series/test_series_pdf_list');
            }
        }
    }

    public function test_series_pdf_list()
    {
        $data['category'] = $this->Test_series_model->get_single_test_series_pdf_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('test_series/test_series_pdf_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/pdf_list_script.php', $data);
    }

    public function delete_test_series_pdf_list($id)
    {
        $this->Test_series_model->delete_test_series_pdf_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('test_series/test_series_pdf_list');
    }

    public function get_duplicate_title_pdf()
    {
        $this->Test_series_model->get_duplicate_title_pdf();
    }
    public function get_duplicate_title()
    {
        $this->Test_series_model->get_duplicate_title();
    }

    public function test_series_quizs()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['single'] = $this->Test_series_model->get_single_test_series_tests($this->uri->segment(3));    // Pending
        // echo 'hiii'; print_r($data['single']);  exit;
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('test_series/test_series_quizs', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/jscript.php', $data);
    }

    public function add_test_series_quizs_tests()
    {
        if (isset($_POST)) {
            $this->form_validation->set_rules('title', 'Test Series', 'required');
            if ($this->form_validation->run() === FALSE) {
                echo validation_errors();
                return false;
            }

            $insert = $this->Test_series_model->save_test_series_quizs_tests();
            redirect('test_series/test_series_quizs_list');
        }
    }

    public function test_series_quizs_list()
    {
        $data['category'] = $this->Test_series_model->get_single_test_series_quizs_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();  
        $this->load->view('test_series/test_series_quizs_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/quiz_list_script.php', $data);
    }

    public function delete_test_series_quizs_test()
    {
        $insert = $this->Test_series_model->delete_test_series_quizs_test($this->uri->segment(3));
        redirect('test_series/test_series_quizs_list');
    }

    public function test_series_quizs_view_details()
    {
        $data['category'] = $this->Test_series_model->get_single_test_series_quizs_list_details();
        $id = $this->input->post('id');
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('test_series/test_series_quizs_view_details', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('test_series/jscript.php', $data);
    }
}
