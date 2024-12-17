<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Introduction_screens extends CI_Controller
{
    public function index()
    {
        $data['title'] = ucfirst('Introduction Screen'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('IntroductionScreen/index', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('IntroductionScreen/jscript.php', $data);
    }

    public function get_introduction_screen_details()
    {
        
        $this->load->model("Introduction_screens_model");
        $fetch_data = $this->Introduction_screens_model->make_datatables();
        //print_r($fetch_data);die;
        $data = array();
        foreach ($fetch_data as $row) {
           $sub_array = array();

           $sub_array[] = '<button type="button" name="Details" onclick="getIntroductionScreenDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showIntroductionScreen">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getIntroductionScreenDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#editIntroductionScreen" >
          <i class="material-icons">mode_edit</i></button>
          ';

          $sub_array[] = $row->title;
          $sub_array[] = $row->description;
          $sub_array[] = date("d-m-Y H:i:s",strtotime($row->created_at));

           $data[] = $sub_array;
       }
       $output = array("recordsTotal" => $this->Introduction_screens_model->get_all_data(), "recordsFiltered" => $this->Introduction_screens_model->get_filtered_data(), "data" => $data);
      
       echo json_encode($output);
    }
    function now()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
    }
    
    public function addIntroductionScreen(){
        //print_r($_POST);die;
        if (!is_dir('AppAPI/introduction-screen/')) {
            mkdir('AppAPI/introduction-screen/', 0777, TRUE);    
        }
        if (!is_dir('AppAPI/introduction-screen/images/')) {
            mkdir('AppAPI/introduction-screen/images', 0777, TRUE);    
        }
        if (!is_dir('AppAPI/introduction-screen/icon')) {
            mkdir('AppAPI/introduction-screen/icon', 0777, TRUE);    
        }

        $image = "";
        $icon = "";
        if (!empty($_FILES['file']['name'])) {
            $path = 'AppAPI/introduction-screen/images/';
            $images = upload_file('file', $path);
            if (empty($images['error'])) {
                $image = $images;
            }
        }

        if (!empty($_FILES['iconfile']['name'])) {
            $path = 'AppAPI/introduction-screen/icon/';
            $images = upload_file('iconfile', $path);
            if (empty($images['error'])) {
                $icon = $images;
            }
        }
        
        $this->load->model("Introduction_screens_model");
        
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $created_at = $this->now();
        
        $result = $this->Introduction_screens_model->save_upload($image, $icon, $title, $description,$created_at);
        //print_r($result);die;
        if ($result === "Failed") {
            echo "Operation failed";
        } elseif ($result === "Inserted") {
            echo "Success";
        } elseif ($result === "Exists") {
            echo "Exists";
        }
    
   }

   public function fetchIntroductionScreenDetail($id){
       
        if (!$id) {
            echo "No ID specified";
            exit;
        }
        $this->load->model("Introduction_screens_model");
        $result = $this->Introduction_screens_model->getPostById($id);
        
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

    public function editIntroductionScreen(){
        //print_r($_POST);die;
        if (!is_dir('AppAPI/introduction-screen/')) {
            mkdir('AppAPI/introduction-screen/', 0777, TRUE);    
        }
        if (!is_dir('AppAPI/introduction-screen/images/')) {
            mkdir('AppAPI/introduction-screen/images', 0777, TRUE);    
        }
        if (!is_dir('AppAPI/introduction-screen/icon')) {
            mkdir('AppAPI/introduction-screen/icon', 0777, TRUE);    
        }
       

        $image=$this->input->post('e_img');
        $icon=$this->input->post('e_iconimg');
        if (!empty($_FILES['file']['name'])) {
            $path = 'AppAPI/introduction-screen/images/';
            $images = upload_file('file', $path);
            if (empty($images['error'])) {
                $image = $images;
            }

            if(!empty($this->input->post('e_img')) && file_exists('AppAPI/introduction-screen/images/'.$this->input->post('e_img'))){
                unlink('AppAPI/introduction-screen/images/'.$this->input->post('e_img'));
            }
        }

        if (!empty($_FILES['iconfile']['name'])) {
            $path = 'AppAPI/introduction-screen/icon/';
            $images = upload_file('iconfile', $path);
            if (empty($images['error'])) {
                $icon = $images;
            }

            if(!empty($this->input->post('e_iconimg')) && file_exists('AppAPI/introduction-screen/icon/'.$this->input->post('e_iconimg'))){
                unlink('AppAPI/introduction-screen/icon/'.$this->input->post('e_iconimg'));
            }
        }

        $this->load->model("Introduction_screens_model");
        
        $id = $this->input->post('e_id');
        $title = $this->input->post('title');
        
        $description = $this->input->post('description');
        $updated_On = $this->now();
        
        $result = $this->Introduction_screens_model->update_upload($id,$image, $icon, $title, $description,$updated_On);
        //print_r($result);die;
        if ($result === "Failed") {
            echo "Operation failed";
        } elseif ($result === "Updated") {
            echo "Success";
        } elseif ($result === "Exists") {
            echo "Exists";
        }
   }

   function deleteIntroductionScreen($id)
    {
        //echo $id;die;
        if (!$id) {
            echo "Parameter missing";
        }
        $this->load->model("Introduction_screens_model");
        $result = $this->Introduction_screens_model->getPostById($id);
        if($result){
            $img=$result[0]['upload_img'];
            $iconimg=$result[0]['upload_icon'];
            
            if ($this->Introduction_screens_model->delete($id)) {
                if(!empty($img) && file_exists('AppAPI/introduction-screen/images/'.$img)){
                    unlink('AppAPI/introduction-screen/images/'.$img);
                }
                if(!empty($iconimg) && file_exists('AppAPI/introduction-screen/icon/'.$iconimg)){
                    unlink('AppAPI/introduction-screen/icon/'.$iconimg);
                }
                echo "Success";
             } else {
                 echo "Failed";
             }

        }else{
            echo "Failed";
        }
        
    }
}

