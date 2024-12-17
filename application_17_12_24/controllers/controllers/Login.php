<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

Class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Login_model'); // Load database
    }

    function index()
    {

        if($this->session->userdata('logged_in')) {
            $this->view('home');
        }else {
            $data = array('alert' => false);
            $this->load->view('login/login_form', $data);
            $this->load->view('login/jscript.php', $data);
        }


    }

    public function login(){
        $postData = $this->input->post();
       
        $validate = $this->Login_model->validate_login($postData);
        
        if ($validate){
            $newdata = array(
                'email'     => $validate[0]->email,
                'name' => $validate[0]->name,
                'role' => $validate[0]->type,
                'user_id' => $validate[0]->id,
                'profile_pic' => $validate[0]->profile_pic,
                'logged_in' => TRUE,
            );
            $this->session->set_userdata($newdata);
            $this->view('home');
        }
        else{
            $art_msg['msg'] = 'Invalid Details.';
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect( base_url().'login', 'refresh');
        }

    }

    public function logout() {
        $this->session->sess_destroy();
        $data = array('alert' => false);
        $this->load->view('login/login_form', $data);
        $this->load->view('login/jscript.php', $data);
    }


    public function view($page)
    {
        $data['title'] = ucfirst($page); // Capitalize the first letter
        if ($page == 'login_form') {
            if (!file_exists(APPPATH . 'views/login/' . $page . '.php')) {
                show_404(); // Whoops, we don't have a page for that!
            }

            $this->load->view('login/login_form', $data);
            $this->load->view('login/jscript.php', $data);

        } elseif ($page == 'home') {
            if (!file_exists(APPPATH . 'views/dashboard/' . $page . '.php')) {
                show_404(); // Whoops, we don't have a page for that!
            }
            $this->load->view('templates/header', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('dashboard/home', $data);
            $this->load->view('templates/footer', $data);
            $this->load->view('dashboard/home_js', $data);
        }

    }



}
