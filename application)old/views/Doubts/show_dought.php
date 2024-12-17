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
<div class="modal fade" id="showdought" tabindex="-1" role="dialog">
  


    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Doubt Details</h4>
            </div>
            <div class="modal-body">
                <!-- Masked Input -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body">
                                <div class="row">
                                    <!-- Post Content Column -->
                                    <div class="col-lg-12">
                                        <!-- Title -->
                                        <h1 class="mt-4" id="d_user_title">User Name</h1>
                                        <!-- Author -->
                                        <p class="lead">
                                            for <a href="#" id="d_exam_group">Exam Group</a>
                                        </p>
                                        <hr>
                                        <!-- Date/Time -->
                                        <p id="d_created_at">Posted on January 1, 2019 at 12:00 PM</p>
                                        <hr>
                                        <!-- Preview Image -->
                                        <div id="d_post_image">
                                            <img class="img-fluid rounded" style="width: 100%;" src="http://placehold.it/900x300" alt="" >
                                        </div>

                                        <hr>
                                        <!-- Post Content -->
                                        <p id="d_question">Question</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <form id="add_doubt_comment_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Doubts/add_data" method="POST">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <div class="col-md-10">
                                                    <b>Message</b>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                        <div class="form-line">
                                                            <input type="text" name="message" id="message"
                                                                   class="form-control text" placeholder="Message" required>
                                                            <input type="hidden" name="id" id="id"
                                                                   class="form-control text" placeholder="ID" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" name="submit" id="submit" class="btn btn-primary waves-effect">PUBLISH COMMENT
                                                    </button>
                                                </div>
                                            </div>
                                            
                                           
                                        </div>
                                    </form>
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <!-- Post Content Column -->
                                    <div class="col-lg-12">
                                        <!-- Comment with nested comments -->
                                        <div class="media mb-4" id="d_comment">
                                            <div class="media mt-4">
                                                <div class="media-left">
                                                    <img class="d-flex mr-3 rounded-circle media-left" width="64" height="64" src="http://placehold.it/50x50" alt=""></div>
                                                <div class="media-body">
                                                    <h5 class="mt-0">Commenter Name</h5>
                                                    Comment Detail
                                                </div>
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

            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                </button>
            </div>
        </div>

    </div>
</div>
