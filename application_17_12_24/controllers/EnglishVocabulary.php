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

class EnglishVocabulary extends CI_Controller
{
    //functions
    public function __construct()
    {
        parent::__construct();
        $this->load->model("EnglishVocabulary_model");
    }

    public function english_vocabulary_category()
    {
        $this->form_validation->set_rules('title', 'Name', 'required');
        if ($this->form_validation->run() === FALSE) {
            // $data['single'] = $this->EnglishVocabulary_model->get_single_english_vocabulary_cat();
            $data['single'] = $this->EnglishVocabulary_model->get_single_english_vocabulary_cat();
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('english_vocabulary/english_vocabulary_category', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('english_vocabulary/categoryjscript.php', $data);

            // $this->load->view("admin/add_round", $data);
        } else {

            $res = $this->EnglishVocabulary_model->set_english_vocabulary_cat_details();

            if ($res == "1") {
                $this->session->set_flashdata("success", "Current Affairs details updated successfully!");
                redirect('english_vocabulary/english_vocabulary_category_list');
            } else {
                $this->session->set_flashdata('success', 'Current Affairs entry updated!');
                redirect('english_vocabulary/english_vocabulary_category_list');
            }
            redirect('english_vocabulary/english_vocabulary_category_list');
        }
    }

    public function english_vocabulary_category_list()
    {
        $data['category'] = $this->EnglishVocabulary_model->get_single_category_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('english_vocabulary/english_vocabulary_category_list', $data);
        $this->load->view('english_vocabulary/category_new_list_script.php', $data);
        $this->load->view('templates/footer1', $data);
    }

    public function english_vocabulary_form_inactive($id)
    {
        $this->EnglishVocabulary_model->english_vocabulary_form_inactive($id);
        redirect('english_vocabulary/english_vocabulary_form_list');
    }

    public function english_vocabulary_form_active($id)
    {
        $this->EnglishVocabulary_model->english_vocabulary_form_active($id);
        redirect('english_vocabulary/english_vocabulary_form_list');
    }

    public function delete_english_vocabulary_category($id)
    {
        $this->EnglishVocabulary_model->delete_english_vocabulary_category($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('english_vocabulary/english_vocabulary_category_list');
    }

    public function english_vocabulary_form()
    {
        $this->form_validation->set_rules('title', 'Name', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->EnglishVocabulary_model->get_single_english_vocabulary();
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('english_vocabulary/english_vocabulary_form', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('english_vocabulary/categorylistjscript.php', $data);

            // $this->load->view("admin/add_round", $data);
        } else {

            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/english_vocabulary/images",
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
                    redirect('english_vocabulary/english_vocabulary_form_list');
                    return;
                }
            }

            $res = $this->EnglishVocabulary_model->set_english_vocabulary_details($upload_image);

            if ($res == "1") {
                $this->session->set_flashdata("success", "English Vocabulary details updated successfully!");
                redirect('english_vocabulary/english_vocabulary_form_list');
            } else {
                $this->session->set_flashdata('success', 'English Vocabulary entry updated!');
                redirect('english_vocabulary/english_vocabulary_form_list');
            }
            redirect('english_vocabulary/english_vocabulary_form_list');
        }
    }

    public function english_vocabulary_form_list()
    {
        $data['category'] = $this->EnglishVocabulary_model->get_single_english_vocabulary_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        // $this->load->view('current_affairs/manage_current_affairs_form_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('english_vocabulary/english_vocabulary_form_list', $data);
        $this->load->view('english_vocabulary/category_list_script.php', $data);
        $this->load->view('templates/footer1', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }
}
