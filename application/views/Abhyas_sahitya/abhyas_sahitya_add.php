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
<div class="modal fade" id="add_abhyas_sahitya" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_masike_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Abhyas_sahitya/addAbhyasSahitya" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Abhyas Sahitya </h4>
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
                                                <b>Abhyas Sahitya Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="AbhyasSahtyaTitle" id="AbhyasSahtyaTitle"
                                                               class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <b>Exam Group</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="examid" id="examid" onchange="return get_select_value_add(this)">
                                                            <option>Select</option>
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
                                            </div> -->
                                            <div class="col-md-4">
                                                <b>Abhyas Sahitya Category </b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="AbhyasSahityaCategoryId" id="AbhyasSahityaCategoryId">
                                                        <?php
                                                            $sql="SELECT * FROM `tbl_other_option_category` WHERE status='Active'";
                                                            $fetch_data=$this->common_model->executeArray($sql);
                                                            if($fetch_data)
                                                            {
                                                                foreach ($fetch_data as $value) 
                                                                {
                                                                    echo '<option value="'.$value->id.'">'.$value->title.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="row clearfix">
                                            
                                            <div class="col-md-4">
                                                <b>Abhyas Sahitya Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="abhyas_sahitya_image" type="file" multiple />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Abhyas Sahitya Pdf</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="abhyas_sahitya_pdf" type="file" multiple />
                                                    </div>
                                                </div>
                                            </div>

                                           
                                            

                                           <div class="col-md-4">
                                              <p>
                                                  <b>Abhyas Sahitya Status</b>
                                              </p>
                                              <select class="form-control show-tick" name="AbhyasSahitya_status" >
                                                  <option value="Active">Active</option>
                                                  <option value="InActive">InActive</option>

                                              </select>

                                          </div>
                                          <div class="col-md-4">
                                                <p>
                                                    <b>Can Download</b>
                                                </p>
                                                <select class="form-control show-tick" name="can_download" id="edit_can_download" >
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>

                                            </div>
                                          

                                            <div class="col-md-12">
                                                <b>
                                                    Description</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="Description" id="Description" placeholder="Description" required></textarea>
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
                $("#AbhyasSahityaCategoryId").empty();
                $("#AbhyasSahityaCategoryId").append("<option value=''>Select Category </option>");                    
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#AbhyasSahityaCategoryId").append("<option value='"+id+"'>"+name+"</option>");
                    $("#AbhyasSahityaCategoryId").selectpicker('refresh');
                }

            }
        });
        return 1;   
    }
    else
    {
        $("#AbhyasSahityaCategoryId").empty();
        $("#AbhyasSahityaCategoryId").append("<option value=''>Select Category </option>");                    
    }

}    
</script>

<script>
    $(document).ready(function() {
        $('#AbhyasSahityaCategoryId').change(function() {
            var categoryId = $(this).val();

            // Clear the subcategory dropdown
            $('#AbhyasSahityaSubCategoryId').empty();
            $('#AbhyasSahityaSubCategoryId').append('<option value="">Select Sub Category</option>');

            if (categoryId) {
                $.ajax({
                    url: 'path/to/your/api/endpoint', // Replace with your actual endpoint to fetch subcategories
                    type: 'POST',
                    data: { category_id: categoryId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'true') {
                            $.each(response.data, function(index, value) {
                                $('#AbhyasSahityaSubCategoryId').append('<option value="' + value.id + '">' + value.title + '</option>');
                            });
                        } else {
                            // Handle case where no subcategories are returned
                            alert('No subcategories found.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching subcategories.');
                    }
                });
            }
        });
    });
</script>