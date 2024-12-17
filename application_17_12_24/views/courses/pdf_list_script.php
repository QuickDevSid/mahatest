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

            $('#courses').addClass('active');
            $('#courses .menu-toggle').addClass('toggled');
            $('#courses .ml-menu').css('display', 'block');

            $('#pdfs_list').addClass('active');
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

                'can_download': {
                    required: true,
                },

                'description': {
                    required: true,
                    // noLeadingWhitespace: true,
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

                'can_download': {
                    required: "Please select download value",
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


    });
</script>