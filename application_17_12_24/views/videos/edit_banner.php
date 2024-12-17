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
<div class="modal fade" id="editbanner" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" id="getbannerDetails">
        <form class="form-horizontal" id="submit_ebanner">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Banner Image </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <input type="hidden" name="e_banner_id" id="e_banner_id" class="form-control text" placeholder="Post ID">
                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <p>
                                                    <b>Banner Image Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="e_status" id="e_status">
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Upload Banner Image</b>
                                                <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <i class="material-icons">security</i>
                                                   </span>
                                                    <div class="form-line">
                                                        <input type="file" name="file"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <b>Banner Image :</b>
                                                <div class="input-group">
                                                    <div class="col-md-12">
                                                        <img class="img-fluid rounded" style="width: 100%;" id="e_img" src="">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="e_img1" id="e_img1" class="form-control text" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">UPDATE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
