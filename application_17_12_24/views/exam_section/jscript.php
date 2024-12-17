<script type="text/javascript">
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function () {
       
        $('#master').addClass('active');
        $('#master .menu-toggle').addClass('toggled');
        $('#master .ml-menu').css('display','block');

        $('#Exam_section').addClass('active');
        getData();
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>get_exam_section_details";
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
            url: "<?php echo base_url() ?>Exam_section/addExamSection",
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

    function getExamSectionDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Exam_section/fetchExamSectionDetail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var img = 'placeholder.png';
                if (result["icon"]){
                    img = result["icon"];
                }
                newsrc = "AppAPI/exam-section-icon/" + img;
                
                
                $("#s_img").attr("src", newsrc);
                $('#s_Title').val(result["title"]);
                $('#s_background_color').val(result["background_color"]);
                $('#s_created_at').val(result["created_at"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    function getExamSectionDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Exam_section/fetchExamSectionDetail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var img = 'placeholder.png';
                if (result["icon"]){
                    img = result["icon"];
                }
                newsrc = "AppAPI/exam-section-icon/" + img;
                
                
                $("#e_img").attr("src", newsrc);
                $('#old_iconfile').val(result["icon"]);
                $('#edit_Title').val(result["title"]);
                $('#edit_background_color').val(result["background_color"]);
                $('#edit_id').val(result["id"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    $('#submit_examsection').submit(function (e) {
        e.preventDefault();
        $.ajax
        ({
            //url:'<?php echo base_url();?>index.php/upload/do_upload',
            url: "<?php echo base_url() ?>Exam_section/editExamSection",
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


</script>