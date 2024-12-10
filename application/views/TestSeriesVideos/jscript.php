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
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function () {
       
        // CKEDITOR.replace('Description');
        // CKEDITOR.replace('edit_Description');
        // CKEDITOR.config.height = 300;

        $('#Test_series_main').addClass('active');
        $('#Test_series_main .menu-toggle').addClass('toggled');
        $('#Test_series_main .ml-menu').css('display','block');

        $('#Test_series_videos').addClass('active');
        $('#Test_series_videos').addClass('active');
        
        getData();
    });


    $(document).ready(function () {
        /**
         * $type may be success, danger, warning, info
         */
        <?php
        if(isset($this->session->get_userdata()['alert_msg'])) {
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
            },
            {
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
        var ur = "<?php echo base_url() ?>Test_series_videos/fetch_data";
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
    function getDetailsEditYoutube(getID) {
        var lid = getID.replace('edit_', '');
        // alert(lid);
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Test_series_videos/CategoryById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                if(result["id"])
                {
                    $('#edit_id_y').val(result["id"]);
                    $('#edit_Title_y').val(result["video_title"]);
                    $('#edit_URL_y').val(result["video_url"]);
                    $('#edit_duration_y').val(result["video_duration"]);

                    var eid = result["selected_exams_id"];
                    var res = eid.substring(2, 3);

                    $('#edit_exam_y').selectpicker('val', res);
                    $('#edit_test_series_y').selectpicker('val', result["test_series_id"]);
                    
                    $('#edit_output_type_y').selectpicker('val', result["output"]);
                    $('#edit_status_y').selectpicker('val', result["status"]);
                    $('#edit_description_y').val(result["description"]);
                }

            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }

    function getDetailsEditUpload(getID) {
        var lid = getID.replace('edit_', '');
        // alert(lid);
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Test_series_videos/CategoryById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                if(result["id"])
                {
                    $('#edit_id_u').val(result["id"]);
                    $('#edit_Title_u').val(result["video_title"]);
                   // $('#edit_URL_u').val(result["video_url"]);
                    $('#edit_duration_u').val(result["video_duration"]);

                    var eid = result["selected_exams_id"];
                    var res = eid.substring(2, 3);

                    $('#edit_exam_u').selectpicker('val', res);
                    $('#edit_test_series_u').selectpicker('val', result["test_series_id"]);
                    
                    $('#edit_output_type_u').selectpicker('val', result["output"]);
                    $('#edit_status_u').selectpicker('val', result["status"]);
                    $('#edit_description_u').val(result["description"]);
                }

            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }

    function getDetailsEditVimeo(getID) {
        var lid = getID.replace('edit_', '');
        // alert(lid);
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Test_series_videos/CategoryById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                if(result["id"])
                {
                    $('#edit_id_v').val(result["id"]);
                    $('#edit_Title_v').val(result["video_title"]);
                    $('#edit_URL_v').val(result["video_url"]);
                    $('#edit_duration_v').val(result["video_duration"]);

                    var eid = result["selected_exams_id"];
                    var res = eid.substring(2, 3);

                    $('#edit_exam_v').selectpicker('val', res);
                    $('#edit_test_series_v').selectpicker('val', result["test_series_id"]);
                    
                    $('#edit_output_type_v').selectpicker('val', result["output"]);
                    $('#edit_status_v').selectpicker('val', result["status"]);
                    $('#edit_description_v').val(result["description"]);
                }

            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }
    
    //code for delete user
    function deleteDetails(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Category will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deleteCategoryDetailsPerform(lid);
        });
    }

    function deleteCategoryDetailsPerform(getID) {
        var lid = getID.replace('delete_', '');
        showConfirmMessage(lid);
    }

    function showConfirmMessage(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            // myFunctionEr();
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>Test_series_videos/deleteCategory",
                data: "id=" + lid,
                success: function (data) {
                    $('#success_message').html(data);
                    // console.log(data);
                    // myFunctionSuc();
                    var str=$.trim(data);
                    if (str === "success") {
                        swal("Deleted!", "Your User details has been deleted.", "success");
                        getData();
                    } else {
                        $("#error_message").html(data);
                        // myFunctionEr();
                    }
                }
            });
        }
    }
</script>
