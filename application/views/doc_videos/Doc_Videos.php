<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Doc_Videos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("DocsVideos_model");
        $this->load->model("Courses_model");
    }

    //functions

    public function documents()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/document', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }

    public function texts()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/texts', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }

    public function videos()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/videos', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }
    public function add_test()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/add_test', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }
    public function tests()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $data['tests'] = $this->DocsVideos_model->get_docs_videos_tests();
        // echo '<pre>'; print_r($data['tests']); exit();
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('doc_videos/tests', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('doc_videos/jscript.php', $data);
    }
    
    public function add_docs_videos_tests()
    {
        if(isset($_POST))
        {
            $this->form_validation->set_rules('test_id[]', 'Test', 'required');
            if ($this->form_validation->run() === FALSE) {
                echo validation_errors();
                return false;
            }

            $insert=$this->DocsVideos_model->save_docs_videos_tests();
            redirect('doc_videos/tests');
        }
    }
    public function delete_test()
    {
        $insert=$this->DocsVideos_model->delete_docs_videos_test($this->uri->segment(3));
        redirect('doc_videos/tests');
    }  

    public function add_doc_data()
    {
        if (isset($_POST)) {

            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);

            $description = str_replace('\r\n', '', $description);
            $image = "";
            $pdf = "";
            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/docs/images';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $image = $images;
                }
            }

            if (!empty($_FILES['pdf']['name'])) {
                $path = 'AppAPI/docs_videos/docs/pdfs';
                $pdfs = upload_file('pdf', $path, 'pdf');
                if (empty($pdfs['error'])) {
                    $pdf = $pdfs;
                }
            }

                $data = [
                    'title' => $title,
                    'type' => 'Docs',
                    'source_type' => $source_type,
                    'description' => $description,
                    'status' => $status,
                    'can_download' => $can_download,
                    'image_url' => $image,
                    'pdf_url' => $pdf
                ];
                $insert = $this->DocsVideos_model->save($data);
                if ($insert == 'Inserted') {
                    echo "Inserted";
                    $art_msg['msg'] = 'New Document added.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }

        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subject', 'refresh');

    }

    public function update_doc_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);

            $description = str_replace('\r\n', '', $description);
                $data = [
                    'title' => $title,
                    'type' => 'Docs',
                    'source_type' => $source_type,
                    'description' => $description,
                    'status' => $status,
                    'can_download' => $can_download
                ];

                if (!empty($_FILES['image']['name'])) {
                    $path = 'AppAPI/docs_videos/docs/images';
                    $images = upload_file('image', $path);
                    if (empty($images['error'])) {
                        $data['image_url'] =  $images;
                    }
                }
                if (!empty($_FILES['pdf']['name'])) {
                    $path = 'AppAPI/docs_videos/docs/pdfs';
                    $pdf = upload_file('pdf', $path, 'pdf');
                    if (empty($pdf['error'])) {
                        $data['pdf_url'] =  $pdf;
                    }
                }
                $id = $_POST['id'];
                $insert = $this->DocsVideos_model->update($id, $data);
                if ($insert == 'Updated') {
                    echo "Updated";
                    $art_msg['msg'] = 'Document updated.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }

        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/document', 'refresh');

    }

    public function add_texts_data()
    {
        if (isset($_POST)) {

            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $ImagePath = '';
            $pdf_url = '';

            $description = str_replace('\r\n', '', $description);
            
            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/texts';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath =  $images;
                }
            }
                $data = [
                    'title' => $title,
                    'type' => 'Texts',
                    'source_type' => $source_type,
                    'description' => $description,
                    'status' => $status,
                    'image_url' => $ImagePath
                ];
                $insert = $this->DocsVideos_model->save($data);
                if ($insert == 'Inserted') {
                    echo "Inserted";
                    $art_msg['msg'] = 'New Texts Added.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }

        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/texts', 'refresh');

    }

    public function update_texts_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $can_download = $this->db->escape_str($_POST['can_download']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);

            $description = str_replace('\r\n', '', $description);
            
                $data = [
                    'title' => $title,
                    'type' => 'Texts',
                    'source_type' => $source_type,
                    'description' => $description,
                    'status' => $status,
                    'can_download' => $can_download
                ];

            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/texts';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] =  $images;
                }
            }

                $id = $_POST['id'];
                $insert = $this->DocsVideos_model->update($id, $data);
                if ($insert == 'Updated') {
                    echo "Updated";
                    $art_msg['msg'] = 'Texts entry updated.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }

        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/texts', 'refresh');

    }

    public function add_video_data()
    {
        if (isset($_POST)) {

            $title = $this->db->escape_str($_POST['title']);
            $video_source = $this->db->escape_str($_POST['video_source']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['status']);
            $description = $this->db->escape_str($_POST['description']);
            $video_url = $this->db->escape_str($_POST['video_url']);

            if (!empty($_FILES['video_url']['name'])) {
                $path = 'AppAPI/docs_videos/videos/' . $_FILES['video_url']['name'];
                move_uploaded_file($_FILES['video_url']['tmp_name'], $path);
                $video_url = $path;
            }
            if (!empty($_FILES['image']['name'])) {
                $path = 'AppAPI/docs_videos/videos';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $ImagePath =  $images;
                }
            }

            $description = str_replace('\r\n', '', $description);
                $data = [
                    'title' => $title,
                    'type' => 'Video',
                    'source_type' => $source_type,
                    'status' => $status,
                    'video_source' => $video_source,
                    'image_url' => $ImagePath,
                    'video_url' => $video_url,
                    'description' => $description
                ];
                $insert = $this->DocsVideos_model->save($data);
                if ($insert == 'Inserted') {
                    echo "Inserted";
                    $art_msg['msg'] = 'New Video added.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }

        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/videos', 'refresh');

    }

    public function update_video_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $video_source = $this->db->escape_str($_POST['video_source']);
            $source_type = $this->db->escape_str($_POST['source_type']);
            $status = $this->db->escape_str($_POST['edit_status']);
            $description = $this->db->escape_str($_POST['description']);
           // $video_url = $this->db->escape_str($_POST['video_url']);

            $description = str_replace('\r\n', '', $description);
                $data = [
                    'title' => $title,
                    'type' => 'Video',
                    'source_type' => $source_type,
                    'description' => $description,
                    'status' => $status,
                    'video_source' => $video_source
                ];
                if (!empty($_FILES['video_url']['name'])) {
                    $path = 'AppAPI/docs_videos/videos/' . $_FILES['video_url']['name'];
                    move_uploaded_file($_FILES['video_url']['tmp_name'], $path);
                    $video_url = $path;
                    $data['video_url'] = $video_url;
                }
                if (!empty($_FILES['image']['name'])) {
                    $path = 'AppAPI/docs_videos/videos';
                    $images = upload_file('image', $path);
                    if (empty($images['error'])) {
                        $data['image_url'] = $images;
                    }
                }
                $id = $_POST['id'];
                $insert = $this->DocsVideos_model->update($id, $data);
                if ($insert == 'Updated') {
                    echo "Updated";
                    $art_msg['msg'] = 'Video updated.';
                    $art_msg['type'] = 'success';
                } else {
                    $art_msg['msg'] = 'Something Error.';
                    $art_msg['type'] = 'error';
                }

        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'doc_videos/videos', 'refresh');

    }

    public function get_doc_video_details()
    {
        $condition = null;
        $type = $_GET['type'];
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $condition = ['type' => $_GET['type']];
        }
        $fetch_data = $this->DocsVideos_model->make_datatables($condition);
