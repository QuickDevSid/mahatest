<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Other_options_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Other_option_model");
    }

    //functions

    public function documents()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/document', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }

    public function texts()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/texts', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }

    public function videos()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/videos', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }
    public function add_test()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/add_test', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }
    public function tests()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['tests'] = $this->Other_option_model->get_docs_videos_tests();
        // echo '<pre>'; print_r($data['tests']); exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/tests', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }

    public function add_docs_videos_tests()
    {
        if (isset($_POST)) {
            $this->form_validation->set_rules('test_id[]', 'Test', 'required');
            if ($this->form_validation->run() === FALSE) {
                echo validation_errors();
                return false;
            }

            $insert = $this->Other_option_model->save_docs_videos_tests();
            redirect('doc_videos/tests');
        }
    }
    public function delete_test()
    {
        $insert = $this->Other_option_model->delete_docs_videos_test($this->uri->segment(3));
        redirect('doc_videos/tests');
    }

    public function add_doc_data()
    {
        if (isset($_POST)) {

            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);

            $description = str_replace('\r\n', '', $description);
            $image = "";
            $pdf = "";
            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/docs/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $image = $images;
                }
            }

            if (!empty($_FILES['pdf']['name'])) {
                $path = 'AppAPI/docs_videos/docs/pdfs';
                $pdfs = upload_file('pdf', $path, 'pdf');
                if (empty($pdfs['error'])) {
                    $pdf = $pdfs;
                }
            }

            $data = [
                'title' => $title,
                'type' => 'Docs',
                'source_type' => $source_type,
                'description' => $description,
                'status' => $status,
                'can_download' => $can_download,
                'image_url' => $image,
                'pdf_url' => $pdf
            ];
            $insert = $this->Other_option_model->save($data);
            if ($insert == 'Inserted') {
                echo "Inserted";
                $art_msg['msg'] = 'New Document added.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
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

            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Docs',
                'source_type' => $source_type,
                'description' => $description,
                'status' => $status,
                'can_download' => $can_download
            ];

            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/docs/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] =  $images;
                }
            }
            if (!empty($_FILES['pdf']['name'])) {
                $path = 'AppAPI/docs_videos/docs/pdfs';
                $pdf = upload_file('pdf', $path, 'pdf');
                if (empty($pdf['error'])) {
                    $data['pdf_url'] =  $pdf;
                }
            }
            $id = $_POST['id'];
            $insert = $this->Other_option_model->update($id, $data);
            if ($insert == 'Updated') {
                echo "Updated";
                $art_msg['msg'] = 'Document updated.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/document', 'refresh');
    }

    public function add_texts_data()
    {
        if (isset($_POST)) {

            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $ImagePath = '';
            $pdf_url = '';

            $description = str_replace('\r\n', '', $description);

            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/texts';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath =  $images;
                }
            }
            $data = [
                'title' => $title,
                'type' => 'Texts',
                'source_type' => $source_type,
                'description' => $description,
                'status' => $status,
                'image_url' => $ImagePath
            ];
            $insert = $this->Other_option_model->save($data);
            if ($insert == 'Inserted') {
                echo "Inserted";
                $art_msg['msg'] = 'New Texts Added.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/texts', 'refresh');
    }

    public function update_texts_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);

            $description = str_replace('\r\n', '', $description);

            $data = [
                'title' => $title,
                'type' => 'Texts',
                'source_type' => $source_type,
                'description' => $description,
                'status' => $status,
                'can_download' => $can_download
            ];

            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/texts';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] =  $images;
                }
            }

            $id = $_POST['id'];
            $insert = $this->Other_option_model->update($id, $data);
            if ($insert == 'Updated') {
                echo "Updated";
                $art_msg['msg'] = 'Texts entry updated.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/texts', 'refresh');
    }

    public function add_video_data()
    {
        if (isset($_POST)) {

            $title = $this->db->escape_str($_POST['title']);
            $video_source = $this->db->escape_str($_POST['video_source']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $video_url = $this->db->escape_str($_POST['video_url']);

            if (!empty($_FILES['video_url']['name'])) {
                $path = 'AppAPI/docs_videos/videos/' . $_FILES['video_url']['name'];
                move_uploaded_file($_FILES['video_url']['tmp_name'], $path);
                $video_url = $path;
            }
            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/videos';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath =  $images;
                }
            }

            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Video',
                'source_type' => $source_type,
                'status' => $status,
                'video_source' => $video_source,
                'image_url' => $ImagePath,
                'video_url' => $video_url,
                'description' => $description
            ];
            $insert = $this->Other_option_model->save($data);
            if ($insert == 'Inserted') {
                echo "Inserted";
                $art_msg['msg'] = 'New Video added.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/videos', 'refresh');
    }

    public function update_video_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $video_source = $this->db->escape_str($_POST['video_source']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['edit_status']);
            $description = $this->db->escape_str($_POST['description']);
            // $video_url = $this->db->escape_str($_POST['video_url']);

            $description = str_replace('\r\n', '', $description);
            $data = [
                'title' => $title,
                'type' => 'Video',
                'source_type' => $source_type,
                'description' => $description,
                'status' => $status,
                'video_source' => $video_source
            ];
            if (!empty($_FILES['video_url']['name'])) {
                $path = 'AppAPI/docs_videos/videos/' . $_FILES['video_url']['name'];
                move_uploaded_file($_FILES['video_url']['tmp_name'], $path);
                $video_url = $path;
                $data['video_url'] = $video_url;
            }
            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/videos';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] = $images;
                }
            }
            $id = $_POST['id'];
            $insert = $this->Other_option_model->update($id, $data);
            if ($insert == 'Updated') {
                echo "Updated";
                $art_msg['msg'] = 'Video updated.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/videos', 'refresh');
    }

    public function get_doc_video_details()
    {
        $condition = null;
        $type = $_GET['type'];
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $condition = ['type' => $_GET['type']];
        }
        $fetch_data = $this->Other_option_model->make_datatables($condition);
        //         echo $this->db->last_query();
        //        print_r($fetch_data);die;
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getExamSectionDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getExamSectionDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteExamSectionDetails(this.id)" id="delete' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

            $sub_array[] = $row->title;

            if ($type == 'Docs') {
                $sub_array[] =  $row->can_download;
                $sub_array[] = '<img src="' . base_url("AppAPI/docs_videos/docs/images/" . $row->image_url) . '" class="img-fluid rounded" style="width: 100px;" >';
            } elseif ($type == 'Video') {
                if ($row->video_source == "Hosted") {
                    $sub_array[] = '<a href="' . base_url($row->video_url) . '" target="_blank"><i class="material-icons">link</i> View Video</a>';
                } else {
                    $sub_array[] = '<a href="' . $row->video_url . '" target="_blank"><i class="material-icons">link</i> View Video</a>';
                }
                $sub_array[] = $row->video_source;
                $sub_array[] = '<img src="' . base_url("AppAPI/docs_videos/videos/" . $row->image_url) . '" class="img-fluid rounded" style="width: 100px;" >';
            } else {
                $sub_array[] = '<img src="' . base_url("AppAPI/docs_videos/texts/" . $row->image_url) . '" class="img-fluid rounded" style="width: 100px;" >';
            }

            if ($type == 'Docs') {
                $sub_array[] = '<a href="' . base_url("AppAPI/docs_videos/docs/pdfs/" . $row->pdf_url) . '" target="_blank"><i class="material-icons">download</i> View</a> ';
            }
            $sub_array[] = $row->views_count;
            $sub_array[] = $row->status;

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->Other_option_model->get_all_data(), "recordsFiltered" => $this->Other_option_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }

    public function get_single_video_doc($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->Other_option_model->getPostById($id);
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

    public function delete_doc_video_data($id = null)
    {
        if ($_GET['id']) {
            $id = $_GET['id'];
        }
        //echo $id;die;
        if (!$id) {
            return false;
        }

        // $result = $this->Other_option_model->checkUserSelectedPlan($id);
        if ($this->Other_option_model->delete($id)) {
            echo "Success";
        } else {
            echo "Failed";
        }
    }
    public function get_single_pdf($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->Other_option_model->getPostById($id);
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

    public function add_other_option()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Other_option_model->get_single_other_option(); //
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('other_option_new/add_other_option', $data);   //pending
            $this->load->view('templates/footer1', $data);
            $this->load->view('other_option_new/otheroptionscript', $data);  //pending
            $this->session->set_flashdata("error", "Error updating Courses.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/other_options/images",
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
                    redirect('other_option_new/other_option_list');
                    return;
                }
            }

            $upload_pdf = $this->input->post('current_pdf');
            if (isset($_FILES['pdf']) && $_FILES['pdf']['name'] != "") {
                $config = array(
                    'upload_path'   => "assets/uploads/other_options/pdfs",
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
                    echo "error";
                    exit;
                    redirect('other_option_new/other_option_list');
                    return;
                }
            }

            $res = $this->Other_option_model->set_other_options_details($upload_image, $upload_pdf);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Doc and Videos details added successfully!");
                // echo "inserted";
                // exit;
                redirect('other_option_new/other_option_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Doc and Videos entry updated!");
                // echo "updated";
                // exit;
                redirect('other_option_new/other_option_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Doc and Videos.");
                redirect('other_option_new/other_option_list');
            }
        }
    }

    public function other_option_list()
    {
        $data['category'] = $this->Other_option_model->get_single_other_option_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('other_option_new/other_option_list', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('other_option_new/otheroptionscript.php', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }

    public function delete_other_option_list($id)
    {
        $this->Other_option_model->delete_other_option_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('other_option_new/other_option_list');
    }

    public function add_text()
    {

        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Other_option_model->get_single_text(); //
            $this->load->view('doc_videos/add_text', $data);   //pending
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            // $this->load->view('courses/jscript.php', $data);
            $this->load->view('doc_videos/textscript.php', $data);  //pending
            $this->session->set_flashdata("error", "Error updating Courses.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/doc_n_videos/images",
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
                    redirect('doc_videos/text_list');
                    return;
                }
            }

            $res = $this->Other_option_model->set_text_details($upload_image);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Doc and Videos details added successfully!");
                // echo "inserted";
                // exit;
                redirect('doc_videos/text_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Doc and Videos entry updated!");
                // echo "updated";
                // exit;
                redirect('doc_videos/text_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Doc and Videos.");
                redirect('doc_videos/text_list');
            }
        }
    }

    public function text_list()
    {
        $data['category'] = $this->Other_option_model->get_single_text_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('doc_videos/text_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/textscript.php', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }

    public function delete_text_list($id)
    {
        $this->Other_option_model->delete_text_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('doc_videos/text_list');
    }

    public function add_videos()
    {

        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Other_option_model->get_single_video();
            $this->load->view('doc_videos/add_videos', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('doc_videos/newjscriptvideo.php', $data);
            $this->session->set_flashdata("error", "Error updating Docs and Video Videos.");
        } else {
            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/doc_n_videos/images",
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
                    redirect('doc_videos/videos_list');
                    return;
                }
            }

            $video_url = $this->input->post('current_video');
            if ($this->input->post('video_source') === "Hosted") {
                if (isset($_FILES['video_file']) && $_FILES['video_file']['name'] != "") {
                    $target_dir = 'assets/uploads/doc_n_videos/videos';
                    $target_file = $target_dir . basename($_FILES['video_file']['name']);
                    $allowed_types = ['mp4', 'avi', 'mov'];
                    $file_ext = pathinfo($target_file, PATHINFO_EXTENSION);
                    if (!in_array(strtolower($file_ext), $allowed_types)) {
                        $this->session->set_flashdata("error", "Invalid video file type. Allowed types: MP4, AVI, MOV.");
                        echo "new error 1";
                        exit;
                        redirect('doc_videos/videos_list');
                        return;
                    }

                    $target_file = $target_dir . uniqid() . '.' . $file_ext;

                    if (move_uploaded_file($_FILES['video_file']['tmp_name'], $target_file)) {
                        $video_url = $target_file;
                    } else {
                        $this->session->set_flashdata("error", "Error uploading video.");
                        echo "new error 2";
                        exit;
                        redirect('doc_videos/videos_list');
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
                        echo "new error 3";
                        exit;
                        redirect('doc_videos/videos_list');
                        return;
                    }
                }
            }

            $res = $this->Other_option_model->set_videos($upload_image, $video_url);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Docs and Videos,Video details added successfully!");
                // echo "inserted";
                // exit;
                redirect('doc_videos/videos_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Docs and Videos,Video entry updated!");
                // echo "updated";
                // exit;
                redirect('doc_videos/videos_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Docs and Videos,Video.");
                redirect('doc_videos/videos_list');
            }
        }
    }

    public function videos_list()
    {
        $data['category'] = $this->Other_option_model->get_single_video_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('doc_videos/videos_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/newjscriptvideo.php', $data);
    }

    public function delete_video_list($id)
    {
        $this->Other_option_model->delete_video_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('doc_videos/videos_list');
    }
}
