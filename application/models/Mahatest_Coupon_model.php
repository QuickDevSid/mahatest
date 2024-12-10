<?php

class Mahatest_Coupon_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    var $table = "tbl_coupons";
    var $select_column = array("id", "type", "name", "code", "discount_type", "discount", "description", "created_on", "is_deleted", "updated_on");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('status', '1');
        $this->db->where('is_deleted', '0');
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

    function getAllData()
    {
        $this->db->select($this->select_column);
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
        $this->db->where('id', $id);
        $this->db->where('status', '1');
        $this->db->where('is_deleted', '0');
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

    function save($data)
    {
        // return $data;
        if ($this->db->insert('tbl_ebook_category', $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    function getDocuments()
    {
        $this->db->select('id, type, title, description, can_download, CONCAT("' . base_url() . '","AppAPI/docs_videos/docs/images/",image_url) as image_url, CONCAT("' . base_url() . '","AppAPI/docs_videos/docs/pdfs/",pdf_url) as pdf_url, views_count, status, created_at');
        $this->db->where('status', 'Active');
        $this->db->where('type', 'Docs');
        $this->db->from("docs_videos");
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getTexts()
    {
        $this->db->select('id, type, title, description, CONCAT("' . base_url() . '","AppAPI/docs_videos/texts/",image_url) as image_url, views_count, status, created_at');
        $this->db->where('status', 'Active');
        $this->db->where('type', 'Texts');
        $this->db->from("docs_videos");
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function getVideos()
    {
        $this->db->select('id, type, title, description, CONCAT("' . base_url() . '","AppAPI/docs_videos/videos/",image_url) as image_url, video_source, CONCAT("' . base_url() . '",video_url) as hosted_video_url, video_url, views_count, status, created_at');
        $this->db->where('status', 'Active');
        $this->db->where('type', 'Video');
        $this->db->from("docs_videos");
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function updateViews($id)
    {
        $this->db->set('views_count', 'views_count + 1', FALSE);
        $this->db->where('id', $id);

        if ($this->db->update('docs_videos')) {
            return true;
        } else {
            return false;
        }
    }
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->where('status', '1');
        $this->db->where('is_deleted', '0');
        if ($this->db->update($this->table, $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_single_coupon()
    {
        $this->db->where('tbl_coupons.is_deleted', '0');
        $this->db->where('tbl_coupons.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_coupons');
        $result = $result->row();
        return $result;
    }

    public function set_coupon_details()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'code' => $this->input->post('code'),
            'discount_type' => $this->input->post('discount_type'),
            'discount' => $this->input->post('discount'),
            'description' => $this->input->post('description'),
            'created_on' => date('Y-m-d H:i:s')
        );

        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('tbl_coupons', $data);
            return 2;
        } else {
            $this->db->insert('tbl_coupons', $data);
            return 1;
        }
    }

    public function get_coupon()
    {
        $this->db->select('*');
        $this->db->where('tbl_coupons.is_deleted', '0');
        $this->db->order_by('tbl_coupons.id', 'DESC');
        $result = $this->db->get('tbl_coupons');
        return $result->result();
    }
    public function delete_coupon($id)
    {
        $data = array(
            'is_deleted' => 0
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_coupons', $data);
    }

    public function get_select_ebooks_sub_cat()
    {
        $this->db->where('tbl_ebook_sub_category.status', '1');
        $this->db->where('tbl_ebook_sub_category.is_deleted', '0');
        $this->db->order_by('tbl_ebook_sub_category.id', 'DESC');
        $result = $this->db->get('tbl_ebook_sub_category');
        return $result->result();
    }
}
