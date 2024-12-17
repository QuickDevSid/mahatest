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
<script type="text/javascript">
    $(document).ready(function() {
        $(function() {

            $('#current_affairs').addClass('active');
            $('#current_affairs .menu-toggle').addClass('toggled');
            $('#current_affairs .ml-menu').css('display', 'block');

            $('#current_affairs_quiz').addClass('active');
            getData();
        });

        $("#categorysubmit").validate({
            ignore: [],
            rules: {
                category_name: "required",
            },
            messages: {
                category_name: "Please enter category name!",
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
    });
    $(document).ready(function() {
        $("#test_submit").validate({
            ignore: [],
            rules: {
                category_id: "required",
                'test_id[]': "required",
            },
            messages: {
                category_id: "Please select category!",
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

    // $(function() {
    //     // $('#posts').addClass('active');
    //     // $('#posts .menu-toggle').addClass('toggled');
    //     // $('#posts .ml-menu').css('display','block');
    //     // $('#current_affairs').addClass('active');

    //     var mathElements = [
    //         'math',
    //         'maction',
    //         'maligngroup',
    //         'malignmark',
    //         'menclose',
    //         'merror',
    //         'mfenced',
    //         'mfrac',
    //         'mglyph',
    //         'mi',
    //         'mlabeledtr',
    //         'mlongdiv',
    //         'mmultiscripts',
    //         'mn',
    //         'mo',
    //         'mover',
    //         'mpadded',
    //         'mphantom',
    //         'mroot',
    //         'mrow',
    //         'ms',
    //         'mscarries',
    //         'mscarry',
    //         'msgroup',
    //         'msline',
    //         'mspace',
    //         'msqrt',
    //         'msrow',
    //         'mstack',
    //         'mstyle',
    //         'msub',
    //         'msup',
    //         'msubsup',
    //         'mtable',
    //         'mtd',
    //         'mtext',
    //         'mtr',
    //         'munder',
    //         'munderover',
    //         'semantics',
    //         'annotation',
    //         'annotation-xml'
    //     ];

    //     CKEDITOR.plugins.addExternal('ckeditor_wiris', 'https://ckeditor.com/docs/ckeditor4/4.16.0/examples/assets/plugins/ckeditor_wiris/', 'plugin.js');



    //     //CKEditor
    //     CKEDITOR.replace('Description', {
    //         extraPlugins: 'ckeditor_wiris,filebrowser',
    //         extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
    //         filebrowserUploadMethod: "form",
    //         filebrowserUploadUrl: '<?php echo base_url() ?>Uploader/upload',
    //     });
    //     CKEDITOR.replace('edit_Description', {
    //         extraPlugins: 'ckeditor_wiris,filebrowser',
    //         extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
    //         filebrowserUploadMethod: "form",
    //         filebrowserUploadUrl: '<?php echo base_url() ?>Uploader/upload',
    //     });
    //     CKEDITOR.config.height = 300;


    //     getData();
    // });

    $(document).ready(function() {
        /**
         * $type may be success, danger, warning, info
         */
        <?php
        if (isset($this->session->get_userdata()['alert_msg'])) {
        ?>
            $msg = '<?php echo $this->session->get_userdata()['alert_msg']['msg']; ?>';
            $type = '<?php echo $this->session->get_userdata()['alert_msg']['type']; ?>';
            showNotification($msg, $type);
        <?php
            $this->session->unset_userdata('alert_msg');
        }
        ?>
    });

    function showNotification(text, type) {
        if (type === null || type === '') {
            type = 'success';
        }
        if (text === null || text === '') {
            text = 'Turning standard Bootstrap alerts';
        }
        //if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
        //if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
        var allowDismiss = true;

        $.notify({
            message: text
        }, {
            type: 'alert-' + type,
            allow_dismiss: allowDismiss,
            newest_on_top: true,
            timer: 1000,
            placement: {
                from: 'top',
                align: 'right'
            },
            animate: {
                enter: 'animated zoomInRight',
                exit: 'animated zoomOutRight'
            },
            template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
        });
    }

    function getData() {
        //Table data featching.
        var ur = "<?php echo base_url() ?>CurrentAffairs/fetch_user";
        //Exportable table
        $('#user_data').DataTable({
            dom: 'Bfrtip',
            destroy: true,
            responsive: true,
            scrollX: true,
            scrollY: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "ajax": {
                url: ur,
                type: "POST"
            }
        });
    }

    function getPostDetails(getID) {
        var lid = getID.replace('details_', '');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>CurrentAffairs/postById_D/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                //console.log(result);return false;
                $("#d_post_title").html(result[0]["current_affair_title"]);
                // $("#d_exam_group").html(result[0]["exam_name"]);
                $("#d_created_at").html("Posted on " + result[0]["created_at"]);
                $("#d_category").html(result[0]["category_name"]);
                $("#d_views").html("Views " + result[0]["views"]);
                if (result[0]["current_affair_image"]) {
                    $("#d_post_image").html('<img class="img-fluid rounded" style="width: 100%;" src="<?php echo base_url() ?>AppAPI/current-affairs/' + result[0]["current_affair_image"] + '" alt="">');
                }
                $("#d_post_description").html(result[0]["current_affair_description"]);

                return false;
                getPostComment(lid)
            },
            error: function() {
                alert('Some error occurred!');
            }
        });
    }

    function getPostComment(getID) {

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>CurrentAffairs/commentById/" + getID, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                let obj = result;
                let comment = "";
                $.each(obj, function(key, value) {
                    comment = comment + '<div class="media mt-4">' +
                        '<div class="media-left"><img class="d-flex mr-3 rounded-circle  media-left" width="64" height="64" src="' + value.profile_image + '" alt=""></div>' +
                        '<div class="media-body">' +
                        '<h5 class="mt-0">' + value.full_name + '</h5>' + value.comment_body +
                        '</div>' +
                        '</div>';
                });

                $("#d_comment").html(comment);
            },
            error: function() {
                alert('Some error occurred!');
            }
        });
    }

    //edit code

    function getPostDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');
        // alert(lid);
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>CurrentAffairs/postById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                $('#edit_id').val(result[0]["current_affair_id"]);
                $('#post_image_old').val(result[0]["current_affair_image"]);
                $('#edit_PostTitle').val(result[0]["current_affair_title"]);

                $("#edit_category").selectpicker('val', result[0]["category"]);
                $("#edit_sequence_no").val(result[0]["sequence_no"]);

                //var myArray = jQuery.parseJSON(result[0]["selected_exams_id"]);

                //$('#edit_Exam_Id').selectpicker('val', myArray);
                $('#edit_Status').selectpicker('val', result[0]["status"]);


                if (result[0]["created_at"] != "") {
                    var date = new Date(result[0]["created_at"]);
                    date.setDate(date.getDate());
                    var y = date.getFullYear(),
                        m = date.getMonth() + 1, // january is month 0 in javascript
                        d = date.getDate();

                    if (m <= 9) {
                        m = "0" + m;
                    }
                    if (d <= 9) {
                        d = "0" + d;
                    }
                    var final_date = y + "-" + m + "-" + d;
                } else {
                    final_date = "";
                }


                $("#edit_current_date").val(final_date);
                CKEDITOR.instances['edit_Description'].setData(result[0]["current_affair_description"]);
            },
            error: function() {
                alert('Some error occurred!');
            }
        });
    }


    function showConfirmMessage(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Current Affair's will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function() {
            deleteDetailsPerform(lid);
        });
    }

    function deleteDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteDetailsPerform(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "DELETE",
                url: "<?php echo base_url() ?>CurrentAffairs_Api/deletePost",
                data: "id=" + lid,
                success: function(data) {
                    $('#success_message').html(data);
                    console.log(data);
                    myFunctionSuc();
                    if (data === "Success") {
                        swal("Deleted!", "Current Affair has been deleted.", "success");
                        getData();
                    } else {
                        $("#error_message").html(data);
                        myFunctionEr();
                    }
                }
            });
        }
    }
</script>