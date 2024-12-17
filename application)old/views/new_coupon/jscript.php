<script type="text/javascript">
    //Tooltip
    $(function() {

        $('#coupon').addClass('active');
        $('#coupon .menu-toggle').addClass('toggled');
        $('#coupon .ml-menu').css('display', 'block');

        $('#coupon').addClass('active');
        getData();
    });


    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function() {

        $('#video_source,#edit_video_source').change(function() {
            if ($(this).val() === 'Hosted') {
                $('#url-section,#edit_url-section').hide();
                $('#video-section,#edit_video-section').show();
            } else {
                $('#video-section,#edit_video-section').hide();
                $('#url-section,#edit_url-section').show();
            }
        });


        //CKEditor
        CKEDITOR.config.height = 300;
        CKEDITOR.replace('description', {
            extraPlugins: 'filebrowser',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url() ?>Uploader/upload',
        });
        CKEDITOR.replace('edit_description', {
            extraPlugins: 'filebrowser',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url() ?>Uploader/upload',
        });



    });

    function getData() {
        //Table data featching.
        var ur = "<?php echo base_url() ?>get_ebooks_video_details";
        console.log('ur', ur)
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

    $('#submit').submit(function(e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                // if()
                $('#success_message').html(data);
                if (data === "Operation failed.") {
                    $("#error_message").html("All Fields are Required");
                    myFunctionEr();
                } else {
                    $('#submit').trigger("reset");
                    myFunctionSuc();
                    getData();
                    $('#add').modal('hide');
                }
            }
        });
    });

    function getExamSectionDetails(getID) {
        var lid = getID.replace('details_', '');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>get_single_video_doc/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                var img = result["image_url"];
                let newsrc = '';
                newsrc = '<?= base_url() ?>' + 'AppAPI/docs_videos/docs/images/' + img;

                let link = result.video_url;

                console.log('img', newsrc)
                $("#s_img").attr("src", newsrc);
                $('#s_title').val(result["title"]);
                var url = link;
                var id = url.split("?v=")[1];
            },
            error: function() {
                alert('Some error occurred!');
            }
        });

    }

    function getExamSectionDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>get_single_video_doc/" + lid,
            dataType: "json",
            success: function(result) {
                $('#edit_title').val(result["title"]);
                $('#edit_id').val(result["id"]);
            },
            error: function() {
                alert('Some error occurred!');
            }
        });
    }



    function toggleVideoFields(videoSource, videoURL) {
        if (videoSource === "YouTube") {
            $('#edit_url-section').show();
            $('#edit_video-section').hide();
            $('#edit_video_url').val(videoURL); // For YouTube URL input
        } else {
            $('#edit_url-section').hide();
            $('#edit_video-section').show();
            $('#edit_video_url').val(videoURL); // For file upload input
        }
    }

    $('#submit_examsection').submit(function(e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            //url:'<?php echo base_url(); ?>index.php/upload/do_upload',
            url: $(this).attr('action'),
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {

                $('#success_message').html(data);
                if (data === "Operation failed.") {
                    $("#error_message").html("All Fields are Required");
                    myFunctionEr();
                } else {
                    myFunctionSuc();

                    getData();
                    $('#edit').modal('hide');
                }
            }
        });
    });

    //code for delete user
    function showConfirmMessage(getID) {
        var lid = getID;
        swal({
            title: "Are you sure?",
            text: "Ebook Details will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true
        }, function() {
            deleteExamSectionDetailsFunc(lid);
        });
    }

    function deleteExamSectionDetails(getID) {
        var lid = getID.replace('delete_', '');
        showConfirmMessage(lid);
    }

    function deleteExamSectionDetailsFunc(getID) {
        var lid = getID.split("delete")[1];
        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>Ebook_Category/delete_ebooks_cat_video_data/",
                data: {
                    id: lid
                },
                success: function(data) {
                    if (data === "Success") {
                        swal("Deleted!", "Details have been deleted successfully.", "success");
                        $('#success_message').html("Successfully Deleted!");
                        myFunctionSuc(); // Ensure this triggers your success popup
                        getData(); // Refresh data after deletion
                    } else {
                        $("#error_message").html(data);
                        myFunctionEr();
                    }
                },
                error: function() {
                    alert("An error occurred!");
                }
            });
        }
    }
</script>