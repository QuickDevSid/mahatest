<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_subsubject extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    //functions
    function index()
    {
        $data=[];
        $this->load->model("Exam_subject_model");
        $fetch_data = $this->Exam_subject_model->make_datatables();
        $data['exam_subject_arr']=$fetch_data;
        $data['title'] = ucfirst('Exam Sub Subject'); // Capitalize the first letter

        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('exam_subsubject/index', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_subsubject/jscript.php', $data);
        
    }

    function fetch_data()
    {

        $this->load->model("Exam_subsubject_model");
        $fetch_data = $this->Exam_subsubject_model->make_datatables();
        //print_r($fetch_data);die;
        $data = array();
        if($fetch_data)
        {
            // print_r($fetch_data);
            foreach($fetch_data as $subject)
            {
                /////////////////////////////////////////////////////////
                $sub_array = array();
                $sub_array[] = '
                    <button type="button" name="Edit" onclick="getDetailsEdit(this.id)" id="edit_' . $subject->id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
                    <i class="material-icons">mode_edit</i></button>

                    <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $subject->id  . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
                    <i class="material-icons">delete</i></button>
                    ';

                $sub_array[] = $subject->subject_name;
                $sub_array[] = $subject->title;
                // $sub_array[] = $List;
                $sub_array[] = $subject->status;     
                $data[] = $sub_array;

                /////////////////////////////////////////////////////////
            }
        }        


        $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
        echo json_encode($output);          
    }
    public function add_data()
    {
        $art_msg=[];
        if(isset($_POST))
        {
            //print_r($_POST);die;
            $Title=$this->db->escape_str($_POST['Title']);
            $description=$this->db->escape_str($_POST['description']);
            $subject_id=$_POST['subject_id'];
            $status=$_POST['status'];
            $this->load->model("Exam_subsubject_model");
            


            $check=$this->Exam_subsubject_model->getDataByWhereCondition(['title'=>$Title,'subject_id'=>$subject_id]);
            //print_r($check);die;
            if(!$check)
            {
                
                $insert=$this->Exam_subsubject_model->save(['title'=>$Title,'subject_id'=>$subject_id,'status'=>$status,'created_at'=>date('Y-m-d H:i:s'),'description'=>$description]);
                //print_r($insert);die;
                if($insert=='Inserted')
                {
                    $art_msg['msg'] = 'New subjects updated.';
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
                $art_msg['msg'] = 'New subject already present.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subsubject', 'refresh');

    }
    public function subSubjectById($id="")
    {
        $return_array=array();
        if($id!="")
        {
            $this->load->model("Exam_subsubject_model");
            $check=$this->Exam_subsubject_model->getDataById($id);
            if($check)
            {
                $return_array=array("id"=>$check['id'],"subject_id"=>$check['subject_id'], "title"=>$check['title'], "status"=>$check['status'],'description'=>$check['description']);
            }
        }
        
        echo json_encode($return_array);
    }

    public function update_data()
    {
        $Title=$this->db->escape_str($_POST['Title']);
        $description=$this->db->escape_str($_POST['description']);
        $status=$_POST['status'];
        $subject_id=$_POST['subject_id'];
        $edit_id=$_POST['edit_id'];

        $this->load->model("Exam_subsubject_model");
       
        $update=$this->Exam_subsubject_model->update($edit_id,['subject_id'=>$subject_id,'title'=>$Title,'status'=>$status,'description'=>$description]);
        if($update=='Updated')
        {
            $art_msg['msg'] = 'Subjects Updated.';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }
        else
        {
            $art_msg['msg'] = 'Error to update subjects.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);            
        }

        redirect(base_url() . 'Exam_subsubject', 'refresh');
    }
    function deleteSubSubject()
    {
        if($_REQUEST['id'])
        {
            $id=$_REQUEST['id'];
            $this->load->model("Exam_subsubject_model");
            $delete=$this->Exam_subsubject_model->delete($id);
            if($delete)
            {
                echo 'success';
            }
            else
            {
                echo 'error';
            }        

        }
        
    }


}