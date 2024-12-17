<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax_controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("TestSetup_model");
        $this->load->model("Admin_model");
        $this->load->model("CurrentAffairs_model");
        $this->load->model("news_model");
        $this->load->model("EbookCategory_model");
        $this->load->model("User_Payments_model");
        $this->load->model("Exam_Material_model");
    }
    // public function get_test_setup_ajx()
    // {
    //     $draw = intval($this->input->post("draw"));
    //     $start = intval($this->input->post("start"));
    //     $length = intval($this->input->post("length"));
    //     $order = $this->input->post("order");
    //     $search = $this->input->post("search");
    //     $search = $search['value'];
    //     $col = 0;
    //     $dir = "";
    //     if (!empty($order)) {
    //         foreach ($order as $o) {
    //             $col = $o['column'];
    //             $dir = $o['dir'];
    //         }
    //     }
    //     if ($dir != "asc" && $dir != "desc") {
    //         $dir = "desc";
    //     }
    //     $document = $this->TestSetup_model->get_test_setup_ajx_list($length, $start, $search);

    //     $data = array();
    //     if (!empty($document)) {
    //         $page = $start / $length + 1;
    //         $offset = ($page - 1) * $length + 1;
    //         foreach ($document as $print) {
    //             $sub_array = array();
    //             $sub_array[] = $offset++;
    //             $action = '<a href="' . base_url() . 'delete-test/' . $print->id . '" onclick="return confirm(\'Are you sure to delete this test?\');" class="btn bg-red waves-effect btn-xs" style="text-decoration:none;" title="Delete">
    //                             <i class="material-icons">delete</i>
    //                         </a>';
    //             $sub_array[] = $action;
    //             $sub_array[] = $print->topic;

    //             // Modal for short note
    //             $short_note_modal = '
    //             <div class="modal fade" id="shortNoteModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="shortNoteModalLabel' . $print->id . '" aria-hidden="true">
    //                 <div class="modal-dialog" role="document">
    //                     <div class="modal-content">
    //                         <div class="modal-header">
    //                             <h5 class="modal-title" id="shortNoteModalLabel' . $print->id . '">Short Note for ' . $print->topic . '</h5>
    //                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    //                                 <span aria-hidden="true">&times;</span>
    //                             </button>
    //                         </div>
    //                         <div class="modal-body">
    //                             ' . ($print->short_note != "" ? $print->short_note : 'No short note available') . '
    //                         </div>
    //                         <div class="modal-footer">
    //                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>';

    //             // Modal for short description
    //             $short_desc_modal = '
    //             <div class="modal fade" id="shortDescModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="shortDescModalLabel' . $print->id . '" aria-hidden="true">
    //                 <div class="modal-dialog" role="document">
    //                     <div class="modal-content">
    //                         <div class="modal-header">
    //                             <h5 class="modal-title" id="shortDescModalLabel' . $print->id . '">Short Description for ' . $print->topic . '</h5>
    //                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    //                                 <span aria-hidden="true">&times;</span>
    //                             </button>
    //                         </div>
    //                         <div class="modal-body">
    //                             ' . ($print->short_description != "" ? $print->short_description : 'No short description available') . '
    //                         </div>
    //                         <div class="modal-footer">
    //                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>';

    //             // Modal for full description
    //             $desc_modal = '
    //             <div class="modal fade" id="descModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="descModalLabel' . $print->id . '" aria-hidden="true">
    //                 <div class="modal-dialog" role="document">
    //                     <div class="modal-content">
    //                         <div class="modal-header">
    //                             <h5 class="modal-title" id="descModalLabel' . $print->id . '">Full Description for ' . $print->topic . '</h5>
    //                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    //                                 <span aria-hidden="true">&times;</span>
    //                             </button>
    //                         </div>
    //                         <div class="modal-body">
    //                             ' . ($print->description != "" ? $print->description : 'No description available') . '
    //                         </div>
    //                         <div class="modal-footer">
    //                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>';

    //             $sub_array[] = $print->duration != "" ? $print->duration : '';

    //             $sub_array[] = $print->total_marks != "" ? $print->total_marks : '';
    //             // $sub_array[] = $print->total_questions != "" ? '<a onclick="showTestQuestions(' . $print->id . ')" style="cursor:pointer; text-decoration:underline;" data-toggle="modal" data-target="#queModal">' . $print->total_questions . '</a>' : '';
    //             $sub_array[] = $print->total_questions != "" ? $print->total_questions : '';
    //             $sub_array[] = $print->questions_file != "" ? '<a class="btn btn-info" href="' . base_url() . 'assets/uploads/questions_bulk/' . $print->questions_file . '" target="_blank">View</a>' : '-';
    //             $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#shortNoteModal' . $print->id . '">View </button>' . $short_note_modal;
    //             $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#shortDescModal' . $print->id . '">View </button>' . $short_desc_modal;
    //             $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#descModal' . $print->id . '">View </button>' . $desc_modal;

    //             $data[] = $sub_array;
    //         }
    //     }

    //     $TotalProducts = $this->TestSetup_model->get_test_setup_ajx_count($search);

    //     $output = array(
    //         "draw" => $draw,
    //         "recordsTotal" => $TotalProducts,
    //         "recordsFiltered" => $TotalProducts,
    //         "data" => $data
    //     );
    //     echo json_encode($output);
    //     exit();
    // }
    public function get_all_payments_ajx()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != "desc") {
            $dir = "desc";
        }
        $document = $this->User_Payments_model->get_payments_ajx_list($length, $start, $search);
        $data = array();
        if (!empty($document)) {
            $page = $start / $length + 1;
            $offset = ($page - 1) * $length + 1;
            foreach ($document as $print) {
                $sub_array = array();

                if($print->payment_status == '0'){
                    $payment_status = '<label class="label label-warning">Pending</label>';
                }elseif($print->payment_status == '1'){
                    $payment_status = '<label class="label label-success">Success</label>';
                }elseif($print->payment_status == '2'){
                    $payment_status = '<label class="label label-danger">Canceled</label>';
                }else{
                    $payment_status = '-';
                }
                
                if($print->payment_for == '0'){
                    $payment_for = 'Membership';
                }elseif($print->payment_for == '1'){
                    $payment_for = 'Course';
                }elseif($print->payment_for == '2'){
                    $payment_for = 'Test Series';
                }else{
                    $payment_for = '-';
                }

                $sub_array[] = $offset++;
                $sub_array[] = $print->full_name != "" ? $print->full_name . '<br>' . $print->mobile_number . '<br>' . $print->email : '';
                $sub_array[] = $payment_status;
                $sub_array[] = $print->payment_amount;
                $sub_array[] = $print->transaction_id;
                $sub_array[] = $print->payment_on != "" ? date('d-m-Y h:i A',strtotime($print->payment_on)) : '-';
                $sub_array[] = $payment_for;
                $data[] = $sub_array;
            }
        }
        $TotalProducts = $this->User_Payments_model->get_payments_ajx_count($search);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $TotalProducts,
            "recordsFiltered" => $TotalProducts,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
    
    public function get_all_contents_ajx()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != "desc") {
            $dir = "desc";
        }
        $document = $this->User_Payments_model->get_contents_ajx_list($length, $start, $search);
        $data = array();
        if (!empty($document)) {
            $page = $start / $length + 1;
            $offset = ($page - 1) * $length + 1;
            foreach ($document as $print) {
                $sub_array = array();

                if($print->payment_status == '0'){
                    $payment_status = '<label class="label label-warning">Pending</label>';
                }elseif($print->payment_status == '1'){
                    $payment_status = '<label class="label label-success">Success</label>';
                }elseif($print->payment_status == '2'){
                    $payment_status = '<label class="label label-danger">Canceled</label>';
                }else{
                    $payment_status = '-';
                }

                $content_details = $this->User_Payments_model->get_content_details($print->content_primary_table,$print->content_primary_table_id);
                if($print->type == '1'){
                    $payment_for = 'Course';
                }elseif($print->type == '0'){
                    $payment_for = 'Test Series';
                }else{
                    $payment_for = '-';
                }

                $sub_array[] = $offset++;
                $sub_array[] = $print->full_name != "" ? $print->full_name . '<br>' . $print->mobile_number . '<br>' . $print->email : '';
                $sub_array[] = $payment_for . '' . (!empty($content_details) ? '<br>Title: ' . $content_details->title : '');
                $sub_array[] = $print->payment_amount;
                $sub_array[] = $print->transaction_id;
                $sub_array[] = $print->payment_on != "" ? date('d-m-Y h:i A',strtotime($print->payment_on)) : '-';
                $sub_array[] = $payment_status;
                $data[] = $sub_array;
            }
        }
        $TotalProducts = $this->User_Payments_model->get_contents_ajx_count($search);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $TotalProducts,
            "recordsFiltered" => $TotalProducts,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
    public function get_test_setup_ajx()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != "desc") {
            $dir = "desc";
        }
        $document = $this->TestSetup_model->get_test_setup_ajx_list($length, $start, $search);
        $data = array();
        if (!empty($document)) {
            $page = $start / $length + 1;
            $offset = ($page - 1) * $length + 1;
            foreach ($document as $print) {
                $sub_array = array();
                $sub_array[] = $offset++;
                // <a href="' . base_url() . 'test-questions?test_id=' . $print->id . '" class="btn bg-info waves-effect btn-xs" style="text-decoration:none;" title="View Test Questions">
                //                 <i class="fa fa-info">!</i>
                //             </a>
                $action = '<a href="' . base_url() . 'add-test-passages/' . $print->id . '" class="btn bg-primary waves-effect btn-xs" style="text-decoration:none;" title="Add Test Questions">
                                <i class="fa fa-plus">+</i>
                            </a>
                            <a href="' . base_url() . 'delete-test/' . $print->id . '" onclick="return confirm(\'Are you sure to delete this test?\');" class="btn bg-red waves-effect btn-xs" style="text-decoration:none;" title="Delete">
                                <i class="material-icons">delete</i>
                            </a>
                            <a href="' . base_url() . 'test-setup/' . $print->id . '" class="btn bg-primary waves-effect btn-xs" style="text-decoration:none;" title="Update">
                                <i class="material-icons">edit</i>
                            </a>';
                $sub_array[] = $action;
                $sub_array[] = $print->topic;
                // Modal for short note
                $short_note_modal = '
                <div class="modal fade" id="shortNoteModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="shortNoteModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="shortNoteModalLabel' . $print->id . '">Short Note for ' . $print->topic . '</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($print->short_note != "" ? $print->short_note : 'No short note available') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                // Modal for short description
                $short_desc_modal = '
                <div class="modal fade" id="shortDescModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="shortDescModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="shortDescModalLabel' . $print->id . '">Short Description for ' . $print->topic . '</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($print->short_description != "" ? $print->short_description : 'No short description available') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                // Modal for full description
                $desc_modal = '
                <div class="modal fade" id="descModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="descModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="descModalLabel' . $print->id . '">Full Description for ' . $print->topic . '</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($print->description != "" ? $print->description : 'No description available') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $testModal = '
                <div class="modal fade" id="testModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="testModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="testModalLabel' . $print->id . '">This Test is Allocated under</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($print->allocated_type  != "" ? $print->allocated_type  : 'No allocation done') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $sub_array[] = $print->duration != "" ? $print->duration : '';
                $sub_array[] = $print->total_marks != "" ? $print->total_marks : '';
                // $sub_array[] = $print->total_questions != "" ? '<a onclick="showTestQuestions(' . $print->id . ')" style="cursor:pointer; text-decoration:underline;" data-toggle="modal" data-target="#queModal">' . $print->total_questions . '</a>' : '';
                $sub_array[] = $print->total_questions != "" ? '<a href="' . base_url() . 'test-questions?test_id=' . $print->id . '" target="_blank" style="text-decoration:underline;" title="View All Questions">' . $print->total_questions . '</a>' : '';
                $sub_array[] = $print->questions_file != "" ? '<a class="btn btn-info" href="' . base_url() . 'assets/uploads/questions_bulk/' . $print->questions_file . '" target="_blank">View</a>' : '-';
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#shortNoteModal' . $print->id . '">View </button>' . $short_note_modal;
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#shortDescModal' . $print->id . '">View </button>' . $short_desc_modal;
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#descModal' . $print->id . '">View </button>' . $desc_modal;
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#testModal' . $print->id . '">View </button>' . $testModal;
                $data[] = $sub_array;
            }
        }
        $TotalProducts = $this->TestSetup_model->get_test_setup_ajx_count($search);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $TotalProducts,
            "recordsFiltered" => $TotalProducts,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
    public function get_test_all_questions_ajx()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != "desc") {
            $dir = "desc";
        }
        $document = $this->TestSetup_model->get_test_questions_ajx_list($length, $start, $search);
        $data = array();
        if (!empty($document)) {
            $page = $start / $length + 1;
            $offset = ($page - 1) * $length + 1;
            foreach ($document as $print) {
                if($print->type == '0'){
                    $question_type = 'Regular';
                }elseif($print->type == '1'){
                    $question_type = 'Image';
                }elseif($print->type == '2'){
                    $question_type = 'Passage';
                    $group = $this->TestSetup_model->get_group_details($print->group_id);
                }else{
                    $question_type = '';
                }

                if($print->answer_column == 'option_1'){
                    $answer_column = 'Option 1';
                }elseif($print->answer_column == 'option_2'){
                    $answer_column = 'Option 2';
                }elseif($print->answer_column == 'option_3'){
                    $answer_column = 'Option 3';
                }elseif($print->answer_column == 'option_4'){
                    $answer_column = 'Option 4';
                }else{
                    $answer_column = '';
                }

                $question = $print->question != "" ? $print->question : '';
                $option_1 = $print->option_1 != "" ? $print->option_1 : '';
                $option_2 = $print->option_2 != "" ? $print->option_2 : '';
                $option_3 = $print->option_3 != "" ? $print->option_3 : '';
                $option_4 = $print->option_4 != "" ? $print->option_4 : '';
                
                $question_image = $print->question_image != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$print->question_image.'" target="_blank">View</a>' : '';
                $option_1_image = $print->option_1_image != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$print->option_1_image.'" target="_blank">View</a>' : '';
                $option_2_image = $print->option_2_image != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$print->option_2_image.'" target="_blank">View</a>' : '';
                $option_3_image = $print->option_3_image != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$print->option_3_image.'" target="_blank">View</a>' : '';
                $option_4_image = $print->option_4_image != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$print->option_4_image.'" target="_blank">View</a>' : '';
                
                $question_image_name = $print->type == '1' && $print->question_image != "" ? $print->question_image : '';
                $option_1_image_name = $print->type == '1' && $print->option_1_image != "" ? $print->option_1_image : '';
                $option_2_image_name = $print->type == '1' && $print->option_2_image != "" ? $print->option_2_image : '';
                $option_3_image_name = $print->type == '1' && $print->option_3_image != "" ? $print->option_3_image : '';
                $option_4_image_name = $print->type == '1' && $print->option_4_image != "" ? $print->option_4_image : '';

                $sub_array = array();
                $sub_array[] = $offset++;
                $action = '<a href="' . base_url() . 'delete-question/' . $print->test_id . '/' . $print->id . '" onclick="return confirm(\'Are you sure to delete this question?\');" class="btn bg-red waves-effect btn-xs" style="text-decoration:none;" title="Delete">
                                <i class="material-icons">delete</i>
                            </a>';
                $sub_array[] = $action;
                $sub_array[] = $print->topic . '<br>' . $print->short_note;
                $sub_array[] = $question_type;

                // $sub_array[] = $question . '' . ($print->type == '1' && $question_image != "" ? (' ' . $question_image . '') : '');
                $question_modal = '
                <div class="modal fade" id="questionModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="questionModalLabel' . $print->id . '">Question</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($question != "" ? '<p>' . $question . '</p>' : '') . '
                                ' . ($question_image_name != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$question_image_name.'" download><img src="'.base_url().'assets/uploads/master_gallary/'.$question_image_name.'" style="width:250px;"></a>' : '') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#questionModal' . $print->id . '">View </button>' . $question_modal;
                
                // $sub_array[] = $option_1 . '' . ($print->type == '1' && $option_1_image != "" ? (' ' . $option_1_image . '') : '');
                $option_1_modal = '
                <div class="modal fade" id="option_1_Modal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="option_1_ModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="option_1_ModalLabel' . $print->id . '">Option 1</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($option_1 != "" ? '<p>' . $option_1 . '</p>' : '') . '
                                ' . ($option_1_image_name != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$option_1_image_name.'" download><img src="'.base_url().'assets/uploads/master_gallary/'.$option_1_image_name.'" style="width:250px;"></a>' : '') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#option_1_Modal' . $print->id . '">View </button>' . $option_1_modal;
                
                // $sub_array[] = $option_2 . '' . ($print->type == '1' && $option_2_image != "" ? (' ' . $option_2_image . '') : '');
                $option_2_modal = '
                <div class="modal fade" id="option_2_Modal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="option_2_ModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="option_2_ModalLabel' . $print->id . '">Optiopn 2</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($option_2 != "" ? '<p>' . $option_2 . '</p>' : '') . '
                                ' . ($option_2_image_name != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$option_2_image_name.'" download><img src="'.base_url().'assets/uploads/master_gallary/'.$option_2_image_name.'" style="width:250px;"></a>' : '') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#option_2_Modal' . $print->id . '">View </button>' . $option_2_modal;
                
                // $sub_array[] = $option_3 . '' . ($print->type == '1' && $option_3_image != "" ? (' ' . $option_3_image . '') : '');
                $option_3_modal = '
                <div class="modal fade" id="option_3_Modal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="option_3_ModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="option_3_ModalLabel' . $print->id . '">Option 3</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($option_3 != "" ? '<p>' . $option_3 . '</p>' : '') . '
                                ' . ($option_3_image_name != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$option_3_image_name.'" download><img src="'.base_url().'assets/uploads/master_gallary/'.$option_3_image_name.'" style="width:250px;"></a>' : '') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#option_3_Modal' . $print->id . '">View </button>' . $option_3_modal;
                
                // $sub_array[] = $option_4 . '' . ($print->type == '1' && $option_4_image != "" ? (' ' . $option_4_image . '') : '');
                $option_4_modal = '
                <div class="modal fade" id="option_4_Modal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="option_4_ModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="option_4_ModalLabel' . $print->id . '">Option 4</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($option_4 != "" ? '<p>' . $option_4 . '</p>' : '') . '
                                ' . ($option_4_image_name != "" ? '<a href="'.base_url().'assets/uploads/master_gallary/'.$option_4_image_name.'" download><img src="'.base_url().'assets/uploads/master_gallary/'.$option_4_image_name.'" style="width:250px;"></a>' : '') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#option_4_Modal' . $print->id . '">View </button>' . $option_4_modal;
                
                $sub_array[] = $answer_column;
                $sub_array[] = $print->positive_mark;
                $sub_array[] = $print->negative_mark;
                $short_note_modal = '
                <div class="modal fade" id="shortNoteModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="shortNoteModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="shortNoteModalLabel' . $print->id . '">Solution</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ($print->solution != "" ? '<p>' . $print->solution . '</p>' : 'Solution not available') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#shortNoteModal' . $print->id . '">View </button>' . $short_note_modal;
                $short_desc_modal = '
                <div class="modal fade" id="shortDescModal' . $print->id . '" tabindex="-1" role="dialog" aria-labelledby="shortDescModalLabel' . $print->id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="shortDescModalLabel' . $print->id . '">Passage</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ' . ((!empty($group) && $group->group_description != "") ?  '<p>' . $group->group_description . '</p>' : 'Passage not available') . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $sub_array[] = '<button class="btn btn-info" data-toggle="modal" data-target="#shortDescModal' . $print->id . '">View </button>' . $short_desc_modal;
                $sub_array[] = $print->asked_exam;
                $sub_array[] = date('d-m-Y h:i A',strtotime($print->created_on));
                $data[] = $sub_array;
            }
        }
        $TotalProducts = $this->TestSetup_model->get_test_questions_ajx_count($search);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $TotalProducts,
            "recordsFiltered" => $TotalProducts,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
    public function get_test_questions_ajx()
    {
        $this->TestSetup_model->get_test_questions_ajx();
    }
    public function check_unique_current_affair_category()
    {
        $this->CurrentAffairs_model->check_unique_current_affair_category();
    }
    public function get_category_tests_ajax()
    {
        $this->CurrentAffairs_model->get_category_tests_ajax();
    }
    public function check_unique_news_category()
    {
        $this->news_model->check_unique_news_category();
    }

    public function update_shift_sequence()
    {
        $this->News_model->update_shift_sequence();
    }
    
	public function get_app_users_ajx(){
		$draw = intval($this->input->post("draw"));
		$start = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$order = $this->input->post("order");
		$search = $this->input->post("search");
		$search = $search['value'];
		$col = 0;
		$dir = "";
		if(!empty($order)){
			foreach($order as $o){
				$col = $o['column'];
				$dir= $o['dir'];
			}
		}
		if($dir != "asc" && $dir != "desc"){
			$dir = "desc";
		}		

		$document = $this->Admin_model->get_app_users_list_ajx($length, $start, $search);
		// echo '<pre>'; print_r($document); exit;
		$data = array();
		if(!empty($document)){
			$page = $start / $length + 1;
			$offset = ($page - 1) * $length + 1;
			foreach($document as $print){
				if($print->is_active_login == '1'){
					$login_details = '<span class="badge badge-success" style="background-color: green;">Active</span>';
					// $login_details .= $print->last_login_on != "" ? '<br>Last Login On: '.date('d M, Y h:i A',strtotime($print->last_login_on)) : '';
				}else{
					$login_details = '<span class="badge badge-danger" background-color: orange;>Inactive</span>';
					$login_details .= $print->last_logout_on != "" ? '<br><small>Logout On:<br>'.date('d M, Y h:i A',strtotime($print->last_logout_on)).'</small>' : '';
				}
				
				$project = $print->project;

				$sub_array = array();
				$sub_array[] = $offset++;
				$sub_array[] = $login_details;
				$sub_array[] = $print->last_login_on != "" ? date('d M, Y h:i A',strtotime($print->last_login_on)) : '';
				// $sub_array[] = $project;
				$sub_array[] = $print->username;
				$sub_array[] = ($print->name != "" ? '<p><b>Name:</b> '.$print->name.'</p>' : '') . '' . ($print->mobile_no != "" ? '<p><b>Mobile:</b> '.$print->mobile_no.'</p>' : '') . '' . ($print->email != "" ? '<p><b>Email:</b> '.$print->email.'</p>' : '');
				$sub_array[] = $print->device_id;
				$device_Details_table = '
					<button type="button" onclick="showDevicePopup(\'exampleModal_'.$print->id.'\')" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_'.$print->id.'">
						View
					</button>
					<div class="modal fade" id="exampleModal_'.$print->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_'.$print->id.'" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel_'.$print->id.'">Device Details</h5>
									<button type="button" style="margin-top: -25px;" class="close" data-dismiss="modal" aria-label="Close" onclick="closeDevicePopup(\'exampleModal_'.$print->id.'\')">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<table class="device_Details_table table table-bordered">
										<thead>
											<tr>
												<th>Key</th>
												<th>Value</th>
											</tr>
										</thead>
										<tbody>';

					$device_details = json_decode($print->device_details, true);
					foreach ($device_details as $key => $value) {
						$display_name = ucwords(str_replace('_', ' ', $key));
						$device_Details_table .= '<tr>
													<td><strong>' . htmlspecialchars($display_name) . '</strong></td>
													<td>' . ($value !== null ? htmlspecialchars($value) : 'N/A') . '</td>
												</tr>';
					}

					$device_Details_table .= '    </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<script>
					$(document).ready(function() {
						// Initialize DataTable when the modal is shown
						$("#exampleModal_'.$print->id.'").on("shown.bs.modal", function() {
							$(this).find(".device_Details_table").DataTable({ 
								dom: "Blfrtip",
								lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
								buttons: [				
									{
										extend: "excel",
										filename: "Device Details",
										exportOptions: {
											columns: [0, 1] 
										}
									},	
								],
								destroy: true // Allow reinitialization
							});
						});
					});
					</script>';
				$sub_array[] = $device_Details_table;
				$permission_Details_table = '
					<button type="button" onclick="showLocationPopup(\'examplePermissionModal_'.$print->id.'\')" class="btn btn-primary" data-toggle="modal" data-target="#examplePermissionModal_'.$print->id.'">
						View
					</button>
					<div class="modal fade" id="examplePermissionModal_'.$print->id.'" tabindex="-1" role="dialog" aria-labelledby="examplePermissionModalLabel_'.$print->id.'" aria-hidden="true">
						<div class="modal-dialog" role="document" style="width: 750px;">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="examplePermissionModalLabel_'.$print->id.'">Permission Details</h5>
									<button type="button" style="margin-top: -25px;" class="close" data-dismiss="modal" aria-label="Close" onclick="closeLocationPopup(\'examplePermissionModal_'.$print->id.'\')">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<table class="permission_details_table table table-bordered">
										<thead>
											<tr>
												<th>Permission</th>
												<th>Is Required</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>';

					$permission_details = json_decode($print->permission_details, true);
					foreach ($permission_details as $permission) {
						$permission_name = htmlspecialchars($permission['permission']);
						$is_required = isset($permission['is_required']) ? htmlspecialchars($permission['is_required']) : '-';
						$status = htmlspecialchars($permission['status']);
						
						$permission_Details_table .= '<tr>
											<td>' . $permission_name . '</td>
											<td>' . $is_required . '</td>
											<td>' . $status . '</td>
										</tr>';
					}

					$permission_Details_table .= '    </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<script>
					$(document).ready(function() {
						$("#examplePermissionModal_'.$print->id.'").on("shown.bs.modal", function() {
							$(this).find(".permission_details_table").DataTable({ 
								dom: "Blfrtip",
								lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
								buttons: [				
									{
										extend: "excel",
										filename: "Permission Details",
										exportOptions: {
											columns: [0, 1, 2] 
										}
									},	
								],
								destroy: true // Allow reinitialization
							});
						});
					});
					</script>';
				$sub_array[] = $permission_Details_table;
				$data[] = $sub_array; 
			}
		}
		$TotalProducts = $this->Admin_model->get_app_users_count_ajx($search);
		
		$output = array(
			"draw" 				=> $draw,
			"recordsTotal" 		=> $TotalProducts,
			"recordsFiltered" 	=> $TotalProducts,
			"data" 				=> $data
		);
		echo json_encode($output);
		exit();
	}


    public function get_details_by_cat()
    {
        $this->EbookCategory_model->get_details_by_cat();
    }

    // public function get_details_by_cat()
    // {
    //     $selectedValue = $this->input->post('selectedValue');
    //     echo "here";
    //     exit;
    //     $result = $this->EbookCategory_model->get_details_by_cat($selectedValue);

    //     if (!empty($result)) {
    //         echo json_encode($result); // Return the mobile numbers as JSON
    //     } else {
    //         echo json_encode(['error' => 'No data found']); // Handle if no data is found
    //     }
    // }
}
