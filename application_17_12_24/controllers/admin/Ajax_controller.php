<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax_controller extends CI_Controller {


   

	public function fetch_user()
{
    $this->load->model('HelpMaster_model');

    $fetch_data = $this->HelpMaster_model->make_datatables();
    // echo "hiiii<pre>";
    // print_r($fetch_data);
    // exit;
    $data = array();
    foreach ($fetch_data as $row) {
        $sub_array = array();
             

        $sub_array[] = '<button type="button" name="Details" onclick="get_help_master_Edit(this.id,\'view\')" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#add_help_entry">
     <i class="material-icons">visibility</i> </button>
      <button type="button" name="Edit" onclick="get_help_master_Edit(this.id,\'edit\')" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#add_help_entry" >
      <i class="material-icons">mode_edit</i></button>

      <button type="button" name="Delete" onclick="deleteExamSectionDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
      <i class="material-icons">delete</i></button>
      ';

        if($row->type == '1') {
			$sub_array[] = 'Help';
		}elseif($row->type == '0') {
			$sub_array[] = 'How to use ';
		}else{
			$sub_array[] = '';
		}
       
        $sub_array[] = $row->title;
        $sub_array[] = $row->status;
        $sub_array[] = date("d-m-Y H:i:s",strtotime($row->created_on));


        $data[] = $sub_array;
    }
//     echo "hiiii<pre>";
// print_r($data);
// exit;
    $output = array("recordsTotal" => $this->HelpMaster_model->get_all_data(), "recordsFiltered" => $this->HelpMaster_model->get_filtered_data(), "data" => $data);

    echo json_encode($output);
}

}