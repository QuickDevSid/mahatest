<script>
    $(document).ready(function() {

        $(function() {

            $('#coupon').addClass('active');
            $('#coupon .menu-toggle').addClass('toggled');
            $('#coupon .ml-menu').css('display', 'block');

            $('#coupon').addClass('active');
            getData();
        });

        $.validator.addMethod("noLeadingWhitespace", function(value, element) {
            return this.optional(element) || /^[^\s].*$/.test(value);
        }, "Please don't start with a blank space.");

        $.validator.addMethod("capitalizeFirstLetter", function(value, element) {
            return this.optional(element) || /^[A-Z]/.test(value);
        }, "Please start with a capital letter.");

        $.validator.addMethod("allCapsAlphaNumeric", function(value, element) {
            return this.optional(element) || /^[A-Z0-9]+$/.test(value);
        }, "Please enter only uppercase letters and numbers.");

        $.validator.addMethod("onlyDigits", function(value, element) {
            return this.optional(element) || /^[0-9]+$/.test(value);
        }, "Please enter only digits.");

        $("#test_submit").validate({
            rules: {
                'name': {
                    required: true,
                    capitalizeFirstLetter: true,
                    noLeadingWhitespace: true,
                },
                'code': {
                    required: true,
                    noLeadingWhitespace: true,
                    allCapsAlphaNumeric: true,
                },
                'discount_type': {
                    required: true,
                },
                'discount': {
                    required: true,
                    onlyDigits: true,
                },
                'type': {
                    required: true,
                },
                'description': {
                    required: true,
                }
            },
            messages: {
                'name': {
                    required: "Please enter name",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                    capitalizeFirstLetter: "Please start first letter with a capital letter.",
                },
                'code': {
                    required: "Please enter code",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                    allCapsAlphaNumeric: "Please enter only uppercase letters and numbers.",
                },
                'discount_type': {
                    required: "Please select discount type",
                },
                'discount': {
                    required: "Please select discount amount",
                    onlyDigits: "Please enter only digits",
                },
                'type': {
                    required: "Please select coupon type",
                },
                'description': {
                    required: "Please select description",
                }
            },
            submitHandler: function(form) {
                console.log("Form is valid and being submitted.");
                form.submit();
            }
        });

        function validateForm() {
            const roundName = $('#name').val();
            let roundValid = $('#name_error').is(':hidden');
            const codeName = $('#code').val();
            let codeValid = $('#code_error').is(':hidden');
            if (roundValid && codeValid) {
                $("#submit").show();
                $("#submit").prop("disabled", false);
            } else {
                $("#submit").hide();
                $("#submit").prop("disabled", true);
            }
        }
        $("#name").keyup(function() {
            $('#name_error').text("").hide();
            validateForm();
        });
        $('#name').keyup(function() {
            var id = $('#id').val();
            var name = $('#name').val();
            console.log("name: " + name);
            $.ajax({
                url: "<?= base_url() ?>Ebook_Category/get_duplicate_coupon_name",
                type: "post",
                data: {
                    'id': id,
                    'name': name,
                },
                success: function(response) {
                    if (response > 0) {
                        $('#name_error').text("This name is already taken").show();
                    } else {
                        $('#name_error').text("").hide();
                    }
                    validateForm();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });

        $("#code").keyup(function() {
            $('#code_error').text("").hide();
            validateForm();
        });
        $('#code').keyup(function() {
            var id = $('#id').val();
            var code = $('#code').val();
            console.log("code: " + code);
            $.ajax({
                url: "<?= base_url() ?>Ebook_Category/get_duplicate_coupon_code",
                type: "post",
                data: {
                    'id': id,
                    'code': code,
                },
                success: function(response) {
                    if (response > 0) {
                        $('#code_error').text("This code is already taken").show();
                    } else {
                        $('#code_error').text("").hide();
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