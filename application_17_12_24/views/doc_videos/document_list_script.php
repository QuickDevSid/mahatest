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

            $('#document_list').addClass('active');
            getData();
        });

    });
</script>