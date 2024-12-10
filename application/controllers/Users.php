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

class Users extends CI_Controller
{
    //functions

    public function __Construct()
    {
        parent::__Construct();
    }

    function index()
    {
        if ($this->session->userdata('role') != 'Super Admin') {
            redirect(base_url());
        }

        $data['title'] = ucfirst('Manage Users'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('users/index', $data);
        $this->load->view('users/user_add', $data);
        $this->load->view('users/edit_user', $data);
        $this->load->view('users/user_detail', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('users/jscript.php', $data);
    }

    function is_login()
    {
        if ($this->session->userdata('user_id') != '') {
            return true;
        } else {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    function profile($id = '')
    {
        $this->is_login();
        if (!isset($id) || $id == '') {
            $id = $this->session->userdata('user_id');
        }

        $this->load->model("Users_model");
        $data['user_data'] = $this->Users_model->getuserbyid($id);

        $data['title'] = ucfirst('User Profile'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('users/profile', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('users/jscript.php', $data);
    }

    /**
     * This function is used to upload file
     * @return Void
     */
    function upload()
    {
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = $exp[0] . '_' . time() . "." . $ext;
            $config['upload_path'] = 'assets/images/';
            $config['upload_url'] = base_url() . 'assets/images/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "assets/images/" . $newname);
            return $newname;
        }
    }

    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add_edit($id = '')
    {
        $data = $this->input->post();
        $profile_pic = 'user.png';
        $this->load->model("Users_model");

        if ($this->input->post('users_id')) {
            $id = $this->input->post('users_id');
        }

        if ($this->input->post('fileOld')) {
            $newname = $this->input->post('fileOld');
            $profile_pic = $newname;
        } else {
            $profile_pic = 'user.png';
        }

        foreach ($_FILES as $name => $fileInfo) {
        if (!empty($_FILES[$name]['name'])) {
            $newname = $this->upload();
            $data[$name] = $newname;
            $profile_pic = $newname;
        } else {
            if ($this->input->post('fileOld')) {
                $newname = $this->input->post('fileOld');
                $data[$name] = $newname;
                $profile_pic = $newname;
            } else {
                $data[$name] = '';
                $profile_pic = 'user.png';
            }
        }
    }

        if ($id != '') {
            $data = $this->input->post();
            if ($this->input->post('password') != '') {
                if ($this->input->post('currentpassword') != '') {
                    $old_row = $this->Users_model->getDataByid('users', $this->input->post('users_id'), 'id');

                    if ($this->input->post('currentpassword') == $old_row->password) {
                        if ($this->input->post('password') == $this->input->post('confirmPassword')) {
                            $password = $this->input->post('password');
                            $data['password'] = $password;

                        } else {
                            $art_msg['msg'] = 'Password and confirm password should be same';
                            $art_msg['type'] = 'warning';
                            $this->session->set_userdata('alert_msg', $art_msg);
                            redirect(base_url() . 'users/profile', 'refresh');
                        }
                    } else {
                        $art_msg['msg'] = 'enter valid current password';
                        $art_msg['type'] = 'warning';
                        $this->session->set_userdata('alert_msg', $art_msg);
                        redirect(base_url() . 'users/profile', 'refresh');
                    }
                } else {
                    $art_msg['msg'] = lang('current password is required');
                    $art_msg['type'] = 'warning';
                    $this->session->set_userdata('alert_msg', $art_msg);
                    redirect(base_url() . 'users/profile', 'refresh');
                }
            }

            $id = $this->input->post('users_id');
            unset($data['fileOld']);
            unset($data['currentpassword']);
            unset($data['confirmPassword']);
            unset($data['users_id']);
            unset($data['users_type']);

            if (isset($data['password']) && $data['password'] == '') {
                unset($data['password']);
            }

            $data['profile_pic'] = $profile_pic;

            foreach ($data as $dkey => $dvalue) {
                if (is_array($dvalue)) {
                    $data[$dkey] = implode(',', $dvalue);
                }
            }

            $this->Users_model->updateRow('users', 'id', $id, $data);

            $art_msg['msg'] = 'your data updated successfully';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'users/profile', 'refresh');
        }

    }


    function fetch_user()
    {
        $this->load->model("Users_model");
        $fetch_data = $this->Users_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = $row->type;
            $sub_array[] = $row->status;
            $sub_array[] = '<button type="button" name="Edit" onclick="getFormDetails(this.id)" id="user_' . $row->id . '" class="btn bg-blue waves-effect btn-xs" data-toggle="modal" data-target="#editUser">
           <i class="material-icons">settings</i></button>
       		<button type="button" name="Delete" onclick="deleteUserDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
           <i class="material-icons">delete</i></button>
       		<button type="button" name="View" id="view_' . $row->id . '" onclick="viewUserDetails(this.id)" class="btn bg-indigo waves-effect btn-xs" data-toggle="modal" data-target="#viewUser">
       		<i class="material-icons">dns</i></button>';
            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->Users_model->get_all_data(), "recordsFiltered" => $this->Users_model->get_filtered_data(), "data" => $data);
        echo json_encode($output);
    }
}
