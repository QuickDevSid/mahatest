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
<div class="modal fade" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_current_affair_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Exam_subject/update_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Subject </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <input type="hidden" name="edit_id" id="edit_id" value="">
                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-3">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="Title" id="edit_Title"
                                                               class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Section</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" name="section" id="edit_section" >
                                                            <option value="">Select Section</option>
                                                            <?php
                                                            if($examSectionArr){
                                                                foreach($examSectionArr as $r){
                                                                    ?>
                                                                    <option value="<?=$r['title'];?>"><?=$r['title']?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <option value="Courses">Courses</option>
                                                            <option value="MPSC">MPSC</option>
                                                            <option value="Test Series">Test Series</option>
                                                            <option value="Mock Test">Mock Test</option>
                                                            <option value="Current Affairs">Current Affairs</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Upload Icon Image</b>
                                                <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">security</i>
                                                  </span>
                                                    <div class="form-line">
                                                        <input type="file" name="edit_iconfile"  accept="image/*" />
                                                        <input type="hidden" name="old_iconfile" id="old_iconfile">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <img class="img-fluid rounded" style="width: 100%;" id="e_img" src="">
                                            </div>

                                            <div class="col-md-12">
                                                <b>Description</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <textarea name="description" id="edit_description"
                                                               class="form-control" placeholder="Description" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" id="edit_status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
