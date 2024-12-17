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
<div class="modal fade" id="edit_upload" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="edit_upload_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Videos/update_data_upload" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Update Videos by Uploading</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="hidden" name="edit_id_u" id="edit_id_u">
                                                        <input type="text" name="edit_Title_u" id="edit_Title_u" class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Exams :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control" id="edit_exam_u" name="edit_exams_u[]" multiple="">
                                                            <?php
                                                            $sql = "SELECT * FROM exams WHERE status='Active'";
                                                            $check = $this->common_model->executeArray($sql);
                                                            if ($check) {
                                                                foreach ($check as $value) {
                                                                    echo '<option value="' . $value->exam_id . '">' . $value->exam_name . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">

                                            <div class="col-md-6">
                                                <b>Video File - Upload your video to server</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="edit_URL_u" id="edit_URL_u" type="file"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Duration - Video Length </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="edit_duration_u" id="edit_duration_u" class="form-control text" placeholder="Duration" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <p>
                                                    <b>Video Availability</b>
                                                </p>
                                                <select class="form-control show-tick" name="edit_video_status_u" id="edit_video_status_u">
                                                    <option value="free">Free</option>
                                                    <option value="paid">paid</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Video Thumbnail</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="edit_Thumbnail_u" id="edit_Thumbnail_u" type="file"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="edit_status_u" id="edit_status_u">
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <b>Description </b>
                                                <div class="input-group">

                                                    <div class="form-line">
                                                        <textarea rows="4" class="form-control no-resize" id="edit_description_u" name="edit_description_u" placeholder="Please type video description..." spellcheck="false"></textarea>
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
                    <button type="submit" name="submit" id="submit_u" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
