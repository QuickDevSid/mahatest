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
<div class="modal fade" id="edit_masike" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_masike_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Test_series_pdfs/updateRecord" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit PDF </h4>
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
                                                <b> Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="Title" id="edit_Title"
                                                               class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Exam Group</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="examid" id="edit_examid" onchange="return get_select_value(this)">
                                                        <?php
                                                            $sql="SELECT * FROM `exams` WHERE status='Active'";
                                                            $fetch_data=$this->common_model->executeArray($sql);
                                                            if($fetch_data)
                                                            {
                                                                foreach ($fetch_data as $value)
                                                                {
                                                                    echo '<option value="'.$value->exam_id.'">'.$value->exam_name.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Test Series </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="TestSeriesId" id="edit_TestSeriesId">
                                                        <?php
                                                            $sql="SELECT * FROM `test_series` WHERE status='Active'";
                                                            $fetch_data=$this->common_model->executeArray($sql);
                                                            if($fetch_data)
                                                            {
                                                                foreach ($fetch_data as $value)
                                                                {
                                                                    echo '<option value="'.$value->test_series.'">'.$value->test_title.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <!--
                                            <div class="col-md-4">
                                                <b> Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="image_url" type="file"  />
                                                    </div>
                                                </div>
                                            </div>
-->
                                            <div class="col-md-4">
                                                <b> Pdf</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="pdf_url" type="file"  />
                                                    </div>
                                                </div>
                                            </div>

                                           
                                            

                                           <div class="col-md-4">
                                              <p>
                                                  <b> Status</b>
                                              </p>
                                              <select class="form-control show-tick" name="status" id="edit_status" >
                                                  <option value="Active">Active</option>
                                                  <option value="InActive">InActive</option>

                                              </select>

                                          </div>
                                          

                                            <div class="col-md-12">
                                                <b>
                                                    Description</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="Description" id="edit_Description" placeholder="Description" required></textarea>
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
                    <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function get_select_value(val)
{
    // $("#MasikeCategoryId").selectpicker('destroy');
    var id=val.value;
    if(id>0)
    {
        $.ajax({
            url: '<?php echo base_url()?>Test_series_pdfs/get_select',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success:function(response){
                var len = response.length;
                $("#edit_TestSeriesId").empty();
                $("#edit_TestSeriesId").append("<option value=''>Select Test Series </option>");
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#edit_TestSeriesId").append("<option value='"+id+"'>"+name+"</option>");
                    $("#edit_TestSeriesId").selectpicker('refresh');
                }

            }
        });
        return 1;
    }
    else
    {
        $("#edit_TestSeriesId").empty();
        $("#edit_TestSeriesId").append("<option value=''>Select Test Series </option>");
    }

}

</script>
