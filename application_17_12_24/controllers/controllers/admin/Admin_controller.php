<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_controller extends CI_Controller {

    public function app_users(){
		$this->load->view('admin/app_users');
        $this->load->view('templates/footer1', $data);
        $this->load->view('templates/footer1', $data);
	}
}