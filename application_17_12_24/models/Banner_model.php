
 <?php

 /**
  * Web Based Software Activation System
  * Developed By
  * Sagar Maher
  * Coding Visions Infotech Pvt. Ltd.
  * http://codingvisions.com/
  * 31/01/2019
  */

 class Banner_model extends CI_Model
 {
   public function __construct()
     {
         $this->load->database();
     }

     var $table = "banner";
      var $select_column = array("banner_id  as id", "banner_image", "status", "created_on", "section_id","sub_section_id","sequence_no");

     function make_query()
     {
         $this->db->select($this->select_column);
         $this->db->from($this->table);

         if (isset($_POST["search"]["value"])) {
             $this->db->like("banner_image", $_POST["search"]["value"]);
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

     //API call - get a licenses record by id

     function getAllData(){
        $this->db->select('banner_id,section_id,status,CONCAT("'.base_url().'","AppAPI/banner-images/",banner_image) as banner_image,sequence_no,sub_section_id,created_on');
        $this->db->where('status','Active');
        $this->db->order_by('sequence_no','asc');
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
         $this->db->where('exam_id', $id);
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
         $this->db->where('exam_id', $id);
         $query = $this->db->get();
         if ($query->num_rows() == 1) {
             return $query->result_array();
         } else {
             return 0;
         }
     }

 }
