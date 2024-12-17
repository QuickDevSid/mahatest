<?php
class Courses_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    var $table = "courses";
    var $select_column = array("id", "title", "description", "sub_headings", "banner_image", "mrp", "sale_price", "discount", 'status', 'usage_count', 'created_at');

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
        if (empty($query)) {
            return  0;
        }
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
        if (empty($query)) {
            return 0;
        }
        if ($query->num_rows()) {
            return $query->result();
        } else {
            return 0;
        }
    }
    public function get_course_tests()
    {
        $this->db->where('tests !=', null);
        $result = $this->db->get('courses')->result();
        return $result;
    }
    public function get_course_videos()
    {
        $this->db->select('docs_videos.*,courses.title as course_title');
        $this->db->join('courses', 'courses.id = docs_videos.source_id');
        $this->db->where('docs_videos.type', 'Video');
        $this->db->where('docs_videos.source_type', 'courses');
        $result = $this->db->get('docs_videos')->result();
        return $result;
    }
    public function get_single_course_tests($id)
    {
        $this->db->where('courses.id', $id);
        $result = $this->db->get('courses')->row();
        return $result;
    }
    public function get_tests()
    {
        $this->db->order_by('tbl_test_setups.id', 'desc');
        $this->db->where('tbl_test_setups.is_deleted', '0');
        $result = $this->db->get('tbl_test_setups')->result();
        return $result;
    }
    public function get_course_test_texts($ids)
    {
        if ($ids != "") {
            $all_ids = explode(',', $ids);
        } else {
            $all_ids = [];
        }

        $text = '';
        if (!empty($all_ids)) {
            $this->db->where_in('tbl_test_setups.id', $all_ids);
            $result = $this->db->get('tbl_test_setups')->result();
            if (!empty($result)) {
                foreach ($result as $row) {
                    $text .= $row->topic . ', ';
                }
                $text = rtrim($text, ', ');
            }
        }
        return $text;
    }
    public function save_course_tests()
    {
        $course_id = $this->db->escape_str($_POST['course_id']);
        $hidden_id = $this->db->escape_str($_POST['hidden_id']);
        $test_id = $this->db->escape_str($_POST['test_id']);
        if ($test_id != "" && is_array($test_id) && !empty($test_id)) {
            $test_id = implode(',', $test_id);
        } else {
            $test_id = '';
        }
        $this->db->where('id', $course_id);
        $this->db->update('courses', array('tests' => $test_id));
        return 1;
    }

    public function delete_test($id)
    {
        $this->db->where('id', $id);
        $this->db->update('courses', array('tests' => null));
        return 1;
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

    public function get_single_courses()
    {
        $this->db->where('courses.is_deleted', '0');
        $this->db->where('courses.status', '1');
        $this->db->where('courses.id', $this->uri->segment(3));
        $result = $this->db->get('courses');
        $result = $result->row();
        return $result;
    }

    function save($data)
    {
        return $data;
        exit;
        if ($this->db->insert($this->table, $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    public function set_courses_details($upload_image, $upload_inner_image)
    {

        $data = array(
            // 'id' => '12',
            'title' => $this->input->post('title'),
            'sub_headings' => $this->input->post('subtitle'),
            'tagline' => $this->input->post('tagline'),
            'mrp' => $this->input->post('mrp'),
            'sale_price' => $this->input->post('sale_price'),
            'discount' => $this->input->post('discount'),
            'description' => $this->input->post('description'),
            'validity' => $this->input->post('validity'),
            'banner_image' => $upload_image,
            'inner_banner_image' => $upload_inner_image,
            'record_status' => $this->input->post('record_status'),
            'created_at' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;
        $id = $this->input->post('id');
        // echo $id;
        // exit;
        $sequence_no = $this->input->post('sequence_no');
        if ($id) {
            // Update existing record logic
            $this->db->select('sequence_no');
            $this->db->from('courses');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $existingRecord = $query->row();

            if ($existingRecord) {
                $currentSequenceNo = $existingRecord->sequence_no;
                $newSequenceNo = $this->input->post('sequence_no');

                if ($currentSequenceNo != $newSequenceNo) {
                    // Adjust sequence numbers for other records if necessary
                    if ($newSequenceNo < $currentSequenceNo) {
                        // Move up (e.g., from 2 to 1)
                        $this->db->set('sequence_no', 'sequence_no + 1', FALSE);
                        $this->db->where('sequence_no >=', $newSequenceNo);
                        $this->db->where('sequence_no <', $currentSequenceNo);
                        $this->db->update('courses');
                    } else {
                        // Move down (e.g., from 2 to 4)
                        $this->db->set('sequence_no', 'sequence_no - 1', FALSE);
                        $this->db->where('sequence_no <=', $newSequenceNo);
                        $this->db->where('sequence_no >', $currentSequenceNo);
                        $this->db->update('courses');
                    }
                }

                // Update the current record with the new sequence_no
                $data['sequence_no'] = $newSequenceNo;
                $this->db->where('id', $id);
                $this->db->update('courses', $data);
                return 0; // Indicate update
            }
        } else {
            // Insert new record logic
            $this->db->select('id');
            $this->db->from('courses');
            $this->db->where('sequence_no', $sequence_no);
            $query = $this->db->get();
            if ($query !== false && $query->num_rows() > 0) {
                // echo "matched";
                // exit;
                $this->db->set('sequence_no', 'sequence_no + 1', FALSE); // Increment sequence_no
                $this->db->where('sequence_no >=', $sequence_no);
                $this->db->update('courses');
            } else {
                // Handle case when query fails or no rows are returned
                // echo "Query failed or no matching records.";
                $data['sequence_no'] = $sequence_no;
                // print_r($data);
                // exit;
                $this->db->insert('courses', $data);
                return 1;
            }
        }


        // if ($id) {
        //     $this->db->where('id', $id);
        //     $this->db->update('courses', $data);
        //     return 2;
        // } else {
        //     try {
        //         foreach ($data as $key => $value) {
        //             if (is_array($value)) {
        //                 $data[$key] = implode(', ', $value);
        //             }
        //         }
        //         if (!$this->db->insert('courses', $data)) {
        //             $error = $this->db->error();
        //             echo "Database Error: " . $error['message'];
        //             log_message('error', 'Insert failed: ' . $error['message']);
        //         } else {
        //         }
        //     } catch (Exception $e) {
        //         log_message('error', 'Exception caught during insert: ' . $e->getMessage());
        //         echo "Exception caught: " . $e->getMessage();
        //         exit;
        //     }
        //     // return 1;
        // }
    }


    // public function set_courses_details($upload_image, $upload_inner_image)
    // {
    //     $sequence_no = (int)$this->input->post('sequence_no');
    //     $id = $this->input->post('id');

    //     $existing_sequence = $this->get_course_existing_sequence($sequence_no);
    //     // Prepare data for insertion or update
    //     $data = array(
    //         'title' => $this->input->post('title'),
    //         'sequence_no' => $sequence_no,
    //         'banner_image' => $upload_image,
    //         'inner_banner_image' => $upload_inner_image,
    //         'sub_headings' => $this->input->post('subtitle'),
    //         'tagline' => $this->input->post('tagline'),
    //         'mrp' => $this->input->post('mrp'),
    //         'sale_price' => $this->input->post('sale_price'),
    //         'discount' => $this->input->post('discount'),
    //         'description' => $this->input->post('description'),
    //         'validity' => $this->input->post('validity'),
    //         'created_at' => date('Y-m-d H:i:s'),
    //     );

    //     try {
    //         if ($id) {

    //             $this->db->where('id', $id);

    //             if ($this->db->update('courses', $data)) {

    //                 return 2;
    //             } else {
    //                 $error = $this->db->error();
    //                 log_message('error', 'Update failed: ' . $error['message']);
    //                 echo "Update Error: " . $error['message'];
    //                 return;
    //             }
    //         } else {
    //             // Insert new record
    //             if ($this->db->insert('courses', $data)) {
    //                 $last_id = $this->db->insert_id();
    //                 if (!empty($existing_sequence)) {
    //                     $this->update_course_sequence($existing_sequence->id, $last_id, $sequence_no);
    //                 }
    //                 return 1;
    //             } else {
    //                 $error = $this->db->error();
    //                 log_message('error', 'Insert failed: ' . $error['message']);
    //                 echo "Insert Error: " . $error['message'];
    //                 return;
    //             }
    //         }
    //     } catch (Exception $e) {
    //         log_message('error', 'Exception caught during insert/update: ' . $e->getMessage());
    //         echo "Exception caught: " . $e->getMessage();
    //         return;
    //     }
    // }

    // public function update_course_sequence($response_id, $last_id, $sequence_no)
    // {
    //     $this->db->where('id >', $response_id);
    //     $this->db->where('id !=', $last_id);
    //     $this->db->set('sequence_no', 'sequence_no + 1', FALSE);
    //     $this->db->update('courses');
    // }


    // public function get_course_existing_sequence($sequence_no)
    // {
    //     $this->db->where('sequence_no', $sequence_no);
    //     $result = $this->db->get('courses');
    //     return $result->row();
    // }

    public function delete_courses_list($id)
    {
        $data = array(
            'status' => 0,
            'record_status' => 'Inactive',
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('courses', $data);
    }

    public function status_courses_list_active($id)
    {
        $data = array(
            'record_status' => 'Inactive'
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('courses', $data);
    }

    public function status_courses_list_in_active($id)
    {
        $data = array(
            'record_status' => 'Active'
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('courses', $data);
    }


    public function delete_video_courses_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        echo "delete";
        // echo $id;
        // exit;
        $this->db->where('id', $id);
        $this->db->update('docs_videos', $data);
    }


    public function get_single_courses_list()
    {
        $this->db->select('*');
        $this->db->where('courses.record_status', 'Active');
        $this->db->where('courses.is_deleted', '0');
        $this->db->order_by('courses.sequence_no', 'ASC');
        $result = $this->db->get('courses');
        return $result->result();
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
        $this->db->where('type', 'Text');
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
        $this->db->select('id, type, title, description, CONCAT("' . base_url() . '","AppAPI/docs_videos/videos/",image_url) as image_url, video_source, video_url, views_count, status, created_at');
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

    public function get_single_video_courses()
    {
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.id', $this->uri->segment(3));
        $result = $this->db->get('docs_videos');
        $result = $result->row();
        return $result;
    }

    public function get_select_course()
    {
        $this->db->where('courses.status', '1');
        $this->db->where('courses.is_deleted', '0');
        $this->db->order_by('courses.id', 'DESC');
        $result = $this->db->get('courses');
        return $result->result();
    }


    public function set_courses_video($upload_image, $video_url)
    {
        // echo $video_url;
        // exit;
        $data = array(
            'title' => $this->input->post('title'),
            'source_id' => $this->input->post('source_id'),
            'source_type' => "courses",
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
                // log_message('info', 'Insert successful: ' . json_encode($data));
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

    public function get_single_video_courses_list()
    {
        $this->db->select('*');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->order_by('docs_videos.id', 'DESC');
        $result = $this->db->get('docs_videos');
        return $result->result();
    }
    public function get_single_texts_courses()
    {
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.id', $this->uri->segment(3));
        $result = $this->db->get('docs_videos');
        $result = $result->row();
        return $result;
    }

    public function set_courses_texts_details($upload_image)
    {
        $data = array(
            // 'id' => '12',
            'title' => $this->input->post('title'),
            'source_id' => $this->input->post('source_id'),
            'source_type' => "courses",
            'type' => "Texts",
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

    public function get_single_courses_texts_list()
    {
        $this->db->select('*');
        $this->db->where('docs_videos.type', 'Texts');
        $this->db->where('docs_videos.source_type', 'courses');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->order_by('docs_videos.id', 'DESC');
        $result = $this->db->get('docs_videos');
        return $result->result();
    }

    public function delete_courses_texts_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('docs_videos', $data);
    }

    public function get_duplicate_courses_text_title()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('source_type', 'courses');
        $this->db->where('type', 'Texts');
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('docs_videos');
        echo $query->num_rows();
    }

    public function get_single_pdfs_courses()
    {
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.id', $this->uri->segment(3));
        $result = $this->db->get('docs_videos');
        $result = $result->row();
        return $result;
    }


    public function set_courses_pdfs_details($upload_image, $upload_pdf)
    {
        $data = array(
            // 'id' => '12',
            'title' => $this->input->post('title'),
            'source_id' => $this->input->post('source_id'),
            'source_type' => "courses",
            'type' => "Pdf",
            'description' => $this->input->post('description'),
            'can_download' => $this->input->post('can_download'),
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

    public function get_single_courses_pdfs_list()
    {
        $this->db->select('*');
        $this->db->where('docs_videos.type', 'Pdf');
        $this->db->where('docs_videos.source_type', 'courses');
        $this->db->where('docs_videos.status', '1');
        $this->db->where('docs_videos.is_deleted', '0');
        $this->db->order_by('docs_videos.id', 'DESC');
        $result = $this->db->get('docs_videos');
        return $result->result();
    }

    public function delete_courses_pdfs_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('docs_videos', $data);
    }

    public function get_duplicate_courses_pdf_title()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('source_type', 'courses');
        $this->db->where('type', 'Pdf');
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('docs_videos');
        echo $query->num_rows();
    }

    public function get_duplicate_courses_title()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('courses');
        echo $query->num_rows();
    }
}
