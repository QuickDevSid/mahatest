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
        $("#categorysubmit").validate({
            rules: {
                'title': {
                    required: true,
                }
            },
            messages: {
                'title': {
                    required: "Please enter title",
                }
            },
            submitHandler: function(form) {
                console.log("Form is valid and being submitted.");
                form.submit();
            }
        });
        $(function() {
            $('#marathi_sabd').addClass('active');
            $('#marathi_sabd .menu-toggle').addClass('toggled');
            $('#marathi_sabd .ml-menu').css('display', 'block');
            $('#marathi_sabd').addClass('active');
            getData();
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