//         echo $this->db->last_query();
//        print_r($fetch_data);die;
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = '<button type="button" name="Details" onclick="getExamSectionDetails(this.id)" id="details_' . $row->id . '" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#show">
         <i class="material-icons">visibility</i> </button>
          <button type="button" name="Edit" onclick="getExamSectionDetailsEdit(this.id)" id="edit_' . $row->id . '"  class="btn bg-purple waves-effect btn-xs" data-toggle="modal" data-target="#edit" >
          <i class="material-icons">mode_edit</i></button>

          <button type="button" name="Delete" onclick="deleteExamSectionDetails(this.id)" id="delete' . $row->id . '" data-type="confirm" class="btn bg-red waves-effect btn-xs">
          <i class="material-icons">delete</i></button>
          ';

            $sub_array[] = $row->title;

            if ($type == 'Docs') {
                $sub_array[] =  $row->can_download;
                $sub_array[] = '<img src="' . base_url("AppAPI/docs_videos/docs/images/" . $row->image_url) . '" class="img-fluid rounded" style="width: 100px;" >';

            } elseif ($type == 'Video') {
				if($row->video_source == "Hosted"){
					$sub_array[] = '<a href="' . base_url($row->video_url) . '" target="_blank"><i class="material-icons">link</i> View Video</a>';
				}else{
					$sub_array[] = '<a href="' . $row->video_url . '" target="_blank"><i class="material-icons">link</i> View Video</a>';
				}
                $sub_array[] = $row->video_source;
                $sub_array[] = '<img src="' . base_url("AppAPI/docs_videos/videos/" . $row->image_url) . '" class="img-fluid rounded" style="width: 100px;" >';
            }else{
                $sub_array[] = '<img src="' . base_url("AppAPI/docs_videos/texts/" . $row->image_url) . '" class="img-fluid rounded" style="width: 100px;" >';

            }

            if ($type == 'Docs') {
                $sub_array[] = '<a href="' . base_url("AppAPI/docs_videos/docs/pdfs/" . $row->pdf_url) . '" target="_blank"><i class="material-icons">download</i> View</a> ';
            }
            $sub_array[] = $row->views_count;
            $sub_array[] = $row->status;

            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->DocsVideos_model->get_all_data(), "recordsFiltered" => $this->DocsVideos_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }

    public function get_single_video_doc($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->DocsVideos_model->getPostById($id);
        if ($result) {
            $row = [];
            $row = $result[0];
            $row['created_at'] = date("d-m-Y H:i:s", strtotime($result[0]['created_at']));
            echo json_encode($row);
            exit;
        } else {
            echo "Invalid ID";
            exit;
        }
    }

    public function delete_doc_video_data($id=null)
    {
		if($_GET['id']){
			$id = $_GET['id'];
		}
        //echo $id;die;
        if (!$id) {
            return false;
        }
		 
        // $result = $this->DocsVideos_model->checkUserSelectedPlan($id);
        if ($this->DocsVideos_model->delete($id)) {
           echo "Success";
        } else {
            echo "Failed";
        }
    }
    public function get_single_pdf($id)
    {

        if (!$id) {
            echo "No ID specified";
            exit;
        }

        $result = $this->DocsVideos_model->getPostById($id);
        if ($result) {
            $row = [];
            $row = $result[0];
            $row['created_at'] = date("d-m-Y H:i:s", strtotime($result[0]['created_at']));
            echo json_encode($row);
            exit;
        } else {
            echo "Invalid ID";
            exit;
        }
    }
}