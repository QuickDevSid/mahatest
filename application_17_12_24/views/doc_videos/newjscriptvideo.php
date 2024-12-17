<script>
    function toggleVideoInput() {
        const videoType = document.getElementById("video_type").value;
        const videoSection = document.getElementById("video-section");
        const urlSection = document.getElementById("url-section");
        const youtubeUrlInput = document.getElementById("youtube_url");
        const videoFileInput = document.getElementById("video_file");
        const currentVideoInput = document.querySelector('input[name="current_video"]');

        // Hide both sections by default
        videoSection.style.display = "none";
        urlSection.style.display = "none";
        if (videoType === "Hosted") {
            youtubeUrlInput.value = ""; // Clear YouTube URL
            youtubeUrlInput.disabled = true; // Disable YouTube URL input
            // currentVideoInput.value = "";
            videoSection.style.display = "block"; // Show video file section

        } else if (videoType === "YouTube") {
            videoFileInput.value = ""; // Clear video file input
            currentVideoInput.value = "";
            youtubeUrlInput.disabled = false; // Enable YouTube URL input
            urlSection.style.display = "block"; // Show YouTube URL section
        }
    }
    // Initialize toggle logic on page load
    window.onload = function() {
        toggleVideoInput(); // Ensure correct state for pre-selected value
    };
</script>
<script>
    $(document).ready(function() {
        $(function() {

            $('#docs_and_videos').addClass('active');
            $('#docs_and_videos .menu-toggle').addClass('toggled');
            $('#docs_and_videos .ml-menu').css('display', 'block');

            $('#add_videos').addClass('active');
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
                'source_id': {
                    required: true,
                },
                'video_source': {
                    required: true,
                },
                "video_file": {
                    required: function() {
                        return $("#video_type").val() === "Hosted" && $("input[name='current_video']").val() === "";
                    },
                    extension: "mp4|avi|mov",
                },
                "youtube_url": {
                    required: function() {
                        return $("#video_type").val() === "YouTube" && $("input[name='current_video']").val() === "";
                    },
                    url: true,
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
                'youtube_url': {
                    required: "Please enter a YouTube URL.",
                    url: "Please enter a valid URL.",
                },
                'video_file': {
                    required: "Please upload a video file.",
                    extension: "Only MP4, AVI, and MOV files are allowed.",
                },
                'title': {
                    required: "Please enter title",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                },
                'source_id': {
                    required: "Please select course",
                },
                'video_source': {
                    required: "Please select video type",
                },
                'video_url': {
                    required: "Please select video",
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
                console.log("Video Type: " + $("#video_type").val());
                console.log("Video File: " + $("#video_file").val());
                console.log("YouTube URL: " + $("#youtube_url").val());
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
                url: "<?= base_url() ?>Ebook_Category/get_duplicate_cat_title",
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