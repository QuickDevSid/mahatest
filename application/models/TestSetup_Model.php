<?php
require_once 'vendor/autoload.php';
class TestSetup_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function add_test_data($bulk_upload_data, $questions_file, $upload_image, $upload_test_pdf)
    {
        $status = $bulk_upload_data['status'];
        $id = $this->input->post('id');
        $sequence_no = $this->input->post('sequence_no');
        if ($status) {
            $bulk_data = $bulk_upload_data['bulk_data'];
            if (!empty($bulk_data)) {
                $total_questions = $bulk_upload_data['total_questions'];
                $total_marks = $bulk_upload_data['total_marks'];
                if ($id) {
                    // echo "<pre>";
                    // print_r($_POST);
                    // exit;
                    // Update existing test
                    $this->db->select('sequence_no');
                    $this->db->from('tbl_test_setups');
                    $this->db->where('id', $id);
                    $query = $this->db->get();
                    $existingRecord = $query->row();
                    if ($existingRecord) {
                        $currentSequenceNo = $existingRecord->sequence_no;
                        if ($currentSequenceNo != $sequence_no) {
                            if ($sequence_no < $currentSequenceNo) {
                                $this->db->set('sequence_no', 'sequence_no + 1', FALSE);
                                $this->db->where('sequence_no >=', $sequence_no);
                                $this->db->where('sequence_no <', $currentSequenceNo);
                                $this->db->update('tbl_test_setups');
                            } else {
                                $this->db->set('sequence_no', 'sequence_no - 1', FALSE);
                                $this->db->where('sequence_no <=', $sequence_no);
                                $this->db->where('sequence_no >', $currentSequenceNo);
                                $this->db->update('tbl_test_setups');
                            }
                        }
                        // Update test data
                        $data = array(
                            'topic'             => $this->input->post('topic'),
                            'short_note'        => $this->input->post('short_note'),
                            'short_description' => $this->input->post('short_description'),
                            'duration'          => $this->input->post('duration'),
                            'description'       => $this->input->post('description'),
                            'questions_shuffle' => $this->input->post('questions_shuffle'),
                            'show_ans'          => $this->input->post('show_ans'),
                            'download_test_pdf' => $this->input->post('download_test_pdf'),
                            'image'             => $upload_image,
                            'test_pdf'          => $upload_test_pdf,
                            'total_questions'   => $total_questions,
                            'total_marks'       => $total_marks,
                            'questions_file'    => $questions_file,
                            'sequence_no'       => $sequence_no,
                            'updated_on'        => date('Y-m-d H:i:s'),
                        );
                        $this->db->where('id', $id);
                        $this->db->update('tbl_test_setups', $data);
                        $this->db->where('test_id', $id);
                        $this->db->where_in('type', ['0','1']);
                        $this->db->delete('tbl_test_questions');
                        // Reinsert updated questions
                        foreach ($bulk_data as $bulk) {
                            $upload_bulk = array(
                                'test_id'       => $id,
                                'question'      => $bulk['question'],
                                'option_1'      => $bulk['option_1'],
                                'option_2'      => $bulk['option_2'],
                                'option_3'      => $bulk['option_3'],
                                'option_4'      => $bulk['option_4'],
                                'answer'        => $bulk['answer'],
                                'answer_column' => $bulk['answer_column'],
                                'solution'      => $bulk['solution'],
                                'positive_mark' => $bulk['positive_marks'],
                                'negative_mark' => $bulk['negative_marks'],
                                'created_on'    => date('Y-m-d H:i:s'),
                            );
                            $this->db->insert('tbl_test_questions', $upload_bulk);
                        }
                        return 1;
                    }
                } else {
                    // echo "into insert";
                    // exit;
                    $this->db->select('id');
                    $this->db->from('tbl_test_setups');
                    $this->db->where('sequence_no', $sequence_no);
                    $query = $this->db->get();
                    if ($query !== false && $query->num_rows() > 0) {
                        $this->db->set('sequence_no', 'sequence_no + 1', FALSE);
                        $this->db->where('sequence_no >=', $sequence_no);
                        $this->db->update('tbl_test_setups');
                    }
                    $data = array(
                        'topic'             => $this->input->post('topic'),
                        'short_note'        => $this->input->post('short_note'),
                        'short_description' => $this->input->post('short_description'),
                        'duration'          => $this->input->post('duration'),
                        'description'       => $this->input->post('description'),
                        'questions_shuffle' => $this->input->post('questions_shuffle'),
                        'show_ans'          => $this->input->post('show_ans'),
                        'download_test_pdf' => $this->input->post('download_test_pdf'),
                        'image'             => $upload_image,
                        'test_pdf'          => $upload_test_pdf,
                        'total_questions'   => $total_questions,
                        'total_marks'       => $total_marks,
                        'questions_file'    => $questions_file,
                        'sequence_no'       => $sequence_no,
                        'created_on'        => date('Y-m-d H:i:s'),
                    );
                    $this->db->insert('tbl_test_setups', $data);
                    $test_id = $this->db->insert_id();
                    foreach ($bulk_data as $bulk) {
                        $upload_bulk = array(
                            'test_id'       => $test_id,
                            'question'      => $bulk['question'],
                            'option_1'      => $bulk['option_1'],
                            'option_2'      => $bulk['option_2'],
                            'option_3'      => $bulk['option_3'],
                            'option_4'      => $bulk['option_4'],
                            'answer'        => $bulk['answer'],
                            'answer_column' => $bulk['answer_column'],
                            'solution'      => $bulk['solution'],
                            'positive_mark' => $bulk['positive_marks'],
                            'negative_mark' => $bulk['negative_marks'],
                            'created_on'    => date('Y-m-d H:i:s'),
                        );
                        $this->db->insert('tbl_test_questions', $upload_bulk);
                    }
                    return 1;
                }
            } else {
                exit;
                return 0;
            }
        } else {
            exit;
            return 2;
        }
    }
    
    public function add_test_passage_data($upload_image)
    {

        $test_id = $this->input->post('test_id');
        $this->db->where('is_deleted','0');
        $this->db->where('id',$test_id);
        $single_test = $this->db->get('tbl_test_setups')->row();
        // echo '<pre>'; print_r($_POST); exit();
        if(!empty($single_test)){
            $exist_total_marks = $single_test->total_marks != "" ? (float)$single_test->total_marks : 0;
            $exist_total_questions = $single_test->total_questions != "" ? (int)$single_test->total_questions : 0;
            $single_total_marks = 0;
            $single_total_questions = 0;
            $test_id = $single_test->id;

            $group_id = '';
            $group_type = '';
            $question_type = $this->input->post('question_type');
            if($question_type == '2'){
                $group_type = '0';
                $data = array(
                    'test_id'           => $test_id,
                    'group_type'        => $group_type,
                    'group_title'       => $this->input->post('title'),
                    'group_description' => $this->input->post('description'),
                    'group_image'       => $upload_image,
                    'created_on'        => date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_test_groups', $data);
                $group_id = $this->db->insert_id();
            }

            $indices = $this->input->post('indices');
            if($indices != "" && is_array($indices) && !empty($indices)){
                for($i=0;$i<count($indices);$i++){
                    $question = $this->input->post('question_' . $indices[$i]);
                    $option_1 = $this->input->post('option_1_' . $indices[$i]);
                    $option_2 = $this->input->post('option_2_' . $indices[$i]);
                    $option_3 = $this->input->post('option_3_' . $indices[$i]);
                    $option_4 = $this->input->post('option_4_' . $indices[$i]);
                    $answer_column = $this->input->post('correct_option_' . $indices[$i]);
                    $solution = $this->input->post('solution_' . $indices[$i]);
                    $positive_mark = $this->input->post('positive_mark_' . $indices[$i]);
                    $negative_mark = $this->input->post('negative_mark_' . $indices[$i]);

                    $answer = null;
                    if($answer_column == 'option_1'){
                        $answer = $option_1;
                    }elseif($answer_column == 'option_2'){
                        $answer = $option_2;
                    }elseif($answer_column == 'option_3'){
                        $answer = $option_3;
                    }elseif($answer_column == 'option_4'){
                        $answer = $option_4;
                    }

                    $gst_config = array(
                        'upload_path'   => "assets/uploads/question_images",
                        'allowed_types' => "*",
                        'encrypt_name'  => true,
                    );

                    $question_image = '';
                    if (isset($_FILES['question_image_' . $indices[$i]]) && $_FILES['question_image_' . $indices[$i]]['name'] != "") {
                        $this->upload->initialize($gst_config);
                        if ($this->upload->do_upload('question_image_' . $indices[$i])) {
                            $data = $this->upload->data();
                            $question_image = $data['file_name'];
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata("error", $error['error']);
                            exit;
                            return;
                        }
                    }

                    $option_1_image = '';
                    if (isset($_FILES['option_1_image_' . $indices[$i]]) && $_FILES['option_1_image_' . $indices[$i]]['name'] != "") {
                        $this->upload->initialize($gst_config);
                        if ($this->upload->do_upload('option_1_image_' . $indices[$i])) {
                            $data = $this->upload->data();
                            $option_1_image = $data['file_name'];
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata("error", $error['error']);
                            exit;
                            return;
                        }
                    }

                    $option_2_image = '';
                    if (isset($_FILES['option_2_image_' . $indices[$i]]) && $_FILES['option_2_image_' . $indices[$i]]['name'] != "") {
                        $this->upload->initialize($gst_config);
                        if ($this->upload->do_upload('option_2_image_' . $indices[$i])) {
                            $data = $this->upload->data();
                            $option_2_image = $data['file_name'];
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata("error", $error['error']);
                            exit;
                            return;
                        }
                    }

                    $option_3_image = '';
                    if (isset($_FILES['option_3_image_' . $indices[$i]]) && $_FILES['option_3_image_' . $indices[$i]]['name'] != "") {
                        $this->upload->initialize($gst_config);
                        if ($this->upload->do_upload('option_3_image_' . $indices[$i])) {
                            $data = $this->upload->data();
                            $option_3_image = $data['file_name'];
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata("error", $error['error']);
                            exit;
                            return;
                        }
                    }

                    $option_4_image = '';
                    if (isset($_FILES['option_4_image_' . $indices[$i]]) && $_FILES['option_4_image_' . $indices[$i]]['name'] != "") {
                        $this->upload->initialize($gst_config);
                        if ($this->upload->do_upload('option_4_image_' . $indices[$i])) {
                            $data = $this->upload->data();
                            $option_4_image = $data['file_name'];
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata("error", $error['error']);
                            exit;
                            return;
                        }
                    }
                    
                    $question_data = array(
                        'test_id'           => $test_id,
                        'type'              => $question_type,
                        'group_id'          => $question_type == '2' ? $group_id : null,
                        'group_type'        => $group_type != "" ? $group_type : null,
                        'question'          => $question,
                        'option_1'          => $option_1,
                        'option_2'          => $option_2,
                        'option_3'          => $option_3,
                        'option_4'          => $option_4,
                        
                        'question_image'     => $question_image != "" ? $question_image : null,
                        'option_1_image'     => $option_1_image != "" ? $option_1_image : null,
                        'option_2_image'     => $option_2_image != "" ? $option_2_image : null,
                        'option_3_image'     => $option_3_image != "" ? $option_3_image : null,
                        'option_4_image'     => $option_4_image != "" ? $option_4_image : null,

                        'answer'             => $answer,
                        'answer_column'      => $answer_column,
                        'solution'           => $solution,
                        'positive_mark'      => $positive_mark,
                        'negative_mark'      => $negative_mark,

                        'created_on'        => date('Y-m-d H:i:s'),
                    );
                    $this->db->insert('tbl_test_questions', $question_data);

                    $single_total_marks += (float)$positive_mark;
                    $single_total_questions += 1;
                }
            }

            $single_test_update_data = array(
                'total_questions'   =>  (int)$single_total_questions + (int)$exist_total_questions,
                'total_marks'       =>  (int)$single_total_marks + (int)$exist_total_marks
            );
            $this->db->where('id',$test_id);
            $this->db->update('tbl_test_setups',$single_test_update_data);

            return true;
        }else{
            return false;
        }
    }
    public function get_test_setup_ajx_list($length, $start, $search)
    {
        $ids = $this->input->post('ids');
        if ($ids != "") {
            $ids = explode(',', $ids);
            if (!empty($ids)) {
                $this->db->where_in('id', $ids);
            }
        }
        $this->db->where('tbl_test_setups.is_deleted', '0');

        if ($search !== "") {
            $this->db->group_start();
            $this->db->like('tbl_test_setups.topic', $search);
            $this->db->like('tbl_test_setups.short_note', $search);
            $this->db->like('tbl_test_setups.short_description', $search);
            $this->db->like('tbl_test_setups.description', $search);
            $this->db->like('tbl_test_setups.total_questions', $search);
            $this->db->like('tbl_test_setups.total_marks', $search);
            $this->db->group_end();
        }

        $this->db->limit($length, $start);
        // $this->db->order_by('tbl_test_setups.id', 'desc');
        $this->db->order_by('tbl_test_setups.sequence_no', 'ASC');

        $this->db->join('tbl_test_allocation', 'tbl_test_allocation.test_id = tbl_test_setups.id', 'left');
        $this->db->distinct();
        $this->db->select('tbl_test_setups.*, tbl_test_allocation.allocated_type');
        // $this->db->groupby('tbl_test_setups.topic');
        $this->db->group_by('tbl_test_setups.topic');
        $result = $this->db->get('tbl_test_setups');
        return $result->result();
    }

    public function get_test_setup_ajx_count($search)
    {
        $this->db->where('is_deleted', '0');

        if ($search !== "") {
            $this->db->group_start();
            $this->db->like('topic', $search);
            $this->db->like('short_note', $search);
            $this->db->like('short_description', $search);
            $this->db->like('description', $search);
            $this->db->like('total_questions', $search);
            $this->db->like('total_marks', $search);
            $this->db->group_end();
        }

        $this->db->order_by('id', 'desc');
        $result = $this->db->get('tbl_test_setups');
        return $result->num_rows();
    }
    public function get_test_questions_ajx()
    {
        $ids = $this->input->post('ids');
        if ($ids != "") {
            $ids = explode(',', $ids);
            if (!empty($ids)) {
                $this->db->where_in('id', $ids);
            }
        }
        $id = $this->input->post('id');
        $this->db->where('is_deleted', '0');
        $this->db->where('test_id', $id);
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('tbl_test_questions');
        $result = $result->result();
        if (!empty($result)) {
?>
            <table class="table table-bordered" id="testQuestionsTable">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Question</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                        <th>Option 3</th>
                        <th>Option 4</th>
                        <th>Answer</th>
                        <th>Answer Option</th>
                        <th>Solution</th>
                        <th>Positive Mark</th>
                        <th>Negative Mark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    if (!empty($result)): ?>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row->question; ?></td>
                                <td><?php echo $row->option_1; ?></td>
                                <td><?php echo $row->option_2; ?></td>
                                <td><?php echo $row->option_3; ?></td>
                                <td><?php echo $row->option_4; ?></td>
                                <td><?php echo $row->answer; ?></td>
                                <td><?php echo $row->answer_column; ?></td>
                                <td><?php echo $row->solution; ?></td>
                                <td><?php echo $row->positive_mark; ?></td>
                                <td><?php echo $row->negative_mark; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11"><label class="error">Questions Not Available</label></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php
        } else {
        ?>
            <label class="error">Questions Not Available</label>
<?php
        }
    }
    public function delete_test()
    {
        $id = $this->uri->segment(2);
        $this->db->where('id', $id);
        $this->db->where('is_deleted', '0');
        $single = $this->db->get('tbl_test_setups')->row();
        if (!empty($single)) {
            $data = array(
                'is_deleted' => '1'
            );
            $this->db->where('id', $single->id);
            $this->db->update('tbl_test_setups', $data);

            $this->db->where('test_id', $single->id);
            $this->db->update('tbl_test_questions', $data);
            return 1;
        } else {
            return 0;
        }
    }

    public function get_single_test_setup()
    {
        // $id = $this->input->post('id');
        $id = $this->uri->segment(2);
        $this->db->where('tbl_test_setups.is_deleted', '0');
        $this->db->where('tbl_test_setups.status', '1');
        $this->db->where('tbl_test_setups.id', $id);
        $result = $this->db->get('tbl_test_setups');
        $result = $result->row();
        return $result;
    }
}
