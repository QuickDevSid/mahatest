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
    function getAllData(){
        $this->db->select('*');
        $this->db->where('status','Active');
        $this->db->from($this->table);
       
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    function getAllDataAccordingToCategory($id, $login_id){
        $this->db->select('current_affair_id, sequence_no, category, category.title as category_name, CONCAT("'.base_url().'","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, current_affairs.status, DATE_FORMAT(current_affairs.created_at,"%d/%m/%Y") AS created_at, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.current_affair_id = current_affairs.current_affair_id AND current_affairs_saved.login_id = '.$login_id.') AS Saved');
        $this->db->where('current_affairs.status','Active');
        $this->db->where('category',$id);
        //$this->db->from($this->table);
        $this->db->from("current_affairs, category");
        $this->db->where('current_affairs.category = category.id ');
        $this->db->order_by('current_affairs.created_at','desc');

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
    
    
    public function add($data){
        if($this->db->insert('current_affairs', $data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function update($id, $data){
        $this->db->where('current_affair_id', $id);

        //echo $this->db->last_query();die;
        if($this->db->update('current_affairs', $data)){
           // echo $this->db->last_query();die;
            return true;
        }else{
            //echo $this->db->last_query();die;
            return false;
        }
    }

    public function updateViews($id){
        $this->db->set('views', 'views + 1', FALSE);
        $this->db->where('current_affair_id', $id);

        if($this->db->update('current_affairs')){
           // echo $this->db->last_query();die;
            return true;
        }else{
            //echo $this->db->last_query();die;
            return false;
        }
    }

    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select('current_affair_id, sequence_no, category, CONCAT("'.base_url().'","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, status, DATE_FORMAT(created_at,"%d/%m/%Y") AS created_at');
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
        $this->db->where('status','Active');
        $this->db->where($whereArr);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    public function getDataByGroupByCategoryCondition($limit=false){
        $this->db->select('category.id,category.title as category_name,CONCAT("'.base_url().'","AppAPI/category-icon/",category.icon_img) as category_img,COUNT(current_affairs.category) as total');
        $this->db->from('current_affairs');
        $this->db->join('category','category.id=current_affairs.category','inner');
        $this->db->where('current_affairs.status','Active');
        $this->db->group_by('current_affairs.category');
        $this->db->order_by('current_affair_id','desc');
        if($limit){
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

    public function getDataByGroupByYearCondition($limit=false){
        $this->db->select('Year(created_at) as year,COUNT(created_at) as total');
        $this->db->from('current_affairs');
        $this->db->where('current_affairs.status','Active');
        $this->db->group_by('year');
        $this->db->order_by("YEAR(created_at)", "desc");
        if($limit){
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

    function getRecentData($login_id){
        $this->db->select('current_affair_id, sequence_no, category, category.title as category_name, CONCAT("'.base_url().'","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, current_affairs.status, DATE_FORMAT(current_affairs.created_at,"%d/%m/%Y") AS created_at, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.current_affair_id = current_affairs.current_affair_id AND current_affairs_saved.login_id = '.$login_id.') AS Saved');
        $this->db->where('current_affairs.status','Active');
        $this->db->from("current_affairs, category");
        $this->db->where('current_affairs.category = category.id ');
        $this->db->order_by('current_affairs.created_at','desc');
        $this->db->limit(2);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getAllDataAccordingToYear($year, $login_id){
        $this->db->select('current_affair_id, sequence_no, category, category.title as category_name, CONCAT("'.base_url().'","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, current_affairs.status, DATE_FORMAT(current_affairs.created_at,"%d/%m/%Y") AS created_at, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.current_affair_id = current_affairs.current_affair_id AND current_affairs_saved.login_id = '.$login_id.') AS Saved');
        $this->db->where('current_affairs.status','Active');
        $this->db->from("current_affairs, category");
        $this->db->where('YEAR(current_affairs.created_at)',$year);
        $this->db->where('current_affairs.category = category.id ');
        $this->db->order_by('current_affairs.created_at','desc');
       
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }


    function getSavedCurrentAffairsDetail($loginId){
        $this->db->select('current_affairs.current_affair_id, sequence_no, category, category.title as category_name, CONCAT("'.base_url().'","AppAPI/current-affairs/",current_affair_image) as current_affair_image, current_affair_title, current_affair_description, current_affairs.status, DATE_FORMAT(current_affairs.created_at,"%d/%m/%Y") AS created_at');
        $this->db->where('current_affairs.status','Active');
        $this->db->from("current_affairs, category, current_affairs_saved");
        $this->db->where('current_affairs_saved.current_affair_id = current_affairs.current_affair_id');
        $this->db->where('current_affairs_saved.login_id',$loginId);
        $this->db->where('current_affairs.category = category.id ');
        $this->db->order_by('current_affairs.created_at','desc');

        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
}
