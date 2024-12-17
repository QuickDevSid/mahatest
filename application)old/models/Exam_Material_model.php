<?php

class Exam_Material_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_exam_material_list()
    {
        $this->db->select('*');
        $this->db->where('tbl_exam_materials.status', '1');
        $this->db->where('tbl_exam_materials.is_deleted', '0');
        // $this->db->order_by('tbl_exam_materials.id', 'DESC');
        $result = $this->db->get('tbl_exam_materials');
        return $result->result();
    }


    public function set_previous_exam_pdf_details($data)
    {

        echo "<pre>";
        print_r($_POST);
        print_r($_FILES);
        echo "</pre>";
        exit;

        $exam_material_id = $this->input->post('exam_material_id');
        $subject_id = $this->input->post('subject_id');

        $pdf_url = $data['pdfs']; // You already have this data from the controller
        $images = $data['images']; // You already have this data from the controller

        // Prepare the data array
        $data_to_insert = [
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'exam_material_id' => $exam_material_id,
            'subject_id' => $subject_id,
            'pdf_url' => $pdf_url,
            'images' => $images,
            'created_on' => date('Y-m-d H:i:s')
        ];

        // Check if ID is provided (for update or insert logic)
        $id = $this->input->post('id');
        // print_r($data_to_insert);exit;

        if ($id) {
            // Update the record if the ID exists
            $this->db->where('id', $id);
            $this->db->update('test_series_pdf', $data_to_insert);

            if ($this->db->affected_rows() > 0) {
                return 2; // Successfully updated
            } else {
                return 0; // No changes made
            }
        } else {
            // Insert a new record if no ID is provided
            try {
                // Insert the data into the database
                if (!$this->db->insert('test_series_pdf', $data_to_insert)) {
                    $error = $this->db->error();
                    echo "Insert failed.<br>";
                    echo "Database Error Code: " . $error['code'] . "<br>";
                    echo "Database Error Message: " . $error['message'] . "<br>";
                    return 0; // Return 0 for insert failure
                } else {
                    return 1; // Successfully inserted
                }
            } catch (Exception $e) {
                // Catch any exception and display an error message
                echo "Exception caught during insert: " . $e->getMessage() . "<br>";
                return 0; // Return 0 for insert failure
            }
        }
    }

    public function get_single_previous_examwise_pdf()
    {
        $this->db->where('tbl_previous_paper_examwise_pdf.is_deleted', '0');
        $this->db->where('tbl_previous_paper_examwise_pdf.status', '1');
        $this->db->where('tbl_previous_paper_examwise_pdf.id', $this->uri->segment(3));
        $result = $this->db->get('tbl_previous_paper_examwise_pdf');
        $result = $result->row();
        return $result;
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

    public function get_single_exam_year_pdf()
    {
        $this->db->where('tbl_examwise_pdf.is_deleted', '0');
        $this->db->where('tbl_examwise_pdf.status', '1');
        $this->db->where('tbl_examwise_pdf.id', $this->uri->segment(4));
        $result = $this->db->get('tbl_examwise_pdf');
        $result = $result->row();
        return $result;
    }

    public function set_examwise_pdf_details($upload_image, $upload_image_update, $upload_pdf, $upload_pdf_update)
    {
        $id = $this->input->post('id');
        $exam_material_id = $this->input->post('exam_material_id');

        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "<pre>";
        // exit;

        if ($id) {
            // echo $upload_image_update;
            // echo $upload_pdf_update;
            // exit;
            $data = array(
                'title'             => $this->input->post('title'),
                'exam_name'       => $this->input->post('exam_name'),
                'exam_year'          => $this->input->post('exam_year'),
                'exam_type'          => $this->input->post('exam_type'),
                'short_description'          => $this->input->post('short_description'),
                'image'             => $upload_image_update,
                'pdf'             => $upload_pdf_update,
                'created_on'        => date('Y-m-d H:i:s'),
                'exam_material_id'          => $exam_material_id
            );
            // print_r($data);
            // echo $id;
            // exit;
            $this->db->where('id', $id);
            $this->db->update('tbl_examwise_pdf', $data);
            return 2;
        } else {
            // echo "insert";
            // exit;
            $files = !empty($upload_image) ? explode(',', $upload_image) : [];
            $pdffiles = !empty($upload_pdf) ? explode(',', $upload_pdf) : [];
            $indices = $this->input->post('indices');
            // echo $ebook_id;
            // // $id = $this->request->getGet('id');
            // // echo $id;
            // exit;
            if (!empty($indices)) {

                for ($i = 0; $i < count($indices); $i++) {
                    $image = array_key_exists($i, $files) ? $files[$i] : null;
                    $pdf = array_key_exists($i, $pdffiles) ? $pdffiles[$i] : null;
                    $data = array(
                        'title'             => $this->input->post('title_' . $indices[$i]),
                        'short_description'       => $this->input->post('description_' . $indices[$i]),
                        'exam_type'       => $this->input->post('exam_type_' . $indices[$i]),
                        'exam_year'       => $this->input->post('exam_year_' . $indices[$i]),
                        'exam_name'       => $this->input->post('exam_name_' . $indices[$i]),
                        'image'             => $image,
                        'pdf'             => $pdf,
                        'created_on'        => date('Y-m-d H:i:s'),
                        'exam_material_id'          => $exam_material_id
                    );
                    // print_r($data);
                    // exit;
                    $this->db->insert('tbl_examwise_pdf', $data);
                }
                return 1;
            }
        }
    }

    public function get_examwise_pdf_list()
    {
        $this->db->select('`tbl_examwise_pdf`.*');
        $this->db->where('tbl_examwise_pdf.status', '1');
        $this->db->where('tbl_examwise_pdf.is_deleted', '0');
        // $this->db->join('tbl_examwise_pdf', 'tbl_examwise_pdf.id = tbl_examwise_pdf.ebook_id', 'left');
        $this->db->order_by('tbl_examwise_pdf.id', 'DESC');
        $result = $this->db->get('tbl_examwise_pdf');
        if ($result && $result->num_rows() > 0) {
            return $result->result();
        } else {
            return [];
        }
    }

    public function get_all_examwise_pdf_for_edit($id)
    {
        $this->db->where('tbl_examwise_pdf.is_deleted', '0');
        $this->db->where('tbl_examwise_pdf.status', '1');
        $this->db->where('tbl_examwise_pdf.id', $id);
        $result = $this->db->get('tbl_examwise_pdf');
        $result = $result->row();
        return $result;
    }

    public function get_select_exam_name()
    {
        $this->db->where('tbl_exam_material_exams.status', '1');
        $this->db->where('tbl_exam_material_exams.is_deleted', '0');
        $this->db->order_by('tbl_exam_material_exams.id', 'DESC');
        $result = $this->db->get('tbl_exam_material_exams');
        return $result->result();
    }

    public function get_select_exam_year()
    {
        $this->db->where('tbl_exam_material_exam_years.status', '1');
        $this->db->where('tbl_exam_material_exam_years.is_deleted', '0');
        $this->db->order_by('tbl_exam_material_exam_years.id', 'DESC');
        $result = $this->db->get('tbl_exam_material_exam_years');
        return $result->result();
    }

    public function get_select_exam_type()
    {
        $this->db->where('tbl_exam_material_exam_types.status', '1');
        $this->db->where('tbl_exam_material_exam_types.is_deleted', '0');
        $this->db->order_by('tbl_exam_material_exam_types.id', 'DESC');
        $result = $this->db->get('tbl_exam_material_exam_types');
        return $result->result();
    }

    public function delete_examwise_pdf($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_examwise_pdf', $data);
    }
}
