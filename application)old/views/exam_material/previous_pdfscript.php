<script>
    $(document).ready(function() {
        $(function() {
            $('#ebooks').addClass('active');
            $('#ebooks .menu-toggle').addClass('toggled');
            $('#ebooks .ml-menu').css('display', 'block');
            $('#ebooks').addClass('active');
            getData();
        });
        $("#chapter_submit").validate({
            rules: {
                // 'category': {
                //     required: true,
                // },
                // 'sub_category': {
                //     required: true,
                // },
                // 'book_name': {
                //     required: true,
                // },
                // 'image': {
                //     required: function(element) {
                //         return $('input[name="current_image"]').val() == "";
                //     }
                // },
                // 'category': {
                //     required: true,
                // }
            },
            messages: {
                // 'category': {
                //     required: "Please select category",
                // },
                // 'sub_category': {
                //     required: "Please select sub category",
                // },
                // 'book_name': {
                //     required: "Please enter book name",
                // },
                // 'image': {
                //     required: "Please choose an image",
                // },
                // 'category': {
                //     required: "Please select category",
                // }
            },
            submitHandler: function(form) {
                var isUpdateMode = <?= !empty($single->id) ? 'true' : 'false' ?>;
                if ($('#dynamic_field_container').children().length > 0 || isUpdateMode) {
                    form.submit();
                } else {
                    alert("Please add at least one pdf before submitting the form.");
                }
            }
        });
        var maxFields = 10; // Limit the number of additions
        var wrapper = $("#dynamic_field_container"); // Container for fields
        var addButton = $("#add_more");
        var i = 1;
        $(addButton).click(function(e) {
            e.preventDefault();
            if ($(wrapper).children().length < maxFields) {
                // Clone the original fields
                var currentImagePath = '';
                var currentPdfPath = '';
                var newField = `
            <div class="demo-masked-input" style="padding:35px; border: 2px solid #ccc; border-radius: 5px; margin-bottom: 15px;" data-index="${i}">
                <div class="row">
                    <input type="hidden" value="${i}" name="indices[]">
                    <div class="col-md-4">
                        <b>Title</b>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" name="title_${i}" id="title_${i}" class="form-control text" placeholder="Title" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <b>Exam Name</b>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">check_circle</i>
                            </span>
                            <div class="form-line">
                                <select name="exam_name_${i}" id="exam_name_${i}" class="form-control text" required>
                                    <option value="" disabled selected>-- Select Exam Name --</option>
                                    <?php
                                    // Fetch data from your model
                                    $exam_names = $this->Exam_Material_model->get_select_exam_name(); // Adjust model function name if needed
                                    $selected_exam = !empty($single) ? $single->exam_name : ''; // Pre-select value if editing
                                    if (!empty($exam_names)) {
                                        foreach ($exam_names as $exam) { ?>
                                            <option value="<?= $exam->id ?>" <?= ($exam->id == $selected_exam) ? 'selected' : '' ?>>
                                                <?= $exam->title ?>
                                            </option>
                                    <?php }
                                    } else { ?>
                                        <option value="">No Exams Available</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <b>Exam Year</b>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">calendar_today</i>
                            </span>
                            <div class="form-line">
                                <select name="exam_year_${i}" id="exam_year_${i}" class="form-control text" required>
                                    <option value="" disabled selected>-- Select Exam Year --</option>
                                    <?php
                                    // Fetch data from your model
                                    $exam_years = $this->Exam_Material_model->get_select_exam_year(); // Adjust model function name if needed
                                    $selected_year = !empty($single) ? $single->exam_year : ''; // Pre-select value if editing
                                    if (!empty($exam_years)) {
                                        foreach ($exam_years as $year) { ?>
                                            <option value="<?= $year->id ?>" <?= ($year->id == $selected_year) ? 'selected' : '' ?>>
                                                <?= $year->title ?>
                                            </option>
                                    <?php }
                                    } else { ?>
                                        <option value="">No Years Available</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <b>Exam Type</b>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">check_circle</i>
                            </span>
                            <div class="form-line">
                                <select name="exam_type_${i}" id="exam_type_${i}" class="form-control text" required>
                                    <option value="" disabled selected>-- Select Exam Type --</option>
                                    <?php
                                    // Fetch data from your model
                                    $exam_types = $this->Exam_Material_model->get_select_exam_type(); // Adjust model function name if needed
                                    $selected_type = !empty($single) ? $single->exam_type : ''; // Pre-select value if editing
                                    if (!empty($exam_types)) {
                                        foreach ($exam_types as $type) { ?>
                                            <option value="<?= $type->id ?>" <?= ($type->id == $selected_type) ? 'selected' : '' ?>>
                                                <?= $type->title ?>
                                            </option>
                                    <?php }
                                    } else { ?>
                                        <option value="">No Types Available</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                            <b>PDF File</b>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">picture_as_pdf</i>
                                </span>
                                <div class="form-line">
                                    <input type="file" name="pdf_${i}" id="pdf_${i}" class="form-control text" required accept="application/pdf">
                                    <input type="hidden" name="current_pdf_${i}" value="${currentPdfPath || ''}">
                                </div>
                            </div>
                            ${currentPdfPath ? `
                                <a href="${currentPdfPath}" target="_blank" style="color: blue;">View Current PDF</a>
                            ` : ''}
                            <div id="errorMessage_${i}" class="error" style="color: red;"></div>
                    </div>
                    <div class="col-md-4">
                        <b>Image</b>
                        <div class="input-group">
                            <span class="input-group-addon">   
                                <i class="material-icons">perm_media</i>
                            </span>
                            <div class="form-line">
                                <input type="file" name="image_${i}" id="image_${i}" class="form-control text" required accept="image/*">
                                <input type="hidden" name="current_image_${i}" value="${currentImagePath || ''}">
                            </div>
                        </div>
                        ${currentImagePath ? `
                            <img src="${currentImagePath}" alt="Image" style="width: 100px; height: auto;" />
                        ` : ''}
                        <div id="errorMessage_${i}" class="error" style="color: red;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <div class="input-group">
                        <p><b>Short Description</b></p>
                        <textarea class="form-control text" name="description_${i}" id="description_${i}" placeholder="Chapter Description" rows="5" cols="5" required></textarea>
                    </div>
                     </div>
                </div>
                <button type="button" class="remove_field btn btn-danger">Remove</button>
                <br><br>
            </div>`;
                // Append the cloned fields to the container
                $(wrapper).append(newField);
                i++;
                initializeValidationForFieldsnew();
                // Get the value of the previous division and set it to the new hidden field
                var previousDivisionValue = $("input[name='division_id_']").val();
                $("select[name='division_id_']").val(previousDivisionValue);
                var previousDivisiontypeValue = $("input[name='division_type_']").val();
                $("input[name='division_type_']").val(previousDivisiontypeValue);
            } else {
                alert('You can add up to ' + maxFields + ' entries.');
            }

            function removeRow(arg) {
                $(arg).parent().parent().remove();
                initializeValidationForFieldsnew();
            }

            function initializeValidationForFieldsnew() {
                $(".process_name").each(function() {
                    $(this).rules("add", {
                        required: true,
                        messages: {
                            required: "Please select process name",
                        },
                    });
                });
                $(".image_upload").each(function() {
                    $(this).rules("add", {
                        required: true,
                        messages: {
                            required: "Please select image upload",
                        },
                    });
                });
            }
        });
        // Remove the cloned fields when clicking "Remove"
        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
        $(wrapper).on('input', '.process_d', function() {
            console.log("Process Name: ", $(this).val());
        });
        $("#dynamic_field_container").on("change", "input[type='file']", function() {
            // Grab the input's index
            let index = $(this).closest(".demo-masked-input").data("index");
            // Update image or video path after selection
            if ($(this).attr("id").includes("image")) {
                // Handle image selection
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(`input[name="current_image_${index}"]`).val(e.target.result);
                    // Update image preview
                    $(`#image_${index}`).next("img").attr("src", e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            } else if ($(this).attr("id").includes("video")) {
                // Handle video selection
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(`input[name="current_video_${index}"]`).val(e.target.result);
                    // Update video preview
                    $(`#video_${index}`).next("video").find("source").attr("src", e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->