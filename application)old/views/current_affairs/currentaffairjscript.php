<script>
    $(document).ready(function() {
        $(function() {

            $('#current_affairs').addClass('active');
            $('#current_affairs .menu-toggle').addClass('toggled');
            $('#current_affairs .ml-menu').css('display', 'block');
            $('#current_affairs').addClass('active');
            getData();
        });

        $.validator.addMethod("onlyDigits", function(value, element) {
            return this.optional(element) || /^\d+$/.test(value);
        }, "Please enter only digits.");

        $.validator.addMethod("onlyPositiveDigits", function(value, element) {
            return this.optional(element) || /^[1-9][0-9]*$/.test(value);
        }, "Please enter only digits (1, 2, 3, etc.).");

        $("#currentaffairsubmit").validate({
            rules: {
                'title': {
                    required: true,
                },
                'sequence_no': {
                    required: true,
                },

                'category': {
                    required: true,
                },
                'date': {
                    required: true,
                },
                'description': {
                    required: true,
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
                },
                'sequence_no': {
                    required: "Please enter sequence_no",
                },
                'date': {
                    required: "Please select date",
                },
                'category': {
                    required: "Please choose category",
                },
                'description': {
                    required: "Please enter description",
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
                url: "<?= base_url() ?>Courses/get_duplicate_courses_title",
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