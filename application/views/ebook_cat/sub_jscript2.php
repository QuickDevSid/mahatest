<script>
    $(document).ready(function() {
        $("#test_submit").validate({
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