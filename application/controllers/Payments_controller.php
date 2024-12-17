<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments_controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("User_Payments_model");
    }

    public function all_payments(){
        $data['title'] = ucfirst('Payments List');
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('payments/all_payments', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('payments/jscript.php', $data);
    }
    public function all_bought_contents(){
        $data['title'] = ucfirst('Bought Contents List');
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('payments/all_bought_contents', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('payments/jscript_content.php', $data);
    }
}
