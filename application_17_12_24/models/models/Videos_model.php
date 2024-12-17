
<?php

class Videos_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "videos";
     var $select_column = array("video_id", "selected_exams_id","payment_status", "output","video_title","video_url","video_duration","video_thumbnail","video_likes","status","recommended_status","created_at","description");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("video_title", $_POST["search"]["value"]);
        }
        $this->db->order_by('video_id', 'DESC');
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

    //API call - get a licenses record by id
    public function getPostById($id)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('video_id', $id);
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
        $this->db->where('video_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where($whereArr);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function save($data)
    {
        if ($this->db->insert('videos', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    function update($id,$data)
    {
        $this->db->where('video_id', $id);
        if ($this->db->update('videos', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }
    
    public function delete($id)
    {
        $this->db->where('video_id', $id);
        if ($this->db->delete('videos')) {
            return true;
        } else {
            return false;
        }
    }
}
