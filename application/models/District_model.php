
<?php
class District_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    
    public function getDistrictList($id){
        $this->db->select('district_id,district_name');
        $this->db->where('state_id',$id);
        $this->db->from('district_list');
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