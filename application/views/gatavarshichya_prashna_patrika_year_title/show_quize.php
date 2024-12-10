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
<div class="modal fade" id="showquiz" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="getquizDetails" action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Show Test Series</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                          <input type="hidden" name="quiz_title" id="s_quiz_id"
                                                 class="form-control text" placeholder="Title"
                                                >
                                             <div class="col-md-12">
                                                <b>Test Series :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                      <select class="form-control" id="test_series">
                                                        <?php
                                                          $sql="SELECT * FROM test_series WHERE status='Active'";
                                                          $check=$this->common_model->executeArray($sql);
                                                          if($check)
                                                          {
                                                            foreach ($check as $value)
                                                            {
                                                              echo '<option value="'.$value->test_series.'">'.$value->test_title.'</option>';
                                                            }
                                                          }
                                                        ?>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="col-md-12">
                                                <b>Title :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="quiz_title" id="s_quiz_title"
                                                               class="form-control text" placeholder="Title"
                                                              disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                               <b>Test Series Questions :</b>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <i class="material-icons">person</i>
                                                   </span>
                                                   <div class="form-line">
                                                       <input type="number" name="quiz_qua" id="s_quiz_questions"
                                                              class="form-control text" placeholder="Add Quiz Question In Number"
                                                             disabled>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-12">
                                              <b>Test Series Duration:</b>
                                              <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">person</i>
                                                  </span>
                                                  <div class="form-line">
                                                      <input type="number" name="quiz_duration" id="s_quiz_duration"
                                                             class="form-control text" placeholder="Add Quiz Time Duaration In Number"
                                                            disabled>
                                                  </div>
                                              </div>
                                          </div>

                                           <div class="col-md-12">
                                              <b>Test Series correct answer mark:</b>
                                              <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">person</i>
                                                  </span>
                                                  <div class="form-line">
                                                      <input type="number" name="quiz_duration" id="s_correct_answer_mark"
                                                             class="form-control text" placeholder=""
                                                            disabled>
                                                  </div>
                                              </div>
                                          </div>
                                           <div class="col-md-12">
                                              <b>Test Series wrong answer mark:</b>
                                              <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">person</i>
                                                  </span>
                                                  <div class="form-line">
                                                      <input type="number" name="quiz_duration" id="s_wrong_answer_mark"
                                                             class="form-control text" placeholder=""
                                                            disabled>
                                                  </div>
                                              </div>
                                          </div>




                                            <div class="col-md-12">
                                                <b>
                                                    Instructions</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="Description" id="s_instruction" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                               <p>
                                                   <b>Test Series Status</b>
                                               </p>
                                               <select class="form-control show-tick" name="quiz_status" id="s_status">
                                                   <option value="Active">Active</option>
                                                   <option value="Deactive">Deactive</option>

                                               </select>

                                           </div>
                                            <div class="col-md-12">
                                                <b>Created On</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">security</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="date" name="CreatedOn" id="s_created_at"
                                                               class="form-control text" placeholder="CreatedOn" disabled>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
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
        </form>
    </div>
</div>
