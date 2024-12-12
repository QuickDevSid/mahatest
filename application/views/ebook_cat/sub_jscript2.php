<script>
    $(document).ready(function() {
        $("#test_submit").validate({

            $(function() {

                $('#ebooks').addClass('active');
                $('#ebooks .menu-toggle').addClass('toggled');
                $('#ebooks .ml-menu').css('display', 'block');

                $('#ebooks').addClass('active');
                getData();
            });


            rules: {
                'title': {
                    required: true,
                },
                'image': {
                    required: true,
                },
                'category': {
                    required: true,
                }
            },
            messages: {
                'title': {
                    required: "Please enter title",
                },
                'image': {
                    required: "Please choose image",
                },
                'category': {
                    required: "Please select category",
                }
            },
            submitHandler: function(form) {
                console.log("Form is valid and being submitted.");
                form.submit();
            }
        });
    });
</script>