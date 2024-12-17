<script>
    function toggleVideoInput() {
        const videoType = document.getElementById("video_type").value;
        const videoSection = document.getElementById("video-section");
        const urlSection = document.getElementById("url-section");
        videoSection.style.display = "none";
        urlSection.style.display = "none";
        if (videoType === "Hosted") {
            videoSection.style.display = "block";
        } else if (videoType === "YouTube") {
            urlSection.style.display = "block";
        }
    }
    window.onload = function() {
        toggleVideoInput();
    };
</script>
<script>
    $(document).ready(function() {

        $(function() {

            $('#docs_and_videos').addClass('active');
            $('#docs_and_videos .menu-toggle').addClass('toggled');
            $('#docs_and_videos .ml-menu').css('display', 'block');

            $('#add_text').addClass('active');
            getData();
        });


        $.validator.addMethod("noLeadingWhitespace", function(value, element) {
            return this.optional(element) || /^[^\s].*$/.test(value);
        }, "Please don't start with a blank space.");
        $.validator.addMethod("onlyDigits", function(value, element) {
            return this.optional(element) || /^\d+$/.test(value);
        }, "Please enter only digits.");
        $("#test_submit").validate({
            rules: {
                'title': {
                    required: true,
                    noLeadingWhitespace: true,
                },
                'source_id': {
                    required: true,
                },
                'can_download': {
                    required: true,
                },
                'description': {
                    required: true,
                },
                'image': {
                    required: function(element) {
                        return $('input[name="current_image"]').val() == "";
                    }
                },
                'pdf': {
                    required: function(element) {
                        return $('input[name="current_pdf"]').val() == "";
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
                },
                'pdf': {
                    required: "Please choose an pdf",
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