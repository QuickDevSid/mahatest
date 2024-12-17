<script>
    $(document).ready(function() {

        $(function() {

            <?php if (isset($_GET['syllabus'])) { ?>

                $('#syllabus_options').addClass('active');

                $('#syllabus_options .menu-toggle').addClass('toggled');

                $('#syllabus_options .ml-menu').css('display', 'block');

                $('#add_syllabus').addClass('active');

            <?php } else { ?>

                $('#other_options').addClass('active');

                $('#other_options .menu-toggle').addClass('toggled');

                $('#other_options .ml-menu').css('display', 'block');

                $('#add_other_option').addClass('active');

            <?php } ?>

            getData();

        });
    });
</script>