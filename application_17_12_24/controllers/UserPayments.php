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

class UserPayments extends CI_Controller
{
    //functions
    function __construct()
    {
        parent::__construct();
        $this->load->model("common_model"); //custome data insert, update, delete library
    }

    function index()
    {
        $data['title'] = ucfirst('All Feedback'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('UserPayments/index', $data);
        $this->load->view('UserPayments/add',$data);
        $this->load->view('UserPayments/show_payment', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('UserPayments/jscript', $data);
    }

    function fetch_user()
   {
       $data = array();
       $sql="SELECT user_purchased_records.*, user_login.full_name as full_name, user_login.email as email, user_login.selected_exams as selected_exams, user_login.mobile_number as mobile_number, test_series.test_title as test_title FROM user_purchased_records, user_login, test_series WHERE user_purchased_records.login_id = user_login.login_id AND user_purchased_records.purchased_item_id = test_series.test_series  ORDER BY user_purchased_records.id DESC";
       $fetch_data = $this->common_model->executeArray($sql);
       if($fetch_data)
       {
           // print_r($fetch_data);
           foreach($fetch_data as $subject)
           {
               /////////////////////////////////////////////////////////
               if(1)
               {
                   $sub_array = array();
                   if(1)
                   {
                    
                       $sub_array[] = '
                       <button type="button" name="Details" onclick="getDetails(this.id)" id="details_' . $subject->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#showdought">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $subject->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          
';
                    
                       $sub_array[] = $subject->full_name;
                       $sub_array[] = $subject->email;
                       $sub_array[] = $subject->selected_exams;
                       $sub_array[] = $subject->payment_gateway_date;
                       $sub_array[] = $subject->payment_gateway_amount;
                       $sub_array[] = $subject->test_title;
                   }
                   $data[] = $sub_array;
               }
            
               /////////////////////////////////////////////////////////
           }
       }
       
       $output = array("recordsTotal" => $data, "recordsFiltered" => $data, "data" => $data);
       echo json_encode($output);
   }

  
    function feedbackById($pid = NULL)
    {
        $return_array=array();
        if($pid!="")
        {
            $sql="SELECT user_purchased_records.*, user_login.full_name as full_name, user_login.email as email, user_login.selected_exams as selected_exams, user_login.mobile_number as mobile_number, test_series.test_title as test_series_title FROM user_purchased_records, user_login, test_series WHERE user_purchased_records.login_id = user_login.login_id AND user_purchased_records.purchased_item_id = test_series.test_series  AND user_purchased_records.id = '". $pid . "'ORDER BY user_purchased_records.id DESC";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $return_array=array("id"=>$check->id, "full_name"=>$check->full_name, "email"=>$check->email, "selected_exams"=>$check->selected_exams, "purchased_item_id"=>$check->purchased_item_id, "purchased_item_type"=>$check->purchased_item_type, "users_exam_group"=>$check->users_exam_group, "payment_gateway"=>$check->payment_gateway, "payment_gateway_date"=>$check->payment_gateway_date, "payment_gateway_status"=>$check->payment_gateway_status, "payment_gateway_method"=>$check->payment_gateway_method, "payment_gateway_id"=>$check->payment_gateway_id, "payment_gateway_amount"=>$check->payment_gateway_amount, "payment_gateway_currency"=>$check->payment_gateway_currency, "payment_gateway_charges"=>$check->payment_gateway_charges, "payment_gateway_order_id"=>$check->payment_gateway_order_id, "payment_gateway_order_description"=>$check->payment_gateway_order_description, "test_series_title"=>$check->test_series_title, "mobile_number"=>$check->mobile_number);

            }
        }
        else
        {
        
        }
        echo json_encode($return_array);
    }
    
    
    public function deleteFeedback($id)
    {
        
            $id=$id;
            $sql="SELECT * FROM user_purchased_records WHERE id='".$id."' ";
            $check=$this->common_model->executeRow($sql);
            if($check)
            {
                $sql="DELETE FROM user_purchased_records WHERE id='".$id."'";
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



    public function add_data()
    {
        $user_id= $this->db->escape_str($_POST['user_id']);
        $a_test_series= $this->db->escape_str($_POST['a_test_series']);
        $payment_method= $this->db->escape_str($_POST['payment_method']);
        $payment_date= $this->db->escape_str($_POST['payment_date']);
        $payment_status= $this->db->escape_str($_POST['payment_status']);
        $Amount= $this->db->escape_str($_POST['Amount']);
        $PaymentId=$this->db->escape_str($_POST['PaymentId']);
        $OrderId= $this->db->escape_str($_POST['OrderId']);
        $Currency= $this->db->escape_str($_POST['Currency']);
        $PaymentCharges= $this->db->escape_str($_POST['PaymentCharges']);
        $description= $this->db->escape_str($_POST['description']);
        $purchased_item_type= "Test Series";

        $sql="SELECT * FROM user_login WHERE login_id ='".$user_id."' ";
        $exam=$this->common_model->executeRow($sql);
        $users_exam_group= $exam->selected_exams_id;

        $sql="SELECT * FROM user_purchased_records WHERE login_id='".$user_id."' AND purchased_item_id='".$a_test_series."' AND purchased_item_type='".$purchased_item_type."' ";
        $check=$this->common_model->executeRow($sql);
        if($check)
        {
            $art_msg['msg'] = 'This user already have same item purchased.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        else
        {
            $sql="INSERT INTO `user_purchased_records`(`login_id`, `purchased_item_id`, `purchased_item_type`, `users_exam_group`, `payment_gateway`, `payment_gateway_date`, `payment_gateway_status`, `payment_gateway_method`, `payment_gateway_id`, `payment_gateway_amount`, `payment_gateway_currency`, `payment_gateway_charges`, `payment_gateway_order_id`, `payment_gateway_order_description`) VALUES ('".$user_id."', '".$a_test_series."', '".$purchased_item_type."', '".$users_exam_group."', '".$payment_method."', '".$payment_date."', '".$payment_status."', '".$payment_method."', '".$PaymentId."', '".$Amount."', '".$Currency."', '".$PaymentCharges."', '".$OrderId."', '".$description."')";
            $update=$this->common_model->executeNonQuery($sql);
            if($update)
            {
                $art_msg['msg'] = 'Students Payment Entry Added.';
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
            else
            {
                $art_msg['msg'] = 'Error to Adding Payment Entry.';
                $art_msg['type'] = 'error';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        }
        redirect(base_url() . 'UserPayments', 'refresh');
    }
}
