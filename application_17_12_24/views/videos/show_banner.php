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
<div class="modal fade" id="showbanner" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" id="getbannerDetails">
        <form class="form-horizontal" id="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel"> Banner Img Details</h4>
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
                                                <b>Banner Image Status :</b>
                                                <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="material-icons">person</i>
                                                 </span>
                                                    <div class="form-line">
                                                        <input type="text" name="s_status" id="s_status" class="form-control text" placeholder="Title" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Created On</b>
                                                <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <i class="material-icons">security</i>
                                                   </span>
                                                    <div class="form-line">
                                                        <input type="text" name="s_created_at" id="s_created_at" class="form-control text" placeholder="CreatedOn" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <b>Banner Image :</b>
                                                <div class="input-group">
                                                    <div class="col-md-12">
                                                        <img class="img-fluid rounded" style="width: 100%;" id="s_img" src="">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- assets/images/> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
