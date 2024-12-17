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
<div class="modal fade" id="addquiz" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="getquizDetails" enctype="multipart/form-data" action="<?php echo base_url()?>Gatavarshichya_prashna_patrika_year_title/add_exam" method="POST" >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Gatavarshichya Prashna Patrika Exam (Live Test)</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                          <input type="hidden" name="a_quiz_id" id="a_quiz_id"
                                                 class="form-control text" placeholder="Title"
                                                >

                                            <div class="col-md-12">
                                                <b>Title :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="a_quiz_title" id="a_quiz_title"
                                                               class="form-control text" placeholder="Title"
                                                        >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <b>Exams :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control" id="a_exams" name="a_exams" onchange="return get_select_value_add(this)">
                                                            <?php
                                                            $sql="SELECT * FROM exams WHERE status='Active'";
                                                            $check=$this->common_model->executeArray($sql);
                                                            if($check)
                                                            {
                                                                foreach ($check as $value)
                                                                {
                                                                    echo '<option value="'.$value->exam_id.'">'.$value->exam_name.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <b>Prashn Patrika :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control" id="a_prashn_patrika" name="a_prashn_patrika" onchange="return get_select_value_add_1(this)">
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <b>Year :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control" id="a_year" name="a_year">
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                               <b> Questions :</b>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <i class="material-icons">person</i>
                                                   </span>
                                                   <div class="form-line">
                                                       <input type="number" name="a_quiz_questions" id="a_quiz_questions" step="0.01"
                                                              class="form-control text" placeholder="Add Quiz Question In Number"
                                                             >
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-12">
                                              <b> Duration:</b>
                                              <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">person</i>
                                                  </span>
                                                  <div class="form-line">
                                                      <input type="number" name="a_quiz_duration" id="a_quiz_duration" step="0.01"
                                                             class="form-control text" placeholder="Add Quiz Time Duaration In Number"
                                                            >
                                                  </div>
                                              </div>
                                          </div>

                                           <div class="col-md-12">
                                              <b>Correct answer mark:</b>
                                              <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">person</i>
                                                  </span>
                                                  <div class="form-line">
                                                      <input type="number" name="a_correct_answer_mark" id="a_correct_answer_mark" step="0.01"
                                                             class="form-control text" placeholder=""
                                                            >
                                                  </div>
                                              </div>
                                          </div>
                                           <div class="col-md-12">
                                              <b>Wrong answer mark:</b>
                                              <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="material-icons">person</i>
                                                  </span>
                                                  <div class="form-line">
                                                      <input type="number" name="a_wrong_answer_mark" id="a_wrong_answer_mark" step="0.01"
                                                             class="form-control text" placeholder=""
                                                            >
                                                  </div>
                                              </div>
                                          </div>


                                            <div class="col-md-12">
                                                <b>Pdf</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="pdf_file" type="file" multiple />
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-12">
                                                <b>
                                                    Instructions</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="a_instructions" id="a_instruction" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                               <p>
                                                   <b>Status</b>
                                               </p>
                                               <select class="form-control show-tick" name="a_status" id="a_status">
                                                   <option value="Active">Active</option>
                                                   <option value="Deactive">Deactive</option>

                                               </select>

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
                    <button type="submit" name="edit_submit" id="edit_submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                  
                    <button type="button" name="edit_close" id="edit_close" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    function get_select_value_add(val)
    {
        // $("#MasikeCategoryId").selectpicker('destroy');
        var id=val.value;
        if(id>0)
        {
            $.ajax({
                url: '<?php echo base_url()?>Gatavarshichya_prashna_patrika_live_test/get_select',
                type: 'post',
                data: {id:id},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#a_prashn_patrika").empty();
                    $("#a_prashn_patrika").append("<option value=''>Select Prashn Patrika </option>");
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#a_prashn_patrika").append("<option value='"+id+"'>"+name+"</option>");
                        $("#a_prashn_patrika").selectpicker('refresh');
                    }

                }
            });
            return 1;
        }
        else
        {
            $("#a_prashn_patrika").empty();
            $("#a_prashn_patrika").append("<option value=''>Select Prashn Patrika </option>");
        }

    }


    function get_select_value_add_1(val)
    {
        // $("#MasikeCategoryId").selectpicker('destroy');
        var id=val.value;
        if(id>0)
        {
            $.ajax({
                url: '<?php echo base_url()?>Gatavarshichya_prashna_patrika_live_test/get_select_1',
                type: 'post',
                data: {id:id},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#a_year").empty();
                    $("#a_year").append("<option value=''>Select Prashn Patrika Year</option>");
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#a_year").append("<option value='"+id+"'>"+name+"</option>");
                        $("#a_year").selectpicker('refresh');
                    }

                }
            });
            return 1;
        }
        else
        {
            $("#a_year").empty();
            $("#a_year").append("<option value=''>Select Prashn Patrika Year</option>");
        }

    }
</script>
