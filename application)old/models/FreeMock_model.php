<?php
require_once 'vendor/autoload.php';
class FreeMock_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function save_free_tests(){        
        $test_id=$this->db->escape_str($_POST['test_id']);
        if($test_id != "" && is_array($test_id) && !empty($test_id)){
            for($i=0;$i<count($test_id);$i++){
                $insert_data = array(
                    'test_id'       =>  $test_id[$i],
                    'created_at'    =>  date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_free_test', $insert_data);
            }
        }
        return 1;
    }

    public function get_is_test_already_set($id){
        $this->db->select('tbl_free_test.*,tbl_test_setups.topic');
        $this->db->join('tbl_test_setups', 'tbl_free_test.test_id = tbl_test_setups.id');
        $this->db->from('tbl_free_test');
        $this->db->where('tbl_free_test.test_id', $id);
        $this->db->where('tbl_free_test.is_deleted', '0');
        $this->db->order_by('tbl_free_test.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();
        if(!empty($query)){
            return 1;
        }else{
            return 0;
        }
    }
    public function get_free_tests(){
        $this->db->select('tbl_free_test.*,tbl_test_setups.topic');
        $this->db->join('tbl_test_setups', 'tbl_free_test.test_id = tbl_test_setups.id');
        $this->db->from('tbl_free_test');
        $this->db->where('tbl_free_test.is_deleted', '0');
        $this->db->order_by('tbl_free_test.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function delete_free_test($id){      
        $this->db->where('id', $id);
        $this->db->update('tbl_free_test', array('is_deleted'=>'1'));
        return 1;
    }
}