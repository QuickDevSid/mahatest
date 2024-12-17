
<?php

class FAQ_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "faq_details";
     var $select_column = array("id", "title","description", "created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

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

    function save_faq( $title, $description,$created_at)
    {
        $data = array( 'created_at' => $created_at, 'title'=>$title,'description'=>$description);
        //return $data;
        if ($this->db->insert('faq_details', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    function update_faq($id, $title, $description,$updated_On)
    {
        $data = array( 'updated_at' => $updated_On, 'title'=>$title,'description'=>$description);
        //return $data;
        $this->db->where('id', $id);
        if ($this->db->update('faq_details', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('faq_details')) {
            return true;
        } else {
            return false;
        }
    }
    
}
