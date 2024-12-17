<?php
/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */
?>
<!-- Modal Dialogs ====================================================================================================================== -->
<!-- Default Size -->
<div class="modal fade" id="addquizqua" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_quiz_qua" action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Question<a href="#" id="question_model_show_button" class="btn btn-primary right" onclick="change_add_question_panel()">SHOW</a></h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                          <div id="addquizQuaDetails">
                                            <input type="hidden" name="quiz_id" id="quiz_id">
                                            <input type="hidden" name="edit_id" id="edit_id" value="0">
                                          </div>
                                          <div class="col-md-12">
                                              <h2 class="card-inside-title">Quiz Question</h2>
                                              <div class="input-group">
                                                  <div class="form-line">
                                                      <textarea rows="1" name="quiz_quation" id="quiz_quation"
                                                                class="form-control no-resize auto-growth"
                                                                placeholder="Quiz Question" ></textarea>
                                                  </div>
                                              </div>
                                          </div>
                                            <div class="col-md-6">
                                                <b>Option 1</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <input type="text" name="quiz_opt1" id="quiz_opt1"
                                                               class="form-control text" placeholder="Enter Question 1"
                                                               required >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <b>Option 2</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <input type="text" name="quiz_opt2" id="quiz_opt2"
                                                               class="form-control email"
                                                               placeholder="Enter Question 2" required >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Option 3</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <input type="text" name="quiz_opt3" id="quiz_opt3"
                                                               class="form-control email"
                                                               placeholder="Enter Question 3" required >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Option 4</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <input type="text" name="quiz_opt4" id="quiz_opt4"
                                                               class="form-control email"
                                                               placeholder="Enter Question 4" required >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Select Answer</b>
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">email</i>
                                                </span>
                                                    <div class="form-line">
                                                       <select class="form-control show-tick" name="option_btn" id="option_btn" onchange="return get_option(this)">
                                                           <option value="">Select Option </option>
                                                           <option value="1">Option 1</option>
                                                           <option value="2">Option 2</option>
                                                           <option value="3">Option 3</option>
                                                           <option value="4">Option 4</option>

                                                       </select>
                                                    </div>
                                                </div>
                                            </div>


                                            
<!--                                             <div class="col-md-6">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="image" type="file" multiple />
                                                    </div>
                                                </div>
                                            </div> -->

                                            <div class="col-md-4">
                                                <b>Section:</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control" id="subject_id" name="subject_id">
                                                            <?php
                                                            $sql="SELECT * FROM quiz_subject WHERE status='Active'";
                                                            $check=$this->common_model->executeArray($sql);
                                                            if($check)
                                                            {
                                                                foreach ($check as $value)
                                                                {
                                                                    echo '<option value="'.$value->subject_id.'">'.$value->subject_name.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                            
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="quiz_status" id="quiz_status">
                                                    <option value="Active">Active</option>
                                                    <option value="Deactive">Deactive</option>

                                                </select>
                                            </div>


                                            <div class="col-md-12">
                                                <b>
                                                    Explanation</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="explanation" id="explanation" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row clearfix">

                                            

                                           

                                            

                                            <div class="col-md-6 hidden">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="type" id="type">
                                                    <option value="text">Text</option>
                                                    <option value="image">Image</option>

                                                </select>
                                            </div>
                                            <div class="col-md-6 hidden">
                                                <b>Question Answer</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <input type="text" name="quiz_ans" id="quiz_ans"
                                                               class="form-control email"
                                                               placeholder="Enter Question Answer" required >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" name="edit_submit" id="edit_submit" class="btn btn-link waves-effect">SAVE DETAILS
                                      </button>

                                    </div>
                              </form>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h2>All Question</h2>
                                </div>
                                <div class="body">
                                  <div class="table-responsive js-sweetalert">
                                    <table id="client_licenses"
                                              class="table table-bordered table-striped table-hover dataTable js-exportable nowrap"
                                              width="100%">
                                           <thead>
                                           <tr>
                                                <th>Action</th>
                                               <th>Subject</th>
                                               <th>Question</th>
                                               <th>Option 1</th>
                                               <th>Option 2</th>
                                               <th>Option 3</th>
                                               <th>Option 4</th>
                                               <th>Answer</th>
                                               <th>Status</th>


                                           </tr>
                                           </thead>
                                           <tfoot>
                                           <tr>
                                             <th>Action</th>
                                             <th>Subject</th>
                                             <th>Question</th>
                                             <th>Option 1</th>
                                             <th>Option 2</th>
                                             <th>Option 3</th>
                                             <th>Option 4</th>
                                             <th>Answer</th>
                                             <th>Status</th>


                                           </tr>
                                           </tfoot>
                                           <tbody>

                                           </tbody>
                                       </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">

                    <button type="button" name="edit_close" id="edit_close" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>

    </div>
</div>
