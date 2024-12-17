<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FAQ extends CI_Controller
{
    public function index()
    {
        $data['title'] = ucfirst('FAQ'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('faq/index', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('faq/jscript.php', $data);
    }

    public function get_faq_details()
    {
        
        $this->load->model("FAQ_model");
        $fetch_data = $this->FAQ_model->make_datatables();
        //print_r($fetch_data);die;
        $data = array();
        foreach ($fetch_data as $row) {
           $sub_array = array();

           $sub_array[] = '<button type="button" name="Details" onclick="getFAQDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showFAQ">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getFAQDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#editFAQ" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteFAQDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

          $sub_array[] = $row->title;
          $sub_array[] = $row->description;
          $sub_array[] = date("d-m-Y H:i:s",strtotime($row->created_at));

           $data[] = $sub_array;
       }
       $output = array("recordsTotal" => $this->FAQ_model->get_all_data(), "recordsFiltered" => $this->FAQ_model->get_filtered_data(), "data" => $data);
      
       echo json_encode($output);
    }

    function now()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
    }
    
    public function addFAQ(){
        //print_r($_POST);die;       
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $created_at = $this->now();
        $this->load->model("FAQ_model");
        $result = $this->FAQ_model->save_faq($title, $description,$created_at);
        //print_r($result);die;
        if ($result === "Failed") {
            echo "Operation failed";
        } elseif ($result === "Inserted") {
            echo "Success";
        } elseif ($result === "Exists") {
            echo "Exists";
        }
    
   }

   public function fetchFAQDetail($id){
       
        if (!$id) {
            echo "No ID specified";
            exit;
        }
        $this->load->model("FAQ_model");
        $result = $this->FAQ_model->getPostById($id);
        
        if ($result) {
            $row=[];
            $row=$result[0];
            $row['created_at']=date("d-m-Y H:i:s",strtotime($result[0]['created_at']));
            echo json_encode($row);
            exit;
        } else {
            echo "Invalid ID";
            exit;
        }
    }

    public function editFAQ(){
        //print_r($_POST);die;
       
        $this->load->model("FAQ_model");
        
        $id = $this->input->post('e_id');
        $title = $this->input->post('title');
        
        $description = $this->input->post('description');
        $updated_On = $this->now();
        
        $result = $this->FAQ_model->update_faq($id,$title, $description,$updated_On);
        //print_r($result);die;
        if ($result === "Failed") {
            echo "Operation failed";
        } elseif ($result === "Updated") {
            echo "Success";
        } elseif ($result === "Exists") {
            echo "Exists";
        }
   }

   function deleteFAQ($id)
    {
        //echo $id;die;
        if (!$id) {
            echo "Parameter missing";
        }
        $this->load->model("FAQ_model");
        $result = $this->FAQ_model->getPostById($id);
        if($result){            
            if ($this->FAQ_model->delete($id)) {                
                echo "Success";
             } else {
                 echo "Failed";
             }

        }else{
            echo "Failed";
        }
        
    }

}