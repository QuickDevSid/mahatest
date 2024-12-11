<script>
    $(document).ready(function() {
        $("#video_setup_submit").validate({
            rules: {
                // 'category': {
                //     required: true,
                // }
            },
            messages: {
                // 'category': {
                //     required: "Please select category",
                // }
            },
            submitHandler: function(form) {
                var isUpdateMode = <?= !empty($single->id) ? 'true' : 'false' ?>;

                if ($('#dynamic_field_container').children().length > 0 || isUpdateMode) {
                    form.submit();
                } else {
                    alert("Please add at least one video before submitting the form.");
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
                var currentVideoPath = '';
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
                                <input type="text" name="title_${i}" id="title_${i}" class="form-control text" placeholder="Chapter Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <b>Video</b>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">perm_media</i>
                            </span>
                            <div class="form-line">
                                <input type="file" name="videos_${i}" id="videos_${i}" class="form-control text" required accept="video/*">
                            </div>
                        </div>
                        ${currentVideoPath ? `
                            <video controls style="width: 100%; height: auto;">
                                <source src="${currentVideoPath}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        ` : ''}
                        <div id="videoErrorMessage_${i}" class="error" style="color: red;"></div>
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
                $(".video_upload").each(function() {
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
                    $(`input[name="current_video_${index}"]`).val(e.target.result);
                    // Update image preview
                    $(`#video_${index}`).next("img").attr("src", e.target.result);
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
<script>
    $("#category").on('change', function() {
        var selectedValue = $('#category').val();
        console.log("Selected Value: " + selectedValue);
        if (selectedValue !== '') {
            $.ajax({
                url: "<?= base_url() ?>Ajax_controller/get_details_by_cat",
                type: 'POST',
                data: {
                    selectedValue: selectedValue
                },
                dataType: 'json',
                success: function(response) {
                    // console.log("hello");
                    // console.log(response);
                    // exit;
                    if (response.error) {
                        // alert("");
                        alert(response.error);
                    } else {
                        console.log(response); // Debug the response
                        $('#sub_category').empty().append('<option value="">Select Sub Category</option>');
                        $.each(response, function(index, value) {
                            $('#sub_category').append('<option value="' + value.id + '">' + value.title + '</option>');
                        });
                    }
                }
            });
        }
        console.log("test the value: " + selectedValue);
    });
</script>