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
<div class="modal fade" id="editfeeds" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" id="getFeedEdit">
      <form class="form-horizontal" id="edit_job_alert" enctype="multipart/form-data" action="<?php echo base_url() ?>JobAlert/editPost" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Job Alert </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                              <input type="hidden" name="e_job_alert_id" id="e_job_alert_id" class="form-control text"
                                  placeholder="Post ID">
                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">

                                             <div class="col-md-4">
                                                <b>Job Alert Title :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="e_job_title" id="e_job_title"
                                                               class="form-control text" placeholder="Title">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>For Exam Group</b>
                                                <div class="input-group" id="edit_exams">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="e_Exam_Id[]" id="e_Exam_Id" multiple="">
                                                        <?php
                                                        if (isset($exams)){
                                                            foreach ($exams as $key) {
                                                                ?>
                                                                <option value="<?php echo($key['exam_id']); ?>"><?php echo($key['exam_name']); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="e_status" id="e_status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>
                                            
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <b>Apply Link :</b>
                                                <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="material-icons">person</i>
                                                 </span>
                                                    <div class="form-line">
                                                        <input type="text" name="e_apply_link" id="e_apply_link"
                                                               class="form-control text" placeholder="Job Link"
                                                        >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Job Poster</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">security</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="e_file"  id="e_file"/>
                                                    </div>
                                                </div>
                                                <div id="show_img"></div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Job Pdf</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">security</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="pdf"  id="e_pdf"/>
                                                    </div>
                                                </div>
                                                <div id="show_pdf"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <b>Description :</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea rows="4" class="form-control no-resize" id="e_job_description" name="e_job_description" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="e_img1" id="e_img1"
                                                   class="form-control text" placeholder="Image">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
