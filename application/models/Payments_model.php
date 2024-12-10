<?php 
    class Payments_model extends CI_Model{
        protected $table = 'payments';
        public function __construct()
        {
            $this->load->database();
        }
        public function insert($data){
            if ($this->db->insert($this->table, $data)) {
                return "Inserted";
            } else {
                return "Failed";
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
        public function get_last_id(){
            $query = $this->db->select('id')->order_by('id', 'DESC')->get($this->table);
            if($query->num_rows() > 0){
                return $query->row()->id;
            }
            return 0;
        }
    }
?>