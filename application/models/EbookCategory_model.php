<?php

class EbookCategory_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    // var $table = "tbl_ebook_category";
    // var $select_column = array("id", "title", "icon", "status", "created_on", "is_deleted", "updated_on");
    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('status', '1');
        $this->db->where('is_deleted', '0');
        if (isset($_POST["search"]["value"])) {
            $this->db->like("title", $_POST["search"]["value"]);
        }
        $this->db->order_by('id', 'DESC');
    }

    function make_datatables()
    {
        $this->make_query();
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
        $this->db->where('status', '1');
        $this->db->where('is_deleted', '0');
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
        // return $data;
        if ($this->db->insert('tbl_ebook_category', $data)) {
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
        $this->db->where('status', '1');
        $this->db->where('is_deleted', '0');
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

    ///Old methods
    public function add_test_data($bulk_upload_data)
    {
        $status = $bulk_upload_data['status'];
        if ($status) {
            $bulk_data = $bulk_upload_data['bulk_data'];
            if (!empty($bulk_data)) {
                $total_questions = $bulk_upload_data['total_questions'];
                $total_marks = $bulk_upload_data['total_marks'];
                $data = array(
                    'topic'             => $this->input->post('topic'),
                    'short_note'        => $this->input->post('short_note'),
                    'short_description' => $this->input->post('short_description'),
                    'duration'          => $this->input->post('duration'),
                    'description'       => $this->input->post('description'),
                    'total_questions'   => $total_questions,
                    'total_marks'       => $total_marks,
                    'created_on'        => date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_test_setups', $data);
                $test_id = $this->db->insert_id();

                $bulk_insert_data = [];
                foreach ($bulk_data as $bulk) {
                    if (isset($bulk['question'], $bulk['question_type'], $bulk['options'], $bulk['answer'], $bulk['solution'], $bulk['positive_marks'], $bulk['negative_marks'])) {
                        $bulk['test_id'] = $test_id;
                        $bulk['created_on'] = date('Y-m-d H:i:s');
                        $bulk['options'] = json_encode($bulk['options']);
                        $bulk_insert_data[] = $bulk;
                    }
                }
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }
    }

    public function get_select_ebooks_cat()
    {
        $this->db->where('tbl_ebook_category.status', '1');
        $this->db->where('tbl_ebook_category.is_deleted', '0');
        $this->db->order_by('tbl_ebook_category.id', 'DESC');
        $result = $this->db->get('tbl_ebook_category');
        return $result->result();
    }

    public function get_single_ebooks_sub_cat()
    {
        $this->db->where('tbl_ebook_sub_category.is_deleted', '0');
        $this->db->where('tbl_ebook_sub_category.status', '1');
        $this->db->where('tbl_ebook_sub_category.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_ebook_sub_category');
        $result = $result->row();
        return $result;
    }

    // public function set_ebook_sub_cat_details($upload_image)
    // {
    //     $data = array(
    //         'title' => $this->input->post('title'),
    //         'category_id' => $this->input->post('category'),
    //         'icon' => $upload_image,
    //         'created_on' => date('Y-m-d H:i:s')
    //     );

    //     $id = $this->input->post('id');
    //     if ($id) {
    //         $this->db->where('id', $id);
    //         $this->db->update('tbl_ebook_sub_category', $data);
    //         return 2; // Returns 2 if the record is updated
    //     } else {
    //         $this->db->insert('tbl_ebook_sub_category', $data);
    //         return 1; // Returns 1 if a new record is added
    //     }
    // }

    public function get_single_ebooks__cat()
    {
        $this->db->where('tbl_ebook_category.is_deleted', '0');
        $this->db->where('tbl_ebook_category.status', '1');
        $this->db->where('tbl_ebook_category.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_ebook_category');
        $result = $result->row();
        return $result;
    }

    public function set_ebook__cat_details($upload_image)
    {
        $data = array(
            'title' => $this->input->post('title'),
            'icon' => $upload_image,
            'created_on' => date('Y-m-d H:i:s')
        );
        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('tbl_ebook_category', $data);
            return 2;
        } else {
            $this->db->insert('tbl_ebook_category', $data);
            return 1;
        }
    }

    public function set_ebook_sub_cat_details($upload_image)
    {
        $data = array(
            'title' => $this->input->post('title'),
            'category_id' => $this->input->post('category'),
            'icon' => $upload_image,
            'created_on' => date('Y-m-d H:i:s')
        );

        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('tbl_ebook_sub_category', $data);
            return 2;
        } else {
            $this->db->insert('tbl_ebook_sub_category', $data);
            return 1;
        }
    }


    // public function set_ebook_setup_details($upload_image, $upload_image_main, $upload_video)
    // {
    //     // Prepare the data array for the main ebook
    //     $data = array(
    //         'category_id'     => $this->input->post('category'),
    //         'sub_category_id	' => $this->input->post('sub_category'),
    //         'title'    => $this->input->post('book_name'),
    //         'image'         => $upload_image_main,
    //         'created_on'   => date('Y-m-d H:i:s')
    //     );
    //     $id = $this->input->post('id');
    //     if ($id) {
    //         $this->db->where('id', $id);
    //         $this->db->update('tbl_ebooks', $data);
    //     } else {
    //         $this->db->insert('tbl_ebooks', $data);
    //         $id = $this->db->insert_id();
    //     }

    //     $files = explode(',', $upload_image);
    //     $videofiles = explode(',', $upload_video);
    //     $category_id = $this->input->post('category');
    //     $sub_category_id = $this->input->post('sub_category_id');
    //     // Get the indices for the dynamic chapters
    //     $indices = $this->input->post('indices');

    //     // var_dump($upload_image);
    //     // exit;
    //     if (!empty($indices)) {
    //         echo "in the loop";
    //         exit;
    //         for ($i = 0; $i < count($indices); $i++) {
    //             $data = array(
    //                 'category_id'            => $category_id,
    //                 'sub_category_id'            => $sub_category_id,
    //                 'title'            => $this->input->post('title_' . $indices[$i]),
    //                 'description'      => $this->input->post('description_' . $indices[$i]),
    //                 'solution'         => $this->input->post('solution_' . $indices[$i]),
    //                 'questions_papers' => $this->input->post('questions_papers_' . $indices[$i]),
    //                 'image'            => $files[$i],
    //                 'videos'           => $videofiles[$i],
    //                 'created_on'       => date('Y-m-d H:i:s'),
    //                 'ebook_id'         => $id
    //             );
    //             $this->db->insert('tbl_ebook_chapters', $data);
    //         }
    //     }
    //     // return 1;
    // }
    public function set_ebook_setup_details($upload_image, $upload_image_main, $upload_video)
    {
        // Prepare the data array for the main ebook
        $data = array(
            'category_id'     => $this->input->post('category'),
            'sub_category_id' => $this->input->post('sub_category'),
            'title'           => $this->input->post('book_name'),
            'image'           => $upload_image_main,
            'created_on'      => date('Y-m-d H:i:s')
        );

        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('tbl_ebooks', $data);
        } else {
            $this->db->insert('tbl_ebooks', $data);
            $id = $this->db->insert_id();
        }

        // Split the uploaded images and videos into arrays
        $files = !empty($upload_image) ? explode(',', $upload_image) : [];
        $videofiles = !empty($upload_video) ? explode(',', $upload_video) : [];
        $category_id = $this->input->post('category');
        $sub_category_id = $this->input->post('sub_category');
        $indices = $this->input->post('indices');

        // Validate the 'indices' array and proceed if not empty
        if (!empty($indices)) {
            for ($i = 0; $i < count($indices); $i++) {
                // Use array values only if they exist, else set them to NULL
                $image = array_key_exists($i, $files) ? $files[$i] : null;
                $video = array_key_exists($i, $videofiles) ? $videofiles[$i] : null;

                $data = array(
                    'category_id'       => $category_id,
                    'subcategory_id'    => $sub_category_id,
                    'title'             => $this->input->post('title_' . $indices[$i]),
                    'description'       => $this->input->post('description_' . $indices[$i]),
                    'solution'          => $this->input->post('solution_' . $indices[$i]),
                    'questions_papers'  => $this->input->post('questions_papers_' . $indices[$i]),
                    'image'             => $image,
                    'videos'            => $video,
                    'created_on'        => date('Y-m-d H:i:s'),
                    'ebook_id'          => $id
                );

                $this->db->insert('tbl_ebook_chapters', $data);
            }
            return 1;
        }
    }


    public function get_ebook__cat()
    {
        $this->db->select('*');
        $this->db->where('tbl_ebook_category.status', '1');
        $this->db->where('tbl_ebook_category.is_deleted', '0');
        $this->db->order_by('tbl_ebook_category.id', 'DESC');
        $result = $this->db->get('tbl_ebook_category');
        return $result->result();
    }

    public function get_ebook_sub_cat()
    {
        $this->db->select('tbl_ebook_sub_category.icon as sub_category_icon, tbl_ebook_sub_category.id, tbl_ebook_sub_category.title as sub_category_title, tbl_ebook_category.title as category_title');
        $this->db->where('tbl_ebook_sub_category.status', '1');
        $this->db->where('tbl_ebook_sub_category.is_deleted', '0');
        $this->db->join('tbl_ebook_category', 'tbl_ebook_sub_category.category_id = tbl_ebook_category.id', 'left');
        $this->db->order_by('tbl_ebook_sub_category.id', 'DESC');
        $result = $this->db->get('tbl_ebook_sub_category');
        return $result->result();
    }

    public function get_ebook_setup()
    {
        $this->db->select('tbl_ebooks.id as ebook_id, tbl_ebooks.title as ebook_title, tbl_ebooks.image, tbl_ebook_chapters.id as chapter_id, tbl_ebook_chapters.title as chapter_title, tbl_ebook_chapters.description, tbl_ebook_chapters.solution, tbl_ebook_chapters.questions_papers');
        $this->db->where('tbl_ebooks.status', '1');
        $this->db->where('tbl_ebooks.is_deleted', '0');
        $this->db->join('tbl_ebook_chapters', 'tbl_ebooks.id = tbl_ebook_chapters.ebook_id', 'left');
        $this->db->order_by('tbl_ebooks.id', 'DESC');
        $result = $this->db->get('tbl_ebooks');
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return [];
        }
    }
    public function delete_ebooks_sub_cat($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_ebook_sub_category', $data);
    }

    public function delete_ebooks__cat($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_ebook_category', $data);
    }


    public function get_select_ebooks_sub_cat()
    {
        $this->db->where('tbl_ebook_sub_category.status', '1');
        $this->db->where('tbl_ebook_sub_category.is_deleted', '0');
        $this->db->order_by('tbl_ebook_sub_category.id', 'DESC');
        $result = $this->db->get('tbl_ebook_sub_category');
        return $result->result();
    }

    //duplicate check 

    public function get_duplicate_cat_title()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_ebook_category');
        echo $query->num_rows();
    }

    public function get_duplicate_sub_cat_title()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_ebook_sub_category');
        echo $query->num_rows();
    }

    public function get_duplicate_coupon_name()
    {
        $id = $this->input->post('id');
        $this->db->select('name');
        $this->db->where('name', $this->input->post('name'));
        $this->db->where('is_deleted', '0');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_coupons');
        echo $query->num_rows();
    }

    public function get_duplicate_coupon_code()
    {
        $id = $this->input->post('id');
        $this->db->select('code');
        $this->db->where('code', $this->input->post('code'));
        $this->db->where('is_deleted', '0');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_coupons');
        echo $query->num_rows();
    }

    public function get_details_by_cat($selectedValue)
    {
        $this->db->select('category_id, title,id');
        $this->db->where('category_id', $selectedValue);
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        $this->db->group_by('title');
        $query = $this->db->get('tbl_ebook_sub_category');
        return $query->result();
    }
}
