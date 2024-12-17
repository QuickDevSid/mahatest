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

class Mahatest_Coupon extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Mahatest_Coupon_model");
    }
    //functions
    public function add_coupon()
    {
        $data['title'] = ucfirst('All CurrentAffairs');
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $data['single'] = $this->Mahatest_Coupon_model->get_single_coupon();
        $this->load->view('new_coupon/add_coupon', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('new_coupon/sub_script.php', $data);
    }
    public function add_coupon_data()
    {
        $name = $this->input->post('name');
        $this->form_validation->set_rules('name', 'Ebook Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->Mahatest_Coupon_model->get_single_coupon();
            $this->load->view('new_coupon/add_coupon', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('new_coupon/jscript.php', $data);
        } else {
            $res = $this->Mahatest_Coupon_model->set_coupon_details();
            if ($res == "1") {
                $this->session->set_flashdata("success", "Coupon details added successfully!");
                redirect('new_coupon/add_coupon_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Coupon entry updated!");
                redirect('new_coupon/add_coupon_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Coupon.");
            }
        }
    }

    public function add_coupon_list()
    {
        $data['category'] = $this->Mahatest_Coupon_model->get_coupon();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('new_coupon/add_coupon_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('new_coupon/jscript.php', $data);
    }

    public function delete_coupon($id)
    {
        $this->Mahatest_Coupon_model->delete_coupon($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');
        redirect('new_coupon/add_coupon_list');
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
                $path = 'assets/ebook_images/';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] =  $images;
                }
            }

            $id = $_POST['id'];
            $insert = $this->DocsVideos_model->update($id, $data);
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
            $insert = $this->DocsVideos_model->save($data);
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
            $insert = $this->DocsVideos_model->update($id, $data);
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

    public function get_ebooks_video_details()
    {

        $fetch_data = $this->EbookCategory_model->make_datatables();
        //         echo $this->db->last_query();
        // print_r($fetch_data);
        // die;
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

            $sub_array[] = '<img src="' . base_url("assets/ebook_images/" . $row->icon) . '" class="img-fluid rounded" style="width: 100px;" alt="' . htmlspecialchars($row->title) . '">';
            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->EbookCategory_model->get_all_data(), "recordsFiltered" => $this->EbookCategory_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }

    public function get_single_video_doc($id)
    {
        if (!$id) {
            echo "No ID specified";
            exit;
        }
        $result = $this->EbookCategory_model->getPostById($id);
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

    public function delete_ebooks_cat_video_data($id = null)
    {
        if ($_GET['id']) {
            $id = $_GET['id'];
        }
        //echo $id;die;
        if (!$id) {
            return false;
        }

        // $result = $this->DocsVideos_model->checkUserSelectedPlan($id);
        if ($this->EbookCategory_model->delete($id)) {
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
}
