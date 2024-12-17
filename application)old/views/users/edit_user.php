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
<div class="modal fade" id="editUser" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="edituserform" action="<?php echo base_url() ?>User/updateUser" method="POST">
            <input type="hidden" name="id" id="edit_id" class="form-control text" placeholder="ID" required>

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add User</h4>
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
                                                        <input type="text" name="name" id="edit_name" class="form-control text" placeholder="User name" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <b>Mobile No.</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">dialpad</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="mobile" id="edit_mobile" class="form-control phone" placeholder="Mobile No." required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <b>Email ID.</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">email</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="email" id="edit_email" class="form-control email" placeholder="Email ID." required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <b>Password</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">security</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="password" id="edit_password" class="form-control text" placeholder="Password" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p> <b>User Type</b> </p>
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">wifi_lock</i>
                                                </span>
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" name="type" id="edit_type" required>
                                                            <option value="Super Admin">Super Admin</option>
                                                            <option value="Admin">Admin</option>
                                                        </select>
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