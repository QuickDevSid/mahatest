<script>
    $(document).ready(function() {
        $(function() {
            $('#exam_material').addClass('active');
            $('#exam_material .menu-toggle').addClass('toggled');
            $('#exam_material .ml-menu').css('display', 'block');
            $('#exam_material').addClass('active');
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
                form.submit();
                // var isUpdateMode = <?= !empty($single->id) ? 'true' : 'false' ?>;
                // if ($('#dynamic_field_container').children().length > 0 || isUpdateMode) {
                //     form.submit();
                // } else {
                //     alert("Please add at least one pdf before submitting the form.");
                // }
            }
        });
        var maxFields = 10;
        var wrapper = $("#dynamic_field_container");
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
                <button type="button" class="remove_field btn btn-danger">Remove</button>
                <br><br>
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
                        <b>Subject Name</b>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">check_circle</i>
                            </span>
                            <div class="form-line">
                                <select name="subject_${i}" id="subject_${i}" class="form-control text" required>
                                    <option value="" disabled selected>-- Select Subject --</option>
                                    <?php
                                    // Fetch data from your model
                                    $subjects_types = $this->Exam_Material_model->get_select_subjects_list(); // Adjust model function name if needed
                                    $selected_subject = !empty($single) ? $single->subject_id : ''; // Pre-select value if editing
                                    if (!empty($subjects_types)) {
                                        foreach ($subjects_types as $subject) { ?>
                                            <option value="<?= $subject->id ?>" <?= ($subject->id == $selected_subject) ? 'selected' : '' ?>>
                                                <?= $subject->title ?>
                                            </option>
                                        <?php }
                                    } else { ?>
                                        <option value="">No Types Available</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
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