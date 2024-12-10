<!-- Modal Dialogs ====================================================================================================================== -->
<!-- Default Size -->
<div class="modal fade" id="add_abhyas_sahitya" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_masike_form" enctype="multipart/form-data" action="<?php echo base_url() ?>Other_option/addAbhyasSahitya" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Other Option</h4>
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
                                                <b>Other Option Title</b>
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

                                            <div class="col-md-4">
                                                <b>Other Option Category</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control text" name="AbhyasSahityaCategoryId" id="AbhyasSahityaCategoryId" placeholder="Enter Category" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-4">
                                                <b>Other Option Category</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control show-tick" name="AbhyasSahityaCategoryId" id="AbhyasSahityaCategoryId">
                                                        <?php
                                                        $sql = "SELECT * FROM tbl_other_option_category WHERE status='Active'";
                                                        $fetch_data = $this->common_model->executeArray($sql);
                                                        if ($fetch_data) {
                                                            foreach ($fetch_data as $value) {
                                                                echo '<option value="' . $value->id . '">' . $value->title . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div> -->

                                            <div class="row clearfix">

                                                <div class="col-md-4">
                                                    <b>Other Option Image</b>
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
                                                    <b>Type</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">description</i>
                                                        </span>
                                                        <select class="form-control show-tick" name="AbhyasSahityaType" id="AbhyasSahityaType" onchange="toggleFields()">
                                                            <option value="">Select Type</option>
                                                            <option value="PDF">PDF</option>
                                                            <option value="Text">Text</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Short Description Field -->
                                            <div class="row clearfix">
                                                <div class="col-md-12">
                                                    <b>Short Description</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">short_text</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <textarea name="ShortDescription" id="ShortDescription" class="form-control" placeholder="Enter a short description" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-4" id="pdfUploadField" style="display: none;">
                                                    <b>Other Option PDF</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">picture_as_pdf</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input name="abhyas_sahitya_pdf" type="file" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="textEditorField" style="display: none;">
                                                    <b>Description</b>
                                                    <div class="input-group">
                                                        <div class="form-line">
                                                            <textarea name="Description" id="Description" placeholder="Description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><b>Other Option Status</b></p>
                                                    <select class="form-control show-tick" name="AbhyasSahitya_status">
                                                        <option value="Active">Active</option>
                                                        <option value="InActive">InActive</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><b>Can Download</b></p>
                                                    <select class="form-control show-tick" name="can_download" id="edit_can_download">
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
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
                        <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
        </form>
    </div>
</div>


<script>
    function toggleFields() {
        var type = document.getElementById("AbhyasSahityaType").value;
        var pdfField = document.getElementById("pdfUploadField");
        var textField = document.getElementById("textEditorField");

        if (type === "PDF") {
            pdfField.style.display = "block";
            textField.style.display = "none";
        } else if (type === "Text") {
            pdfField.style.display = "none";
            textField.style.display = "block";
        } else {
            pdfField.style.display = "none";
            textField.style.display = "none";
        }
    }

    $(document).ready(function() {
        $('#AbhyasSahityaCategoryId').change(function() {
            var categoryId = $(this).val();
            $('#AbhyasSahityaSubCategoryId').empty().append('<option value="">Select Sub Category</option>');
            if (categoryId) {
                $.ajax({
                    url: 'path/to/your/api/endpoint', // Replace with your actual endpoint to fetch subcategories
                    type: 'POST',
                    data: {
                        category_id: categoryId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'true') {
                            $.each(response.data, function(index, value) {
                                $('#AbhyasSahityaSubCategoryId').append('<option value="' + value.id + '">' + value.title + '</option>');
                            });
                        } else {
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