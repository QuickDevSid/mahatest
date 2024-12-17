<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */
?>


<script>
    $(document).ready(function() {
        $("#categorysubmit").validate({
            ignore: [],
            rules: {
                'title': {
                    required: true,
                }
            },
            messages: {
                'title': {
                    required: "Please enter title",
                }
            },
            submitHandler: function(form) {
                if (confirm("Do you want to submit the form?")) {
                    document.getElementById("test_submit").addEventListener("submit", function(event) {
                        var submitButton = document.getElementById("submit_category");
                        submitButton.disabled = true;
                        submitButton.innerHTML = "Submitting...";
                    });
                    form.submit();
                }
            }
        });

        $(function() {

            $('#english_vocabulary').addClass('active');
            $('#english_vocabulary .menu-toggle').addClass('toggled');
            $('#english_vocabulary .ml-menu').css('display', 'block');

            $('#english_vocabulary_category').addClass('active');
            getData();
        });
    });
</script>