
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
            <h2>DASHBOARD -> Exam Sub Subjects  </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                         Exam Sub Subjects
                          <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                     data-target="#add">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Exam Sub Subjects</span>
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
                                    <th>Subject</th>
                                    <th>Title</th>
                                    <th width="10%">Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Subject</th>
                                    <th>Title</th>
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

<!-- Modal Dialogs ====================================================================================================================== -->
<!-- Default Size -->
<div class="modal fade" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_current_affair_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Exam_subsubject/add_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Sub Subject </h4>
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
                                              <p>
                                                  <b>Subject</b>
                                              </p>
                                              <select class="form-control show-tick" name="subject_id" >
                                                <option value="">Select Subject</option>
                                                <?php 
                                                    if($exam_subject_arr){
                                                        foreach($exam_subject_arr as $row){
                                                            ?>
                                                            <option value="<?=$row->subject_id;?>"><?=$row->subject_name;?></option>
                                                            <?php
                                                        }
                                                    }
                                                 ?>
                                              </select>

                                          </div>
                                            <div class="col-md-6">
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
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6">
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
                                           <div class="col-md-6">
                                              <p>
                                                  <b>Status</b>
                                              </p>
                                              <select class="form-control show-tick" name="status" >
                                                  <option value="Active">Active</option>
                                                  <option value="InActive">InActive</option>

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
        <form id="add_current_affair_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Exam_subsubject/update_data" method="POST">
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
                                            <div class="col-md-6">
                                              <p>
                                                  <b>Subject</b>
                                              </p>
                                              <select class="form-control show-tick" name="subject_id" id="edit_subject_id" >
                                                <option value="">Select Subject</option>
                                                <?php 
                                                    if($exam_subject_arr){
                                                        foreach($exam_subject_arr as $row){
                                                            ?>
                                                            <option value="<?=$row->subject_id;?>"><?=$row->subject_name;?></option>
                                                            <?php
                                                        }
                                                    }
                                                 ?>
                                              </select>

                                            </div>
                                            <div class="col-md-6">
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
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
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
                                            <div class="col-md-6">
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

