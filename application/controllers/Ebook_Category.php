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

class Ebook_Category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("EbookCategory_model");
    }
    //functions
    public function ebooks_cat()
    {
        $data['title'] = ucfirst('All CurrentAffairs'); // Capitalize the first letter
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('ebook_cat/ebooks_cat', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('ebook_cat/sub_jscript2.php', $data);
    }

    public function ebooks__cat()
    {
        $data['title'] = ucfirst('All CurrentAffairs');
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('ebook_cat/ebooks__cat', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('ebook_cat/subjscript.php', $data);
    }

    public function ebooks_sub_cat()
    {
        $data['title'] = ucfirst('All CurrentAffairs');
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('ebook_cat/ebooks_sub_cat', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('ebook_cat/sub_jscript.php', $data);
    }

    public function ebooks_setup()
    {
        $data['title'] = ucfirst('All CurrentAffairs');
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('ebook_cat/ebooks_setup', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('ebook_cat/setup_jscript.php', $data);
    }

    public function add_ebooks_cat_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $image = "";
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/ebook_images/';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $image = $images;
                }
            }
            $data = [
                'title' => $title,
                'icon' => $image
            ];
            // print_r($data);
            // exit;
            $insert = $this->EbookCategory_model->save($data);
            if ($insert == 'Inserted') {
                $art_msg['msg'] = 'New Ebook Category added.';
                $art_msg['type'] = 'success';
            } else {
                $art_msg['msg'] = 'Something Error.';
                $art_msg['type'] = 'error';
            }
        }
        $this->session->set_userdata('alert_msg', $art_msg);

        redirect(base_url() . 'Exam_subject', 'refresh');
    }

    public function update_ebooks_cat_data()
    {
        if (isset($_POST)) {
            $title = $this->db->escape_str($_POST['title']);
            $image = "";
            if (!empty($_FILES['image']['name'])) {
                $path = 'assets/ebook_images/';
                $images = upload_file('image', $path);
                if (empty($images['error'])) {
                    $data['image_url'] =  $images;
                }
            }
            $data = [
                'title' => $title,
                'icon' => $image
            ];

            $id = $_POST['id'];
            $insert = $this->EbookCategory_model->update($id, $data);
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

        redirect(base_url() . 'ebook_cat/ebooks_cat', 'refresh');
    }

    // public function add_ebook_sub_cat_data()
    // {
    //     $title = $this->input->post('title');
    //     $this->form_validation->set_rules('title', 'Ebook Title', 'required');

    //     if ($this->form_validation->run() === FALSE) {
    //         $data['single'] = $this->EbookCategory_model->get_single_ebooks_sub_cat();
    //         $this->load->view('ebook_cat/ebooks_sub_cat', $data);
    //         $this->load->view('templates/header1', $data);
    //         $this->load->view('templates/menu', $data);
    //         $this->load->view('templates/footer1', $data);
    //         $this->load->view('ebook_cat/sub_jscript.php', $data);
    //     } else {
    //         // Initialize $upload_image with the current image value (if available)
    //         $upload_image = '';
    //         // Check if a new image is uploaded
    //         if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
    //             $gst_config = array(
    //                 'upload_path'   => "assets/ebook_images/",
    //                 'allowed_types' => "*",
    //                 'encrypt_name'  => true,
    //             );
    //             $this->upload->initialize($gst_config);

    //             if ($this->upload->do_upload('image')) {
    //                 $data = $this->upload->data();
    //                 $upload_image = $data['file_name']; // Get the name of the uploaded image
    //             } else {
    //                 $error = array('error' => $this->upload->display_errors());
    //                 $this->session->set_flashdata("error", $error['error']);
    //                 redirect('ebook_cat/ebooks_sub_cat_list');
    //                 return;
    //             }
    //         } else {
    //             // No new image uploaded, use the existing image (if any)
    //             if ($this->input->post('current_image')) {
    //                 $upload_image = $this->input->post('current_image');
    //             }
    //         }
    //         $res = $this->EbookCategory_model->set_ebook_sub_cat_details($upload_image);

    //         if ($res == "1") {
    //             $this->session->set_flashdata("success", "Ebook Sub Category details added successfully!");
    //             redirect('ebook_cat/ebooks_sub_cat_list');
    //         } elseif ($res == "2") {
    //             $this->session->set_flashdata("success", "Ebook Sub Category entry updated!");
    //             redirect('ebook_cat/ebooks_sub_cat_list');
    //         } else {
    //             $this->session->set_flashdata("error", "Error updating Ebook Sub Category.");
    //         }
    //     }
    // }

    public function add_ebook__cat_data()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Ebook Title', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->EbookCategory_model->get_single_ebooks__cat(); //
            $this->load->view('ebook_cat/ebooks__cat', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('ebook_cat/subjscript.php', $data);
            $this->session->set_flashdata("error", "Error updating Ebook Category.");
        } else {

            $upload_image = $this->input->post('current_image');

            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/ebook_images/",
                    'allowed_types' => "*",
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);

                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $upload_image = $data['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    echo "new error";
                    exit;
                    redirect('ebook_cat/ebooks__cat_list');
                    return;
                }
            }

            $res = $this->EbookCategory_model->set_ebook__cat_details($upload_image);

            if ($res == "1") {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $this->session->set_flashdata("success", "Ebook Category details added successfully!");
                redirect('ebook_cat/ebooks__cat_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Ebook Category entry updated!");
                redirect('ebook_cat/ebooks__cat_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Ebook Category.");
                redirect('ebooks__cat_list');
            }
        }
    }

    public function add_ebook_sub_cat_data()
    {
        $title = $this->input->post('title');
        $this->form_validation->set_rules('title', 'Ebook Title', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->EbookCategory_model->get_single_ebooks_sub_cat();
            $this->load->view('ebook_cat/ebooks_sub_cat', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('ebook_cat/sub_jscript.php', $data);
        } else {
            $upload_image = $this->input->post('current_image');

            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/ebook_images/",
                    'allowed_types' => "*",
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);

                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $upload_image = $data['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    redirect('ebook_cat/ebooks_sub_cat_list');
                    return;
                }
            }
            $res = $this->EbookCategory_model->set_ebook_sub_cat_details($upload_image);
            if ($res == "1") {
                $this->session->set_flashdata("success", "Ebook Sub Category details added successfully!");
                redirect('ebook_cat/ebooks_sub_cat_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Ebook Sub Category entry updated!");
                redirect('ebook_cat/ebooks_sub_cat_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Ebook Sub Category.");
            }
        }
    }

    public function add_ebooks_chapter_setup()
    {
        $validate = $this->input->post('validate');
        $this->form_validation->set_rules('validate', 'Ebook Chapter', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->EbookCategory_model->get_single_ebooks_chapter();
            $ebook_id = $id = $this->uri->segment(3);
            $data['ebook_id'] = $ebook_id;
            $this->load->view('ebook_cat/add_ebooks_chapter_setup', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('ebook_cat/chapter_setup_jscript.php', $data);
        } else {
            $indices = $this->input->post('indices');
            $upload_image = $this->input->post('current_image');
            $image_uploads = [];
            if (!empty($indices)) {
                for ($i = 0; $i < count($indices); $i++) {
                    // Handle chapter image upload
                    if (isset($_FILES['image_' . $indices[$i]]) && $_FILES['image_' . $indices[$i]]['name'] != "") {
                        $gst_config = array(
                            'upload_path'   => "assets/ebook_images/",
                            'allowed_types' => "*",  // You can specify the types if needed
                            'encrypt_name'  => true,
                        );
                        $this->upload->initialize($gst_config);
                        if ($this->upload->do_upload('image_' . $indices[$i])) {
                            $data = $this->upload->data();
                            $image_uploads[] = $data['file_name'];  // Store uploaded chapter image
                        } else {
                            // Handle image upload error
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata("error", $error['error']);
                            echo "problem in second image";
                            exit;
                            redirect('ebook_cat/ebooks_setup_list');
                            return;
                        }
                    }
                }
                // Combine image and video uploads if they exist
                $upload_image = implode(',', $image_uploads);
            }

            $upload_image_update = $this->input->post('current_image_update');  // Get the current image from the hidden field

            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                $gst_config = array(
                    'upload_path'   => "assets/ebook_images/",
                    'allowed_types' => "*",  // You can specify the types if needed
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);

                // Handle file upload
                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $upload_image_update = $data['file_name'];  // Store the uploaded image's file name
                } else {
                    // Handle upload error
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    echo "problem in main image";
                    exit;
                    redirect('ebook_cat/ebooks_setup_list');
                    return;
                }
            }
            $res = $this->EbookCategory_model->set_ebook_chapter_details($upload_image, $upload_image_update);
            if ($res == "1") {
                // echo "1";
                // exit;
                $this->session->set_flashdata("success", "Ebook Setup details added successfully!");
                redirect('ebook_cat/ebooks_chapter_setup_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Ebook Setup entry updated!");
                // echo "2";
                // exit;
                redirect('ebook_cat/ebooks_chapter_setup_list');
            } else {
                echo "0";
                exit;
                $this->session->set_flashdata("error", "Error updating Ebook Sub Category.");
            }
        }
    }

    public function ebooks_chapter_setup_list()
    {
        $data['category'] = $this->EbookCategory_model->get_ebook_chapter_setup();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('ebook_cat/ebooks_chapter_setup_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('ebook_cat/chapter_setup_jscript.php', $data);
    }


    public function add_ebooks_video_setup()
    {
        $validate = $this->input->post('validate');
        $this->form_validation->set_rules('validate', 'Ebook video', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['single'] = $this->EbookCategory_model->get_single_ebooks_videos();
            $ebook_id = $id = $this->uri->segment(3);
            $data['ebook_id'] = $ebook_id;
            $this->load->view('ebook_cat/add_ebooks_video_setup', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('ebook_cat/video_setup_jscript.php', $data);
        } else {
            // echo "<pre>";
            // print_r($_POST);
            // print_r($_FILES);
            // exit;
            $indices = $this->input->post('indices');
            $upload_video = $this->input->post('current_video');
            $video_uploads = [];
            if (!empty($indices)) {
                for ($i = 0; $i < count($indices); $i++) {
                    // if (isset($_FILES['videos_' . $indices[$i]]) && $_FILES['videos_' . $indices[$i]]['name'] != "") {
                    if (isset($_FILES['videos_' . $indices[$i]]) && $_FILES['videos_' . $indices[$i]]['name'] != "") {
                        $gst_config = array(
                            'upload_path'   => "assets/ebook_images/",
                            'allowed_types' => "*",
                            'encrypt_name'  => true,
                        );
                        // print_r($gst_config);
                        // exit;
                        $this->upload->initialize($gst_config);
                        if ($this->upload->do_upload('videos_' . $indices[$i])) {
                            $data = $this->upload->data();
                            $video_uploads[] = $data['file_name'];  // Store uploaded chapter video
                        } else {
                            $error = $this->upload->display_errors();
                            $this->session->set_flashdata("error", $error);
                            echo "Error uploading video: " . $error;  // Display detailed error
                            exit;
                        }
                    }
                }
                $upload_video = implode(',', $video_uploads);
            }

            $upload_video_update = $this->input->post('current_video_update');  // Get the current image from the hidden field

            if (isset($_FILES['file_name']) && $_FILES['file_name']['name'] != "") {

                $gst_config = array(
                    'upload_path'   => "assets/ebook_images/",
                    'allowed_types' => "*",  // You can specify the types if needed
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);

                // Handle file upload
                if ($this->upload->do_upload('file_name')) {
                    $data = $this->upload->data();
                    $upload_video_update = $data['file_name'];  // Store the uploaded image's file name
                } else {
                    // Handle upload error
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    echo "problem in main video";
                    exit;
                    redirect('ebook_cat/ebooks_video_setup_list');
                    return;
                }
            }
            // print_r($upload_video_update);
            // // print_r($upload_video);
            // exit;
            $res = $this->EbookCategory_model->set_ebook_video_details($upload_video, $upload_video_update);
            if ($res == "1") {
                // echo "1";
                // exit;
                $this->session->set_flashdata("success", "Ebook Setup details added successfully!");
                redirect('ebook_cat/ebooks_video_setup_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Ebook Setup entry updated!");
                // echo "2";
                // exit;
                redirect('ebook_cat/ebooks_video_setup_list');
            } else {
                echo "0";
                exit;
                $this->session->set_flashdata("error", "Error updating Ebook Sub Category.");
            }
        }
    }

    public function ebooks_video_setup_list()
    {
        $data['category'] = $this->EbookCategory_model->get_ebook_video_setup();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('ebook_cat/ebooks_video_setup_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('ebook_cat/video_setup_jscript.php', $data);
    }





    public function add_ebook_setup_data()
    {
        $category = $this->input->post('category');
        $this->form_validation->set_rules('category', 'Chapter category', 'required');

        // Run form validation
        if ($this->form_validation->run() === FALSE) {
            // Load data for the view if form validation fails
            $data['single'] = $this->EbookCategory_model->get_single_ebooks();
            $this->load->view('ebook_cat/ebooks_setup', $data);
            $this->load->view('templates/header1', $data);
            $this->load->view('templates/menu', $data);
            $this->load->view('templates/footer1', $data);
            $this->load->view('ebook_cat/setup_jscript.php', $data);
        } else {
            // Upload main ebook image
            $upload_image_main = $this->input->post('current_image_main');  // Get the current image from the hidden field

            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                // Configurations for uploading the main ebook image
                $gst_config = array(
                    'upload_path'   => "assets/ebook_images/",
                    'allowed_types' => "*",  // You can specify the types if needed
                    'encrypt_name'  => true,
                );
                $this->upload->initialize($gst_config);

                // Handle file upload
                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $upload_image_main = $data['file_name'];  // Store the uploaded image's file name
                } else {
                    // Handle upload error
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata("error", $error['error']);
                    echo "problem in main image";
                    exit;
                    redirect('ebook_cat/ebooks_setup_list');
                    return;
                }
            }
            // print_r($upload_image_main);
            // exit;
            // Handle dynamic chapter uploads (images and videos)

            // $indices = $this->input->post('indices');  // Get the dynamic chapter indices
            // $upload_image = $this->input->post('current_image');
            // $upload_video = $this->input->post('current_video');
            // echo $upload_image;
            // echo $upload_video;
            // exit;
            // $image_uploads = [];
            // $video_uploads = [];
            // if (!empty($indices)) {
            //     for ($i = 0; $i < count($indices); $i++) {
            //         // Handle chapter image upload
            //         if (isset($_FILES['image_' . $indices[$i]]) && $_FILES['image_' . $indices[$i]]['name'] != "") {
            //             $gst_config = array(
            //                 'upload_path'   => "assets/ebook_images/",
            //                 'allowed_types' => "*",  // You can specify the types if needed
            //                 'encrypt_name'  => true,
            //             );
            //             $this->upload->initialize($gst_config);
            //             if ($this->upload->do_upload('image_' . $indices[$i])) {
            //                 $data = $this->upload->data();
            //                 $image_uploads[] = $data['file_name'];  // Store uploaded chapter image
            //             } else {
            //                 // Handle image upload error
            //                 $error = array('error' => $this->upload->display_errors());
            //                 $this->session->set_flashdata("error", $error['error']);
            //                 echo "problem in second image";
            //                 exit;
            //                 redirect('ebook_cat/ebooks_setup_list');
            //                 return;
            //             }
            //         }
            //         // Handle chapter video upload (if present)
            //         if (isset($_FILES['video_' . $indices[$i]]) && $_FILES['video_' . $indices[$i]]['name'] != "") {
            //             $gst_config = array(
            //                 'upload_path'   => "assets/ebook_images/",
            //                 'allowed_types' => "*",  // You can specify the types for videos
            //                 'encrypt_name'  => true,
            //             );
            //             $this->upload->initialize($gst_config);
            //             if ($this->upload->do_upload('video_' . $indices[$i])) {
            //                 $data = $this->upload->data();
            //                 $video_uploads[] = $data['file_name'];  // Store uploaded chapter video
            //             } else {
            //                 $error = $this->upload->display_errors();
            //                 $this->session->set_flashdata("error", $error);
            //                 echo "Error uploading video: " . $error;  // Display detailed error
            //                 exit;
            //             }
            //         }
            //     }
            //     // Combine image and video uploads if they exist
            //     $upload_image = implode(',', $image_uploads);
            //     $upload_video = implode(',', $video_uploads);
            // }
            // Insert or update the ebook data
            $res = $this->EbookCategory_model->set_ebook_setup_details($upload_image_main);
            if ($res == "1") {
                $this->session->set_flashdata("success", "Ebook Setup details added successfully!");
                redirect('ebook_cat/ebooks_setup_list');
            } elseif ($res == "2") {
                $this->session->set_flashdata("success", "Ebook Setup entry updated!");
                redirect('ebook_cat/ebooks_setup_list');
            } else {
                $this->session->set_flashdata("error", "Error updating Ebook Sub Category.");
            }
        }
    }

    public function ebooks__cat_list()
    {
        $data['category'] = $this->EbookCategory_model->get_ebook__cat();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('ebook_cat/ebooks__cat_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
    }
    public function delete_ebooks__cat($id)
    {
        $this->EbookCategory_model->delete_ebooks__cat($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('ebook_cat/ebooks__cat_list');
    }

    public function ebooks_sub_cat_list()
    {
        $data['category'] = $this->EbookCategory_model->get_ebook_sub_cat();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('ebook_cat/ebooks_sub_cat_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('ebook_cat/jscript.php', $data);
    }

    public function delete_ebooks_sub_cat($id)
    {
        $this->EbookCategory_model->delete_ebooks_sub_cat($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('ebook_cat/ebooks_sub_cat_list');
    }

    public function delete_ebooks_setup($id)
    {
        $this->EbookCategory_model->delete_ebooks_setup($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('ebook_cat/ebooks_setup_list');
    }

    public function delete_ebooks_chapter_setup($id)
    {
        $this->EbookCategory_model->delete_ebooks_chapter_setup($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('ebook_cat/ebooks_chapter_setup_list');
    }

    public function delete_ebooks_video_setup($id)
    {
        $this->EbookCategory_model->delete_ebooks_video_setup($id);
        $this->session->set_flashdata('delete', 'Record deleted successfully');

        redirect('ebook_cat/ebooks_video_setup_list');
    }

    public function ebooks_setup_list()
    {
        $data['category'] = $this->EbookCategory_model->get_ebook_setup();
        // echo '<pre>';
        // print_r($data['category']);
        // exit();
        $this->load->view('ebook_cat/ebooks_setup_list', $data);
        $this->load->view('templates/header1', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('templates/footer1', $data);
        $this->load->view('ebook_cat/setup_jscript.php', $data);
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
                $path = 'assets/ebook_images/';
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

    public function get_ebooks_video_details()
    {

        $fetch_data = $this->EbookCategory_model->make_datatables();
        //         echo $this->db->last_query();
        // print_r($fetch_data);
        // die;
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
            $sub_array[] = '<img src="' . base_url("assets/ebook_images/" . $row->icon) . '" class="img-fluid rounded" style="width: 100px;" alt="' . htmlspecialchars($row->title) . '">';
            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->EbookCategory_model->get_all_data(), "recordsFiltered" => $this->EbookCategory_model->get_filtered_data(), "data" => $data);

        echo json_encode($output);
    }

    public function get_single_video_doc($id)
    {
        if (!$id) {
            echo "No ID specified";
            exit;
        }
        $result = $this->EbookCategory_model->getPostById($id);
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

    public function delete_ebooks_cat_video_data($id = null)
    {
        if ($_GET['id']) {
            $id = $_GET['id'];
        }
        //echo $id;die;
        if (!$id) {
            return false;
        }

        // $result = $this->DocsVideos_model->checkUserSelectedPlan($id);
        if ($this->EbookCategory_model->delete($id)) {
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

    // Ajax request
    public function get_duplicate_cat_title()
    {
        $this->EbookCategory_model->get_duplicate_cat_title();
    }

    public function get_duplicate_sub_cat_title()
    {
        $this->EbookCategory_model->get_duplicate_sub_cat_title();
    }

    public function get_duplicate_coupon_name()
    {
        $this->EbookCategory_model->get_duplicate_coupon_name();
    }
    public function get_duplicate_coupon_code()
    {
        $this->EbookCategory_model->get_duplicate_coupon_code();
    }
}
