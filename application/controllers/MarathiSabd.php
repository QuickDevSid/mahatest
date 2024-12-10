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

class MarathiSabd extends CI_Controller
{
    //functions
    public function __construct()
    {
        parent::__construct();
        $this->load->model("MarathiSabd_model");
    }

    public function marathi_sabd_category()
    {
        $this->form_validation->set_rules('title', 'Name', 'required');
        if ($this->form_validation->run() === FALSE) {
            // $data['single'] = $this->MarathiSabd_model->get_single_english_vocabulary_cat();
            $data['single'] = $this->MarathiSabd_model->get_single_marathi_sabd_cat();
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('marathi_sabd/marathi_sabd_category', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('marathi_sabd/categoryscript.php', $data);

            // $this->load->view("admin/add_round", $data);
        } else {

            $res = $this->MarathiSabd_model->set_marathi_sabd_cat_details();

            if ($res == "1") {
                $this->session->set_flashdata("success", "Current Affairs details updated successfully!");
                redirect('marathi_sabd/marathi_sabd_category_list');
            } else {
                $this->session->set_flashdata('success', 'Current Affairs entry updated!');
                redirect('marathi_sabd/marathi_sabd_category_list');
            }
            redirect('marathi_sabd/marathi_sabd_category_list');
        }
    }

    public function marathi_sabd_category_list()
    {
        $data['category'] = $this->MarathiSabd_model->get_single_category_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('marathi_sabd/marathi_sabd_category_list', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('marathi_sabd/categoryscript.php', $data);
    }

    public function marathi_sabd_form_inactive($id)
    {
        $this->MarathiSabd_model->marathi_sabd_form_inactive($id);
        redirect('marathi_sabd/marathi_sabd_form_list');
    }

    public function marathi_sabd_form_active($id)
    {
        $this->MarathiSabd_model->marathi_sabd_form_active($id);
        redirect('marathi_sabd/marathi_sabd_form_list');
    }

    public function delete_marathi_sabd_form($id)
    {
        $this->MarathiSabd_model->delete_marathi_sabd_form($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('marathi_sabd/marathi_sabd_form_list');
    }

    public function delete_marathi_sabd_category($id)
    {
        $this->MarathiSabd_model->delete_marathi_sabd_category($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('marathi_sabd/marathi_sabd_category_list');
    }

    public function marathi_sabd_form()
    {
        $this->form_validation->set_rules('title', 'Name', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->MarathiSabd_model->get_single_marathi_sabd();
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('marathi_sabd/marathi_sabd_form', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('marathi_sabd/marathisabdscript.php', $data);

            // $this->load->view("admin/add_round", $data);
        } else {

            $upload_image = $this->input->post('current_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/uploads/marathi_sabd/images",
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
                    redirect('marathi_sabd/marathi_sabd_form_list');
                    return;
                }
            }

            $res = $this->MarathiSabd_model->set_marathi_sabd_details($upload_image);

            if ($res == "1") {
                $this->session->set_flashdata("success", "Marathi Sabd Sangrah details updated successfully!");
                redirect('marathi_sabd/marathi_sabd_form_list');
            } else {
                $this->session->set_flashdata('success', 'Marathi Sabd Sangrah entry updated!');
                redirect('marathi_sabd/marathi_sabd_form_list');
            }
            redirect('marathi_sabd/marathi_sabd_form_list');
        }
    }

    public function marathi_sabd_form_list()
    {
        $data['category'] = $this->MarathiSabd_model->get_single_english_vocabulary_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        // $this->load->view('current_affairs/manage_current_affairs_form_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('marathi_sabd/marathi_sabd_form_list', $data);
        $this->load->view('marathi_sabd/marathisabdscript.php', $data);
        $this->load->view('templates/footer1', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }
}
