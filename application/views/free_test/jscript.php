<script type="text/javascript">
    $(document).ready(function() {
        $("#test_submit").validate({
            ignore: [],
            rules: {
                'test_id[]': "required",
            },
            messages: {
                'test_id[]': "Please select test!",
            },
            submitHandler: function(form) {
                if (confirm("Do you want to submit the form?")) {
                    document.getElementById("test_submit").addEventListener("submit", function(event) {
                        var submitButton = document.getElementById("submit_course_test");
                        submitButton.disabled = true;
                        submitButton.innerHTML = "Submitting...";
                    });
                    form.submit();
                }
            }
        });
    });
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

</script>