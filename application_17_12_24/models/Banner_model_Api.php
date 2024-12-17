<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class Banner_model_Api extends CI_Model
{
    
    public function __construct()
    {
        $this->load->database();
    }
    
    function save_upload($image, $banner_status, $bannerOn, $section_id,$sub_section_id,$sequence)
    {
        $data = array('banner_image' => $image, 'status' => $banner_status, 'created_on' => $bannerOn, 'sequence_no'=>$sequence,'section_id'=>$section_id,'sub_section_id'=>$sub_section_id);
        
        if ($this->db->insert('banner', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }
    
    public function getbannerbyid($id)
    {
        //echo $id;
        //$this->load->model("CurrentAffairs_model");
        $this->db->select('banner_id,CONCAT("'.base_url().'","AppAPI/banner-images/",banner_image) as banner_image,banner_image as image_name,status,created_on,section_id,sub_section_id,sequence_no');
        $this->db->from('banner');
        $this->db->where('banner_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    
    function update_upload($id, $image, $e_status, $section_id,$sub_section_id,$sequence)
    {
        $data = array('banner_image' => $image, 'status' => $e_status, 'section_id'=>$section_id,'sub_section_id'=>$sub_section_id,'sequence_no'=>$sequence);
        $this->db->where('banner_id', $id);
        if ($this->db->update('banner', $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }
    
    public function delete($id)
    {
        $this->db->where('banner_id', $id);
        if ($this->db->delete('banner')) {
            return true;
        } else {
            return false;
        }
    }
    
    
}
