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

            $('#videos_list').addClass('active');
            getData();
        });



    });
</script>