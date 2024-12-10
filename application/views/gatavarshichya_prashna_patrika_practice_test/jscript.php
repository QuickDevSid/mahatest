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
        $('#Gatavarshiche_prashna_main').addClass('active');
        $('#Gatavarshiche_prashna_main .menu-toggle').addClass('toggled');
        $('#Gatavarshiche_prashna_main .ml-menu').css('display', 'block');

        $('#Gatavarshichya_prashna_patrika_practice_test').addClass('active');
        
        $('#quiz_ans').prop('readonly', true);

        var mathElements = [
            'math',
            'maction',
            'maligngroup',
            'malignmark',
            'menclose',
            'merror',
            'mfenced',
            'mfrac',
            'mglyph',
            'mi',
            'mlabeledtr',
            'mlongdiv',
            'mmultiscripts',
            'mn',
            'mo',
            'mover',
            'mpadded',
            'mphantom',
            'mroot',
            'mrow',
            'ms',
            'mscarries',
            'mscarry',
            'msgroup',
            'msline',
            'mspace',
            'msqrt',
            'msrow',
            'mstack',
            'mstyle',
            'msub',
            'msup',
            'msubsup',
            'mtable',
            'mtd',
            'mtext',
            'mtr',
            'munder',
            'munderover',
            'semantics',
            'annotation',
            'annotation-xml'
        ];

        CKEDITOR.plugins.addExternal('ckeditor_wiris', 'https://ckeditor.com/docs/ckeditor4/4.16.0/examples/assets/plugins/ckeditor_wiris/', 'plugin.js');

        CKEDITOR.replace('s_instruction', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        CKEDITOR.replace('e_instruction', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        CKEDITOR.replace('a_instruction', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });

        CKEDITOR.replace('explanation', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });

        CKEDITOR.replace('quiz_quation', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        CKEDITOR.replace('quiz_opt1', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        CKEDITOR.replace('quiz_opt2', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        CKEDITOR.replace('quiz_opt3', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        CKEDITOR.replace('quiz_opt4', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        CKEDITOR.replace('quiz_ans', {
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });

        // CKEDITOR.replace('edit_Description');
        CKEDITOR.config.height = 100;
        $("#addquizqua").removeAttr("tabindex");


        // CKEDITOR.replace('edit_Description');
        // CKEDITOR.config.height = 300;

        getData();
    });
    $('#addquizqua').on('shown.bs.modal', function () {
        $(document).off('focusin.modal');
    });
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


    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/fetch_data";
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

    //Form data submition.js for add exam in sql.
    $("#addquizform").submit(function (e) {
        e.preventDefault();
        var quiz_title = $("#quiz_title").val();
        var quiz_qua = $("#quiz_qua").val();
        var quiz_duration = $("#quiz_duration").val();
        var quiz_status = $("#quiz_status").val();
        var CreatedOn = $("#CreatedOn").val();
        //alert(study_name);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/addQuiz",
            data: "quiz_title=" + quiz_title + "&quiz_qua=" + quiz_qua + "&quiz_duration=" + quiz_duration + "&quiz_status=" + quiz_status + "&CreatedOn=" + CreatedOn,

            success: function (data) {


                $('#success_message').html(data);
                if (data === "Operation failed.") {
                    $("#error_message").html("All Fields are Required");
                    myFunctionEr();
                } else {
                    myFunctionSuc();
                    $("#quiz_title").val("");
                    $("#quiz_qua").val("");
                    $("#quiz_duration").val("");
                    $("#quiz_status").val("");
                    $("#CreatedOn").val("");
                    getData();
                }
            }
        });

    });

    //fetch exam detailes
    function getquizDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/QuizById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                // console.log(result);
                //alert(lid);
                $('#s_quiz_id').val(result["quiz_id"]);
                $("#s_quiz_title").val(result["s_quiz_title"]);
                $("#s_quiz_questions").val(result["quiz_questions"]);
                $("#s_quiz_duration").val(result["quiz_duration"]);
                $('#test_series').selectpicker('val', result["test_series_id"]);
                $("#s_correct_answer_mark").val(result["correct_answer_mark"]);
                $("#s_wrong_answer_mark").val(result["wrong_answer_mark"]);
                $("#s_instructions").val(result["instructions"]);


                var s = result["status"];
                $('button[data-id="s_status"]').html('<span class="filter-option pull-left">' + s + '</span>');

                $('#e_year').selectpicker('val', result["year"]);
                $('#s_status').val(result["status"]);

                $('#s_created_at').val(result["created_at"]);

            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    function getquizeEdit(getID) {
        var lid = getID.replace('client_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/QuizById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                 console.log(result);
                //alert(lid);
                $('#e_quiz_id').val(result["quiz_id"]);
                $("#e_quiz_title").val(result["s_quiz_title"]);
                $("#e_quiz_questions").val(result["quiz_questions"]);
                $("#e_quiz_duration").val(result["quiz_duration"]);
             
               // $("#file_view").html(result["file"]);

                $('#e_test_series').selectpicker('val', result["test_series_id"]);


                $("#e_correct_answer_mark").val(result["correct_answer_mark"]);
                $("#e_wrong_answer_mark").val(result["wrong_answer_mark"]);
                CKEDITOR.instances['e_instruction'].setData(result["instructions"]);

                $('#e_year').selectpicker('val', result["year"]);
                $('#e_status').selectpicker('val', result["status"]);


                $('#e_created_at').val(result["created_at"]);

            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    $("#editquizform").submit(function (e) {
        e.preventDefault();
        var e_quiz_id = $("#e_quiz_id").val();
        var e_quiz_title = $("#e_quiz_title").val();
        var e_quiz_questions = $("#e_quiz_questions").val();
        var e_quiz_duration = $("#e_quiz_duration").val();
        var e_status = $("#e_status").val();
        var e_created_at = $("#e_created_at").val();


        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/Quizbyadd",

            data: "e_quiz_id=" + e_quiz_id + "&e_quiz_title=" + e_quiz_title + "&e_quiz_questions=" + e_quiz_questions +
                "&e_quiz_duration=" + e_quiz_duration + "&e_status=" + e_status + "&e_created_at=" + e_created_at,

            success: function (data) {
                //console.log(data);

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


    });

    //code for delete user
    function showConfirmMessage(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Test will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deletequizDetailsPerform(lid);
        });
    }

    function deletequizDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deletequizDetailsPerform(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "DELETE",
                url: "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/deletequiz/" + lid + "",
                data: "id=" + lid,
                success: function (data) {
                    $('#success_message').html(data);
                    console.log(data);
                    myFunctionSuc();
                    if (data === "Success") {
                        swal("Deleted!", "Test details has been deleted.", "success");
                        getData();
                    } else {
                        $("#error_message").html(data);
                        myFunctionEr();
                    }
                }
            });
        }
    }


    //this code for add qution in quize
    function addquizQuaDetails(getID) {
        var lid = getID.replace('Add_', '');
        $('#quiz_id').val(lid);
        var ur = "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/fetch_qua_ans/" + lid;
        //Exportable table
        //  alert(lid);
        setTimeout(function () {
            //your datatable code
            $('#client_licenses').DataTable({
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
        }, 1000);
    }

    function getData_one(lid) {
//Table data featching.
//alert(lid);
        var ur = "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/fetch_qua_ans/" + lid;
        //Exportable table
        $('#client_licenses').DataTable({
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

    function edit_qtn(id) {
        $.post("<?php echo base_url()?>Gatavarshichya_prashna_patrika_practice_test/get_qtn_details", {id: id}, function (res) {
            var str = $.trim(res);
            // alert(str);
            var obj = JSON.parse(str);
            CKEDITOR.instances["quiz_quation"].setData(obj.question);
            CKEDITOR.instances["quiz_opt1"].setData(obj.option1);
            CKEDITOR.instances["quiz_opt2"].setData(obj.option2);
            CKEDITOR.instances["quiz_opt3"].setData(obj.option3);
            CKEDITOR.instances["quiz_opt4"].setData(obj.option4);
            CKEDITOR.instances["quiz_ans"].setData(obj.answer);
            CKEDITOR.instances["explanation"].setData(obj.explanation);

            $("#edit_id").val(obj.id);
            $("#quiz_id").val(obj.quiz_id);

            $('#quiz_status').selectpicker('val', obj.status);
            $('#subject_id').selectpicker('val', obj.subject_id);
            $('#option_btn').selectpicker('val', obj.select_ans);

        });
    }


    $('#add_quiz_qua').submit(function (e) {
        e.preventDefault();

        var quiz_quation = CKEDITOR.instances["quiz_quation"].getData();
        var quiz_opt1 = CKEDITOR.instances["quiz_opt1"].getData();
        var quiz_opt2 = CKEDITOR.instances["quiz_opt2"].getData();
        var quiz_opt3 = CKEDITOR.instances["quiz_opt3"].getData();
        var quiz_opt4 = CKEDITOR.instances["quiz_opt4"].getData();
        var quiz_ans = CKEDITOR.instances["quiz_ans"].getData();
        var explanation = CKEDITOR.instances["explanation"].getData();
        var quiz_id = $("#quiz_id").val();
        var quiz_status = $("#quiz_status").val();
        var subject_id = $("#subject_id").val();
        var edit_id = $("#edit_id").val();
        var type = $("#type").val();
        if (quiz_quation != "" && quiz_opt1 != "" && quiz_opt2 != "" && quiz_opt3 != "" && quiz_opt4 != "" && quiz_ans != "" && quiz_id != "") {

            $.ajax
            ({
                //url:'<?php echo base_url();?>index.php/upload/do_upload',
                url: "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/addquation",
                type: "post",
                // data:new FormData(this),
                // processData:false,
                // contentType:false,
                // cache:false,
                // async:false,
                data: {
                    "quiz_id": quiz_id,
                    "quiz_quation": quiz_quation,
                    "quiz_opt1": quiz_opt1,
                    "quiz_opt2": quiz_opt2,
                    "quiz_opt3": quiz_opt3,
                    "quiz_opt4": quiz_opt4,
                    "quiz_ans": quiz_ans,
                    "quiz_status": quiz_status,
                    "subject_id": subject_id,
                    "edit_id": edit_id,
                    "type": type,
                    "explanation": explanation
                },

                success: function (data) {
                    $('#success_message').html(data);
                    if (data === "Operation failed.") {
                        $("#error_message").html("All Fields are Required");
                        swal("Error!", "error to update data.", "error");
                    } else {
                        $("#quiz_title").val("");
                        $("#quiz_qua").val("");
                        $("#quiz_duration").val("");
                        $("#quiz_status").val("");
                        $("#CreatedOn").val("");
                        CKEDITOR.instances["quiz_quation"].setData("");
                        CKEDITOR.instances["quiz_opt1"].setData("");
                        CKEDITOR.instances["quiz_opt2"].setData("");
                        CKEDITOR.instances["quiz_opt3"].setData("");
                        CKEDITOR.instances["quiz_opt4"].setData("");
                        CKEDITOR.instances["quiz_ans"].setData("");
                        CKEDITOR.instances["explanation"].setData("");

                        $("#edit_id").val("");

                        $('#quiz_status').selectpicker('val', "");
                        $('#subject_id').selectpicker('val', "");
                        $('#option_btn').selectpicker('val', "");

                        myFunctionSuc();
                        var id = $("#quiz_id").val();
                        getData();
                        getData_one(id);
                        swal("Success!", "Question Added.", "success");
                    }
                }
            });
        } else {
            swal("Error!", "All fields are compulsory.", "error");
        }

        //Table data featching.

    });

    function deletequaDetails(getID, uid) {
        var lid = getID.replace('delete_', '');
//           alert(lid);
        showConfirmMessageQuestion(lid, uid);
    }

    function deletequaDetailsPerform(getID, uid) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "DELETE",
                url: "<?php echo base_url() ?>Gatavarshichya_prashna_patrika_practice_test/deletequizqua/" + lid + "",
                data: "id=" + lid,
                success: function (data) {
                    $('#success_message').html(data);
                    //console.log(data);
                    myFunctionSuc();
                    if (data === "Success") {
                        swal("Deleted!", "Exam details has been deleted.", "success");
                        var id = $("#quiz_id").val();
                        getData();
                        getData_one(id);
                        //alert(uid);
                    } else {
                        $("#error_message").html(data);
                        myFunctionEr();
                    }
                }
            });
        }
    }

    function showConfirmMessageQuestion(getID, uid) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Test Question will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deletequaDetailsPerform(lid, uid);
        });
    }

    function get_option(val) {
        var op = val.value;
        if (op > 0) {
            // var ans=$("#quiz_opt"+op+"").val();
            // $("#quiz_ans").val(ans);

            var ans = CKEDITOR.instances["quiz_opt" + op + ""].getData();
            CKEDITOR.instances['quiz_ans'].setData(ans);
        }

    }


    function change_add_question_panel()
    {
        if ($("#cke_4_toolbox").hasClass("hidden")) {
            jQuery('#cke_3_toolbox').removeClass('hidden');
            jQuery('#cke_4_toolbox').removeClass('hidden');
            jQuery('#cke_5_toolbox').removeClass('hidden');
            jQuery('#cke_6_toolbox').removeClass('hidden');
            jQuery('#cke_7_toolbox').removeClass('hidden');
            jQuery('#cke_8_toolbox').removeClass('hidden');
            jQuery('#cke_9_toolbox').removeClass('hidden');
            $("#question_model_show_button").text(function(_,text){
                return "Hide";
            });

        }else {
            jQuery('#cke_3_toolbox').addClass('hidden');
            jQuery('#cke_4_toolbox').addClass('hidden');
            jQuery('#cke_5_toolbox').addClass('hidden');
            jQuery('#cke_6_toolbox').addClass('hidden');
            jQuery('#cke_7_toolbox').addClass('hidden');
            jQuery('#cke_8_toolbox').addClass('hidden');
            jQuery('#cke_9_toolbox').addClass('hidden');
            $("#question_model_show_button").text(function(_,text){
                return "Show";
            });
        }

    }


    jQuery(window).load(function () {
        setTimeout(function () {
            change_add_question_panel();
        }, 2000);

    });


    function importExcel(getID) {
        var lid = getID.replace('Import_', '');
        $('#import_quiz_id').val(lid);

    }
</script>
