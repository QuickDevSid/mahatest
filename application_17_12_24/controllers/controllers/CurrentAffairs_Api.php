
<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

require(APPPATH . '/libraries/REST_controller.php');

use Restserver\Libraries\REST_controller;

class CurrentAffairs_Api  extends REST_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CurrentAffairsApi_model');
    }

    
    //API - delete a user
    function deletePost_delete()
    {
        $id = $this->delete('id');
        if (!$id) {
            $this->response("Parameter missing", 404);
        }
        $this->load->model('CurrentAffairs_model');
        $result=$this->CurrentAffairs_model->getPostById($id);
        if ($this->CurrentAffairsApi_model->delete($id)) {
            if(!empty($result[0]['current_affair_image']) && file_exists('AppAPI/current-affairs/'.$result[0]['current_affair_image'])){
                unlink('AppAPI/current-affairs/'.$result[0]['current_affair_image']);
            }
            $this->response("Success", 200);
        } else {
            $this->response("Failed", 400);
        }
    }

}
