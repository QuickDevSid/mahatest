<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

class MarathiSabd_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }



    public function set_marathi_sabd_cat_details()
    {
        // Debugging input data (remove these in production)
        // echo "<pre>";
        // print_r($_POST);
        // echo "<pre>";
        // exit;
        // Prepare data to insert/update
        $data = array(
            'category_name' => $this->input->post('title'),
            'created_on' => date('Y-m-d H:i:s'),
        );

        $id = $this->input->post('id');

        if ($id) {
            // echo "into update";
            // exit;
            // echo $id;exit;
            // Fetch the existing record's current sequence_no
            $this->db->where('id', $id);
            $this->db->update('marathi_sabd_category', $data);
            return 0;
        } else {
            // echo "into insert";
            // exit;
            $this->db->insert('marathi_sabd_category', $data);
            return 1; // Indicating successful insert
        }
    }

    public function get_select_category()
    {
        $this->db->where('marathi_sabd_category.status', '1');
        $this->db->where('marathi_sabd_category.is_deleted', '0');
        $this->db->order_by('marathi_sabd_category.id', 'DESC');
        $result = $this->db->get('marathi_sabd_category');
        return $result->result();
    }


    public function get_single_category_list()
    {
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        $result = $this->db->get('marathi_sabd_category');
        return $result->result();
    }



    public function get_single_marathi_sabd_cat()
    {
        $this->db->where('marathi_sabd_category.is_deleted', '0');
        $this->db->where('marathi_sabd_category.status', '1');
        $this->db->where('marathi_sabd_category.id', $this->uri->segment(3));
        $result = $this->db->get('marathi_sabd_category');
        $result = $result->row();
        return $result;
    }

    public function delete_marathi_sabd_form($id)
    {
        $id = $this->uri->segment(3);
        $data = array(
            'new_status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('marathi_sabd', $data);
    }

    public function delete_marathi_sabd_category($id)
    {
        $id = $this->uri->segment(3);
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('marathi_sabd_category', $data);
    }

    public function marathi_sabd_form_active($id)
    {
        // $id = $this->uri->segment(3);
        // echo "into active";exit;
        $data = array(
            'status' => 'Active'
        );
        $this->db->where('id', $id);
        $this->db->update('marathi_sabd', $data);
    }

    public function marathi_sabd_form_inactive($id)
    {
        // $id = $this->uri->segment(3);
        // echo "into inactive";exit;
        $data = array(
            'status' => 'Inactive'
        );
        $this->db->where('id', $id);
        $this->db->update('marathi_sabd', $data);
    }


    public function set_marathi_sabd_details($upload_image)
    {
        // Debugging input data (remove these in production)
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "<pre>";
        // exit;

        // Prepare data to insert/update
        $data = array(
            'marathi_sabd_image' => $upload_image,
            'category' => $this->input->post('category'),
            'marathi_sabd_title' => $this->input->post('title'),
            'marathi_sabd_description' => $this->input->post('description'),
            'date' => $this->input->post('date'),
            'status' => $this->input->post('status'),
            'created_on' => date('Y-m-d H:i:s'),
        );
        // print_r($data);
        // exit;

        $id = $this->input->post('id'); // Check if updating or inserting
        $sequence_no = $this->input->post('sequence_no'); // Sequence number from input

        if ($id) {
            // Update existing record logic
            // echo "into update";
            // exit;
            // Fetch the existing record's current sequence_no
            $this->db->select('sequence_no');
            $this->db->from('marathi_sabd');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $existingRecord = $query->row();

            if ($existingRecord) {
                // echo "into exist";exit;
                $currentSequenceNo = $existingRecord->sequence_no;
                // echo $currentSequenceNo;exit;
                $newSequenceNo = $this->input->post('sequence_no');
                // echo $newSequenceNo;exit;

                if ($currentSequenceNo != $newSequenceNo) {
                    // echo "into not equal to current sequence";exit;

                    // Increment sequence_no for affected rows between the old and new positions
                    if ($newSequenceNo < $currentSequenceNo) {
                        // If moving up (e.g., from 2 to 1)
                        $this->db->set('sequence_no', 'sequence_no + 1', FALSE);
                        $this->db->where('sequence_no >=', $newSequenceNo);
                        $this->db->where('sequence_no <', $currentSequenceNo);
                        $this->db->update('marathi_sabd');
                    } else {
                        // If moving down (e.g., from 2 to 4)
                        $this->db->set('sequence_no', 'sequence_no - 1', FALSE);
                        $this->db->where('sequence_no <=', $newSequenceNo);
                        $this->db->where('sequence_no >', $currentSequenceNo);
                        $this->db->update('marathi_sabd');
                    }
                }
                // echo "outside";exit;

                // Update the current record with the new sequence_no and other details
                $data['sequence_no'] = $newSequenceNo;
                $this->db->where('id', $id);
                $this->db->update('marathi_sabd', $data);
                return 0; // Indicate update
            }
        } else {
            // echo "into insert";
            // exit;
            $this->db->select('id');
            $this->db->from('marathi_sabd');
            $this->db->where('sequence_no', $sequence_no);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                // echo "into insert dsvd";
                // exit;
                $this->db->set('sequence_no', 'sequence_no + 1', FALSE); // Increment sequence_no by 1
                $this->db->where('sequence_no >=', $sequence_no);
                $this->db->update('marathi_sabd');
            }
            $data['sequence_no'] = $sequence_no;
            // echo "Before Insert Debugging:";
            // print_r($data); // Display the data being inserted
            // exit;
            $this->db->insert('marathi_sabd', $data);
            return 1;
        }
    }


    public function get_single_marathi_sabd()
    {
        $this->db->where('marathi_sabd.is_deleted', '0');
        // $this->db->where('english_vocabulary.status', '1');
        $this->db->where('marathi_sabd.new_status', '1');
        $this->db->where('marathi_sabd.id', $this->uri->segment(3));
        $result = $this->db->get('marathi_sabd');
        $result = $result->row();
        return $result;
    }

    public function get_single_english_vocabulary_list()
    {
        $this->db->where('is_deleted', '0');
        $this->db->where('new_status', '1');
        // $this->db->where('status', 'Active');
        $this->db->order_by('sequence_no', 'ASC');
        $result = $this->db->get('marathi_sabd');
        return $result->result();
    }
}
