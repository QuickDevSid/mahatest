<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class news_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    var $table = "tbl_news";

    function make_query()
    {
        $this->db->select("*");
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("news_title", $_POST["search"]["value"]);
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
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    //API call - get a licenses record by id
    function getAllData()
    {
        $this->db->select('*');
        $this->db->where('status', 'Active');
        $this->db->from('tbl_news_category');

        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    function getAllDataAccordingToCategory($id, $login_id)
    {
        $this->db->select('id, sequence_no, category, category.title as category_name, CONCAT("' . base_url() . '","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description	, tbl_news.status, DATE_FORMAT(tbl_news.created_on,"%d/%m/%Y") AS created_on, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.id = tbl_news.id AND current_affairs_saved.login_id = ' . $login_id . ') AS Saved');
        $this->db->where('tbl_news.status', 'Active');
        $this->db->where('category', $id);
        //$this->db->from($this->table);
        $this->db->from("tbl_news, category");
        $this->db->where('tbl_news.category = category.id ');
        $this->db->order_by('tbl_news.created_on', 'desc');

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    public function getPostById($id)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getPostById_D($id)
    {
        $this->db->select("tbl_news.*, category.title as category_name");
        $this->db->from("tbl_news, category");
        $this->db->where('tbl_news.category = category.id ');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getPostComment($id)
    {
        $this->db->select("current_affairs_comments_id, comment_body, comment_status, date, time, current_affairs_comments.status, user_login.full_name, user_login.profile_image");
        $this->db->from("current_affairs_comments, user_login ");
        $this->db->where('user_login.login_id  = current_affairs_comments.login_id');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    //API call - get a licenses record by id
    public function getExams()
    {
        $this->db->select("*");
        $this->db->from("exams");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }


    public function add($data)
    {
        if ($this->db->insert('tbl_news', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);

        //echo $this->db->last_query();die;
        if ($this->db->update('tbl_news', $data)) {
            // echo $this->db->last_query();die;
            return true;
        } else {
            //echo $this->db->last_query();die;
            return false;
        }
    }

    public function updateViews($id)
    {
        $this->db->set('views', 'views + 1', FALSE);
        $this->db->where('id', $id);

        if ($this->db->update('tbl_news')) {
            // echo $this->db->last_query();die;
            return true;
        } else {
            //echo $this->db->last_query();die;
            return false;
        }
    }

    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select('id, sequence_no, category, CONCAT("' . base_url() . '","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description, status, DATE_FORMAT(created_on,"%d/%m/%Y") AS created_on');
        $this->db->from($this->table);
        $this->db->where($whereArr);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    public function getAllDataByWhereCondition($whereArr)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'Active');
        $this->db->where($whereArr);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    public function getDataByGroupByCategoryCondition($limit = false)
    {
        $this->db->select('category.id,category.title as category_name,CONCAT("' . base_url() . '","AppAPI/category-icon/",category.icon_img) as category_img,COUNT(tbl_news.category) as total');
        $this->db->from('tbl_news');
        $this->db->join('category', 'category.id=tbl_news.category', 'inner');
        $this->db->where('tbl_news.status', 'Active');
        $this->db->group_by('tbl_news.category');
        $this->db->order_by('id', 'desc');
        if ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getDataByGroupByYearCondition($limit = false)
    {
        $this->db->select('Year(created_on) as year,COUNT(created_on) as total');
        $this->db->from('tbl_news');
        $this->db->where('tbl_news.status', 'Active');
        $this->db->group_by('year');
        $this->db->order_by("YEAR(created_on)", "desc");
        if ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getRecentData($login_id)
    {
        $this->db->select('id, sequence_no, category, category.title as category_name, CONCAT("' . base_url() . '","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description, tbl_news.status, DATE_FORMAT(tbl_news.created_on,"%d/%m/%Y") AS created_on, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.id = tbl_news.id AND current_affairs_saved.login_id = ' . $login_id . ') AS Saved');
        $this->db->where('tbl_news.status', 'Active');
        $this->db->from("tbl_news, category");
        $this->db->where('tbl_news.category = category.id ');
        $this->db->order_by('tbl_news.created_on', 'desc');
        $this->db->limit(2);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getAllDataAccordingToYear($year, $login_id)
    {
        $this->db->select('id, sequence_no, category, category.title as category_name, CONCAT("' . base_url() . '","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description, tbl_news.status, DATE_FORMAT(tbl_news.created_on,"%d/%m/%Y") AS created_on, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.id = tbl_news.id AND current_affairs_saved.login_id = ' . $login_id . ') AS Saved');
        $this->db->where('tbl_news.status', 'Active');
        $this->db->from("tbl_news, category");
        $this->db->where('YEAR(tbl_news.created_on)', $year);
        $this->db->where('tbl_news.category = category.id ');
        $this->db->order_by('tbl_news.created_on', 'desc');

        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }


    function getSavedCurrentAffairsDetail($loginId)
    {
        $this->db->select('tbl_news.id, sequence_no, category, category.title as category_name, CONCAT("' . base_url() . '","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description, tbl_news.status, DATE_FORMAT(tbl_news.created_on,"%d/%m/%Y") AS created_on');
        $this->db->where('tbl_news.status', 'Active');
        $this->db->from("tbl_news, category, current_affairs_saved");
        $this->db->where('current_affairs_saved.id = tbl_news.id');
        $this->db->where('current_affairs_saved.login_id', $loginId);
        $this->db->where('tbl_news.category = category.id ');
        $this->db->order_by('tbl_news.created_on', 'desc');

        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }




    // public function get_single_news_category($id)
    // {
    //     $this->db->where('tbl_news_category.id', $id);
    //     $result = $this->db->get('tbl_news_category')->row();
    //     return $result;
    // }
    public function get_news_category()
    {
        $this->db->order_by('tbl_news_category.id', 'desc');
        $this->db->where('tbl_news_category.is_deleted', '0');
        $result = $this->db->get('tbl_news_category')->result();
        return $result;
    }
    public function add_news_category()
    {
        $category_name = $this->db->escape_str($_POST['category_name']);
        $hidden_id = $this->db->escape_str($_POST['hidden_id']);
        if ($hidden_id == '') {
            $array = array(
                'title'         =>  $category_name,
                'created_at'    =>  date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_news_category', $array);
        } else {
            $array = array(
                'title'         =>  $category_name
            );
            $this->db->where('id', $hidden_id);
            $this->db->update('tbl_news_category', $array);
        }
        return 1;
    }

    public function delete_news_category($id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_news_category', array('is_deleted' => '1'));
        return 1;
    }

    public function check_unique_news_category()
    {
        $name = $this->input->post('name');
        $id = $this->input->post('id');

        if ($id != "") {
            $this->db->where('tbl_news_category.id !=', $id);
        }
        $this->db->where('tbl_news_category.title', $name);
        $this->db->where('tbl_news_category.is_deleted', '0');
        $result = $this->db->get('tbl_news_category')->result();
        // echo '<pre>'; print_r($name);
        // echo '<pre>'; print_r($id);
        if (!empty($result)) {
            echo '0';
        } else {
            echo '1';
        }
    }

    public function get_single_news()
    {
        $this->db->where('tbl_news.is_deleted', '0');
        $this->db->where('tbl_news.status', '1');
        $this->db->where('tbl_news.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_news');
        $result = $result->row();
        return $result;
    }

    public function set_news_details($upload_image)
    {
        $data = array(
            // 'id' => '12',
            'news_title' => $this->input->post('title'),
            'category' => $this->input->post('category_title'),
            'date' => $this->input->post('date') ? date('Y-m-d', strtotime($this->input->post('date'))) : null,
            'news_description' => $this->input->post('description'),
            'news_image' => $upload_image,
            'created_on' => date('Y-m-d H:i:s')
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
            $this->db->update('tbl_news', $data);
            return 2;
        } else {
            // echo "insert";
            // exit;

            try {
                $last_sequence_no = $this->db->select('sequence_no')->order_by('sequence_no', 'DESC')->limit(1)->get('tbl_news')->row_array();
                $sequence_no = $last_sequence_no ? $last_sequence_no['sequence_no'] + 1 : 1;
                $data['sequence_no'] = $sequence_no;

                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $data[$key] = implode(', ', $value);
                    }
                }
                if (!$this->db->insert('tbl_news', $data)) {
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

    public function get_select_news()
    {
        $this->db->where('tbl_news_category.status', '1');
        $this->db->where('tbl_news_category.is_deleted', '0');
        $this->db->order_by('tbl_news_category.id', 'DESC');
        $result = $this->db->get('tbl_news_category');
        return $result->result();
    }



    public function get_single_news_list()
    {
        $this->db->select('*');
        $this->db->where('tbl_news.status', '1');
        $this->db->where('tbl_news.is_deleted', '0');
        $this->db->order_by('tbl_news.sequence_no', 'ASC');
        $result = $this->db->get('tbl_news');
        return $result->result();
    }

    public function update_shift_sequence()
    {
        $sequence_no = $this->input->post('sequence_no');

        if (!empty($sequence_no)) {
            foreach ($sequence_no as $item) {
                if (isset($item['id']) && isset($item['sequence_no'])) {
                    $this->db->where('id', $item['id']);
                    $this->db->update('tbl_news', ['sequence_no' => $item['sequence_no']]);
                }
            }
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data received']);
        }
    }

    public function delete_news_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('tbl_news', $data);
    }

    public function get_duplicate_title_check()
    {
        $id = $this->input->post('id');
        $this->db->select('news_title');
        $this->db->where('news_title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_news');
        echo $query->num_rows();
    }

    public function get_single_news_category()
    {
        $this->db->where('tbl_news_category.is_deleted', '0');
        $this->db->where('tbl_news_category.status', '1');
        $this->db->where('tbl_news_category.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_news_category');
        $result = $result->row();
        return $result;
    }

    public function set_news_cat_details($upload_image)
    {
        $data = array(
            'title' => $this->input->post('title'),
            'section' => 'News',
            'icon_img' => $upload_image,
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
            $this->db->update('tbl_news_category', $data);
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
                if (!$this->db->insert('tbl_news_category', $data)) {
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

    public function get_duplicate_title_cat_check()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_news_category');
        echo $query->num_rows();
    }

    public function get_single_news_cat_list()
    {
        $this->db->select('*');
        $this->db->where('tbl_news_category.status', 'Active');
        $this->db->where('tbl_news_category.is_deleted', '0');
        $this->db->order_by('tbl_news_category.id', 'DESC');
        $result = $this->db->get('tbl_news_category');
        return $result->result();
    }

    public function delete_news_categorys_list($id)
    {
        $data = array(
            'status' => 'Inactive',
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('tbl_news_category', $data);
    }
}
