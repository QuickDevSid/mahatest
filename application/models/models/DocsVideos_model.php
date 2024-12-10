
<?php

class DocsVideos_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }
    var $table = "docs_videos";
  var $select_column = array("id", "type", "source_type", "title", "description", "can_download", "image_url", "pdf_url", "video_source", "video_url", "views_count", "status", "created_at", "source_id","	num_of_questions","time","created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("title", $_POST["search"]["value"]);
        }
        $this->db->order_by('id', 'DESC');
    }

    function make_datatables($condition=null)
    {
        $this->make_query();
        if(isset($condition) && !empty($condition)){
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

    function getAllData(){
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

    function save( $data)
    {
        //return $data;
        if ($this->db->insert('docs_videos', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    function getDocuments(){
        $this->db->select('id, type, title, description, can_download, CONCAT("'.base_url().'","AppAPI/docs_videos/docs/images/",image_url) as image_url, CONCAT("'.base_url().'","AppAPI/docs_videos/docs/pdfs/",pdf_url) as pdf_url, views_count, status, created_at');
        $this->db->where('status','Active');
        $this->db->where('type','Docs');
        $this->db->from("docs_videos");
        $this->db->order_by('created_at','desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getTexts(){
        $this->db->select('id, type, title, description, CONCAT("'.base_url().'","AppAPI/docs_videos/texts/",image_url) as image_url, views_count, status, created_at');
        $this->db->where('status','Active');
        $this->db->where('type','Texts');
        $this->db->from("docs_videos");
        $this->db->order_by('created_at','desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getVideos(){
        $this->db->select('id, type, title, description, CONCAT("'.base_url().'","AppAPI/docs_videos/videos/",image_url) as image_url, video_source, CONCAT("'.base_url().'",video_url) as hosted_video_url, video_url, views_count, status, created_at');
        $this->db->where('status','Active');
        $this->db->where('type','Video');
        $this->db->from("docs_videos");
        $this->db->order_by('created_at','desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function updateViews($id){
        $this->db->set('views_count', 'views_count + 1', FALSE);
        $this->db->where('id', $id);

        if($this->db->update('docs_videos')){
            return true;
        }else{
            return false;
        }
    }
    function update($id,$data)
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
}
