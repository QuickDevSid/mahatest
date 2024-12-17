<script type="text/javascript">
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function () {
       
        $('#master').addClass('active');
        $('#master .menu-toggle').addClass('toggled');
        $('#master .ml-menu').css('display','block');

        $('#Category').addClass('active');
        getData();
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>get_category_details";
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
            url: "<?php echo base_url() ?>Category/addCategory",
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
                    $('#add').modal('hide');
                }
            }
        });
    });

    function getCategoryDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Category/fetchCategoryDetail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var img = result["icon_img"];
                newsrc = "AppAPI/category-icon/" + img;
                
                
                $("#s_img").attr("src", newsrc);
                $('#s_Title').val(result["title"]);
                $('#s_section').selectpicker('val',result["section"]);
                $('#s_status').selectpicker('val',result["status"]);
                $('#s_created_at').val(result["created_at"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    function getCategoryDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Category/fetchCategoryDetail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var img = result["icon_img"];
                newsrc = "AppAPI/category-icon/" + img;
                
                
                $("#e_img").attr("src", newsrc);
                $('#old_iconfile').val(result["icon_img"]);
                $('#edit_Title').val(result["title"]);
                $('#edit_section').selectpicker('val',result["section"]);
                $('#edit_status').selectpicker('val',result["status"]);
                $('#edit_id').val(result["id"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    $('#submit_category').submit(function (e) {
        e.preventDefault();
        $.ajax
        ({
            //url:'<?php echo base_url();?>index.php/upload/do_upload',
            url: "<?php echo base_url() ?>Category/editCategory",
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
            text: "Details will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deleteCategoryFunc(lid);
        });
    }

    function deleteCategoryDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteCategoryFunc(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>Category/deleteCategory/"+lid,
                
                success: function (data) {
                    
                    $('#success_message').html(data);
                    myFunctionSuc();                     
                    window.location.href='<?php echo base_url() ?>Category';   
                    
                }
            });
        }
    }

</script>