<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_controller extends CI_Controller {

  public function add_other_option_category(){
		$this->load->view('admin/add_other_option_category');
    $this->load->view('templates/menu');
        $this->load->view('templates/footer1');
        $this->load->view('templates/footer1');
	}

  public function add_help_master(){
    $this->load->view('templates/header1');
    $this->load->view('templates/menu');
		$this->load->view('help_master/add_help_master');
        $this->load->view('help_master/edit_help_master');
    $this->load->view('templates/footer1');
    $this->load->view('help_master/jscript.php');



}

public function add_data()
{
    $this->load->model('HelpMaster_model');
   
    if (isset($_POST)) {
       
        $Title = $this->db->escape_str($_POST['title']);
        $type = $this->db->escape_str($_POST['type']);
        $status = $this->db->escape_str($_POST['status']);
        $description = isset($_POST['Description']) ? $this->db->escape_str($_POST['Description']) : '';

        $check = $this->HelpMaster_model->getDataByWhereCondition(['title' => $Title]);
        //$check=$this->HelpMaster_model->getDataByWhereCondition(['title'=>$Title, 'id !=' => $id]);
        
        if (!$check) {
            $description = str_replace('\r\n', '', $description);
            $actual_price = $price - ($price * $discount_per / 100);
            
            $data = [
                'title' => $Title,
                'type' => $type,
                'status' => $status,
                'description' => $description
            ];
            
            $insert = $this->HelpMaster_model->save($data);
            if ($insert == 'Inserted') {
                echo "inserted";
                $art_msg['msg'] = 'New Plan Added.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
        } else {
            echo "false";
            die;
            $art_msg['msg'] = 'New Plan already present.';
            $art_msg['type'] = 'error';
        }
    }

    $this->session->set_userdata('alert_msg', $art_msg);
    redirect(base_url() . 'add_help_master', 'refresh');
}

public function update_data()
{
    $this->load->model('HelpMaster_model');
    if(isset($_POST))
    {

        $id = $this->input->post('edit_id');
        $Title=$this->db->escape_str($_POST['title']);
        $type=$this->db->escape_str($_POST['type']);
        $status=$this->db->escape_str($_POST['status']);
        $description=$this->db->escape_str($_POST['Description']);
        $check=$this->HelpMaster_model->getDataByWhereCondition(['title'=>$Title, 'id !=' => $id]);
        if(!$check)
        {
            $description = str_replace('\r\n', '', $description);

            $data = [
                'title'=>$Title,
                'status'=>$status,
                'type'=>$type,
                'description'=>$description
            ];
            $insert=$this->HelpMaster_model->update($id,$data);
            if($insert=='Updated')
            {
                echo "Updated";
                $art_msg['msg'] = 'data updated.';
                $art_msg['type'] = 'success';
            }
            else
            {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
        }
        else
        {
            $art_msg['msg'] = 'New Plan already present.';
            $art_msg['type'] = 'error';
        }
    }
    $this->session->set_userdata('alert_msg', $art_msg);

    redirect(base_url() . 'add_help_master', 'refresh');

}


public function get_help($id){
    $this->load->model('HelpMaster_model');
    if (!$id) {
        echo "No ID specified";
        exit;
    }
    
    $result = $this->HelpMaster_model->getPostById($id);
    
    if ($result) {
        $row=[];
        $row=$result[0];
        $row['created_on']=date("d-m-Y H:i:s",strtotime($result[0]['created_on']));
        echo json_encode($row);
        exit;
    } else {
        echo "Invalid ID";
        exit;
    }
}

	}


