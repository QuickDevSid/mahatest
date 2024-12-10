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
    $(function () {
 
        $('#master').addClass('active');
        $('#master .menu-toggle').addClass('toggled');
        $('#master .ml-menu').css('display','block');

        $('#admin_users').addClass('active');
        getData();
    });

    $("#fileUpload").on('change', function () {
        if (typeof (FileReader) != "undefined") {
            var image_holder = $("#image-holder");
            image_holder.empty();
            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image setpropileam"
                }).appendTo(image_holder);
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    });

    $(document).ready(function() {
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
        if (type === null || type === '') { type = 'success'; }
        if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
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
        var ur = "<?php echo base_url() ?>Users/fetch_user";
        //Exportable table
        $('.js-exportable').DataTable({
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

    //Add client form validation.
    $('#adduserform').validate({
        rules: {
            'checkbox': {
                required: true
            },
            'gender': {
                required: true
            }
        },
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.input-group').append(error);
        }
    });

    //Form data submition.
    $("#adduserform").submit(function (e) {
        e.preventDefault();
        var name = $("#name").val();
        var mobile = $("#mobile").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var type = $("#type").val();
        var status = $("#status").val();

        if (name === "" || email === "" || password === "" || type === "" || status === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>User_API/addUser",
                data: "name=" + name + "&mobile=" + mobile + "&email=" + email + "&password=" + password + "&type=" + type + "&status=" + status,
                success: function (data) {
                    $('#success_message').html(data);
                    if (data === "Success") {
                        myFunctionSuc();
                        getData();
                    } else if (data === "Exists") {
                        $("#error_message").html("User all ready exists");
                        myFunctionEr();
                    }else if (data === "Mail Sent.") {
                        $("#success_message").html("User added.");
                        myFunctionSuc();
                        getData();
                    } else{
                        $("#error_message").html("All Fields required.");
                        myFunctionEr();
                    }
                }
            });
        }
    });

    function getFormDetails(getID) {
        var lid = getID.replace('user_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>User_API/userById", // replace 'PHP-FILE.php with your php file
            data: "id=" + lid,
            dataType: "json",
            success: function (result) {
                $('#edit_id').val(result[0]["id"]);
                $('#edit_name').val(result[0]["name"]);
                $('#edit_mobile').val(result[0]["mobile"]);
                $('#edit_email').val(result[0]["email"]);
                $('#edit_password').val(result[0]["password"]);
                $('#edit_type').val(result[0]["type"]);
                $('#edit_status').val(result[0]["status"]);

                var x = document.getElementById("div_limit");
                if (result[0]["type"] == "Super Admin" || result[0]["type"] == "Client") {
                    x.style.display = "none";
                }else {
                    x.style.display = "block";
                }
            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }

    //Form data submition.
    $("#edituserform").submit(function (e) {
        e.preventDefault();

        var id = $("#edit_id").val();
        var name = $("#edit_name").val();
        var mobile = $("#edit_mobile").val();
        var email = $("#edit_email").val();
        var password = $("#edit_password").val();
        var type = $("#edit_type").val();
        var status = $("#edit_status").val();

        if (name === "" || email === "" || password === "" || type === "" || status === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "PUT",
                url: "<?php echo base_url() ?>User_API/updateUser",

                data: "id=" + id + "&name=" + name + "&mobile=" + mobile + "&email=" + email + "&password=" + password + "&type=" + type + "&status=" + status,

                success: function (data) {
                    $('#success_message').html(data);
                    if (data === "success") {
                        myFunctionSuc();
                        getData();
                    } else {
                        $("#error_message").html("All Fields are Required");
                        myFunctionEr();
                    }
                }
            });
        }
    });

    function showConfirmMessage(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "User will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deleteUserDetailsPerform(lid);
        });
    }

    function deleteUserDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteUserDetailsPerform(getID) {
        var lid = getID;

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "DELETE",
                url: "<?php echo base_url() ?>User_API/deleteUser",
                data: "id=" + lid,
                success: function (data) {
                    $('#success_message').html(data);
                    myFunctionSuc();
                    if (data === "Success") {
                        swal("Deleted!", "Your User details has been deleted.", "success");
                        getData();
                    } else {
                        $("#error_message").html(data);
                        myFunctionEr();
                    }
                }
            });
        }
    }

    function viewUserDetails(getID) {
        var lid = getID.replace('view_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>User_API/userById", // replace 'PHP-FILE.php with your php file
            data: "id=" + lid,
            dataType: "json",
            success: function (result) {
                $('#view_id').val(result[0]["id"]);
                $('#view_name').val(result[0]["name"]);
                $('#view_mobile').val(result[0]["mobile"]);
                $('#view_email').val(result[0]["email"]);
                $('#view_password').val(result[0]["password"]);
                $('#view_type').val(result[0]["type"]);
                $('#view_status').val(result[0]["status"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }
</script>
