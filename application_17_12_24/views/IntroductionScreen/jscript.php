<script type="text/javascript">
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function () {
        $('#master').addClass('active');
        $('#master .menu-toggle').addClass('toggled');
        $('#master .ml-menu').css('display','block');

        $('#introduction_screens').addClass('active');
        getData();
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>get_introduction_screen_details";
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
                type: "GET"
            }
        });
    }

    $('#submit').submit(function (e) {
        e.preventDefault();
        $.ajax
        ({
            //url:'<?php echo base_url();?>index.php/upload/do_upload',
            url: "<?php echo base_url() ?>Introduction_screens/addIntroductionScreen",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
                $('#success_message').html(data);
                if (data === "Operation failed.") {
                    $("#error_message").html("All Fields are Required");
                    myFunctionEr();
                } else {
                    $('#submit').trigger("reset");
                    myFunctionSuc();
                    getData();
                    $('#addIntroductionScreen').modal('hide');
                }
            }
        });
    });

    function getIntroductionScreenDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>introduction_screens/fetchIntroductionScreenDetail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var img = result["upload_img"];
                newsrc = "AppAPI/introduction-screen/images/" + img;
                var iconimg = result["upload_icon"];
                iconsrc = "AppAPI/introduction-screen/icon/" + iconimg;
                $("#s_img").attr("src", newsrc);
                $("#s_iconImg").attr("src", iconsrc);
                $('#s_title').val(result["title"]);
                $('#s_description').val(result["description"]);
                $('#s_created_at').val(result["created_at"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    function getIntroductionScreenDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>introduction_screens/fetchIntroductionScreenDetail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var img = result["upload_img"];
                newsrc = "AppAPI/introduction-screen/images/" + img;
                var iconimg = result["upload_icon"];
                iconsrc = "AppAPI/introduction-screen/icon/" + iconimg;
                $("#e_img").attr("src", newsrc);
                $("#e_iconimg").attr("src", iconsrc);
                $('#e_title').val(result["title"]);
                $('#e_id').val(result["id"]);
                $('#e_description').val(result["description"]);
                $('#e_oldimg').val(img);
                $('#e_oldiconimg').val(iconimg);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }

    $('#submit_introductionScreen').submit(function (e) {
        e.preventDefault();
        $.ajax
        ({
            //url:'<?php echo base_url();?>index.php/upload/do_upload',
            url: "<?php echo base_url() ?>introduction_screens/editIntroductionScreen",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {

                $('#success_message').html(data);
                if (data === "Operation failed.") {
                    $("#error_message").html("All Fields are Required");
                    myFunctionEr();
                } else {
                    myFunctionSuc();

                    getData();
                    $('#editIntroductionScreen').modal('hide');
                }
            }
        });
    });

    //code for delete user
    function showConfirmMessage(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Details will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deleteIntroductionScreenDetailsFunc(lid);
        });
    }

    function deleteIntroductionScreenDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteIntroductionScreenDetailsFunc(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>introduction_screens/deleteIntroductionScreen/"+lid,
                
                success: function (data) {
                    
                    $('#success_message').html(data);
                    myFunctionSuc();                     
                    window.location.href='<?php echo base_url() ?>introduction_screens';   
                    
                }
            });
        }
    }
</script>
