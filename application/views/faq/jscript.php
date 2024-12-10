<script type="text/javascript">
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function () {
        $('#master').addClass('active');
        $('#master .menu-toggle').addClass('toggled');
        $('#master .ml-menu').css('display','block');

        $('#faq').addClass('active');
        getData();
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>get_faq_details";
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
            url: "<?php echo base_url() ?>FAQ/addFAQ",
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
                    $('#addFAQ').modal('hide');
                }
            }
        });
    });

    function getFAQDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>FAQ/fetchFAQDetail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {                
                $('#s_title').val(result["title"]);
                $('#s_description').val(result["description"]);
                $('#s_created_at').val(result["created_at"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    function getFAQDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>FAQ/fetchFAQDetail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                
                $('#e_title').val(result["title"]);
                $('#e_id').val(result["id"]);
                $('#e_description').val(result["description"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }

    $('#submit_faq').submit(function (e) {
        e.preventDefault();
        $.ajax
        ({
            //url:'<?php echo base_url();?>index.php/upload/do_upload',
            url: "<?php echo base_url() ?>FAQ/editFAQ",
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
                    $('#editFAQ').modal('hide');
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
            deleteFAQFunc(lid);
        });
    }

    function deleteFAQDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteFAQFunc(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>FAQ/deleteFAQ/"+lid,
                
                success: function (data) {
                    
                    $('#success_message').html(data);
                    myFunctionSuc();                     
                    window.location.href='<?php echo base_url() ?>faq';   
                    
                }
            });
        }
    }
</script>
