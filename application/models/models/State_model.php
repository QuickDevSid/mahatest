
<?php
class State_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    
    public function getStateList(){
        $this->db->select('state_id,state_name');
        $this->db->from('state_list');
        $query = $this->db->get();
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
        return 0;
        }
    }

    
}

?>