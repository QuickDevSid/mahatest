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
            $('#whatsapp_details').addClass('active');
            $('#whatsapp_details .menu-toggle').addClass('toggled');
            $('#whatsapp_details .ml-menu').css('display', 'block');
            $('#whatsapp_details').addClass('active');
            getData();
        });

        $.validator.addMethod("noLeadingWhitespace", function(value, element) {
            return this.optional(element) || /^[^\s].*$/.test(value);
        }, "Please don't start with a blank space.");


        $.validator.addMethod("onlyDigits", function(value, element) {
            return this.optional(element) || /^\d+$/.test(value);
        }, "Please enter only digits.");

        $("#whatsapp_details").validate({
            rules: {
                'whatsapp_number': {
                    required: true,
                    onlyDigits: true,
                    noLeadingWhitespace: true,
                },
            },
            messages: {
                'whatsapp_number': {
                    required: "Please enter title",
                    onlyDigits: "Please enter only digits.",
                    noLeadingWhitespace: "Please don't start with a blank space.",
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

    });
</script>