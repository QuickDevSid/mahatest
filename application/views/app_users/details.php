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
<div class="modal fade" id="UserDetailModel" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <form id="UserDetails" action="" method="POST">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="defaultModalLabel">View User</h4>
              </div>
              <div class="modal-body">
                  <!-- Masked Input -->
                  <div class="row clearfix">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="card">

                              <div class="body">
                                  <div class="demo-masked-input">
                                      <div class="row clearfix">
                                          <div class="col-md-4">
                                              <b>User Full Name :</b>
                                              <div class="input-group">

                                                  <div class="form-line">
                                                      <input type="text" name="full_name" id="d_Name"
                                                             class="form-control text" placeholder="User Full Name"
                                                             disabled>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="col-md-4">
                                              <b>Select Exam Type :</b>
                                              <div class="input-group">

                                                  <div class="form-line">
                                                      <input type="text" name="exam_type" id="d_selected_exams"
                                                             class="form-control email"
                                                             placeholder="Select Exam Type" disabled>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-4">
                                             <b>Email ID</b>
                                             <div class="input-group">

                                                 <div class="form-line">
                                                     <input type="text" name="email" id="d_Email_ID"
                                                            class="form-control email"
                                                            placeholder="Ex: example@example.com" disabled>
                                                 </div>
                                             </div>
                                         </div>
                                        <div class="col-md-4">
                                            <b>Gender :</b>
                                            <div class="input-group">

                                                <div class="form-line">
                                                    <input type="text" name="gender" id="d_gender"
                                                           class="form-control text" placeholder="User Full Gender"
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-md-4">
                                             <b>User Status :</b>
                                             <div class="input-group">

                                                 <div class="form-line">
                                                     <input type="text" name="status" id="d_status"
                                                            class="form-control text" placeholder="User Status"
                                                            disabled>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="col-xs-4">
                                           <h2 class="card-inside-title">Register on</h2>
                                           <div class="form-group">
                                               <div class="form-line" name="user_date" id="d_created_at">
                                                   <input type="text" class="form-control" placeholder="date..." disabled>
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
                  
                  <button type="button" name="close" id="close" class="btn btn-link waves-effect"
                          data-dismiss="modal">CLOSE
                  </button>
              </div>
          </div>
      </form>
    </div>
</div>
