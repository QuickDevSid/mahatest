<script>
    $(document).ready(function() {
        $.validator.addMethod("noLeadingWhitespace", function(value, element) {
            return this.optional(element) || /^[^\s].*$/.test(value); // Ensures the first character is not whitespace
        }, "Please don't start with a blank space.");
        $.validator.addMethod("capitalizeFirstLetter", function(value, element) {
            return this.optional(element) || /^[A-Z]/.test(value); // Ensures the first character is uppercase
        }, "Please start with a capital letter.");
        $.validator.addMethod("onlyDigits", function(value, element) {
            return this.optional(element) || /^\d+$/.test(value); // Ensures only digits are allowed
        }, "Please enter only digits.");
        $("#test_submit").validate({
            rules: {
                'title': {
                    required: true,
                    noLeadingWhitespace: true,
                    capitalizeFirstLetter: true,
                },
                'category_title': {
                    required: true,
                },
                'source_id': {
                    required: true,
                },
                'description': {
                    required: true,
                    // noLeadingWhitespace: true,
                    capitalizeFirstLetter: true,
                },
                'image': {
                    required: function(element) {
                        return $('input[name="current_image"]').val() == "";
                    }
                }
            },
            messages: {
                'title': {
                    required: "Please enter title",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                    capitalizeFirstLetter: "Please start with a capital letter.",
                },
                'category_title': {
                    required: "Please select category",
                },
                'source_id': {
                    required: "Please select course",
                },
                'description': {
                    required: "Please enter description",
                    capitalizeFirstLetter: "Please start with a capital letter.",
                },
                'image': {
                    required: "Please choose an image",
                }
            },
            submitHandler: function(form) {
                console.log("Form is valid and being submitted.");
                form.submit();
            }
        });

        function validateForm() {
            const roundName = $('#title').val();
            let roundValid = $('#title_error').is(':hidden');
            if (roundValid) {
                // $("#submit").show();
                $("#submit").prop("disabled", false);
            } else {
                // $("#submit").hide();
                $("#submit").prop("disabled", true);
            }
        }
        $("#title").keyup(function() {
            $('#title_error').text("").hide();
            validateForm();
        });
        $('#title').keyup(function() {
            var id = $('#id').val();
            var title = $('#title').val();
            console.log("name: " + title);
            $.ajax({
                url: "<?= base_url() ?>admin/Ajax_controller/get_duplicate_title_check",
                type: "post",
                data: {
                    'id': id,
                    'title': title,
                },
                success: function(response) {
                    if (response > 0) {
                        $('#title_error').text("This title is already taken").show();
                    } else {
                        $('#title_error').text("").hide();
                    }
                    validateForm();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    });
</script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $('#course_data_list tbody').sortable({
            handle: '.handle',
            update: function(event, ui) {
                var sequence_no = [];
                $('.draggable-rows').each(function(index, element) {
                    var id = $(this).data('id');
                    $(this).data('sequence_no', index + 1);
                    if (id) {
                        sequence_no.push({
                            id: id,
                            sequence_no: index + 1
                        });
                    }
                });
                $.ajax({
                    url: '<?= base_url(); ?>admin/Ajax_controller/update_shift_sequence',
                    method: 'POST',
                    data: {
                        sequence_no: sequence_no
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Sequence no updated successfully', response);

                        // Loop through each draggable row to update the `Sr. No.` and `sequence_no`
                        $('.draggable-rows').each(function(index) {
                            var newOrder = index + 1;

                            // Update the Sr. No. column (first <td>)
                            $(this).find('td:first').text(newOrder);

                            // Update the sequence_no column (second <td>)
                            $(this).find('.handle').html(
                                '<i class="fas fa-grip-vertical"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + newOrder
                            );

                            // Update the `data-order` attribute for sorting reference
                            $(this).attr('data-order', newOrder);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred while updating the order:', error);
                    }
                });
            }
        });
    });
</script>