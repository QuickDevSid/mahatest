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
<div class="modal fade" id="editquiz" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="getquizDetails" action="<?php echo base_url()?>Daily_quiz/update_exam" method="POST" >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Daily Quiz</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                          <input type="hidden" name="e_quiz_id" id="e_quiz_id"
                                                 class="form-control text" placeholder="Title"
                                                >
                                             <div class="col-md-12">
                                                <b>Exams :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                      <select class="form-control  show-tick" id="e_exams" name="e_exams[]" multiple="">
                                                        <?php
                                                          $sql="SELECT * FROM exams WHERE status='Active'";
                                                          $check=$this->common_model->executeArray($sql);
                                                          if($check)
                                                          {
                                                            foreach ($check as $value)
                                                            {
                                                              echo '<option value="'.$value->exam_id.'">'.$value->exam_name.'</option>';
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
                                                        <input type="text" name="e_quiz_title" id="e_quiz_title"
                                                               class="form-control text" placeholder="Title"
                                                              >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                               <b> Questions :</b>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <i class="material-icons">person</i>
                                                   </span>
                                                   <div class="form-line">
                                                       <input type="number" name="e_quiz_questions" id="e_quiz_questions" step="0.01"
                                                              class="form-control text" placeholder="Add Quiz Question In Number"
                                                             >
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-12">
                                              <b> Duration:</b>
                                              <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">person</i>
                                                  </span>
                                                  <div class="form-line">
                                                      <input type="number" name="e_quiz_duration" id="e_quiz_duration" step="0.01"
                                                             class="form-control text" placeholder="Add Quiz Time Duaration In Number"
                                                            >
                                                  </div>
                                              </div>
                                          </div>

                                           <div class="col-md-12">
                                              <b> correct answer mark:</b>
                                              <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">person</i>
                                                  </span>
                                                  <div class="form-line">
                                                      <input type="number" name="e_correct_answer_mark" id="e_correct_answer_mark" step="0.01"
                                                             class="form-control text" placeholder=""
                                                            >
                                                  </div>
                                              </div>
                                          </div>
                                           <div class="col-md-12">
                                              <b>wrong answer mark:</b>
                                              <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">person</i>
                                                  </span>
                                                  <div class="form-line">
                                                      <input type="number" name="e_wrong_answer_mark" id="e_wrong_answer_mark" step="0.01"
                                                             class="form-control text" placeholder=""
                                                            >
                                                  </div>
                                              </div>
                                          </div>




                                            <div class="col-md-12">
                                                <b>
                                                    Instructions</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="e_instructions" id="e_instruction" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                               <p>
                                                   <b>Test Series Status</b>
                                               </p>
                                               <select class="form-control show-tick" name="e_status" id="e_status">
                                                   <option value="Active">Active</option>
                                                   <option value="Deactive">Deactive</option>

                                               </select>

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
                    <button type="submit" name="edit_submit" id="edit_submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                  
                    <button type="button" name="edit_close" id="edit_close" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>