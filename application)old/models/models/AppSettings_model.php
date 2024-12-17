
 <?php

 /**
  * Web Based Software Activation System
  * Developed By
  * Sagar Maher
  * Coding Visions Infotech Pvt. Ltd.
  * http://codingvisions.com/
  * 31/01/2019
  */

 class AppSettings_model extends CI_Model
 {
   public function __construct()
     {
         $this->load->database();
     }

     var $table = "app_settings";
      var $select_column = array("id", "key_label", "key_value");

     function make_query()
     {
         $this->db->select($this->select_column);
         $this->db->from($this->table);

         if (isset($_POST["search"]["value"])) {
             $this->db->like("key_label", $_POST["search"]["value"]);
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
        $this->db->select('*');
        $this->db->order_by('id','asc');
        $this->db->from($this->table);
       
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
     public function getRecordById($id)
     {
         $this->db->select($this->select_column);
         $this->db->from($this->table);
         $this->db->where('key_label', $id);
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
         $this->db->where('key_label', $id);
         $query = $this->db->get();
         if ($query->num_rows() == 1) {
             return $query->result_array();
         } else {
             return 0;
         }
     }



     function update($key,$data)
     {

         $this->db->where('key_label', $key);
         if ($this->db->update($this->table, $data)) {
             return "Updated";
         } else {
             return "Failed";
         }
     }
 }
