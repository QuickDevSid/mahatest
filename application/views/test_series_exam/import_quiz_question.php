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
<div class="modal fade" id="importQuestion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="import_quiz_qua" action="<?php echo base_url() ?>Test_series_exam/importQuestions" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Import Quiz Question <a href="/assets/uploads/TestSeriesExamFormat.xlsx" class="btn btn-sm btn-primary right" download>Download Format</a></h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="add_question_panel" class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                          <div id="addquizQuaDetails">
                                            <input type="hidden" name="import_quiz_id" id="import_quiz_id">
                                          </div>
                                          
                                           
                                            <div class="col-md-4">
                                                <b>Section:</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control" id="import_subject_id" name="import_subject_id">
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
                                                <b>Question Excel</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="uploadFile" type="file" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS
                                      </button>

                                    </div>
                              </form>
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
