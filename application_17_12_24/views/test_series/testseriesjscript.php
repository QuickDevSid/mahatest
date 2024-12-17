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
            $('#test_series_main').addClass('active');
            $('#test_series_main .menu-toggle').addClass('toggled');
            $('#test_series_main .ml-menu').css('display', 'block');

            $('#add_test_series').addClass('active');
            getData();
        });

        $.validator.addMethod("noLeadingWhitespace", function(value, element) {
            return this.optional(element) || /^[^\s].*$/.test(value); // Ensures the first character is not whitespace
        }, "Please don't start with a blank space.");


        $.validator.addMethod("onlyDigits", function(value, element) {
            return this.optional(element) || /^\d+$/.test(value); // Ensures only digits are allowed
        }, "Please enter only digits.");

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
                    // noLeadingWhitespace: true,
                },

                'record_status': {
                    required: true,
                },

                'prakaran_lecture': {
                    required: true,
                },

                'image': {
                    required: function(element) {
                        return $('input[name="current_image"]').val() == "";
                    }
                },
                'inner_banner_image': {
                    required: function(element) {
                        return $('input[name="current_inner_banner_image"]').val() == "";
                    }
                }
            },
            messages: {
                'title': {
                    required: "Please enter title",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                },

                'validity': {
                    required: "Please enter validity",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                    onlyPositiveDigits: "Please enter a digit only (e.g., 1, 2, 3).",
                },

                'subtitle': {
                    required: "Please enter subtitle",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
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

                'tagline': {
                    required: "Please enter tagline",
                },

                'prakaran_lecture': {
                    required: "Please enter prakaran lecture",
                },

                'description': {
                    required: "Please enter description",
                },
                'record_status': {
                    required: "Please select status",
                },

                'image': {
                    required: "Please choose an image",
                },
                'inner_banner_image': {
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
                $("#submit").show();
                $("#submit").prop("disabled", false);
            } else {
                $("#submit").hide();
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
                url: "<?= base_url() ?>TestSeries/get_duplicate_title",
                type: "post",
                data: {
                    'id': id,
                    'title': title,
                },
                success: function(response) {
                    // print_r(response);
                    if (response > 0) {
                        $('#title_error').text("This title is already taken").show();
                        console.log("inside " + title);
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