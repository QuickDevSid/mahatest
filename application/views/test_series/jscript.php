<script>
    $(document).ready(function() {
        $(function() {
            $('#test_series_main').addClass('active');
            $('#test_series_main .menu-toggle').addClass('toggled');
            $('#test_series_main .ml-menu').css('display', 'block');

            $('#test_series_main').addClass('active');
            getData();
        });

        $("#test_submit").validate({
            ignore: [],
            rules: {
                test_series_id: "required",
                'test_id[]': "required",
            },
            messages: {
                test_series_id: "Please select test series!",
                'test_id[]': "Please select test!",
            },
            submitHandler: function(form) {
                if (confirm("Do you want to submit the form?")) {
                    document.getElementById("test_submit").addEventListener("submit", function(event) {
                        var submitButton = document.getElementById("submit_course_test");
                        submitButton.disabled = true;
                        submitButton.innerHTML = "Submitting...";
                    });
                    form.submit();
                }
            }
        });
    });
</script>
<script type="text/javascript">
    //Tooltip

    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function() {

        $('#test_series_main').addClass('active');
        $('#test_series_main .menu-toggle').addClass('toggled');
        $('#test_series_main .ml-menu').css('display', 'block');

        $('#' + id).addClass('active');
        getData();
        $('#video_source,#edit_video_source').change(function() {
            if ($(this).val() === 'Hosted') {
                $('#url-section,#edit_url-section').hide();
                $('#video-section,#edit_video-section').show();
            } else {
                $('#video-section,#edit_video-section').hide();
                $('#url-section,#edit_url-section').show();
            }
        });
    });

    function getData() {
        //Table data featching.
        var ur = url;
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

    function getSeriesDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>TestSeries/get_single_series_detail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                $('#edit_title').val(result["title"]);
                $('#edit_sub_title').val(result["sub_headings"]);
                $('#edit_mrp').val(result["mrp"]);
                $('#edit_sale_price').val(result["sale_price"]);
                $('#edit_discount').val(result["discount"]);
                $('#edit_status option[value="' + result["status"] + '"]').attr("selected", "selected");
                $('#edit_status').selectpicker('refresh');
                $('#edit_description').val(result["description"]);
                $('#edit_id').val(result["id"]);
            },
            error: function() {
                alert('Some error occurred!');
            }
        });

    }

    function getSingleSeriesDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>TestSeries/get_single_series_detail/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                var img = result["banner_image"];
                let newsrc = '';
                newsrc = '<?= base_url() ?>' + img;

                console.log('img', newsrc)
                $("#s_img").attr("src", newsrc);
                $('#s_title').val(result["title"]);
                $('#s_sub_title').val(result["sub_headings"]);
                $('#s_mrp').val(result["mrp"]);
                $('#s_sale_price').val(result["sale_price"]);
                $('#s_discount').val(result["discount"]);
                $('#s_status option[value="' + result["status"] + '"]').attr("selected", "selected");
                $('#s_status').selectpicker('refresh');
                $('#s_description').val(result["description"]);

            },
            error: function() {
                alert('Some error occurred!');
            }
        });

    }

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                $('.err').remove();
                var response = $.parseJSON(data);
                if (response.Status === "Success") {
                    $('#success_message').html(response.msg);
                    $('#submit').trigger("reset");
                    myFunctionSuc();
                    getData();
                    $('#add').modal('hide');
                } else {
                    if (!response.Status) {
                        let i = 1;
                        if (response.Exception) {
                            swal('Oops...', response.Body);
                            return false;
                        } else {
                            $.each(response.error, function(index, item) {
                                console.log(index, item);
                                if (index != '') {
                                    let inputField = $('#' + index);
                                    if (i == 1) {
                                        inputField.focus();
                                    }
                                    inputField.after(
                                        `${item}`);
                                    i++;
                                }
                            });
                        }
                    }
                }
            }
        });
    });

    function getExamSectionDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>get_single_video_doc/" + lid + "?type=" + type, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                var img = result["image_url"];
                let newsrc = '';
                newsrc = '<?= base_url() ?>' + img;
                let source_type = result.video_source;
                let link = result.video_url;

                console.log('img', newsrc)
                $("#s_img").attr("src", newsrc);
                $('#s_title').val(result["title"]);
                $('#s_time').val(result["time"]);

                $('#s_status option[value="' + result["status"] + '"]').attr("selected", "selected");
                $('#s_status').selectpicker('refresh');
                $('#s_can_download option[value="' + result["can_download"] + '"]').attr("selected", "selected");
                $('#s_can_download').selectpicker('refresh');
                $('#s_description').val(result["description"]);
                $('#s_num_of_question').val(result["num_of_questions"]);
                if (result['type'] == 'Video') {
                    if (source_type != 'Youtube') {
                        url = '';
                        if (source_type == 'Hosted') {
                            link = '<video width="100%" height="200" controls class="w-100"><source src="<?= base_url() ?>' + link + '"></video>';
                        } else {
                            var url = link;
                            var id = url.split("vimeo.com/")[1]; //sGbxmsDFVnE
                            link = `
						<iframe width="100%" height="200" src="https://player.vimeo.com/video/${id}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
							`;
                            // link = '<video width="320" height="240" controls><source type="video/mp4" src="'+link+'"></video>';
                        }
                    } else {
                        var url = link;
                        var id = url.split("?v=")[1]; //sGbxmsDFVnE

                        var embedlink = "http://www.youtube.com/embed/" + id;
                        link = '<div class="ratio ratio-16x9"><iframe width="100%" height="400" src="' + embedlink + '?autohide=0&showinfo=0&controls=0"></iframe></div>';
                    }
                    $('#video').html(link)
                }
                $('#s_source_id option[value="' + result["source_id"] + '"]').attr("selected", "selected");
                $('#s_source_id').selectpicker('refresh');
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
            url: "<?php echo base_url() ?>get_single_video_doc/" + lid + "?type=" + type, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                $('#edit_title').val(result["title"]);
                $('#edit_status').val(result["status"]);
                $('#edit_num_of_question').val(result["num_of_questions"]);
                $('#edit_status option[value="' + result["status"] + '"]').attr("selected", "selected");
                $('#edit_status').selectpicker('refresh');
                $('#edit_can_download option[value="' + result["can_download"] + '"]').attr("selected", "selected");
                $('#edit_can_download').selectpicker('refresh');

                $('#edit_source_id option[value="' + result["source_id"] + '"]').attr("selected", "selected");
                $('#edit_source_id').selectpicker('refresh');
                // alert()
                if (result['video_source'] != '') {
                    // alert()
                    $('#edit_video_source option[value="' + result["video_source"] + '"]').attr("selected", "selected");
                    $('#edit_video_source').change();
                    $('#edit_video_source').selectpicker('refresh');
                    if (result['video_source'] != 'Hosted') {
                        $('input[type="url"]').val(result['video_url'])
                    }

                }
                $('#edit_description').val(result["description"]);
                $('#edit_id').val(result["id"]);
                $('#edit_time').val(result["time"]);
            },
            error: function() {
                alert('Some error occurred!');
            }
        });

    }

    $('#submit_examsection').submit(function(e) {
        e.preventDefault();
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
                $('.err').remove();
                var response = $.parseJSON(data);
                if (response.Status === "Success") {
                    $('#success_message').html(response.msg);
                    $('#submit_examsection').trigger("reset");
                    myFunctionSuc();
                    getData();
                    $('#edit').modal('hide');
                } else {
                    if (!response.Status) {
                        let i = 1;
                        if (response.Exception) {
                            swal('Oops...', response.Body);
                            return false;
                        } else {
                            $.each(response.error, function(index, item) {
                                console.log(index, item);
                                if (index != '') {
                                    let inputField = $('#' + index);
                                    if (i == 1) {
                                        inputField.focus();
                                    }
                                    inputField.after(
                                        `${item}`);
                                    i++;
                                }
                            });
                        }
                    }
                }
            }
        });
    });
    $('#submit_question').submit(function(e) {
        e.preventDefault();
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
                $('.err').remove();
                var response = $.parseJSON(data);
                if (response.Status === "Success") {
                    $('#submit_question').trigger("reset");
                    myFunctionSuc();
                    questions(selected_quiz_id);
                } else {
                    if (!response.Status) {
                        let i = 1;
                        if (response.Exception) {
                            swal('Oops...', response.Body);
                            return false;
                        } else {
                            $.each(response.error, function(index, item) {
                                console.log(index, item);
                                if (index != '') {
                                    let inputField = $('#' + index);
                                    if (i == 1) {
                                        inputField.focus();
                                    }
                                    inputField.after(
                                        `${item}`);
                                    i++;
                                }
                            });
                        }
                    }
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
        }, function() {
            deleteExamSectionDetailsFunc(lid);
        });
    }

    function deleteExamSectionDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteExamSectionDetailsFunc(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>Doc_Videos/delete_doc_video_data/" + lid,

                success: function(data) {

                    $('#success_message').html(data);
                    myFunctionSuc();
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);

                }
            });
        }
    }
    let selected_quiz_id = 0;

    function getQuizDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Quizs/get_single_quiz/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                $('#edit_title').val(result["title"]);
                $('#edit_status option[value="' + result["status"] + '"]').attr("selected", "selected");
                $('#edit_status').selectpicker('refresh');
                $('#edit_source_id option[value="' + result["section_id"] + '"]').attr("selected", "selected");
                $('#edit_source_id').selectpicker('refresh');
                $('#edit_num_of_question').val(result["no_of_question"]);
                $('#edit_marks_per_question').val(result["marks_per_question"]);
                $('#edit_time').val(result["time"]);
                $('#edit_description').val(result["description"]);
                $('#edit_id').val(result["id"]);
            },
            error: function() {
                alert('Some error occurred!');
            }
        });

    }

    function getSingleQuizDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Quizs/get_single_quiz/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                var img = result["image_url"];
                let newsrc = '';
                newsrc = '<?= base_url() ?>' + img;
                $("#s_img").attr("src", newsrc);
                $('#s_title').val(result["title"]);
                $('#s_status option[value="' + result["status"] + '"]').attr("selected", "selected");
                $('#s_status').selectpicker('refresh');
                $('#s_source_id option[value="' + result["section_id"] + '"]').attr("selected", "selected");
                $('#s_source_id').selectpicker('refresh');
                $('#s_num_of_question').val(result["no_of_question"]);
                $('#s_marks_per_question').val(result["marks_per_question"]);
                $('#s_time').val(result["time"]);
                $('#s_description').val(result["description"]);
                $('#s_id').val(result["id"]);
            },
            error: function() {
                alert('Some error occurred!');
            }
        });

    }

    function getQuestions(quiz_id) {
        quiz_id = quiz_id.replace('edit_', '');
        $('#quiz_id').val(quiz_id);
        questions(quiz_id);
        selected_quiz_id = quiz_id
    }

    function questions(quiz_id) {
        //Exportable table
        setTimeout(() => {
            $('#questions').DataTable({
                dom: 'Bfrtip',
                destroy: true,
                responsive: true,
                scrollX: true,
                scrollY: true,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "ajax": {
                    url: "<?= base_url('Quizs/getQuestions'); ?>?quiz_id=" + quiz_id,
                    type: "GET"
                }
            });

        }, 1000);
    }

    function getSingleQuestionDetail(question_id) {
        question_id = question_id.replace('edit_', '');
        $('#question_id').val(question_id);
        getSingleQuestion(question_id);
    }

    function getSingleQuestion(question_id) {
        //Exportable table
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Quizs/get_single_question/" + question_id,
            dataType: "json",
            success: function(result) {
                $('#question').val(result["question"]);
                $('#option1').val(result["option1"]);
                $('#option2').val(result["option2"]);
                $('#option3').val(result["option3"]);
                $('#option4').val(result["option4"]);
                $('#status option[value="' + result["status"] + '"]').attr("selected", "selected");
                $('#status').selectpicker('refresh');
                $('#answer option[value="' + result["answer"] + '"]').attr("selected", "selected");
                $('#answer').selectpicker('refresh');
                $('#question_description').val(result["description"]);
                $('#question_id').val(result["id"]);
                $('#quiz_id').val(result["quiz_id"]);
            },
            error: function() {
                alert('Some error occurred!');
            }
        });
    }
</script>