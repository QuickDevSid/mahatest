<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class CurrentAffairs_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    var $table = "current_affairs";

    function make_query()
    {
        $this->db->select("*");
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("current_affair_title", $_POST["search"]["value"]);
        }
        $this->db->order_by('current_affair_id ', 'DESC');
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
        $this->db->from($this->table);

        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    function getAllDataAccordingToCategory($id, $login_id)
    {
        $this->db->select('current_affair_id, sequence_no, category, category.title as category_name, CONCAT("' . base_url() . '","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, current_affairs.status, DATE_FORMAT(current_affairs.created_on,"%d/%m/%Y") AS created_on, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.current_affair_id = current_affairs.current_affair_id AND current_affairs_saved.login_id = ' . $login_id . ') AS Saved');
        $this->db->where('current_affairs.status', 'Active');
        $this->db->where('category', $id);
        //$this->db->from($this->table);
        $this->db->from("current_affairs, category");
        $this->db->where('current_affairs.category = category.id ');
        $this->db->order_by('current_affairs.created_on', 'desc');

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
        $this->db->where('current_affair_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getPostById_D($id)
    {
        $this->db->select("current_affairs.*, category.title as category_name");
        $this->db->from("current_affairs, category");
        $this->db->where('current_affairs.category = category.id ');
        $this->db->where('current_affair_id', $id);
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
        $this->db->where('current_affair_id', $id);
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
        if ($this->db->insert('current_affairs', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $data)
    {
        $this->db->where('current_affair_id', $id);

        //echo $this->db->last_query();die;
        if ($this->db->update('current_affairs', $data)) {
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
        $this->db->where('current_affair_id', $id);

        if ($this->db->update('current_affairs')) {
            // echo $this->db->last_query();die;
            return true;
        } else {
            //echo $this->db->last_query();die;
            return false;
        }
    }

    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select('current_affair_id, sequence_no, category, CONCAT("' . base_url() . '","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, status, DATE_FORMAT(created_on,"%d/%m/%Y") AS created_on');
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
        $this->db->select('category.id,category.title as category_name,CONCAT("' . base_url() . '","AppAPI/category-icon/",category.icon_img) as category_img,COUNT(current_affairs.category) as total');
        $this->db->from('current_affairs');
        $this->db->join('category', 'category.id=current_affairs.category', 'inner');
        $this->db->where('current_affairs.status', 'Active');
        $this->db->group_by('current_affairs.category');
        $this->db->order_by('current_affair_id', 'desc');
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
        $this->db->from('current_affairs');
        $this->db->where('current_affairs.status', 'Active');
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
        $this->db->select('current_affair_id, sequence_no, category, category.title as category_name, CONCAT("' . base_url() . '","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, current_affairs.status, DATE_FORMAT(current_affairs.created_on,"%d/%m/%Y") AS created_on, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.current_affair_id = current_affairs.current_affair_id AND current_affairs_saved.login_id = ' . $login_id . ') AS Saved');
        $this->db->where('current_affairs.status', 'Active');
        $this->db->from("current_affairs, category");
        $this->db->where('current_affairs.category = category.id ');
        $this->db->order_by('current_affairs.created_on', 'desc');
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
        $this->db->select('current_affair_id, sequence_no, category, category.title as category_name, CONCAT("' . base_url() . '","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, current_affairs.status, DATE_FORMAT(current_affairs.created_on,"%d/%m/%Y") AS created_on, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.current_affair_id = current_affairs.current_affair_id AND current_affairs_saved.login_id = ' . $login_id . ') AS Saved');
        $this->db->where('current_affairs.status', 'Active');
        $this->db->from("current_affairs, category");
        $this->db->where('YEAR(current_affairs.created_on)', $year);
        $this->db->where('current_affairs.category = category.id ');
        $this->db->order_by('current_affairs.created_on', 'desc');

        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }


    function getSavedCurrentAffairsDetail($loginId)
    {
        $this->db->select('current_affairs.current_affair_id, sequence_no, category, category.title as category_name, CONCAT("' . base_url() . '","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, current_affairs.status, DATE_FORMAT(current_affairs.created_on,"%d/%m/%Y") AS created_on');
        $this->db->where('current_affairs.status', 'Active');
        $this->db->from("current_affairs, category, current_affairs_saved");
        $this->db->where('current_affairs_saved.current_affair_id = current_affairs.current_affair_id');
        $this->db->where('current_affairs_saved.login_id', $loginId);
        $this->db->where('current_affairs.category = category.id ');
        $this->db->order_by('current_affairs.created_on', 'desc');

        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function get_single_current_affairs_category($id)
    {

        $this->db->where('current_affairs_category.id', $id);
        $result = $this->db->get('current_affairs_category')->row();
        return $result;
    }
    public function get_current_affairs_category()
    {
        $this->db->order_by('current_affairs_category.id', 'desc');
        $this->db->where('current_affairs_category.is_deleted', '0');
        $result = $this->db->get('current_affairs_category')->result();
        return $result;
    }
    public function add_current_affairs_category()
    {
        $category_name = $this->db->escape_str($_POST['category_name']);
        $hidden_id = $this->db->escape_str($_POST['hidden_id']);
        if ($hidden_id == '') {
            $array = array(
                'category_name' =>  $category_name,
                'created_on'    =>  date('Y-m-d H:i:s')
            );
            $this->db->insert('current_affairs_category', $array);
        } else {
            $array = array(
                'category_name' =>  $category_name
            );
            $this->db->where('id', $hidden_id);
            $this->db->update('current_affairs_category', $array);
        }
        return 1;
    }

    public function delete_current_affairs_category($id)
    {
        $this->db->where('id', $id);
        $this->db->update('current_affairs_category', array('is_deleted' => '1'));
        return 1;
    }

    public function check_unique_current_affair_category()
    {
        $name = $this->input->post('name');
        $id = $this->input->post('id');

        if ($id != "") {
            $this->db->where('current_affairs_category.id !=', $id);
        }
        $this->db->where('current_affairs_category.category_name', $name);
        $this->db->where('current_affairs_category.is_deleted', '0');
        $result = $this->db->get('current_affairs_category')->result();
        // echo '<pre>'; print_r($name);
        // echo '<pre>'; print_r($id);
        if (!empty($result)) {
            echo '0';
        } else {
            echo '1';
        }
    }
    public function get_course_tests()
    {
        $this->db->where('current_affairs_category.tests !=', null);
        $this->db->where('current_affairs_category.is_deleted', '0');
        $result = $this->db->get('current_affairs_category')->result();
        return $result;
    }
    public function get_single_course_tests($id)
    {
        $this->db->where('current_affairs_category.id', $id);
        $this->db->where('current_affairs_category.is_deleted', '0');
        $result = $this->db->get('current_affairs_category')->row();
        return $result;
    }
    public function save_course_tests()
    {
        $category_id = $this->db->escape_str($_POST['category_id']);
        $hidden_id = $this->db->escape_str($_POST['hidden_id']);
        $test_id = $this->db->escape_str($_POST['test_id']);
        if ($test_id != "" && is_array($test_id) && !empty($test_id)) {
            $test_id = implode(',', $test_id);
        } else {
            $test_id = '';
        }
        $this->db->where('id', $category_id);
        $this->db->update('current_affairs_category', array('tests' => $test_id));
        return 1;
    }

    public function delete_test($id)
    {
        $this->db->where('id', $id);
        $this->db->update('current_affairs_category', array('tests' => null));
        return 1;
    }
    public function get_category_tests_ajax()
    {
        $category_id = $this->input->post('category_id');
        $id = $this->input->post('id');

        if ($id != "") {
            $this->db->where('current_affairs_category.id !=', $id);
        }
        $this->db->where('current_affairs_category.id', $category_id);
        $this->db->where('current_affairs_category.tests !=', null);
        $this->db->where('current_affairs_category.is_deleted', '0');
        $result = $this->db->get('current_affairs_category')->result();
        if (!empty($result)) {
            echo '0';
        } else {
            echo '1';
        }
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
    public function get_tests()
    {
        $this->db->order_by('tbl_test_setups.id', 'desc');
        $this->db->where('tbl_test_setups.is_deleted', '0');
        $result = $this->db->get('tbl_test_setups')->result();
        return $result;
    }


    public function get_single_current_affairs()
    {
        $this->db->where('current_affairs.is_deleted', '0');
        $this->db->where('current_affairs.new_status', '1');
        // $this->db->where('current_affairs.status', 'Active');
        $this->db->where('current_affairs.current_affair_id', $this->uri->segment(3));
        $result = $this->db->get('current_affairs');
        $result = $result->row();
        return $result;
    }

    public function set_current_affairs_details($upload_image)
    {
        // Debugging input data (remove these in production)
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "<pre>";
        // exit;

        // Prepare data to insert/update
        $data = array(
            'current_affair_image' => $upload_image,
            'category' => $this->input->post('category'),
            'current_affair_title' => $this->input->post('title'),
            'current_affair_description' => $this->input->post('description'),
            'date' => $this->input->post('date'),
            'status' => $this->input->post('status'),
            'created_on' => date('Y-m-d H:i:s'),
        );

        $id = $this->input->post('id'); // Check if updating or inserting
        $sequence_no = $this->input->post('sequence_no'); // Sequence number from input

        if ($id) {
            // Update existing record logic
            // echo "into update";
            // exit;
            // Fetch the existing record's current sequence_no
            $this->db->select('sequence_no');
            $this->db->from('current_affairs');
            $this->db->where('current_affair_id', $id);
            $query = $this->db->get();
            $existingRecord = $query->row();

            if ($existingRecord) {
                // echo "into exist";exit;
                $currentSequenceNo = $existingRecord->sequence_no;
                // echo $currentSequenceNo;exit;
                $newSequenceNo = $this->input->post('sequence_no');
                // echo $newSequenceNo;exit;

                if ($currentSequenceNo != $newSequenceNo) {
                    // echo "into not equal to current sequence";exit;

                    // Increment sequence_no for affected rows between the old and new positions
                    if ($newSequenceNo < $currentSequenceNo) {
                        // If moving up (e.g., from 2 to 1)
                        $this->db->set('sequence_no', 'sequence_no + 1', FALSE);
                        $this->db->where('sequence_no >=', $newSequenceNo);
                        $this->db->where('sequence_no <', $currentSequenceNo);
                        $this->db->update('current_affairs');
                    } else {
                        // If moving down (e.g., from 2 to 4)
                        $this->db->set('sequence_no', 'sequence_no - 1', FALSE);
                        $this->db->where('sequence_no <=', $newSequenceNo);
                        $this->db->where('sequence_no >', $currentSequenceNo);
                        $this->db->update('current_affairs');
                    }
                }
                // echo "outside";exit;

                // Update the current record with the new sequence_no and other details
                $data['sequence_no'] = $newSequenceNo;
                $this->db->where('current_affair_id', $id);
                $this->db->update('current_affairs', $data);
                return 0; // Indicate update
            }
        } else {
            // echo "into insert";
            // exit;
            $this->db->select('current_affair_id');
            $this->db->from('current_affairs');
            $this->db->where('sequence_no', $sequence_no);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $this->db->set('sequence_no', 'sequence_no + 1', FALSE); // Increment sequence_no by 1
                $this->db->where('sequence_no >=', $sequence_no);
                $this->db->update('current_affairs');
            }
            $data['sequence_no'] = $sequence_no;
            $this->db->insert('current_affairs', $data);
            return 1; // Indicating successful insert
        }
    }

    public function get_select_category()
    {
        $this->db->where('current_affairs_category.status', '1');
        $this->db->where('current_affairs_category.is_deleted', '0');
        $this->db->order_by('current_affairs_category.id', 'DESC');
        $result = $this->db->get('current_affairs_category');
        return $result->result();
    }

    public function get_single_current_affairs_list()
    {
        $this->db->where('is_deleted', '0');
        $this->db->where('new_status', '1');
        // $this->db->where('status', 'Active');
        $this->db->order_by('sequence_no', 'ASC');
        $result = $this->db->get('current_affairs');
        return $result->result();
    }

    public function delete_manage_current_affairs_form($id)
    {
        $id = $this->uri->segment(3);
        $data = array(
            'new_status' => 0,
            'is_deleted' => 1,
            'status' => 'Inactive'
        );
        $this->db->where('current_affair_id', $id);
        $this->db->update('current_affairs', $data);
    }

    public function manage_current_affairs_form_active($id)
    {
        // $id = $this->uri->segment(3);
        // echo "into active";exit;
        $data = array(
            'status' => 'Active'
        );
        $this->db->where('current_affair_id', $id);
        $this->db->update('current_affairs', $data);
    }

    public function manage_current_affairs_form_inactive($id)
    {
        // $id = $this->uri->segment(3);
        // echo "into inactive";exit;
        $data = array(
            'status' => 'Inactive'
        );
        $this->db->where('current_affair_id', $id);
        $this->db->update('current_affairs', $data);
    }

    public function get_duplicate_current_affair_title()
    {
        $id = $this->input->post('id');
        $this->db->select('current_affair_title');
        $this->db->where('current_affair_title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('current_affairs');
        echo $query->num_rows();
    }
}
