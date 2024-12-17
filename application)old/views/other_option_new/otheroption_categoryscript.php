<script>
    $(document).ready(function() {

        $(function() {

            <?php if(isset($_GET['syllabus'])){ ?>
                $('#syllabus_options').addClass('active');
                $('#syllabus_options .menu-toggle').addClass('toggled');
                $('#syllabus_options .ml-menu').css('display', 'block');
                $('#syllabus_options').addClass('active');
            <?php }else{ ?>
                $('#other_options').addClass('active');
                $('#other_options .menu-toggle').addClass('toggled');
                $('#other_options .ml-menu').css('display', 'block');
                $('#other_options').addClass('active');
            <?php } ?>
            getData();
        });

        $.validator.addMethod("noLeadingWhitespace", function(value, element) {

            return this.optional(element) || /^[^\s].*$/.test(value);

        }, "Please don't start with a blank space.");

        $.validator.addMethod("onlyDigits", function(value, element) {

            return this.optional(element) || /^\d+$/.test(value);

        }, "Please enter only digits.");

        $("#category_submit").validate({

            rules: {

                'title': {

                    required: true,

                    noLeadingWhitespace: true,

                },
                'description': {

                    required: true,

                }

            },

            messages: {

                'title': {

                    required: "Please enter title",

                    noLeadingWhitespace: "This field cannot start with a blank space.",

                },

                'description': {

                    required: "Please enter short description",

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

                $("#submit").prop("disabled", false);

            } else {

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

                url: "<?= base_url() ?>Other_options_controller/get_duplicate_other_option_title",

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