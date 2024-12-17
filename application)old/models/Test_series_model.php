<?php


class Test_series_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    var $table = "test_series";
    var $select_column = array(
        'id',
        "title",
        "sub_headings",
        "banner_image",
        "mrp",
        "sale_price",
        "discount",
        "status",
        "usage_count",
        "description",
        "created_at",
        "updated_at",
    );

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("test_title", $_POST["search"]["value"]);
        }
        $this->db->order_by('id', 'DESC');
    }

    function make_datatables()
    {
        $this->make_query();
        $query = $this->db->get();
        if (empty($query)) {
            return [];
        }
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        if (empty($query)) {
            return [];
        }
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
        $this->db->where('status', 'Active');
        $this->db->from($this->table);

        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        } else {
            return 0;
        }
    }
    public function getPostById($id)
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
        //return $data;
        if ($this->db->insert($this->table, $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }
    public function updateViews($id)
    {
        $this->db->set('views_count', 'views_count + 1', FALSE);
        $this->db->where('id', $id);

        if ($this->db->update($this->table)) {
            return true;
        } else {
            return false;
        }
    }
    function update($id, $data)
    {

        $this->db->where('id', $id);
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


    public function set_test_series_details($upload_image, $upload_inner_image)
    {
        $data = array(
            // 'id' => '11',
            'title' => $this->input->post('title'),
            'sub_headings' => $this->input->post('subtitle'),
            'mrp' => $this->input->post('mrp'),
            'sale_price' => $this->input->post('sale_price'),
            'discount' => $this->input->post('discount'),
            'description' => $this->input->post('description'),
            'prakaran_lecture' => $this->input->post('prakaran_lecture'),
            'banner_image' => $upload_image,
            'inner_banner_image' => $upload_inner_image,
            'validity' => $this->input->post('validity'),
            'tagline' => $this->input->post('tagline'),
            'record_status' => $this->input->post('record_status'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $id = $this->input->post('id'); // Retrieve the ID

        $sequence_no = $this->input->post('sequence_no');
        if ($id) {
            // Update existing record logic
            $this->db->select('sequence_no');
            $this->db->from('test_series');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $existingRecord = $query->row();

            if ($existingRecord) {
                $currentSequenceNo = $existingRecord->sequence_no;
                $newSequenceNo = $this->input->post('sequence_no');

                if ($currentSequenceNo != $newSequenceNo) {
                    // Adjust sequence numbers for other records if necessary
                    if ($newSequenceNo < $currentSequenceNo) {
                        // Move up (e.g., from 2 to 1)
                        $this->db->set('sequence_no', 'sequence_no + 1', FALSE);
                        $this->db->where('sequence_no >=', $newSequenceNo);
                        $this->db->where('sequence_no <', $currentSequenceNo);
                        $this->db->update('test_series');
                    } else {
                        // Move down (e.g., from 2 to 4)
                        $this->db->set('sequence_no', 'sequence_no - 1', FALSE);
                        $this->db->where('sequence_no <=', $newSequenceNo);
                        $this->db->where('sequence_no >', $currentSequenceNo);
                        $this->db->update('test_series');
                    }
                }

                // Update the current record with the new sequence_no
                $data['sequence_no'] = $newSequenceNo;
                $this->db->where('id', $id);
                $this->db->update('test_series', $data);
                return 0; // Indicate update
            }
        } else {
            // Insert new record logic
            $this->db->select('id');
            $this->db->from('test_series');
            $this->db->where('sequence_no', $sequence_no);
            $query = $this->db->get();
            if ($query !== false && $query->num_rows() > 0) {
                // echo "matched";
                // exit;
                $this->db->set('sequence_no', 'sequence_no + 1', FALSE); // Increment sequence_no
                $this->db->where('sequence_no >=', $sequence_no);
                $this->db->update('test_series');
            } else {
                // Handle case when query fails or no rows are returned
                // echo "Query failed or no matching records.";
                $data['sequence_no'] = $sequence_no;
                $this->db->insert('test_series', $data);
                return 1;
            }
        }
    }

    public function status_test_series_list_active($id)
    {
        $data = array(
            'record_status' => 'Inactive'
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('test_series', $data);
    }

    public function status_test_series_list_in_active($id)
    {
        $data = array(
            'record_status' => 'Active'
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('test_series', $data);
    }

    public function get_single_test_series()
    {
        $this->db->where('test_series.is_deleted', '0');
        $this->db->where('test_series.status', '1');
        $this->db->where('test_series.id', $this->uri->segment(3));
        $result = $this->db->get('test_series');
        $result = $result->row();
        return $result;
    }

    public function get_single_test_series_list()
    {
        $this->db->select('*');
        $this->db->where('test_series.status', '1');
        $this->db->where('test_series.is_deleted', '0');
        $this->db->order_by('test_series.sequence_no', 'ASC');
        $result = $this->db->get('test_series');
        return $result->result();
    }

    public function set_test_series_pdf_details($upload_pdf)
    {
        $data = array(
            // 'id' => '18',
            'title' => $this->input->post('title'),
            'test_series_id' => $this->input->post('test_series_id'),
            'pdf_url' => $upload_pdf,
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
            $this->db->update('test_series_pdf', $data);
            return 2;
        } else {
            // print_r($data);
            // echo "insert";
            // exit;

            try {
                // echo "Entering try block.<br>";
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $data[$key] = implode(', ', $value);
                    }
                }

                if (!$this->db->insert('test_series_pdf', $data)) {
                    $error = $this->db->error();
                    echo "Insert failed.<br>";
                    echo "Database Error Code: " . $error['code'] . "<br>";
                    echo "Database Error Message: " . $error['message'] . "<br>";
                    exit;
                } else {
                    // echo "Insert successful.<br>";
                    // exit;
                    return 1;
                }
            } catch (Exception $e) {
                // Display exception details
                echo "Exception caught during insert: " . $e->getMessage() . "<br>";
            }
        }
    }

    public function get_single_test_series_pdf_list()
    {
        $this->db->select('*');
        $this->db->where('test_series_pdf.status', '1');
        $this->db->where('test_series_pdf.is_deleted', '0');
        $this->db->order_by('test_series_pdf.id', 'DESC');
        $result = $this->db->get('test_series_pdf');
        return $result->result();
    }

    public function get_select_test()
    {
        $this->db->where('test_series.status', '1');
        $this->db->where('test_series.is_deleted', '0');
        $this->db->order_by('test_series.id', 'DESC');
        $result = $this->db->get('test_series');
        return $result->result();
    }

    public function get_single_test_series_pdf()
    {
        $this->db->where('test_series_pdf.is_deleted', '0');
        $this->db->where('test_series_pdf.status', '1');
        $this->db->where('test_series_pdf.id', $this->uri->segment(3));
        $result = $this->db->get('test_series_pdf');
        $result = $result->row();
        return $result;
    }

    public function delete_test_series_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('test_series', $data);
    }

    public function delete_test_series_pdf_list($id)
    {
        $data = array(
            'status' => 0,
            'is_deleted' => 1
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('test_series_pdf', $data);
    }
    public function get_duplicate_title_pdf()
    {
        $id = $this->input->post('id');
        $this->db->select('title');
        $this->db->where('title', $this->input->post('title'));
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('test_series_pdf');
        echo $query->num_rows();
    }
    public function get_duplicate_title()
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $this->db->select('title');
        $this->db->from('test_series');
        $this->db->where('title', $title);
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();
        echo $query->num_rows();
    }

    public function get_tests()
    {
        $this->db->order_by('tbl_test_setups.id', 'desc');
        $result = $this->db->get('tbl_test_setups')->result();
        return $result;
    }

    public function save_test_series_quizs_tests()
    {

        $title = $this->db->escape_str($_POST['title']);
        $hidden_id = $this->db->escape_str($_POST['hidden_id']);
        $test_id = $this->db->escape_str($_POST['test_id']);
        if ($test_id != "" && is_array($test_id) && !empty($test_id)) {
            $test_id = implode(',', $test_id);
        } else {
            $test_id = '';
        }
        // echo "into insert";
        // exit;
        $this->db->where('id', $title);
        $this->db->update('test_series', array('tests' => $test_id));
        return 1;
    }

    public function get_single_test_series_quizs_list()
    {
        $this->db->select('test_series.*, GROUP_CONCAT(tbl_test_setups.topic SEPARATOR ", ") as topics'); // Concatenate topics
        $this->db->from('test_series');
        $this->db->join('tbl_test_setups', "FIND_IN_SET(tbl_test_setups.id, test_series.tests)", 'inner'); // Match IDs in the `test` column
        $this->db->where('test_series.status', '1');
        $this->db->where('test_series.is_deleted', '0');
        $this->db->group_by('test_series.id'); // Group by test_series ID
        $this->db->order_by('test_series.id', 'DESC');

        $query = $this->db->get();

        if (!$query) {
            // Debugging output
            echo "Query: " . $this->db->last_query(); // Prints the query for inspection
            print_r($this->db->error()); // Shows the error message
            die(); // Stop execution for debugging
        }

        return $query->result();
    }

    public function get_single_test_series_tests($id)
    {
        $this->db->where('test_series.id', $id);
        $result = $this->db->get('test_series')->row();
        return $result;
    }

    public function delete_test_series_quizs_test($id)
    {
        $this->db->where('id', $id);
        $this->db->update('test_series', array('tests' => null));
        return 1;
    }

    // public function get_single_test_series_quizs_list_details()
    // {
    //     $this->db->select('test_series.*, GROUP_CONCAT(tbl_test_setups.topic SEPARATOR ", ") as topics'); // Concatenate topics
    //     $this->db->from('test_series');
    //     $this->db->join('tbl_test_setups', "FIND_IN_SET(tbl_test_setups.id, test_series.tests)", 'inner'); // Match IDs in the `test` column
    //     $this->db->where('test_series.status', '1');
    //     $this->db->where('test_series.is_deleted', '0');
    //     $this->db->group_by('test_series.id'); // Group by test_series ID
    //     $this->db->order_by('test_series.id', 'DESC');

    //     $query = $this->db->get();

    //     if (!$query) {
    //         // Debugging output
    //         echo "Query: " . $this->db->last_query(); // Prints the query for inspection
    //         print_r($this->db->error()); // Shows the error message
    //         die(); // Stop execution for debugging
    //     }

    //     return $query->result();
    // }

    public function get_single_test_series_quizs_list_details()
    {
        $this->db->select('*');
        $this->db->where('tbl_test_setups.status', '1');
        $this->db->where('tbl_test_setups.status', '1');
        $this->db->where('tbl_test_setups.is_deleted', '0');
        $this->db->order_by('tbl_test_setups.id', 'DESC');
        $result = $this->db->get('tbl_test_setups');
        return $result->result();
    }
}
