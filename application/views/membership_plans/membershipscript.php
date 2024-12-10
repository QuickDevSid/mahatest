<script>
    function toggleVideoInput() {
        const videoType = document.getElementById("video_type").value;
        const videoSection = document.getElementById("video-section");
        const urlSection = document.getElementById("url-section");

        // Hide both sections initially
        videoSection.style.display = "none";
        urlSection.style.display = "none";

        // Show the appropriate section based on the selected option
        if (videoType === "Hosted") {
            videoSection.style.display = "block";
        } else if (videoType === "YouTube") {
            urlSection.style.display = "block";
        }
    }

    // Automatically toggle fields based on pre-selected value (for edit forms)
    window.onload = function() {
        toggleVideoInput();
    };
</script>

<script>
    $(document).ready(function() {

        $(function() {

            $('#membership_plan').addClass('active');
            $('#membership_plan .menu-toggle').addClass('toggled');
            $('#membership_plan .ml-menu').css('display', 'block');

            $('#membership_plan').addClass('active');
            getData();
        });

        $.validator.addMethod("noLeadingWhitespace", function(value, element) {
            return this.optional(element) || /^[^\s].*$/.test(value);
        }, "Please don't start with a blank space.");


        $.validator.addMethod("onlyDigits", function(value, element) {
            return this.optional(element) || /^\d+$/.test(value);
        }, "Please enter only digits.");

        $.validator.addMethod("onlyPositiveDigits", function(value, element) {
            return this.optional(element) || /^[1-9][0-9]*$/.test(value);
        }, "Please enter only digits (1, 2, 3, etc.).");

        $("#test_submit").validate({
            rules: {
                'title': {
                    required: true,
                    noLeadingWhitespace: true,
                },

                'subtitle': {
                    required: true,
                    noLeadingWhitespace: true,
                },

                'validity': {
                    required: true,
                    noLeadingWhitespace: true,
                    onlyPositiveDigits: true,
                },

                'tagline': {
                    required: true,
                    noLeadingWhitespace: true,
                },

                'sequence_no': {
                    required: true,
                    noLeadingWhitespace: true,
                    onlyPositiveDigits: true,
                },


                'mrp': {
                    required: true,
                    noLeadingWhitespace: true,
                    onlyDigits: true,
                },

                'sale_price': {
                    required: true,
                    noLeadingWhitespace: true,
                },

                'discount': {
                    required: true,
                    noLeadingWhitespace: true,
                    onlyDigits: true,
                },

                'description': {
                    required: true,
                },

                'record_status': {
                    required: true,
                },


            },
            messages: {
                'title': {
                    required: "Please enter title",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                },

                'subtitle': {
                    required: "Please enter subtitle",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                },

                'tagline': {
                    required: "Please enter tagline",
                },

                'validity': {
                    required: "Please enter no. of months",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                    onlyPositiveDigits: "Please enter a digit only (e.g., 1, 2, 3).",
                },

                'sequence_no': {
                    required: "Please enter sequence no",
                },

                'mrp': {
                    required: "Please enter mrp",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                    onlyDigits: "Please enter only numeric values."
                },

                'sale_price': {
                    required: "Please enter sale price",
                    noLeadingWhitespace: "This field cannot start with a blank space.",

                },

                'discount': {
                    required: "Please enter discount",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                    onlyDigits: "Please enter only numeric values."
                },

                'description': {
                    required: "Please enter description",
                },
                'record_status': {
                    required: "Please select status",
                },


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

        function calculateSalePrice() {
            var mrp = parseFloat($('#mrp').val());
            var discount = parseFloat($('#discount').val());
            if (!isNaN(mrp) && !isNaN(discount)) {
                var salePrice = mrp - (mrp * discount / 100);
                $('#sale_price').val(salePrice.toFixed(2));
            } else {
                $('#sale_price').val('');
            }
        }
        $('#mrp, #discount').on('input', function() {
            calculateSalePrice();
        });
        if ($('#mrp').val() && $('#discount').val()) {
            calculateSalePrice();
        }
    });
</script>