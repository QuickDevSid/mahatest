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

class Pariksha_paddhati_abhyaskram extends CI_Controller
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
        $this->load->view('pariksha_paddhati_abhyaskram/index', $data);
        $this->load->view('pariksha_paddhati_abhyaskram/pariksha_paddhati_abhyaskram_add',$data);
        $this->load->view('pariksha_paddhati_abhyaskram/pariksha_paddhati_abhyaskram_edit',$data);

        $this->load->view('pariksha_paddhati_abhyaskram/cutoff',$data);
        $this->load->view('pariksha_paddhati_abhyaskram/syllabus',$data);
        $this->load->view('pariksha_paddhati_abhyaskram/wattage',$data);

        $this->load->view('templates/footer1', $data);
        $this->load->view('pariksha_paddhati_abhyaskram/jscript.php', $data);

        
    }

    function fetch_data()
    {

        $sql="SELECT * FROM pariksha_paddhati_abhyaskram ORDER BY pariksha_paddhati_abhyaskram_id DESC";
        $fetch_data = $this->common_model->executeArray($sql);
        if($fetch_data)
        {
            // print_r($fetch_data);
            foreach($fetch_data as $pariksha_paddhati_abhyaskram)
            {
                /////////////////////////////////////////////////////////
                if(1)
                {

                    $array=json_decode($pariksha_paddhati_abhyaskram->selected_exam_id);
                    if (is_array($array))
                    {
                    }
                    else
                    {
                        $array=array();
                        array_push($array, $pariksha_paddhati_abhyaskram->selected_exam_id);                
                    }            
                    $exam_name=array();
                    for($i=0; $i<sizeof($array);$i++)
                    {
                       $sql="SELECT * FROM exams WHERE exam_id='".$array[$i]."' ";
                       $exam=$this->common_model->executeRow($sql);  
                       $exam_name[]=$exam->exam_name;              
                    }
                    $List = implode(', ', $exam_name);                    
                    $sub_array = array();
                    if(1)
                    {
                   
                        $sub_array[] = '

                       <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $pariksha_paddhati_abhyaskram->pariksha_paddhati_abhyaskram_id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                       <i class="material-icons">delete</i></button>


                       <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $pariksha_paddhati_abhyaskram->pariksha_paddhati_abhyaskram_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_post" >
                       <i class="material-icons">mode_edit</i></button>


                       <button type="button" name="wattage" onclick="getWattage(this.id)" id="wattage_' . $pariksha_paddhati_abhyaskram->pariksha_paddhati_abhyaskram_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#wattage_model" >
                       Details</button>                       

                       <button type="button" name="syllabus" onclick="getSyllabus(this.id)" id="syllabus_' . $pariksha_paddhati_abhyaskram->pariksha_paddhati_abhyaskram_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#syllabus_model" >
                       Syllabus</button>                       

                       <button type="button" name="cutoff" onclick="getCutOff(this.id)" id="cutoff_' . $pariksha_paddhati_abhyaskram->pariksha_paddhati_abhyaskram_id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#cutoff_model" >
                       CutOff</button>                       


                       ';

                        $sub_array[] = $pariksha_paddhati_abhyaskram->title;
                        $sub_array[] = $List;
                        $sub_array[] = $pariksha_paddhati_abhyaskram->status;
                        $sub_array[] = $pariksha_paddhati_abhyaskram->created_at;
                   }            
                    $data[] = $sub_array;
                }

                /////////////////////////////////////////////////////////
            }
        }        


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);          
    }
    public function add_data()
    {
        if(isset($_POST))
        {
            $ParikshapaddhatiabhyaskramTitle=$this->db->escape_str($_POST['ParikshapaddhatiabhyaskramTitle']);
            $Exam_Id=$_POST['Exam_Id'];
            $Exam_Id=json_encode($Exam_Id);

            $Parikshapaddhatiabhyaskram_status=$_POST['Parikshapaddhatiabhyaskram_status'];

            $sql="SELECT * FROM `pariksha_paddhati_abhyaskram` WHERE title = '".$ParikshapaddhatiabhyaskramTitle."' ";
            // echo $sql;
            $check=$this->common_model->executeRow($sql);
            if(!$check)
            {
                $sql="INSERT INTO `pariksha_paddhati_abhyaskram`(`selected_exam_id`, `title`, `status`, `created_at`) VALUES ('".$Exam_Id."', '".$ParikshapaddhatiabhyaskramTitle."', '".$Parikshapaddhatiabhyaskram_status."', '".date('Y-m-d H:i:s')."')";
                $insert=$this->common_model->executeNonQuery($sql);
                if($insert)
                {
                    $art_msg['msg'] = 'New Pariksha paddhati abhyaskram updated.';
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
                $art_msg['msg'] = 'New pariksha paddhati abhyaskram already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Pariksha_paddhati_abhyaskram', 'refresh');

    }
    public function CategoryById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $sql="SELECT * FROM pariksha_paddhati_abhyaskram WHERE pariksha_paddhati_abhyaskram_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->pariksha_paddhati_abhyaskram_id, "selected_exams_id"=>json_decode($check->selected_exam_id), "title"=>$check->title, "status"=>$check->status);
            }
        }
        else
        {

        }
        echo json_encode($return_array);
    }

    public function update_data()
    {
        $Pariksha_paddhati_abhyaskramTitle=$this->db->escape_str($_POST['Pariksha_paddhati_abhyaskramTitle']);
        $Edit_Exam_Id=$_POST['Edit_Exam_Id'];
        $Edit_Exam_Id=json_encode($Edit_Exam_Id);

        $Pariksha_paddhati_abhyaskramStatus=$_POST['Pariksha_paddhati_abhyaskramStatus'];
        $edit_id=$_POST['edit_id'];


        $sql="UPDATE pariksha_paddhati_abhyaskram SET `selected_exam_id`='".$Edit_Exam_Id."', `title`='".$Pariksha_paddhati_abhyaskramTitle."', `status`='".$Pariksha_paddhati_abhyaskramStatus."' WHERE pariksha_paddhati_abhyaskram_id='".$edit_id."' ";
        // echo $sql;
        // exit(0);
        $update=$this->common_model->executeNonQuery($sql);



        if($update)
        {
            $art_msg['msg'] = 'Pariksha paddhati abhyaskram Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }
        else
        {
            $art_msg['msg'] = 'Error to update pariksha paddhati abhyaskram.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }

        redirect(base_url() . 'Pariksha_paddhati_abhyaskram', 'refresh');
    }
    function deleteCategory()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
           $sql="SELECT * FROM pariksha_paddhati_abhyaskram WHERE pariksha_paddhati_abhyaskram_id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM pariksha_paddhati_abhyaskram WHERE pariksha_paddhati_abhyaskram_id='".$id."'";
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