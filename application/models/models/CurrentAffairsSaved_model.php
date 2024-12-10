<?php
class CurrentAffairsSaved_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    var $table = "current_affairs_saved";

    function make_query()
    {
        $this->db->select("*");
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("login_id", $_POST["search"]["value"]);
        }
        $this->db->order_by('current_affairs_saved_id', 'DESC');
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

    public function getPostById($id)
    {
        $this->db->select('current_affairs_saved_id, current_affair_id, login_id, status, created_at, updated_on');
        $this->db->from($this->table);
        $this->db->where('login_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    public function add($data){
        if($this->db->insert('current_affairs_saved', $data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function update($id, $data){
        $this->db->where('current_affairs_saved_id', $id);
        if($this->db->update('current_affairs_saved', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select('*');
        $this->db->from('current_affairs_saved');
        $this->db->where($whereArr);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return 0;
        }


    }

    public function delete($id)
    {
        $this->db->where('current_affairs_saved_id', $id);
        if ($this->db->delete('current_affairs_saved')) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteWhere($whereArr)
    {
        $this->db->where($whereArr);
        if ($this->db->delete('current_affairs_saved')) {
            return true;
        } else {
            return false;
        }
    }
}
?>