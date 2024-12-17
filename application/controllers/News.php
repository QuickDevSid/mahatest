<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("DocsVideos_model");
        $this->load->model("Exam_Material_model");
        $this->load->model("Courses_model");
        $this->load->model("News_model");
    }

    //functions
    function index()
    {
        $this->load->model("news_model");
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['exams'] = $this->news_model->getExams();
        $this->load->model('news_model');
        $data['category'] = $this->news_model->getAllData(['section' => 'Current Affairs']);
        // print_r($data['category']);die;
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('news/index', $data);
        $this->load->view('news/edit_current_affaires', $data);
        // $this->load->view('news/add_current_affaires', $data);
        // $this->load->view('news/details', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('news/jscript.php', $data);
    }

    public function exam_material_list_new()
    {
        $data['category'] = $this->Exam_Material_model->get_exam_material_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('exam_material/exam_material_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('exam_material/exam_list_script.php', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }
    function fetch_user()
    {
        $this->load->model("news_model");
        $fetch_data = $this->news_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getPostDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#PostDetailModel">
          <i class="material-icons">visibility</i> </button>
           <button type="button" name="Edit" onclick="getPostDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_post" >
           <i class="material-icons">mode_edit</i></button>

           <button type="button" name="Delete" onclick="deleteDetails(this.id)" id="delete_' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
           <i class="material-icons">delete</i></button>
           ';

            $sub_array[] = $row->news_title;
            $sub_array[] = $row->status;
            $sub_array[] = $row->views;
            $sub_array[] = date('d-m-Y H:i:s', strtotime($row->created_on));

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->news_model->get_all_data(), "recordsFiltered" => $this->news_model->get_filtered_data(), "data" => $data);
        echo json_encode($output);
    }

    //API - licenses sends id and on valid id licenses information is sent back editbyId
    function postById($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("news_model");
        $result = $this->news_model->getPostById($id);
        if ($result) {
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
    }

    //API - licenses sends id and on valid id licenses information is sent back editbyId
    function postById_D($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("news_model");
        $result = $this->news_model->getPostById_D($id);
        if ($result) {

            $result[0]['created_on'] = date('d-m-Y H:i:s', strtotime($result[0]['created_on']));
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
    }

    function commentById($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("news_model");
        $result = $this->news_model->getPostComment($id);
        if ($result) {
            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
    }

    function now()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
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
            $newname = 'current_affair' . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/current-affairs/';
            $config['upload_url'] = base_url() . 'AppAPI/current-affairs/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/current-affairs/" . $newname);
            return $newname;
        }
    }

    function upload_setting()
    {
        if (!is_dir('AppAPI/exam-section-setting/')) {
            mkdir('AppAPI/exam-section-setting/', 0777, TRUE);
        }
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = "exam_section_setting" . '_' . time() . "." . $ext;
            $config['upload_path'] = 'AppAPI/exam-section-setting/';
            $config['upload_url'] = base_url() . 'AppAPI/exam-section-setting/';
            $config['allowed_types'] = "jpg|jpeg|png";
            $config['max_size'] = '200000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "AppAPI/exam-section-setting/" . $newname);
            return $newname;
        }
    }
    /**
     * This function is used to add and update users
     * @return Void
     */
    public function addPost()
    {
        //print_r($_POST);die;
        $image = 'placeholder.png';
        $this->load->model("news_model");

        $sequence_no = $this->input->post('sequence_no');
        /*$checkDataExist=$this->news_model->getDataByWhereCondition(['sequence_no'=>$sequence_no]);
        if($checkDataExist){
            $art_msg['msg'] = 'Sequence No. is already used.';
            $art_msg['type'] = 'error';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'current_affairs', 'refresh');
        }*/
        if ($this->input->post('post_image')) {
            $image = $this->input->post('post_image');
        } else {
            $image = 'placeholder.png';
        }

        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
            } else {
                $image = 'placeholder.png';
            }
        }

        $PostTitle = $this->input->post('PostTitle');
        $Description = $this->input->post('Description');
        // $Exam_Id = json_encode($this->input->post('Exam_Id'));
        $Category = $this->input->post('Category');
        $current_date = date("Y-m-d", strtotime($this->input->post('current_date')));
        $Status = "Active";
        $created_on = $this->now();
        $data = array(
            "news_title" => $PostTitle,
            "news_description	" => $Description,
            "status" => $Status,
            // "selected_exams_id" => $Exam_Id,
            "news_image" => $image,
            "created_on" => $current_date,
            "category" => $Category,
            "sequence_no" => $sequence_no

        );

        $this->news_model->add($data);

        $art_msg['msg'] = 'Current Affair Post Added.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'news', 'refresh');
    }


    public function editPost($id = '')

    {
        $image = 'placeholder.png';
        $this->load->model("news_model");

        if ($this->input->post('edit_id')) {
            $id = $this->input->post('edit_id');
        }


        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $image = $newname;
                if (!empty($this->input->post('post_image_old')) && file_exists('AppAPI/current-affairs/' . $this->input->post('post_image_old'))) {
                    unlink('AppAPI/current-affairs/' . $this->input->post('post_image_old'));
                }
            }
        }

        if ($image == "placeholder.png") {
            if ($this->input->post('post_image_old')) {
                $newname = $this->input->post('post_image_old');
                $image = $newname;
            } else {
                $image = 'placeholder.png';
            }
        }



        $PostTitle = $this->input->post('edit_PostTitle');
        $sequence_no = $this->input->post('sequence_no');
        $Description = $this->input->post('edit_Description');
        // $Exam_Id = json_encode($this->input->post('edit_Exam_Id'));
        $Status = $this->input->post('edit_Status');
        $Category = $this->input->post('category');
        $current_date = date("Y-m-d", strtotime($this->input->post('current_date')));

        $data = array(
            "news_title" => $PostTitle,
            "news_description" => $Description,
            "status" => $Status,
            // "selected_exams_id" => $Exam_Id,
            "news_image" => $image,
            "category" => $Category,
            "sequence_no" => $sequence_no
        );

        $this->news_model->update($id, $data);

        $art_msg['msg'] = 'Current Affair Post Updated.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'news', 'refresh');
    }

    public function current_affairs_setting()
    {
        $this->load->model("news_model");
        $data['title'] = ucfirst('All Section Setting'); // Capitalize the first letter
        $data['exams'] = $this->news_model->getExams();
        $this->load->model('news_model');
        $data['category'] = $this->news_model->getAllData(['section' => 'Current Affairs']);
        // print_r($data['category']);die;
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('current_affairs/exam_section_setting', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('current_affairs/setting_jscript.php', $data);
    }

    public function addSettingPost()
    {
        //print_r($_POST);print_r($_FILES);die;
        $image = 'placeholder.png';
        $this->load->model("news_model");



        if ($this->input->post('post_image')) {
            $image = $this->input->post('post_image');
        } else {
            $image = 'placeholder.png';
        }

        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_setting();
                $image = $newname;
            } else {
                $image = 'placeholder.png';
            }
        }

        $title = $this->input->post('title');
        $subtitle = $this->input->post('subtitle');

        $sectionTilte1 = $this->input->post('sectionTilte1');
        $sectionTilte2 = $this->input->post('sectionTilte2');
        $sectionTilte3 = $this->input->post('sectionTilte3');

        $created_on = $this->now();
        $data = array(
            "title" => $title,
            "subtitle" => $subtitle,
            "icon_img" => $image,
            "created_on" => $created_on,
            "section_title_1" => $sectionTilte1,
            "section_title_2" => $sectionTilte2,
            "section_title_3" => $sectionTilte3

        );

        $this->news_model->add($data);

        $art_msg['msg'] = 'Current Affair Post Added.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'news', 'refresh');
    }


    function fetch_setting()
    {
        $this->load->model("news_model");
        $fetch_data = $this->news_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Edit" onclick="getPostDetailsEdit(this.id)" id="edit_' . $row->id  . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit_post" >
           <i class="material-icons">mode_edit</i></button>';

            $sub_array[] = $row->Section;
            $sub_array[] = $row->title;
            $sub_array[] = $row->subtitle;

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->news_model->get_all_data(), "recordsFiltered" => $this->news_model->get_filtered_data(), "data" => $data);
        echo json_encode($output);
    }

    function postById_setting($pid = NULL)
    {
        $id = $pid;
        if (!$id) {
            echo json_encode("No ID specified");
            exit;
        }
        $this->load->model("news_model");
        $result = $this->news_model->getPostById($id);
        if ($result) {
            //$result[0]['subtitle']=explode(',',$result[0]['subtitle']);
            $result[0]['created_on'] = date('d-m-Y H:i:s', strtotime($result[0]['created_on']));

            echo json_encode($result);
            exit;
        } else {
            echo json_encode("Invalid ID");
            exit;
        }
    }


    public function editSettingPost()
    {
        //print_r($_POST);print_r($_FILES);die;

        $this->load->model("news_model");
        /*
        if ($this->input->post('post_image_old')) {
            $image = $this->input->post('post_image_old');
        } else {
            $image = 'placeholder.png';
        }
        
        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload_setting();
                $image = $newname;
            } 
        }*/

        $title = $this->input->post('title');
        $subtitle = $this->input->post('subtitle');
        $sectionTilte1 = $this->input->post('sectionTilte1');
        $sectionTilte2 = $this->input->post('sectionTilte2');
        $sectionTilte3 = $this->input->post('sectionTilte3');
        $sectionTilte4 = $this->input->post('sectionTilte4');
        $sectionTilte5 = $this->input->post('sectionTilte5');
        $section = $this->input->post('section');
        $description = $this->input->post('description');
        $id = $this->input->post('edit_id');

        $created_on = $this->now();
        $data = array(
            "title" => $title,
            "subtitle" => $subtitle,
            "section_title_1" => $sectionTilte1,
            "section_title_2" => $sectionTilte2,
            "section_title_3" => $sectionTilte3,
            "section_title_4" => $sectionTilte4,
            "section_title_5" => $sectionTilte5,
            "Description" => $description

        );


        if (!empty($_FILES['post_image']['name'])) {
            $path = 'AppAPI/exam-section-setting/';
            $images = upload_file('post_image', $path);
            if (empty($images['error'])) {
                $data['icon_img'] = $images;
            }
        }


        $this->news_model->update($id, $data);

        $art_msg['msg'] = 'Section Setting Updated.';
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'current_affairs_setting', 'refresh');
    }

    public function deleteSettingPost()
    {
        $id = $this->delete('id');
        if (!$id) {
            $this->response("Parameter missing", 404);
        }
        $this->load->model('news_model');
        $result = $this->news_model->getPostById($id);
        if ($this->news_model->delete($id)) {
            if (!empty($result[0]['icon_img']) && file_exists('AppAPI/exam-section-setting/' . $result[0]['icon_img'])) {
                unlink('AppAPI/exam-section-setting/' . $result[0]['icon_img']);
            }
            $this->response("Success", 200);
        } else {
            $this->response("Failed", 400);
        }
    }


    public function add_news_category_form()
    {
        $this->load->model("news_model");
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['single'] = $this->news_model->get_single_news_category($this->uri->segment(2));
        // echo 'hiii'; print_r($data['single']);  exit;
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('news/add_news_category', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('news/jscript.php', $data);
    }
    public function news_category()
    {
        $this->load->model("news_model");
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['category'] = $this->news_model->get_news_category();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('news/new_category', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('news/jscript.php', $data);
    }
    public function delete_news_category()
    {
        $this->load->model("news_model");
        $insert = $this->news_model->delete_news_category($this->uri->segment(2));
        redirect('news_category');
    }

    public function add_news()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->News_model->get_single_news(); //
            $this->load->view('news/add_news', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            // $this->load->view('courses/jscript.php', $data);
            $this->load->view('news/newscript.php', $data);
            $this->session->set_flashdata("error", "Error updating News.");
        } else {
            $upload_image = $this->input->post('current_image');

            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $config = array(
                    'upload_path'   => "assets/uploads/news/images",
                    'allowed_types' => "jpg|jpeg|png|gif",
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($config);
                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $upload_image = $data['file_name'];
                } else {
                    $error_message = $this->upload->display_errors();
                    $this->session->set_flashdata("error", $error_message);
                    echo $error_message;
                    exit;
                    redirect('news/news_list');
                    return;
                }
            }

            $res = $this->News_model->set_news_details($upload_image);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "News details added successfully!");
                // echo "inserted";
                // exit;
                redirect('news/news_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "News entry updated!");
                // echo "updated";
                // exit;
                redirect('news/news_list');
            } else {
                $this->session->set_flashdata("error", "Error updating News.");
                redirect('news/news_list');
            }
        }
    }

    public function news_list()
    {
        $data['category'] = $this->News_model->get_single_news_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('news/news_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('news/news_list_script.php', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }

    public function delete_news_list($id)
    {
        $this->News_model->delete_news_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('news/news_list');
    }

    public function add_news_categorys()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->News_model->get_single_news_category(); //
            $this->load->view('news/add_news_categorys', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('news/newscatscript.php', $data);
            $this->session->set_flashdata("error", "Error updating News.");
        } else {

            $upload_image = $this->input->post('current_image');

            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $config = array(
                    'upload_path'   => "assets/uploads/news/images",
                    'allowed_types' => "jpg|jpeg|png|gif",
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($config);
                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $upload_image = $data['file_name'];
                } else {
                    $error_message = $this->upload->display_errors();
                    $this->session->set_flashdata("error", $error_message);
                    echo $error_message;
                    exit;
                    redirect('news/news_list');
                    return;
                }
            }

            $res = $this->News_model->set_news_cat_details($upload_image);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "News Category details added successfully!");
                // echo "inserted";
                // exit;
                redirect('news/news_cat_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "News Category entry updated!");
                // echo "updated";
                // exit;
                redirect('news/news_cat_list');
            } else {
                $this->session->set_flashdata("error", "Error updating News Category.");
                redirect('news/news_cat_list');
            }
        }
    }

    public function news_cat_list()
    {
        $data['category'] = $this->News_model->get_single_news_cat_list();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('news/news_cat_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('news/news_category_list_script.php', $data);
        // $this->load->view('courses/newjscript.php', $data);
    }

    public function delete_news_categorys_list($id)
    {
        $this->News_model->delete_news_categorys_list($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('news/news_cat_list');
    }
}
