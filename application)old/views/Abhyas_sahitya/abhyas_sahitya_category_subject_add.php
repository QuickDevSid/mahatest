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
<div class="modal fade" id="add_abhyas_sahitya_category_subject" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <form class="form-horizontal" id="submit" action="<?php echo base_url()?>Abhyas_sahitya_category_subject/add_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Abhyas Sahitya Category Subject</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">

                                            <div class="col-md-12">
                                                <b>Abhyas Sahitya Category Subject Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="CategorySubjectTitle" id="CategorySubjectTitle"
                                                               class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Exam Group</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="examid" id="examid" onchange="return get_select_value_add(this)">
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

                                            <div class="col-md-6">
                                                <b>Category </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="CategoryId" id="CategoryId">
                                                        <?php
                                                        /*
                                                        $sql="SELECT * FROM `abhyas_sahitya_category` WHERE status='Active' ";
                                                        $exams=$this->common_model->executeArray($sql);
                                                        if (isset($exams)){
                                                            foreach ($exams as $key) {
                                                                ?>
                                                                <option value="<?php echo($key->abhyas_sahitya_category_id); ?>"><?php echo($key->category_name); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        */
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                           <div class="col-md-6">
                                                  <b>Category Status</b>
                                                <div class="input-group">

                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>

                                              <select class="form-control show-tick" name="category_status" >
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
<script type="text/javascript">
function get_select_value_add(val)
{
    // $("#MasikeCategoryId").selectpicker('destroy');
    var id=val.value;
    if(id>0)
    {
        $.ajax({
            url: '<?php echo base_url()?>Abhyas_sahitya/get_select',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success:function(response){
                var len = response.length;
                $("#CategoryId").empty();
                $("#CategoryId").append("<option value=''>Select Category </option>");                    
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#CategoryId").append("<option value='"+id+"'>"+name+"</option>");
                    $("#CategoryId").selectpicker('refresh');
                }

            }
        });
        return 1;   
    }
    else
    {
        $("#CategoryId").empty();
        $("#CategoryId").append("<option value=''>Select Category </option>");                    
    }

}    
</script>