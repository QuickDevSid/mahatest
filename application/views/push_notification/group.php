<script type="text/javascript">
$(function () { $("#all").addClass("active"); alert()});
</script>


<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD ->  Push Notification to selected exam group user </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                          Push Notification to selected exam group user
                        </h2>

                    </div>
                    <div class="body">

                    	 <form id="add_current_affair_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Push_notification/sent_to_group" method="POST">


                                        <div class="row clearfix">
                                            <div class="col-md-8">
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
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="image" id="image" type="file"  />
                                                    </div>
                                                </div>
                                            </div>
                                          <div class="col-md-12">
                                              <h2 class="card-inside-title">Message</h2>
                                              <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>

                                                  <div class="form-line">
                                                      <textarea rows="1" name="msg" id="msg"
                                                                class="form-control no-resize auto-growth"
                                                                placeholder="Message" required></textarea>
                                                  </div>
                                              </div>
                                          </div>


                                            <div class="col-md-12">
                                                <b>For Exam Group</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="Exam_Id[]" id="Exam_Id" multiple="">
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

                                          <div class="col-md-12">

                                    		<div class="modal-footer">
			                                      <button type="submit" name="edit_submit" id="edit_submit" class="btn btn-link waves-effect">SENT
			                                      </button>
			                                  </div>
			                              </div>



                                        </div>


                    	 </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
