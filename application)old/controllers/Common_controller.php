<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Notification_model");
    }
    
	public function test_notification() {
		$this->Notification_model->test_notification();
	}
}
