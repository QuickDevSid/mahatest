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
        $('#master').addClass('active');
        $('#master .menu-toggle').addClass('toggled');
        $('#master .ml-menu').css('display','block');

        $('#Banner').addClass('active');
        getData();
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>Banner/fetch_user";
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

    $('#submit').submit(function (e) {
        e.preventDefault();
        $.ajax
        ({
            //url:'<?php echo base_url();?>index.php/upload/do_upload',
            url: "<?php echo base_url() ?>Banner_Api/addbanner",
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
                    $('#addbanner').modal('hide');
                }
            }
        });
    });

    function getbannerDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Banner_Api/BannerById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var img = result[0]["banner_image"];
                
                $("#s_img").attr("src", img);
                $('#s_status').val(result[0]["status"]);
                $('#s_section_id').selectpicker('val',result[0]["section_id"]);
                $('#s_sub_section_id').html(result[0]["sub_section_id"]);
                $('#s_sub_section_id').selectpicker('refresh');
                $('#s_sequence').val(result[0]["sequence_no"]);
                $('#s_created_at').val(result[0]["created_on"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    function getBannerEdit(getID) {
        var lid = getID.replace('client_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Banner_Api/BannerById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                $('#e_banner_id').val(result[0]["banner_id"]);
                var img = result[0]["banner_image"];

                $('#e_section_id').val(result[0]["section_id"]);

                
                $("#e_img").attr("src", img);
                $('#e_section_id').selectpicker('val',result[0]["section_id"]);
                $('#e_sub_section_id').html(result[0]["sub_section_id"]);
                $('#e_sub_section_id').selectpicker('refresh');
                $('#e_sequence').val(result[0]["sequence_no"]);

                var s = result[0]["status"];
                $('button[data-id="e_status"]').html('<span class="filter-option pull-left">' + s + '</span>');
                $('#e_img1').val(result[0]["banner_image"]);


            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }

    $('#submit_ebanner').submit(function (e) {
        e.preventDefault();
        $.ajax
        ({
            //url:'<?php echo base_url();?>index.php/upload/do_upload',
            url: "<?php echo base_url() ?>Banner_Api/editbannerD",
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
                    $('#editbanner').modal('hide');
                    getData();
                }
            }
        });
    });

    //code for delete user
    function showConfirmMessage(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Banner will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deleteBannerDetailsPerform(lid);
        });
    }

    function deleteBannerDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteBannerDetailsPerform(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "DELETE",
                url: "<?php echo base_url() ?>Banner_Api/deleteBanner",
                data: "id=" + lid,
                success: function (data) {
                    $('#success_message').html(data);
                    //console.log(data);
                    myFunctionSuc();
                    if (data === "Success") {
                        swal("Deleted!", "Your Banner details has been deleted.", "success");
                        getData();
                    } else {
                        $("#error_message").html(data);
                        myFunctionEr();
                    }
                }
            });
        }
    }
    $('#section_id').change(function(){
        var section_id=$(this).val();
        //alert(section_id);
        if (section_id === "") {
            $("#error_message").html("Please select Section");
            myFunctionEr();
        } else {
            $.ajax({
                type: "Post",
                url: "<?php echo base_url() ?>Banner/getSubSectionDetail",
                data: {"section_id":section_id},
                success: function (data) {
                    $('#sub_section_id').html(data);
                    $('#sub_section_id').selectpicker('refresh');
                   // console.log(data);
                   
                }
            });
        }
    });
    $('#e_section_id').change(function(){
        var section_id=$(this).val();
        //alert(section_id);
        if (section_id === "") {
            $("#error_message").html("Please select Section");
            myFunctionEr();
        } else {
            $.ajax({
                type: "Post",
                url: "<?php echo base_url() ?>Banner/getSubSectionDetail",
                data: {"section_id":section_id},
                success: function (data) {
                    $('#e_sub_section_id').html(data);
                    $('#e_sub_section_id').selectpicker('refresh');
                   // console.log(data);
                   
                }
            });
        }
    });
</script>
