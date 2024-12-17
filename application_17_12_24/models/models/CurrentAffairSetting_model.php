<?php
class CurrentAffairSetting_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    var $table = "exam_section_setting";

    function make_query()
    {
        $this->db->select("*");
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("title", $_POST["search"]["value"]);
        }
        $this->db->order_by('id ', 'DESC');
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
        $this->db->select('id, title, subtitle, CONCAT("'.base_url().'","AppAPI/exam-section-setting/",icon_img) as icon_img, section_title_1, section_title_2, section_title_3, section_title_4, section_title_5, Section, Description, created_at, updated_at');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    public function add($data){
        if($this->db->insert('exam_section_setting', $data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function update($id, $data){
        $this->db->where('id', $id);
        if($this->db->update('exam_section_setting', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function getDataByWhereCondition($whereArr)
    {
        $this->db->select('*');
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

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('exam_section_setting')) {
            return true;
        } else {
            return false;
        }
    }

}
?>