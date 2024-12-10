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
<div class="modal fade" id="viewUser" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <form id="viewuserform" action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">User Detail</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <input type="hidden" name="view_id" id="view_id" class="form-control text"
                                                   placeholder="User ID">
                                            <div class="col-md-6">
                                                <b>Name</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="view_name" id="view_name" class="form-control text" placeholder="User name" required disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <b>Mobile No.</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">dialpad</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="view_mobile" id="view_mobile" class="form-control phone" placeholder="Mobile No." required disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Email ID.</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">email</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="view_email" id="view_email" class="form-control email" placeholder="Email ID." required disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Password</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">security</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="view_password" id="view_password" class="form-control text" placeholder="Password" required disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                             <p> <b>User Type</b> </p>
                                             <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">wifi_lock</i>
                                                </span>
                                                <div class="form-line">
                                                    <select class="form-control show-tick" name="view_type" id="view_type" required disabled>
                                                        <option value="Super Admin">Super Admin</option>
                                                        <option value="Admin">Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <p><b>Status</b></p>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">enhanced_encryption</i>
                                                </span>
                                                <div class="form-line">
                                                    <select class="form-control show-tick" name="view_status" id="view_status" required disabled>
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
                <button type="button" name="close" id="close" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </form>
</div>
</div>