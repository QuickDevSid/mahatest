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
<div class="modal fade" id="addstudycontent" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_study_content" action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Study Material Content Quiz </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                          <div id="addContentDetails">
                                            <input type="hidden" name="content_id" id="content_id" class="form-control text"
                                                   placeholder="Client ID">
                                          </div>
                                          <div class="col-md-12">
                                             <b>Quiz Title :</b>
                                             <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="material-icons">person</i>
                                                 </span>
                                                 <div class="form-line">
                                                     <input type="text" name="study_quiz_title" id="study_quiz_title"
                                                            class="form-control text" placeholder="Quiz Title"
                                                           >
                                                 </div>
                                             </div>
                                         </div>
                                          <div class="col-md-12">
                                             <b>Quiz Total Question :</b>
                                             <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="material-icons">person</i>
                                                 </span>
                                                 <div class="form-line">
                                                     <input type="number" name="study_total_qua" id="study_total_qua"
                                                            class="form-control text" placeholder="Quiz Total Question"
                                                           >
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-md-12">
                                            <b>Quiz Total Time :</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">person</i>
                                                </span>
                                                <div class="form-line">
                                                    <input type="time" name="study_total_time" id="study_total_time"
                                                           class="form-control text" placeholder="Quiz Total Time"
                                                          >
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-md-12">
                                            <p>
                                                <b>Study Material Status</b>
                                            </p>
                                            <select class="form-control show-tick" name="study_status" id="study_content_status">
                                                <option value="Active">Active</option>
                                                <option value="Deactive">Deactive</option>

                                            </select>

                                        </div>









                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" name="edit_submit" id="edit_submit" class="btn btn-link waves-effect">SAVE DETAILS
                                      </button>

                                    </div>
                              </form>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h2>All Question</h2>
                                </div>
                                <div class="body">
                                  <div class="table-responsive js-sweetalert">
                                    <table id="client_licenses"
                                              class="table table-bordered table-striped table-hover dataTable js-exportable nowrap"
                                              width="100%">
                                           <thead>
                                           <tr>
                                                <th>Action</th>
                                               <th>Study Material Title</th>
                                               <th>Quiz Title</th>
                                               <th>Total Question</th>
                                               <th>Total Time</th>
                                               <th>Status</th>



                                           </tr>
                                           </thead>
                                           <tfoot>
                                           <tr>
                                             <th>Action</th>
                                            <th>Study Material Title</th>
                                             <th>Quiz Title</th>
                                            <th>Total Question</th>
                                            <th>Total Time</th>
                                            <th>Status</th>


                                           </tr>
                                           </tfoot>
                                           <tbody>

                                           </tbody>
                                       </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">

                    <button type="button" name="edit_close" id="edit_close" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>

    </div>
</div>
