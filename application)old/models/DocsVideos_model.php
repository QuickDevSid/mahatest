<?php
class DocsVideos_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    var $table = "docs_videos";
    var $select_column = array("id", "type", "source_type", "title", "description", "can_download", "image_url", "pdf_url", "video_source", "video_url", "views_count", "status", "created_at", "source_id", "	num_of_questions", "time", "created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("title", $_POST["search"]["value"]);
        }
        $this->db->order_by('id', 'DESC');
    }

    function make_datatables($condition = null)
    {
        $this->make_query();
        if (isset($condition) && !empty($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function getAllData()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getPostById($id)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    public function editbyId($id)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function save($data)
    {
        //return $data;
        if ($this->db->insert('docs_videos', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    function getDocuments()
    {
        $this->db->select('id, type, title, description, can_download, CONCAT("' . base_url() . '","AppAPI/docs_videos/docs/images/",image_url) as image_url, CONCAT("' . base_url() . '","AppAPI/docs_videos/docs/pdfs/",pdf_url) as pdf_url, views_count, status, created_at');
        $this->db->where('status', 'Active');
        $this->db->where('type', 'Docs');
        $this->db->from("docs_videos");
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getTexts()
    {
        $this->db->select('id, type, title, description, CONCAT("' . base_url() . '","AppAPI/docs_videos/texts/",image_url) as image_url, views_count, status, created_at');
        $this->db->where('status', 'Active');
        $this->db->where('type', 'Texts');
        $this->db->from("docs_videos");
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getVideos()
    {
        $this->db->select('id, type, title, description, CONCAT("' . base_url() . '","AppAPI/docs_videos/videos/",image_url) as image_url, video_source, CONCAT("' . base_url() . '",video_url) as hosted_video_url, video_url, views_count, status, created_at');
        $this->db->where('status', 'Active');
        $this->db->where('type', 'Video');
        $this->db->from("docs_videos");
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function updateViews($id)
    {
        $this->db->set('views_count', 'views_count + 1', FALSE);
        $this->db->where('id', $id);

        if ($this->db->update('docs_videos')) {
            return true;
        } else {
            return false;
        }
    }
    function update($id, $data)
    {

        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table)) {
            return true;
        } else {
            return false;
        }
    }

    public function save_docs_videos_tests()
    {
        $test_id = $this->db->escape_str($_POST['test_id']);

        if ($test_id != "" && is_array($test_id) && !empty($test_id)) {
            $test_array = $test_id;

            foreach ($test_array as $test) {
                $this->db->insert('tbl_docs_videos_test', array(
                    'test_id' => $test,
                    'created_at' => date('Y-m-d H:i:s')
                ));

                $docs_n_videos_id = $this->db->insert_id();

                $this->db->insert('tbl_test_allocation', array(
                    'test_id' => $test,
                    'allocated_type' => 'doc and video',
                    'allocated_table_id' => $docs_n_videos_id,
                    'allocated_table_name' => 'docs_videos',
                    'created_on' => date('Y-m-d H:i:s')
                ));
            }
        }

        return 1;
    }



    // public function save_docs_videos_tests()
    // {
    //     $test_id = $this->db->escape_str($_POST['test_id']);
    //     if ($test_id != "" && is_array($test_id) && !empty($test_id)) {
    //         for ($i = 0; $i < count($test_id); $i++) {
    //             $insert_data = array(
    //                 'test_id'       =>  $test_id[$i],
    //                 'created_at'    =>  date('Y-m-d H:i:s')
    //             );
    //             $this->db->insert('tbl_docs_videos_test', $insert_data);
    //         }
    //     }
    //     return 1;
    // }

    public function get_is_test_already_set($id)
    {
        $this->db->select('tbl_docs_videos_test.*,tbl_test_setups.topic');
        $this->db->join('tbl_test_setups', 'tbl_docs_videos_test.test_id = tbl_test_setups.id');
        $this->db->from('tbl_docs_videos_test');
        $this->db->where('tbl_docs_videos_test.test_id', $id);
        $this->db->where('tbl_docs_videos_test.is_deleted', '0');
        $this->db->order_by('tbl_docs_videos_test.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();
        if (!empty($query)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function get_docs_videos_tests()
    {
        $this->db->select('tbl_docs_videos_test.*,tbl_test_setups.topic');
        $this->db->join('tbl_test_setups', 'tbl_docs_videos_test.test_id = tbl_test_setups.id');
        $this->db->from('tbl_docs_videos_test');
        $this->db->where('tbl_docs_videos_test.is_deleted', '0');
        $this->db->order_by('tbl_docs_videos_test.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function delete_docs_videos_test($id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_docs_videos_test', array('is_deleted' => '1'));
        return 1;
    }
    //New work 23/11/24
    public function get_single_docs_n_videos()
    {
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.id', $this->uri->segment(3));
        $result = $this->db->get('docs_videos');
        $result = $result->row();
        return $result;
    }
    public function set_doc_n_videos_details($upload_image, $upload_pdf)
    {
        $data = array(
            // 'id' => '12',
            'title' => $this->input->post('title'),
            'can_download' => $this->input->post('can_download'),
            'source_type' => "doc_video",
            'type' => "Docs",
            'description' => $this->input->post('description'),
            'image_url' => $upload_image,
            'pdf_url' => $upload_pdf,
            'created_at' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;
        $id = $this->input->post('id');
        // echo $id;
        // exit;

        if ($id) {
            // echo "update";
            // exit;
            $this->db->where('id', $id);
            $this->db->update('docs_videos', $data);
            return 2;
        } else {
            // echo "insert";
            // exit;
            try {
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $data[$key] = implode(', ', $value);
                    }
                }
                if (!$this->db->insert('docs_videos', $data)) {
                    $error = $this->db->error();
                    echo "Database Error: " . $error['message'];
                    log_message('error', 'Insert failed: ' . $error['message']);
                } else {
                    return 1;
                }
            } catch (Exception $e) {
                log_message('error', 'Exception caught during insert: ' . $e->getMessage());
                echo "Exception caught: " . $e->getMessage();
                exit;
            }
            return 1;
        }
    }

    public function get_single_document_list()
    {
        $this->db->select('*');
        $this->db->where('docs_videos.type', 'Docs');
        $this->db->where('docs_videos.source_type', 'doc_video');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->order_by('docs_videos.id', 'DESC');
        $result = $this->db->get('docs_videos');
        return $result->result();
    }

    public function delete_document_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('docs_videos', $data);
    }

    public function get_single_text()
    {
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.id', $this->uri->segment(3));
        $result = $this->db->get('docs_videos');
        $result = $result->row();
        return $result;
    }

    public function set_text_details($upload_image)
    {
        $data = array(
            // 'id' => '12',
            'title' => $this->input->post('title'),
            'source_type' => "doc_video",
            'type' => "Text",
            'description' => $this->input->post('description'),
            'image_url' => $upload_image,
            'created_at' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;
        $id = $this->input->post('id');
        // echo $id;
        // exit;

        if ($id) {
            // echo "update";
            // exit;
            $this->db->where('id', $id);
            $this->db->update('docs_videos', $data);
            return 2;
        } else {
            // echo "insert";
            // exit;
            try {
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $data[$key] = implode(', ', $value);
                    }
                }
                if (!$this->db->insert('docs_videos', $data)) {
                    $error = $this->db->error();
                    echo "Database Error: " . $error['message'];
                    log_message('error', 'Insert failed: ' . $error['message']);
                } else {
                    return 1;
                }
            } catch (Exception $e) {
                log_message('error', 'Exception caught during insert: ' . $e->getMessage());
                echo "Exception caught: " . $e->getMessage();
                exit;
            }
            return 1;
        }
    }

    public function get_single_text_list()
    {
        $this->db->select('*');
        $this->db->where('docs_videos.type', 'Text');
        $this->db->where('docs_videos.source_type', 'doc_video');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->order_by('docs_videos.id', 'DESC');
        $result = $this->db->get('docs_videos');
        return $result->result();
    }

    public function delete_text_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('docs_videos', $data);
    }

    public function get_single_video()
    {
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.id', $this->uri->segment(3));
        $result = $this->db->get('docs_videos');
        $result = $result->row();
        return $result;
    }

    public function set_videos($upload_image, $video_url)
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit;

        // echo $video_url;
        // exit;
        $video_source = $this->input->post('video_source');
        if (empty($video_source)) {
            $this->session->set_flashdata("error", "Please select a video source.");
            echo "not found";
            exit;
            redirect('doc_videos/videos_list');
            return;
        }

        $data = array(
            'title' => $this->input->post('title'),
            'source_id' => $this->input->post('source_id'),
            'source_type' => "doc_video",
            'type' => "Video",
            'video_source' => $this->input->post('video_source'),
            'description' => $this->input->post('description'),
            'image_url' => $upload_image,
            'video_url' => $video_url,
            'created_at' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;
        $id = $this->input->post('id');
        // echo $id;
        // exit;

        if ($id) {
            // echo "update";
            // exit;
            $this->db->where('id', $id);
            $this->db->update('docs_videos', $data);
            return 2;
        } else {
            // echo "insert";
            // exit;
            try {
                log_message('info', 'Data received: ' . json_encode($data));

                if (empty($data['title']) || empty($data['source_id']) || empty($data['video_source']) || empty($data['video_url'])) {
                    throw new Exception('Required fields are missing.');
                }
                if (!$this->db->insert('docs_videos', $data)) {
                    $error = $this->db->error();
                    log_message('error', 'Insert failed: ' . $error['message']);
                    echo "Database Error: " . $error['message'];
                    return 0;
                }
                log_message('info', 'Insert successful: ' . json_encode($data));
                return 1;
            } catch (Exception $e) {
                log_message('error', 'Exception caught during insert: ' . $e->getMessage());
                echo "Exception caught: " . $e->getMessage();
                exit;
            }
            // echo "you are here";
            // exit;
        }
    }

    public function get_single_video_list()
    {
        $this->db->select('*');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->order_by('docs_videos.id', 'DESC');
        $result = $this->db->get('docs_videos');
        return $result->result();
    }

    public function delete_video_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        // echo "delete";
        // echo $id;
        // exit;
        $this->db->where('id', $id);
        $this->db->update('docs_videos', $data);
    }
}
