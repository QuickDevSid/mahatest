<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />



<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('#exam_material').addClass('active');
            $('#exam_material .menu-toggle').addClass('toggled');
            $('#exam_material .ml-menu').css('display', 'block');
            $('#exam_material').addClass('active');
            getData();
        });
        $('.select2').select2({
            placeholder: "Select Category",
            allowClear: true,
            width: '100%'
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
                    <div class="col-md-8">
                        <b>Tests*</b>
                        <select class="chosen-select" name="test_id_${i}_[]" id="test_id" multiple required>
                            <option value="">Select Tests</option>
                            <?php
                            $tests = $this->Exam_Material_model->get_tests_examwise_setup();
                            if (!empty($tests)) {
                                foreach ($tests as $row) {
                            ?>
                                    <option value="<?= $row->id; ?>" <?php if (!empty($single) && in_array($row->id, explode(',', $single->tests))) {
                                                                            echo 'selected';
                                                                        } ?>><?= $row->topic; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
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