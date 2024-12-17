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
        <form id="add_masike_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Masike/updateMasike" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit New Masike </h4>
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
                                                <b>Masike Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="MasikeTitle" id="edit_MasikeTitle"
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
                                                <b>Masike Category </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="MasikeCategoryId" id="edit_MasikeCategoryId">
                                                        <?php
                                                            $sql="SELECT * FROM `masike_category` WHERE status='Active'";
                                                            $fetch_data=$this->common_model->executeArray($sql);
                                                            if($fetch_data)
                                                            {
                                                                foreach ($fetch_data as $value) 
                                                                {
                                                                    echo '<option value="'.$value->masike_category_id.'">'.$value->category_name.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            
                                            <div class="col-md-4">
                                                <b>Masike Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="masike_image" type="file" multiple />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Masike Pdf</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="masike_pdf" type="file" multiple />
                                                    </div>
                                                </div>
                                            </div>

                                           
                                            

                                           <div class="col-md-4">
                                              <p>
                                                  <b>Masike Status</b>
                                              </p>
                                              <select class="form-control show-tick" name="masike_status" id="edit_masike_status" >
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
            url: '<?php echo base_url()?>masike/get_select',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success:function(response){
                var len = response.length;
                $("#edit_MasikeCategoryId").empty();
                $("#edit_MasikeCategoryId").append("<option value=''>Select Category </option>");                    
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#edit_MasikeCategoryId").append("<option value='"+id+"'>"+name+"</option>");
                    $("#edit_MasikeCategoryId").selectpicker('refresh');
                }

            }
        });
        return 1;   
    }
    else
    {
        $("#edit_MasikeCategoryId").empty();
        $("#edit_MasikeCategoryId").append("<option value=''>Select Category </option>");                    
    }

} 

function get_select_value_edit(id,edit_id)
{
    // $("#MasikeCategoryId").selectpicker('destroy');
    if(id>0)
    {
        $.ajax({
            url: '<?php echo base_url()?>masike/get_select',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success:function(response){
                var len = response.length;
                $("#edit_MasikeCategoryId").empty();
                $("#edit_MasikeCategoryId").append("<option value=''>Select Category </option>");                    
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    if(id==edit_id)
                    {
                        $("#edit_MasikeCategoryId").append("<option value='"+id+"' selected>"+name+"</option>");
                        $("#edit_MasikeCategoryId").selectpicker('refresh');                        
                    }
                    else
                    {
                        $("#edit_MasikeCategoryId").append("<option value='"+id+"'>"+name+"</option>");
                        $("#edit_MasikeCategoryId").selectpicker('refresh');                        
                    }
                }

            }
        });
        return 1;   
    }
    else
    {
        $("#edit_MasikeCategoryId").empty();
        $("#edit_MasikeCategoryId").append("<option value=''>Select Category </option>");                    
    }

}    
</script>