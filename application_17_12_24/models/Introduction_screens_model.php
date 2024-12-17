
<?php

class Introduction_screens_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }

    var $table = "introduction_screens";
     var $select_column = array("id", "title","description", "upload_img", "upload_icon", "created_at");

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
        $this->db->select('id,title,description,CONCAT("'.base_url().'","AppAPI/introduction-screen/images/",upload_img) as upload_img,CONCAT("'.base_url().'","AppAPI/introduction-screen/icon/",upload_icon) as upload_icon,created_at,updated_at');
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

    function save_upload($image, $icon_image, $title, $description,$created_at)
    {
        $data = array('upload_img' => $image, 'upload_icon' => $icon_image, 'created_at' => $created_at, 'title'=>$title,'description'=>$description);
        //return $data;
        if ($this->db->insert('introduction_screens', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }

    function update_upload($id,$image, $icon_image, $title, $description,$updated_On)
    {
        $data = array('upload_img' => $image, 'upload_icon' => $icon_image, 'updated_at' => $updated_On, 'title'=>$title,'description'=>$description);
        //return $data;
        $this->db->where('id', $id);
        if ($this->db->update('introduction_screens', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('introduction_screens')) {
            return true;
        } else {
            return false;
        }
    }
    
}
