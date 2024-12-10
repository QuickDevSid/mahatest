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
            <h2>DASHBOARD -> Manage Exam</h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Manage Exam
                            <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                    data-target="#addExam">
                                <i class="material-icons">devices</i>
                                <span>ADD EXAM</span>
                            </button></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="user_data" class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Exam Name</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Added On</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>Exam Name</th>
                                    <th>Status</th>
                                    <th>Added On</th>
                                </tr>
                                </tfoot>
                                <tbody></tbody>
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
<div class="modal fade" id="addExam" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="addExamForm" action="<?php echo base_url() ?>All_exam_list_API/addExam" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Exam</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-12">
                                                <b>Name</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="exam_name" id="exam_name" class="form-control text" placeholder="Exam name" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <p><b>Status</b></p>
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">enhanced_encryption</i>
                                                </span>
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" name="status" id="status" required>
                                                            <option value="Active">Active</option>
                                                            <option value="Inactive">Inactive</option>
                                                        </select>
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
                    <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS</button>
                    <button type="button" name="close" id="close" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Modal Dialogs ====================================================================================================================== -->
<!-- Default Size -->
<div class="modal fade" id="editExamDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="editExamForm" action="<?php echo base_url() ?>All_exam_list_API/updateExam" method="POST">
            <input type="hidden" name="exam_id" id="edit_exam_id" class="form-control text" placeholder="ID" required>

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Exam</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-12">
                                                <b>Name</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="exam_name" id="edit_exam_name" class="form-control text" placeholder="Exam name" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <p><b>Status</b></p>
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">enhanced_encryption</i>
                                                </span>
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" name="status" id="edit_status" required>
                                                            <option value="Active">Active</option>
                                                            <option value="Inactive">Inactive</option>
                                                        </select>
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
                    <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS</button>
                    <button type="button" name="close" id="close" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </form>
    </div>
</div>