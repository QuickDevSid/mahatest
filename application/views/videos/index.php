
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

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Videos  </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                         Videos
                          <button type="button" class="btn bg-teal waves-effect pull-right m-l-5" data-toggle="modal"
                                     data-target="#add">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Videos</span>
                             </button>
                            
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="user_data"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Exam</th>
                                    <th>Link</th>
                                    <th>Duration</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Added On</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Exam</th>
                                    <th>Link</th>
                                    <th>Duration</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Added On</th>
                                </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->

        </div>
    </div>
</section>


<div class="modal fade" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_upload_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Videos/add_video_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Videos</h4>
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
                                                            
                                                            if ($examArr) {
                                                                foreach ($examArr as $value) {
                                                                    echo '<option value="' . $value['exam_id'] . '">' . $value['exam_name'] . '</option>';
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
                                                <p>
                                                    <b>Video Type</b>
                                                </p>
                                                <select class="form-control show-tick" name="video_type" id="video_type">
                                                    <option value="">Select type</option>
                                                    <option value="upload">Upload</option>
                                                    <option value="youtube">Youtube</option>
                                                    <option value="vimeo">Vimeo</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6" id="upload_video_div" style="display:none;">
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
                                            <div class="col-md-6" id="vimeo_video_div" style="display:none;">
                                                <b>Video ID - Such as : 417703774 </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="URL_v" id="URL_v" class="form-control text" placeholder="Video ID - Such as : 417703774" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="youtube_video_div" style="display:none;">
                                                <b>Video ID - Such as : KzyXIqoXZ38 </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="URL_y" id="URL_y" class="form-control text" placeholder="Video ID - Such as : KzyXIqoXZ38" >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-6">
                                                <b>Duration - Video Length </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="duration" id="duration" class="form-control text" placeholder="Duration" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <b>Video Availability</b>
                                                </p>
                                                <select class="form-control show-tick" name="video_status" id="video_status">
                                                    <option value="free">Free</option>
                                                    <option value="paid">paid</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b>Video Thumbnail</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="Thumbnail" id="Thumbnail" type="file"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" id="status">
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b>Description </b>
                                                <div class="input-group">

                                                    <div class="form-line">
                                                        <textarea rows="4" class="form-control no-resize" id="description" name="description" placeholder="Please type video description..." spellcheck="false"></textarea>
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

<div class="modal fade" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="edit_upload_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Videos/update_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Update Videos</h4>
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
                                                            if ($examArr) {
                                                                foreach ($examArr as $value) {
                                                                    echo '<option value="' . $value['exam_id'] . '">' . $value['exam_name'] . '</option>';
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
                                                <p>
                                                    <b>Video Type</b>
                                                </p>
                                                <select class="form-control show-tick" name="video_type" id="video_type">
                                                    <option value="">Select type</option>
                                                    <option value="upload">Upload</option>
                                                    <option value="youtube">Youtube</option>
                                                    <option value="vimeo">Vimeo</option>
                                                </select>
                                            </div>
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
                                        </div>
                                        <div class="row">
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
                                            <div class="col-md-6">
                                                <p>
                                                    <b>Video Availability</b>
                                                </p>
                                                <select class="form-control show-tick" name="edit_video_status_u" id="edit_video_status_u">
                                                    <option value="free">Free</option>
                                                    <option value="paid">paid</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            
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
                                        </div>
                                        <div class="row">
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

