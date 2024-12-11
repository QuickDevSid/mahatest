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
            // echo '<pre>'; print_r($bulk_data); exit();
            if (!empty($bulk_data)) {
                $total_questions = $bulk_upload_data['total_questions'];
                $total_marks = $bulk_upload_data['total_marks'];
                if ($id != "") {
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
                        // $this->db->where_in('type', ['0','1']);
                        $this->db->delete('tbl_test_questions');

                        foreach ($bulk_data as $bulk) {
                            $type = $bulk['type'];
                            $group_id = null;
                            $group_type = null;
                            if($type == '2'){
                                $group_description = $bulk['passage'];
                                $group_type = '0';
                                $this->db->where('is_deleted','0');
                                $this->db->where('test_id',$id);
                                $this->db->where('group_description',$group_description);
                                $exist_passage = $this->db->get('tbl_test_groups')->row();
                                if(!empty($exist_passage)){
                                    $group_id = $exist_passage->id;
                                }else{
                                    $data = array(
                                        'test_id'           => $id,
                                        'group_type'        => $group_type,
                                        'group_title'       => null,
                                        'group_description' => $group_description,
                                        'group_image'       => null,
                                        'created_on'        => date('Y-m-d H:i:s'),
                                    );
                                    $this->db->insert('tbl_test_groups', $data);
                                    $group_id = $this->db->insert_id();
                                }
                            }
                            $upload_bulk = array(
                                'test_id'       => $id,
                                'type'          => $type,
                                'group_id'      => $group_id,
                                'group_type'    => $group_type,
                                'question_image'=> $bulk['question_image'],
                                'question'      => $bulk['question'],
                                'option_1'      => $bulk['option_1'],
                                'option_1_image'=> $bulk['option_1_image'],
                                'option_2'      => $bulk['option_2'],
                                'option_2_image'=> $bulk['option_2_image'],
                                'option_3'      => $bulk['option_3'],
                                'option_3_image'=> $bulk['option_3_image'],
                                'option_4'      => $bulk['option_4'],
                                'option_4_image'=> $bulk['option_4_image'],
                                'answer'        => $bulk['answer'],
                                'answer_column' => $bulk['answer_column'],
                                'solution'      => $bulk['solution'],
                                'positive_mark' => $bulk['positive_marks'],
                                'negative_mark' => $bulk['negative_marks'],
                                'asked_exam'    => $bulk['asked_exam'],
                                'created_on'    => date('Y-m-d H:i:s'),
                            );
                            $this->db->insert('tbl_test_questions', $upload_bulk);
                        }
                        return 1;
                    }
                } else {
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
                        $type = $bulk['type'];
                        $group_id = null;
                        $group_type = null;
                        if($type == '2'){
                            $group_description = $bulk['passage'];
                            $group_type = '0';
                            $this->db->where('is_deleted','0');
                            $this->db->where('test_id',$test_id);
                            $this->db->where('group_description',$group_description);
                            $exist_passage = $this->db->get('tbl_test_groups')->row();
                            if(!empty($exist_passage)){
                                $group_id = $exist_passage->id;
                            }else{
                                $data = array(
                                    'test_id'           => $test_id,
                                    'group_type'        => $group_type,
                                    'group_title'       => null,
                                    'group_description' => $group_description,
                                    'group_image'       => null,
                                    'created_on'        => date('Y-m-d H:i:s'),
                                );
                                $this->db->insert('tbl_test_groups', $data);
                                $group_id = $this->db->insert_id();
                            }
                        }

                        $upload_bulk = array(
                            'test_id'       => $test_id,
                            'type'          => $type,
                            'group_id'      => $group_id,
                            'group_type'    => $group_type,
                            'question_image'=> $bulk['question_image'],
                            'question'      => $bulk['question'],
                            'option_1'      => $bulk['option_1'],
                            'option_1_image'=> $bulk['option_1_image'],
                            'option_2'      => $bulk['option_2'],
                            'option_2_image'=> $bulk['option_2_image'],
                            'option_3'      => $bulk['option_3'],
                            'option_3_image'=> $bulk['option_3_image'],
                            'option_4'      => $bulk['option_4'],
                            'option_4_image'=> $bulk['option_4_image'],
                            'answer'        => $bulk['answer'],
                            'answer_column' => $bulk['answer_column'],
                            'solution'      => $bulk['solution'],
                            'positive_mark' => $bulk['positive_marks'],
                            'negative_mark' => $bulk['negative_marks'],
                            'asked_exam'    => $bulk['asked_exam'],
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
    public function check_image_is_allocated($name){
        $this->db->where('is_deleted','0');
        $this->db->group_start();
        $this->db->or_where('question_image',$name);
        $this->db->or_where('option_1_image',$name);
        $this->db->or_where('option_2_image',$name);
        $this->db->or_where('option_3_image',$name);
        $this->db->or_where('option_4_image',$name);
        $this->db->group_end();
        $result = $this->db->get('tbl_test_questions')->num_rows();
        return $result;
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
    public function add_master_gallary_data($name){
        $data = array(
            'uploaded_file'     =>  $name,
            'uploaded_on'       =>  date('Y-m-d H:i:s'),
            'created_on'        =>  date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_master_gallary_upload_status',$data);
        return false;
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
        $ids = $this->input->post('ids');
        if ($ids != "") {
            $ids = explode(',', $ids);
            if (!empty($ids)) {
                $this->db->where_in('id', $ids);
            }
        }
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
    public function get_group_details($id){
        $this->db->where('id', $id);
        $result = $this->db->get('tbl_test_groups');
        return $result->row();
    }
    public function get_test_questions_ajx_list($length, $start, $search)
    {
        $this->db->select('tbl_test_questions.*, tbl_test_setups.topic, tbl_test_setups.short_note, tbl_test_setups.short_description');
        $this->db->join('tbl_test_setups', 'tbl_test_questions.test_id = tbl_test_setups.id');
        $this->db->where('tbl_test_setups.is_deleted', '0');
        $this->db->where('tbl_test_questions.is_deleted', '0');
        if ($search !== "") {
            $this->db->group_start();
            $this->db->like('tbl_test_setups.topic', $search);
            $this->db->like('tbl_test_setups.short_note', $search);
            $this->db->like('tbl_test_setups.short_description', $search);
            $this->db->like('tbl_test_questions.question', $search);
            $this->db->like('tbl_test_questions.question_image', $search);
            $this->db->like('tbl_test_questions.option_1', $search);
            $this->db->like('tbl_test_questions.option_2', $search);
            $this->db->like('tbl_test_questions.option_3', $search);
            $this->db->like('tbl_test_questions.option_4', $search);
            $this->db->like('tbl_test_questions.option_1_image', $search);
            $this->db->like('tbl_test_questions.option_2_image', $search);
            $this->db->like('tbl_test_questions.option_3_image', $search);
            $this->db->like('tbl_test_questions.option_4_image', $search);
            $this->db->like('tbl_test_questions.answer_column', $search);
            $this->db->like('tbl_test_questions.solution', $search);
            $this->db->like('tbl_test_questions.positive_mark', $search);
            $this->db->like('tbl_test_questions.negative_mark', $search);
            $this->db->like('tbl_test_questions.asked_exam', $search);
            $this->db->like('tbl_test_questions.created_on', $search);
            $this->db->group_end();
        }
        if($this->input->post('test_id') != ""){
            $this->db->where('tbl_test_questions.test_id', $this->input->post('test_id'));
        }
        $this->db->limit($length, $start);
        $this->db->order_by('tbl_test_questions.id', 'desc');
        $this->db->group_by('tbl_test_questions.id');
        $result = $this->db->get('tbl_test_questions');
        return $result->result();
    }
    public function delete_question($id,$test_id){
        $this->db->where('tbl_test_questions.id',$id);
        $this->db->where('tbl_test_questions.test_id',$test_id);
        $this->db->update('tbl_test_questions',array('is_deleted'=>'1'));

        $this->calculate_test_totals($test_id);
        return true;
    }
    public function calculate_test_totals($id){
        $this->db->where('is_deleted','0');
        $this->db->where('id',$id);
        $exist = $this->db->get('tbl_test_setups')->row();
        if(!empty($exist)){
            $total_questions = $exist->total_questions;
            $total_marks = $exist->total_marks;
            
            $new_total_questions = 0;
            $new_total_marks = 0;
            $this->db->where('is_deleted','0');
            $this->db->where('test_id',$exist->id);
            $result = $this->db->get('tbl_test_questions')->result();
            if(!empty($result)){
                foreach($result as $data){
                    $new_total_questions += 1;
                    $new_total_marks += ($data->positive_mark != "" ? (float)$data->positive_mark : 0);
                }
                $total_questions = $new_total_questions;
                $total_marks = $new_total_marks;
            }

            $update_data = array(
                'total_questions'   =>  $total_questions,
                'total_marks'       =>  $total_marks,
            );
            $this->db->where('id',$exist->id);
            $this->db->update('tbl_test_setups',$update_data);
        }
        return true;
    }

    public function get_test_questions_ajx_count($search)
    {
        $this->db->select('tbl_test_questions.*, tbl_test_setups.topic, tbl_test_setups.short_note, tbl_test_setups.short_description');
        $this->db->join('tbl_test_setups', 'tbl_test_questions.test_id = tbl_test_setups.id');
        $this->db->where('tbl_test_setups.is_deleted', '0');
        $this->db->where('tbl_test_questions.is_deleted', '0');
        if ($search !== "") {
            $this->db->group_start();
            $this->db->like('tbl_test_setups.topic', $search);
            $this->db->like('tbl_test_setups.short_note', $search);
            $this->db->like('tbl_test_setups.short_description', $search);
            $this->db->like('tbl_test_questions.question', $search);
            $this->db->like('tbl_test_questions.question_image', $search);
            $this->db->like('tbl_test_questions.option_1', $search);
            $this->db->like('tbl_test_questions.option_2', $search);
            $this->db->like('tbl_test_questions.option_3', $search);
            $this->db->like('tbl_test_questions.option_4', $search);
            $this->db->like('tbl_test_questions.option_1_image', $search);
            $this->db->like('tbl_test_questions.option_2_image', $search);
            $this->db->like('tbl_test_questions.option_3_image', $search);
            $this->db->like('tbl_test_questions.option_4_image', $search);
            $this->db->like('tbl_test_questions.answer_column', $search);
            $this->db->like('tbl_test_questions.solution', $search);
            $this->db->like('tbl_test_questions.positive_mark', $search);
            $this->db->like('tbl_test_questions.negative_mark', $search);
            $this->db->like('tbl_test_questions.asked_exam', $search);
            $this->db->like('tbl_test_questions.created_on', $search);
            $this->db->group_end();
        }
        if($this->input->post('test_id') != ""){
            $this->db->where('tbl_test_questions.test_id', $this->input->post('test_id'));
        }
        $this->db->order_by('tbl_test_questions.id', 'desc');
        $this->db->group_by('tbl_test_questions.id');
        $result = $this->db->get('tbl_test_questions');
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
    
    public function get_all_master_images()
    {
        // Define the directory path
        $directory = 'assets/uploads/master_gallary/';
        
        // Check if the directory exists
        if (is_dir($directory)) {
            // Get all files and folders in the directory
            $files = scandir($directory);
            
            // Filter out "." and ".."
            $files = array_diff($files, array('.', '..'));
            
            // Return the list of files (optional, you can return the full path if needed)
            return $files;
        } else {
            // If directory doesn't exist, return an empty array or handle the error as needed
            return array();
        }
    }

}
