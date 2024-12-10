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
<div class="modal fade" id="add_upload" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_upload_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Videos/add_data_upload" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Videos by Uploading</h4>
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
                                                        <input type="text" name="Title_u" id="Title_u" class="form-control text" placeholder="Title" required>
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
                                                        <select class="form-control" id="exam_u" name="exams_u[]" multiple="">
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
                                                        <input name="URL_u" id="URL_u" type="file"/>
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
                                                        <input type="text" name="duration_u" id="duration_u" class="form-control text" placeholder="Duration" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <p>
                                                    <b>Video Availability</b>
                                                </p>
                                                <select class="form-control show-tick" name="video_status_u" id="video_status_u">
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
                                                        <input name="Thumbnail_u" id="Thumbnail_u" type="file"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status_u" id="status_u">
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <b>Description </b>
                                                <div class="input-group">

                                                    <div class="form-line">
                                                        <textarea rows="4" class="form-control no-resize" id="description_u" name="description_u" placeholder="Please type video description..." spellcheck="false"></textarea>
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
