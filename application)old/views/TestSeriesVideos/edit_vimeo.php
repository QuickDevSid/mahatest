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
<div class="modal fade" id="edit_vimeo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="edit_vimeo_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Test_series_videos/update_data_vimeo" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Update Vimeo Videos</h4>
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
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="hidden" name="edit_id_v" id="edit_id_v">
                                                        <input type="text" name="edit_Title_v" id="edit_Title_v" class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Exams :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control" id="edit_exam_v" name="edit_exams_v" onchange="return get_select_value_edit_vimeo(this)">
                                                            <?php
                                                            $sql = "SELECT * FROM exams WHERE status='Active'";
                                                            $check = $this->common_model->executeArray($sql);
                                                            if ($check) {
                                                                foreach ($check as $value) {
                                                                    echo '<option value="' . $value->exam_id . '">' . $value->exam_name . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Test Series </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="edit_test_series_v" id="edit_test_series_v">
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
                                            <div class="col-md-6">
                                                <b>Video ID - Such as : 417703774 </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="edit_URL_v" id="edit_URL_v" class="form-control text" placeholder="Video ID - Such as : 417703774" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Duration - Video Length </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="edit_duration_v" id="edit_duration_v" class="form-control text" placeholder="Duration" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            
                                            <div class="col-md-6">
                                                <b>Video Thumbnail</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="edit_Thumbnail_v" id="edit_Thumbnail_v" type="file"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="edit_status_v" id="edit_status_v">
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <b>Description </b>
                                                <div class="input-group">

                                                    <div class="form-line">
                                                        <textarea rows="4" class="form-control no-resize" id="edit_description_v" name="edit_description_v" placeholder="Please type video description..." spellcheck="false"></textarea>
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
                    <button type="submit" name="submit" id="submit_v" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function get_select_value_edit_vimeo(val)
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
                    $("#edit_test_series_v").empty();
                    $("#edit_test_series_v").append("<option value=''>Select Test Series </option>");
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#edit_test_series_v").append("<option value='"+id+"'>"+name+"</option>");
                        $("#edit_test_series_v").selectpicker('refresh');
                    }

                }
            });
            return 1;
        }
        else
        {
            $("#edit_test_series_v").empty();
            $("#edit_test_series_v").append("<option value=''>Select Test Series </option>");
        }

    }

    
</script>
