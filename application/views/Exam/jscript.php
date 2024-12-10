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

        $('#All_exam_list').addClass('active');
        getData();
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>All_exam_list/fetch_user";
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

    function getExamDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>All_exam_list/ExamById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                $('#d_exam_name').val(result[0]["exam_name"]);
                $("#d_status").val(result[0]["status"]);
                $('#d_created_at').val(result[0]["created_at"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });


    }


    //Form data submition.
    $("#addExamForm").submit(function (e) {
        e.preventDefault();
        var exam_name = $("#exam_name").val();
        var status = $("#status").val();

        if (exam_name === "" || status === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>All_exam_list_API/addExam",
                data: "exam_name=" + exam_name +  "&status=" + status,
                success: function (data) {
                    $('#success_message').html(data);
                    if (data === "Success") {
                        myFunctionSuc();
                        getData();
                    } else if (data === "Exists") {
                        $("#error_message").html("Exam all ready exists");
                        myFunctionEr();
                    }else if (data === "Mail Sent.") {
                        $("#success_message").html("Exam added.");
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
            url: "<?php echo base_url() ?>All_exam_list_API/examById", // replace 'PHP-FILE.php with your php file
            data: "id=" + lid,
            dataType: "json",
            success: function (result) {
                $('#edit_exam_id').val(result[0]["exam_id"]);
                $('#edit_exam_name').val(result[0]["exam_name"]);
                $('#edit_status').val(result[0]["status"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }


    //Form data submition.
    $("#editExamForm").submit(function (e) {
        e.preventDefault();

        var exam_id = $("#edit_exam_id").val();
        var exam_name = $("#edit_exam_name").val();
        var status = $("#edit_status").val();

        if (exam_name === "" || status === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "PUT",
                url: "<?php echo base_url() ?>All_exam_list_API/updateExam",

                data: "exam_id=" + exam_id + "&exam_name=" + exam_name + "&status=" + status,

                success: function (data) {
                    $('#success_message').html(data);
                    if (data === "success") {
                        myFunctionSuc();
                        getData();
                    } else {
                        $("#error_message").html("All Fields are Required.");
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
            text: "Exam will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deleteExamDetailsPerform(lid);
        });
    }

    function deleteExamDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteExamDetailsPerform(getID) {
        var lid = getID;

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "DELETE",
                url: "<?php echo base_url() ?>All_exam_list_API/deleteExam",
                data: "id=" + lid,
                success: function (data) {
                    $('#success_message').html(data);
                    myFunctionSuc();
                    if (data === "Success") {
                        swal("Deleted!", "Your Exam details has been deleted.", "success");
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
