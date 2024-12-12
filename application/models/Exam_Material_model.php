<?php

class Exam_Material_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_single_exam_subject()
    {
        $this->db->where('tbl_exam_material_subjects.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjects.status', '1');
        $this->db->where('tbl_exam_material_subjects.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_exam_material_subjects');
        $result = $result->row();
        return $result;
    }

    public function get_duplicate_exam_subject_title()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_exam_material_subjects');
        echo $query->num_rows();
    }

    public function set_exam_subject_details($upload_image)
    {
        $data = array(
            'title' => $this->input->post('title'),
            'short_description' => $this->input->post('title'),
            'icon' => $upload_image,
            'created_on' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;
        $id = $this->input->post('id');
        // echo $id;
        // exit;
        if ($id) {
            // echo "update";
            // exit;
            $this->db->where('id', $id);
            $this->db->update('tbl_exam_material_subjects', $data);
            return 2;
        } else {
            // echo "insert";
            // exit;
            try {
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $data[$key] = implode(', ', $value);
                    }
                }
                if (!$this->db->insert('tbl_exam_material_subjects', $data)) {
                    $error = $this->db->error();
                    echo "Database Error: " . $error['message'];
                    log_message('error', 'Insert failed: ' . $error['message']);
                } else {
                    return 1;
                }
            } catch (Exception $e) {
                log_message('error', 'Exception caught during insert: ' . $e->getMessage());
                echo "Exception caught: " . $e->getMessage();
                exit;
            }
            return 1;
        }
    }

    public function get_single_subject_list()
    {
        $this->db->select('*');
        $this->db->where('tbl_exam_material_subjects.status', '1');
        $this->db->where('tbl_exam_material_subjects.is_deleted', '0');
        $this->db->order_by('tbl_exam_material_subjects.id', 'DESC');
        $result = $this->db->get('tbl_exam_material_subjects');
        return $result->result();
    }

    public function delete_subject_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('tbl_exam_material_subjects', $data);
    }

    public function get_single_exam()
    {
        $this->db->where('tbl_exam_material_exams.is_deleted', '0');
        $this->db->where('tbl_exam_material_exams.status', '1');
        $this->db->where('tbl_exam_material_exams.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_exam_material_exams');
        $result = $result->row();
        return $result;
    }

    public function get_duplicate_exam_title()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_exam_material_exams');
        echo $query->num_rows();
    }

    public function set_exam_exam_details($upload_image)
    {
        $data = array(
            'title' => $this->input->post('title'),
            'short_description' => $this->input->post('title'),
            'icon' => $upload_image,
            'created_on' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;
        $id = $this->input->post('id');
        // echo $id;
        // exit;
        if ($id) {
            // echo "update";
            // exit;
            $this->db->where('id', $id);
            $this->db->update('tbl_exam_material_exams', $data);
            return 2;
        } else {
            // echo "insert";
            // exit;
            try {
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $data[$key] = implode(', ', $value);
                    }
                }
                if (!$this->db->insert('tbl_exam_material_exams', $data)) {
                    $error = $this->db->error();
                    echo "Database Error: " . $error['message'];
                    log_message('error', 'Insert failed: ' . $error['message']);
                } else {
                    return 1;
                }
            } catch (Exception $e) {
                log_message('error', 'Exception caught during insert: ' . $e->getMessage());
                echo "Exception caught: " . $e->getMessage();
                exit;
            }
            return 1;
        }
    }

    public function get_single_exam_list()
    {
        $this->db->select('*');
        $this->db->where('tbl_exam_material_exams.status', '1');
        $this->db->where('tbl_exam_material_exams.is_deleted', '0');
        $this->db->order_by('tbl_exam_material_exams.id', 'DESC');
        $result = $this->db->get('tbl_exam_material_exams');
        return $result->result();
    }

    public function delete_exam_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('tbl_exam_material_exams', $data);
    }

    public function get_single_exam_sub()
    {
        $this->db->where('tbl_exam_material_exam_types.is_deleted', '0');
        $this->db->where('tbl_exam_material_exam_types.status', '1');
        $this->db->where('tbl_exam_material_exam_types.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_exam_material_exam_types');
        $result = $result->row();
        return $result;
    }

    public function get_duplicate_exam_sub_title()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_exam_material_exam_types');
        echo $query->num_rows();
    }

    public function set_exam_sub_details($upload_image)
    {
        $data = array(
            'title' => $this->input->post('title'),
            'short_description' => $this->input->post('title'),
            'icon' => $upload_image,
            'created_on' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;
        $id = $this->input->post('id');
        // echo $id;
        // exit;
        if ($id) {
            // echo "update";
            // exit;
            $this->db->where('id', $id);
            $this->db->update('tbl_exam_material_exam_types', $data);
            return 2;
        } else {
            // echo "insert";
            // exit;
            try {
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $data[$key] = implode(', ', $value);
                    }
                }
                if (!$this->db->insert('tbl_exam_material_exam_types', $data)) {
                    $error = $this->db->error();
                    echo "Database Error: " . $error['message'];
                    log_message('error', 'Insert failed: ' . $error['message']);
                } else {
                    return 1;
                }
            } catch (Exception $e) {
                log_message('error', 'Exception caught during insert: ' . $e->getMessage());
                echo "Exception caught: " . $e->getMessage();
                exit;
            }
            return 1;
        }
    }

    public function get_single_exam_sub_list()
    {
        $this->db->select('*');
        $this->db->where('tbl_exam_material_exam_types.status', '1');
        $this->db->where('tbl_exam_material_exam_types.is_deleted', '0');
        $this->db->order_by('tbl_exam_material_exam_types.id', 'DESC');
        $result = $this->db->get('tbl_exam_material_exam_types');
        return $result->result();
    }

    public function delete_exam_sub_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('tbl_exam_material_exam_types', $data);
    }

    public function get_single_exam_year()
    {
        $this->db->where('tbl_exam_material_exam_years.is_deleted', '0');
        $this->db->where('tbl_exam_material_exam_years.status', '1');
        $this->db->where('tbl_exam_material_exam_years.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_exam_material_exam_years');
        $result = $result->row();
        return $result;
    }

    public function get_duplicate_exam_year_title()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('tbl_exam_material_exam_years');
        echo $query->num_rows();
    }

    public function set_exam_year_details()
    {
        $data = array(
            'title' => $this->input->post('title'),
            'created_on' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;
        $id = $this->input->post('id');
        // echo $id;
        // exit;
        if ($id) {
            // echo "update";
            // exit;
            $this->db->where('id', $id);
            $this->db->update('tbl_exam_material_exam_years', $data);
            return 2;
        } else {
            // echo "insert";
            // exit;
            try {
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $data[$key] = implode(', ', $value);
                    }
                }
                if (!$this->db->insert('tbl_exam_material_exam_years', $data)) {
                    $error = $this->db->error();
                    echo "Database Error: " . $error['message'];
                    log_message('error', 'Insert failed: ' . $error['message']);
                } else {
                    return 1;
                }
            } catch (Exception $e) {
                log_message('error', 'Exception caught during insert: ' . $e->getMessage());
                echo "Exception caught: " . $e->getMessage();
                exit;
            }
            return 1;
        }
    }

    public function get_single_exam_year_list()
    {
        $this->db->select('*');
        $this->db->where('tbl_exam_material_exam_years.status', '1');
        $this->db->where('tbl_exam_material_exam_years.is_deleted', '0');
        $this->db->order_by('tbl_exam_material_exam_years.id', 'DESC');
        $result = $this->db->get('tbl_exam_material_exam_years');
        return $result->result();
    }

    public function delete_exam_year_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('tbl_exam_material_exam_years', $data);
    }
}
