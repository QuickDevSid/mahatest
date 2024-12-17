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
        <form id="update_form" action="<?php echo base_url()?>Gatavarshichya_prashna_patrika_year/update_data" method="POST" >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Gatavarshichya Prashna Patrika Year</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <input type="hidden" name="edit_id" id="edit_id" value="">
                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-3">
                                                <b>Year</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="edit_question_paper_year" id="edit_question_paper_year"
                                                               class="form-control text" placeholder="Year" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <b>For Exam Group</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="exam_id" id="ppa_id"  onchange="return get_select_value_edit(this)">
                                                        <?php
                                                        $sql="SELECT * FROM exams WHERE status='Active' ORDER BY exam_id DESC";
                                                        $datas=$this->common_model->executeArray($sql);
                                                        if (isset($datas)){
                                                            foreach ($datas as $key) {
                                                                ?>
                                                                <option value="<?php echo($key->exam_id); ?>"><?php echo($key->exam_name); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <b>Prashn Patrika :</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <select class="form-control" id="edit_question_paper_id" name="edit_question_paper_id">
                                                            <?php
                                                            $sql="SELECT * FROM gatavarshichya_prashna_patrika WHERE status='Active' ORDER BY gatavarshichya_prashna_patrika_id  DESC";
                                                            $datas=$this->common_model->executeArray($sql);
                                                            if (isset($datas)){
                                                                foreach ($datas as $key) {
                                                                    ?>
                                                                    <option value="<?php echo($key->gatavarshichya_prashna_patrika_id ); ?>"><?php echo($key->exam_name); ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="edit_status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

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
    function get_select_value_edit(val)
    {
        // $("#MasikeCategoryId").selectpicker('destroy');
        var id=val.value;
        if(id>0)
        {
            $.ajax({
                url: '<?php echo base_url()?>Gatavarshichya_prashna_patrika_year/get_select',
                type: 'post',
                data: {id:id},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#edit_question_paper_id").empty();
                    $("#edit_question_paper_id").append("<option value=''>Select Prashn Patrika </option>");
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#edit_question_paper_id").append("<option value='"+id+"'>"+name+"</option>");
                        $("#edit_question_paper_id").selectpicker('refresh');
                    }

                }
            });
            return 1;
        }
        else
        {
            $("#edit_question_paper_id").empty();
            $("#edit_question_paper_id").append("<option value=''>Select Prashn Patrika </option>");
        }

    }
</script>
