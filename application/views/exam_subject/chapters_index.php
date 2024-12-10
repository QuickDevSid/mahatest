
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
            <h2>DASHBOARD -> Chapters  </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                         Chapters
                          <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                     data-target="#add">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Chapter</span>
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
                                    <th>Class</th>
                                    <th width="10%">Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Class</th>
                                    <th width="10%">Status</th>
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
        <form id="add_current_affair_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Exam_subject/add_data_chapters" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Chapter </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

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
                                                        <input type="text" name="Title" id="Title"
                                                               class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Class</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" name="class_id" >
                                                            <option value="">Select Class</option>
                                                            <?php
                                                            if($examSectionArr){
                                                                foreach($examSectionArr as $r){
                                                                    ?>
                                                                    <option value="<?=$r->id;?>"><?=$r->title?> (<?=$r->subject_name?>)</option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

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
                                                        <input type="file" name="iconfile"  accept="image/*" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b>Description</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <textarea name="description" id="description"
                                                                  class="form-control" placeholder="Description" required></textarea>
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


<div class="modal fade" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_current_affair_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Exam_subject/update_data_chapters" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Class </h4>
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
                                                        <select class="form-control show-tick" name="class_id" id="edit_class_id" >
                                                            <option value="">Select Subject</option>
                                                            <?php
                                                            if($examSectionArr){
                                                                foreach($examSectionArr as $r){
                                                                    ?>
                                                                    <option value="<?=$r->id;?>"><?=$r->title ?> (<?=$r->subject_name?>)</option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

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