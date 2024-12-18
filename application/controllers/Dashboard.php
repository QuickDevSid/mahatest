<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Dashboard extends CI_Controller
{

    public function __Construct()
    {
        parent::__Construct();
    }
//Home Page
    public function view($page = 'home')
    {
        if (!file_exists(APPPATH . 'views/dashboard/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('dashboard/' . $page, $data);
        $this->load->view('templates/footer', $data);
        $this->load->view('dashboard/home_js', $data);
    }

    function fetch_user()
    {
        $this->load->model("Dashboard_model");
        $fetch_data = $this->Dashboard_model->make_datatables();
        $data = array();
        $serial_number = 1;
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $serial_number++;
            $sub_array[] = $row->Name;
            $sub_array[] = $row->EmailID;
            $sub_array[] = $row->Gender;
            $sub_array[] = $row->user_Status;
            $sub_array[] = date('d-m-Y h:i A',strtotime($row->Added_On));
            // $sub_array[] = $row->Selected_Exams;
            $data[] = $sub_array;
        }
        $output = array(
            "recordsTotal" => $this->Dashboard_model->get_all_data(),
            "recordsFiltered" => $this->Dashboard_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    function chart_data()
    {
        $this->load->model("Dashboard_model");
        $fetch_data = $this->Dashboard_model->make_donutchart();
        $data = array();

        $i = 0;
        foreach ($fetch_data as $row) {
            $data[$i]['label'] = $row->Label;
            $data[$i]['value'] = $row->Value;
            $i++;
        }

        echo json_encode($data);
    }
    
    
    function statistic_data()
    {
        $this->load->model("Dashboard_model");
        $fetch_data1 = $this->Dashboard_model->make_statistic1();
        $fetch_data2 = $this->Dashboard_model->make_statistic2();
        $fetch_data3 = $this->Dashboard_model->make_statistic3();
        $fetch_data4 = $this->Dashboard_model->make_statistic4();

        $data = array();

        foreach ($fetch_data1 as $row) {
            $data['Users'] = $row->Users;
        }
        foreach ($fetch_data2 as $row) {
            $data['admin_users'] = $row->admin_users;
        }
        foreach ($fetch_data3 as $row) {
            $data['active_members'] = $row->active_members;
        }
        foreach ($fetch_data4 as $row) {
            $data['total_tests'] = $row->tests;
        }
        echo json_encode($data);
    }

    public function getAppSettings(){
        $this->load->model("AppSettings_model");
        $result = $this->AppSettings_model->getAllData();

        if ($result) {
            echo json_encode($result);
            exit;
        } else {
            echo "Invalid ID";
            exit;
        }
    }


    public function editSettingPost()
    {
        $this->load->model("AppSettings_model");
        if (isset($_POST)) {
            $app_footer_info = $this->db->escape_str($_POST['app_footer_info']);
            $setting_membership_title = $this->db->escape_str($_POST['setting_membership_title']);
            $setting_membership_subtitle = $this->db->escape_str($_POST['setting_membership_subtitle']);
            $setting_membership_description = $this->db->escape_str($_POST['setting_membership_description']);
            $setting_membership_image = $this->db->escape_str($_POST['setting_membership_image']);

            $setting_membership_description = str_replace('\r\n', '', $setting_membership_description);

            if (!empty($_FILES['setting_membership_image_new']['name'])) {
                $path = 'AppAPI/banner-images';
                $images = upload_file('setting_membership_image_new', $path);
                if (empty($images['error'])) {
                    $setting_membership_image = $images;
                }
            }

            $data['key_value'] = $app_footer_info;
            $this->AppSettings_model->update('app_footer_info',$data);

            $data['key_value'] = $setting_membership_title;
            $this->AppSettings_model->update('setting_membership_title',$data);

            $data['key_value'] = $setting_membership_subtitle;
            $this->AppSettings_model->update('setting_membership_subtitle',$data);

            $data['key_value'] = $setting_membership_description;
            $this->AppSettings_model->update('setting_membership_description',$data);

            $data['key_value'] = $setting_membership_image;
            $insert = $this->AppSettings_model->update('setting_membership_image',$data);

            if ($insert == "Updated") {
                $art_msg['msg'] = 'App Setting updated.';
                $art_msg['type'] = 'success';
                echo "Success";
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
                echo "Operation failed.";
            }

        }
        $this->session->set_userdata('alert_msg', $art_msg);

    }
}
