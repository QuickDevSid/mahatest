<?php defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Session extends CI_Session
{

    function __construct()
    {
        parent::__construct();

        $this->CI->session = $this;
    }

    function sess_update()
    {
        // Do NOT update an existing session on AJAX calls.
        if (!$this->CI->input->is_ajax_request())
            return parent::sess_update();
    }

}