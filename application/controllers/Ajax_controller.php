<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax_controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("TestSetup_model");
        $this->load->model("CurrentAffairs_model");
        $this->load->model("news_model");
        $this->load->model("EbookCategory_model");
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
                $sub_array[] = $print->total_questions != "" ? $print->total_questions : '';
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
