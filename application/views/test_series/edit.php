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
<div class="modal fade" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <form class="form-horizontal" id="submit" enctype="multipart/form-data" action="<?php echo base_url()?>Test_series/update_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Test Series </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <input type="hidden" name="edit_id" id="edit_id">
                                            <div class="col-md-4">
                                                <b>Test Series Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="TestSeriesTitle" id="editTestSeriesTitle"
                                                               class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>For Exam Group</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="Exam_Id[]" id="editExam_Id" multiple="">
                                                        <?php
                                                        $sql="SELECT * FROM `exams` WHERE status='Active' ";
                                                        // echo $sql;
                                                        $exams=$this->common_model->executeArray($sql);
                                                        if (isset($exams)){
                                                            // print $exams;
                                                            foreach ($exams as $key) {
                                                                ?>
                                                                <option value="<?php echo($key->exam_id); ?>"><?php echo($key->exam_name); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                           <div class="col-md-4">
                                              <p>
                                                  <b>Test Series Status</b>
                                              </p>
                                              <select class="form-control show-tick" name="status" name="editstatus" >
                                                  <option value="Active">Active</option>
                                                  <option value="InActive">InActive</option>

                                              </select>

                                          </div>
                                        </div>
                                            <div class="row">
                                            <div class="col-md-4">
                                                <b>Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="test_price" id="edit_test_price"
                                                               class="form-control text" placeholder="Price" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Exams</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="test_exams" id="edit_test_exams"
                                                               class="form-control text" placeholder="Exams" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Test Series Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="test_image" id="edit_test_image" type="file"  />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b>
                                                    Description</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="test_details" id="edit_test_details" placeholder="Description" required></textarea>
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
                    <button type="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
