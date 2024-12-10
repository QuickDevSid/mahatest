<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Yashogatha extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data['title'] = ucfirst('Masik'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('yashogatha/index', $data);
        $this->load->view('yashogatha/add',$data);
        $this->load->view('yashogatha/edit',$data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('yashogatha/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $sql="SELECT * FROM yashogatha ORDER BY yashogatha_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            foreach($fetch_data as $yashogatha)
            {
                /////////////////////////////////////////////////////////
                if(1)
                {
                    $sub_array = array();
                    if(1)
                    {
                   
                        $sub_array[] = '
                       <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $yashogatha->yashogatha_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                       <i class="material-icons">mode_edit</i></button>

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $yashogatha->yashogatha_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>
                       ';

                        $sub_array[] = $yashogatha->category;
                        if($yashogatha->yashogatha_image!="")
                        {
                            $sub_array[] = '<a href="'.base_url().'/AppAPI/yashogatha/'.$yashogatha->yashogatha_image.'" target="_blank"><img src="'.base_url().'/AppAPI/yashogatha/'.$yashogatha->yashogatha_image.'" style="height:30px;"></a>';
                        }
                        else
                        {
                            $sub_array[] = '';
                        }
                        $sub_array[] = $yashogatha->yashogatha_title;
                        $sub_array[] = $yashogatha->status;
                        $sub_array[] = $yashogatha->created_at;
                   }            
                    $data[] = $sub_array;
                }

                /////////////////////////////////////////////////////////
            }
        }        


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);          
    }

    function upload()
    {

        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/yashogatha';
            $config['upload_url'] = base_url() . 'AppAPI/yashogatha';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/yashogatha/" . $newname);
            return $newname;
        }
    }

    function add_data()
    {
        if(isset($_POST))
        {
            $Title=$this->db->escape_str($_POST['Title']);
            $Category=$this->db->escape_str($_POST['Category']);
            $Description=$this->db->escape_str($_POST['Description']);
            $name='image';
            if (!empty($_FILES[$name]['name']))
            {
                $newname = $this->upload();
                $image = $newname;
            }
            else
            {
                $image = 'yashogatha-1.jpg';
            }

            $status=$_POST['status'];

            $sql="SELECT * FROM `yashogatha` WHERE category='".$Category."' AND yashogatha_title = '".$Title."' ";
            // echo $sql;
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `yashogatha`(`category`, `yashogatha_title`, `yashogatha_image`,`yashogatha_description`,`status`, `created_at`) VALUES ('".$Category."', '".$Title."' ,'".$image."', '".$Description."','".$status."', '".date('Y-m-d H:i:s')."')";
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New yashogatha updated.';
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
                $art_msg['msg'] = 'Yashogatha already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Yashogatha', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM yashogatha WHERE yashogatha_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->yashogatha_id, "category"=>$check->category, "title"=>$check->yashogatha_title,"description"=>$check->yashogatha_description, "status"=>$check->status);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    public function update_data()
    {
            $id=$this->db->escape_str($_POST['edit_id']);
            $Title=$this->db->escape_str($_POST['Title']);
            $Category=$this->db->escape_str($_POST['Category']);
            $Description=$this->db->escape_str($_POST['Description']);
            $name='image';
            if (!empty($_FILES[$name]['name']))
            {
                $newname = $this->upload();
                $image = $newname;
            }
            else
            {
                $image = '';
            }

            $status=$_POST['status'];

            $sql="SELECT * FROM yashogatha WHERE yashogatha_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                if($image=="")
                {
                    $image=$check->yashogatha_image;
                }
                $sql="UPDATE yashogatha SET `category`='".$Category."', `yashogatha_title`='".$Title."', `yashogatha_image`='".$image."',`yashogatha_description`='".$Description."', `status`='".$status."' WHERE yashogatha_id='".$id."' ";
                // echo $sql;
                $update=$this->common_model->executeNonQuery($sql);
                if($update)
                {
                    $art_msg['msg'] = 'Yashogatha Updated.';
                    $art_msg['type'] = 'success';
                    $this->session->set_userdata('alert_msg', $art_msg);            
                }
                else
                {
                    $art_msg['msg'] = 'Error to update yashogatha.';
                    $art_msg['type'] = 'error';
                    $this->session->set_userdata('alert_msg', $art_msg);            
                }
            }
            else
            {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);            

            }

        redirect(base_url() . 'Yashogatha', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM yashogatha WHERE yashogatha_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM yashogatha WHERE yashogatha_id='".$id."'";
                $delete=$this->common_model->executeNonQuery($sql);
                if($delete)
                {
                    echo 'success';
                }
                else
                {
                    echo 'error';
                }
            }
            else
            {
                echo 'error';
            }            

        }
        
    }
}
?>