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



class Whatsapp_details extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->model("Whatsapp_details_model");
    }

    //functions

    // function index()

    // {



    //     $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter

    //     $this->load->view('templates/header1', $data);

    //     $this->load->view('templates/menu', $data);

    //     $this->load->view('membership_plans/index', $data);

    //     //        $this->load->view('membership_plans/details', $data);

    //     $this->load->view('templates/footer1', $data);

    //     $this->load->view('membership_plans/jscript.php', $data);

    // }



    public function add_whatsapp_details()

    {

        $whatsapp_number = $this->input->post('whatsapp_number');

        $this->form_validation->set_rules('whatsapp_number', 'Number', 'required');



        if ($this->form_validation->run() === FALSE) {

            $data['single'] = $this->Whatsapp_details_model->get_single_whatsapp_details(); //



            $this->load->view('templates/header1', $data);

            $this->load->view('templates/menu', $data);

            $this->load->view('whatsapp_details/add_whatsapp_details', $data);

            $this->load->view('templates/footer1', $data);

            $this->load->view('whatsapp_details/whatsappdetailscript.php', $data);

            $this->session->set_flashdata("error", "Error updating Whatsapp Details.");
        } else {

            $res = $this->Whatsapp_details_model->set_whatsapp_details_details();

            if ($res == "1") {

                ini_set('display_errors', 1);

                ini_set('display_startup_errors', 1);

                error_reporting(E_ALL);

                $this->session->set_flashdata("success", "Whatsapp details added successfully!");

                redirect('whatsapp_details/whatsapp_details_list');
            } elseif ($res == "0") {

                $this->session->set_flashdata("success", "Whatsapp Details entry updated!");

                redirect('whatsapp_details/whatsapp_details_list');
            } else {

                $this->session->set_flashdata("error", "Error updating Whatsapp Details.");

                redirect('whatsapp_details/whatsapp_details_list');
            }
        }
    }



    public function whatsapp_details_list()

    {

        $data['category'] = $this->Whatsapp_details_model->get_single_whatsapp_details_list();

        // echo '<pre>';

        // print_r($data['category']);

        // exit();

        $this->load->view('templates/header1', $data);

        $this->load->view('templates/menu', $data);

        $this->load->view('whatsapp_details/whatsapp_details_list', $data);

        $this->load->view('templates/footer1', $data);

        // $this->load->view('courses/jscript.php', $data);

        $this->load->view('whatsapp_details/whatsappdetailscript.php', $data);
    }





    public function delete_membership_plans_list($id)

    {

        $this->Whatsapp_details_model->delete_membership_plans_list($id);

        $this->session->set_flashdata('delete', 'Record deleted successfully');



        redirect('membership_plans/membership_plans_list');
    }



    public function status_membership_plans_list_active($id)

    {

        $this->Whatsapp_details_model->status_membership_plans_list_active($id);

        // $this->session->set_flashdata('delete', 'Record deleted successfully');



        redirect('membership_plans/membership_plans_list');
    }



    public function status_membership_plans_list_in_active($id)

    {

        $this->Whatsapp_details_model->status_membership_plans_list_in_active($id);

        // $this->session->set_flashdata('delete', 'Record deleted successfully');



        redirect('membership_plans/membership_plans_list');
    }
}
