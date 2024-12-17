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
    function getAllData(){
        $this->db->select('*');
        $this->db->where('status','Active');
        $this->db->from('tbl_news_category');
       
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    function getAllDataAccordingToCategory($id, $login_id){
        $this->db->select('current_affair_id, sequence_no, category, category.title as category_name, CONCAT("'.base_url().'","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description	, tbl_news.status, DATE_FORMAT(tbl_news.created_at,"%d/%m/%Y") AS created_at, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.id = tbl_news.id AND current_affairs_saved.login_id = '.$login_id.') AS Saved');
        $this->db->where('tbl_news.status','Active');
        $this->db->where('category',$id);
        //$this->db->from($this->table);
        $this->db->from("tbl_news, category");
        $this->db->where('tbl_news.category = category.id ');
        $this->db->order_by('tbl_news.created_at','desc');

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
        if($this->db->insert('tbl_news', $data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function update($id, $data){
        $this->db->where('id', $id);

        //echo $this->db->last_query();die;
        if($this->db->update('tbl_news', $data)){
           // echo $this->db->last_query();die;
            return true;
        }else{
            //echo $this->db->last_query();die;
            return false;
        }
    }

    public function updateViews($id){
        $this->db->set('views', 'views + 1', FALSE);
        $this->db->where('id', $id);

        if($this->db->update('tbl_news')){
           // echo $this->db->last_query();die;
            return true;
        }else{
            //echo $this->db->last_query();die;
            return false;
        }
    }

    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select('id, sequence_no, category, CONCAT("'.base_url().'","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description, status, DATE_FORMAT(created_at,"%d/%m/%Y") AS created_at');
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
        $this->db->select('category.id,category.title as category_name,CONCAT("'.base_url().'","AppAPI/category-icon/",category.icon_img) as category_img,COUNT(tbl_news.category) as total');
        $this->db->from('tbl_news');
        $this->db->join('category','category.id=tbl_news.category','inner');
        $this->db->where('tbl_news.status','Active');
        $this->db->group_by('tbl_news.category');
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
        $this->db->from('tbl_news');
        $this->db->where('tbl_news.status','Active');
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
        $this->db->select('current_affair_id, sequence_no, category, category.title as category_name, CONCAT("'.base_url().'","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description, tbl_news.status, DATE_FORMAT(tbl_news.created_at,"%d/%m/%Y") AS created_at, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.id = tbl_news.id AND current_affairs_saved.login_id = '.$login_id.') AS Saved');
        $this->db->where('tbl_news.status','Active');
        $this->db->from("tbl_news, category");
        $this->db->where('tbl_news.category = category.id ');
        $this->db->order_by('tbl_news.created_at','desc');
        $this->db->limit(2);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getAllDataAccordingToYear($year, $login_id){
        $this->db->select('current_affair_id, sequence_no, category, category.title as category_name, CONCAT("'.base_url().'","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description, tbl_news.status, DATE_FORMAT(tbl_news.created_at,"%d/%m/%Y") AS created_at, (SELECT COUNT(current_affairs_saved.current_affairs_saved_id) as SavedId FROM current_affairs_saved WHERE current_affairs_saved.id = tbl_news.id AND current_affairs_saved.login_id = '.$login_id.') AS Saved');
        $this->db->where('tbl_news.status','Active');
        $this->db->from("tbl_news, category");
        $this->db->where('YEAR(tbl_news.created_at)',$year);
        $this->db->where('tbl_news.category = category.id ');
        $this->db->order_by('tbl_news.created_at','desc');
       
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }


    function getSavedCurrentAffairsDetail($loginId){
        $this->db->select('tbl_news.current_affair_id, sequence_no, category, category.title as category_name, CONCAT("'.base_url().'","AppAPI/current-affairs/",news_image) as news_image, news_title, news_description, tbl_news.status, DATE_FORMAT(tbl_news.created_at,"%d/%m/%Y") AS created_at');
        $this->db->where('tbl_news.status','Active');
        $this->db->from("tbl_news, category, current_affairs_saved");
        $this->db->where('current_affairs_saved.id = tbl_news.current_affair_id');
        $this->db->where('current_affairs_saved.login_id',$loginId);
        $this->db->where('tbl_news.category = category.id ');
        $this->db->order_by('tbl_news.created_at','desc');

        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
}
