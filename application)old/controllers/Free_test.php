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

class Free_test extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model("FreeMock_model");
        $this->load->model("Courses_model");
    }
    public function add_test()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('free_test/add_test', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('free_test/jscript.php', $data);
    }
    public function tests()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['tests'] = $this->FreeMock_model->get_free_tests();
        // echo '<pre>'; print_r($data['tests']); exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('free_test/tests', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('free_test/jscript.php', $data);
    }
    public function add_free_tests()
    {
        if(isset($_POST))
        {
            $this->form_validation->set_rules('test_id[]', 'Test', 'required');
            if ($this->form_validation->run() === FALSE) {
                echo validation_errors();
                return false;
            }

            $insert=$this->FreeMock_model->save_free_tests();
            redirect('free_test/tests');
        }
    }
    public function delete_test()
    {
        $insert=$this->FreeMock_model->delete_free_test($this->uri->segment(3));
        redirect('free_test/tests');
    }  

}
