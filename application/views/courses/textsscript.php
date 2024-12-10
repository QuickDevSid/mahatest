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
        $.validator.addMethod("noLeadingWhitespace", function(value, element) {
            return this.optional(element) || /^[^\s].*$/.test(value); // Ensures the first character is not whitespace
        }, "Please don't start with a blank space.");

        $.validator.addMethod("onlyDigits", function(value, element) {
            return this.optional(element) || /^\d+$/.test(value); // Ensures only digits are allowed
        }, "Please enter only digits.");

        $(function() {

            $('#courses').addClass('active');
            $('#courses .menu-toggle').addClass('toggled');
            $('#courses .ml-menu').css('display', 'block');

            $('#courses').addClass('active');
            getData();
        });

        $("#test_submit").validate({
            rules: {
                'title': {
                    required: true,
                    noLeadingWhitespace: true,
                },

                'source_id': {
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
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                },

                'source_id': {
                    required: "Please select course",
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
                url: "<?= base_url() ?>Courses/get_duplicate_courses_text_title",
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