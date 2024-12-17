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
        $('#doubts').addClass('active');
        getData();
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>Doubts/fetch_user";
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

    //end code here
    function getdoughtDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Doubts_Api/doughtById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                $("#d_user_title").html(result[0]["username"]);
                $("#d_exam_group").html(result[0]["exam_name"]);
                $("#d_created_at").html("Posted on " + result[0]["created_at"]);
                if (result[0]["image"] != "N/A"){
                    $("#d_post_image").html('<img class="img-fluid rounded" style="width: 100%;" src="<?php echo base_url() ?>AppAPI/' + result[0]["image"] + '" alt="">');
                }
                
                $("#d_question").html(result[0]["question"]);

                $('#id').val(result[0]["id"]);

                getPostComment(result[0]["id"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    //code for delete user
    function showConfirmMessage(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Dought will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deletedoughtDetailsPerform(lid);
        });
    }

    function deletedoughtDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deletedoughtDetailsPerform(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "DELETE",
                url: "<?php echo base_url() ?>Doubts_Api/deletedought",
                data: "id=" + lid,
                success: function (data) {
                    $('#success_message').html(data);
                    console.log(data);
                    myFunctionSuc();
                    if (data === "Success") {
                        swal("Deleted!", "Dought details has been deleted.", "success");
                        getData();
                    } else {
                        $("#error_message").html(data);
                        myFunctionEr();
                    }
                }
            });
        }
    }

    function change_status(id, status)
    {
        if(id!="" && status!="")
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>Doubts/updateStatus",
                data: "id=" + id+"&status="+status,
                success: function (data) {
                    $('#success_message').html(data);
                    console.log(data);
                    if (data === "Success") {
                        swal("Updated!", "Doubts status updated.", "success");
                        getData();
                    } else {
                        $("#error_message").html(data);
                    }
                }
            });

        }
        getData();
        return false;
    }

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


    function getPostComment(getID) {

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Doubts/commentById/" + getID, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var obj = result;
                var comment = "";
                var state = "";
                
                $("#d_comment").html("");
                
                $.each(obj, function (key, value) {

                    if(value.comment_status =='Active')
                    {
                        state = '<a href="#" class="btn btn-primary right" onclick="return change_status_comment(' + value.doubts_comment_id + ', \'Deactive\',' + getID + ')">Active</a>';
                    }
                    else
                    {
                        state = '<a href="#" class="btn btn-danger right" onclick="return change_status_comment(' + value.doubts_comment_id + ', \'Active\',' + getID + ')">Deactive</a>';
                    }
                    
                    comment =  comment + '<div class="media mt-4">' +
                        '<div class="media-left"><img class="d-flex mr-3 rounded-circle  media-left" width="64" height="64" src="' + value.profile_image + '" alt=""></div>' +
                        '<div class="media-body">' +
                        '<h5 class="mt-0">' + value.full_name + '</h5>' + value.comment_body +
                        '   ' + state +  '</div>' +
                        '</div>';
                });

                $("#d_comment").html(comment);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }


    function change_status_comment(id, status, did)
    {
        if(id!="" && status!="")
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>Doubts/updateStatusComment",
                data: "id=" + id+"&status="+status,
                success: function (data) {
                    $('#success_message').html(data);
                    console.log(data);
                    if (data === "Success") {
                        swal("Updated!", "Doubts Comment status updated.", "success");

                        getPostComment(did);
                        getData();
                    } else {
                        $("#error_message").html(data);
                    }
                }
            });

        }
        getData();
        return false;
    }
</script>
