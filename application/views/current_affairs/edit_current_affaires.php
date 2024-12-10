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
<div class="modal fade" id="edit_post" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="edit_current_affair_form"  enctype="multipart/form-data" action="<?php echo base_url() ?>CurrentAffairs/editPost" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Post Details</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <input type="hidden" name="edit_id" id="edit_id" class="form-control text"
                                                   placeholder="Post ID">
                                            <input type="hidden" name="post_image_old" id="post_image_old" />
                                            
                                            <div class="row">
                                            <div class="col-md-6">
                                                <b>Posts Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="edit_PostTitle" id="edit_PostTitle"
                                                               class="form-control text" placeholder="Title"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>


                                                <!-- <div class="col-md-4">
                                                    <b>For Exam Group</b>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                        <select class="form-control show-tick" name="edit_Exam_Id[]" id="edit_Exam_Id" multiple="">
                                                            <?php
                                                            /* if (isset($exams)){
                                                                foreach ($exams as $key) { */
                                                                    ?>
                                                                    <option value="<?php echo($key['exam_id']); ?>"><?php echo($key['exam_name']); ?></option>
                                                                    <?php
                                                               /*  }
                                                            } */
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                
                                            <div class="col-md-6">
                                                <b>Category</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                      
                                                    <select class="form-control show-tick" name="category" id="edit_category" required>
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        if (isset($category)){
                                                            //print_r($category);
                                                            foreach ($category as $key) { 
                                                                //print_r($key);
                                                                ?>
                                                                <option value="<?php echo($key->id); ?>"><?php echo($key->title); ?></option>
                                                                <?php
                                                            }
                                                        } 
                                                        ?>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b>Status</b>
                                                <div class="input-group" id="edit_status">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="edit_Status" id="edit_Status">
                                                        <option value="Active">Active</option>
                                                        <option value="InActive">InActive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <b>Post Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="post_image" type="file" multiple />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b>Date</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="current_date" id="edit_current_date" type="date" style="background: transparent;border:none;" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Sequence</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" min="1" name="sequence_no" id="edit_sequence_no"
                                                               class="form-control text" placeholder="Sequence" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b>Description</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="edit_Description" id="edit_Description" placeholder="Description" required></textarea>
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
                    <button type="submit" name="edit_submit" id="edit_submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
