<script>
    $(document).ready(function() {
        $('#test_series_data_list').DataTable({
            dom: 'lfrtip',
            responsive: false,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [{
                extend: 'excel',
                footer: true,
                filename: 'Master Gallary list',
                exportOptions: {
                    columns: [0, 2]
                }
            }],
        });
        $("#test_gallary_submit").validate({
            ignore: [],
            rules: {
                zipfile: "required",
            },
            messages: {
                zipfile: "Please select zip file!",
            },
            submitHandler: function(form) {
                if (confirm("Do you want to upload gallary?")) {
                    document.getElementById("test_gallary_submit").addEventListener("gallary_submit", function(event) {
                        var submitButton = document.getElementById("gallary_submit");
                        submitButton.disabled = true;
                        submitButton.innerHTML = "Submitting...";
                    });
                    form.submit();
                }
            }
        });
    });

    function showPassageField() {
        var question_type = $('#question_type').val();
        if (question_type == '2') {
            $('.passage_field').show();
        } else {
            $('.passage_field').hide();
        }
    }
    $(document).ready(function() {
        $(function() {

            $('#test_setup').addClass('active');
            $('#test_setup .menu-toggle').addClass('toggled');
            $('#test_setup .ml-menu').css('display', 'block');

            $('#test-setup').addClass('active');
            getData();
        });

        $.validator.addMethod("noLeadingWhitespace", function(value, element) {
            return this.optional(element) || /^[^\s].*$/.test(value);
        }, "Please don't start with a blank space.");

        $.validator.addMethod("onlyPositiveDigits", function(value, element) {
            return this.optional(element) || /^[1-9][0-9]*$/.test(value);
        }, "Please enter only digits (1, 2, 3, etc.).");

        $("#test_submit").validate({
            ignore: [],
            rules: {
                topic: "required",
                short_note: "required",
                short_description: "required",
                description: "required",
                // bulk_file: "required",
                // sequence_no: "required",
                'sequence_no': {
                    required: true,
                    noLeadingWhitespace: true,
                    onlyPositiveDigits: true,
                },
                questions_shuffle: "required",
                show_ans: "required",
                'image': {
                    required: function(element) {
                        return $('input[name="current_image"]').val() == "";
                    }
                },

                'bulk_file': {
                    required: function(element) {
                        return $('input[name="current_file"]').val() == "";
                    }
                },
                duration: {
                    required: true,
                    number: true,
                    min: 1
                },
            },
            messages: {
                topic: "Please enter subject/topic!",
                short_note: "Please enter short note!",
                short_description: "Please enter short description!",
                description: "Please enter Instruction  description!",
                // bulk_file: "Please upload questions!",
                'sequence_no': {
                    required: "Please enter sequence no!",
                    noLeadingWhitespace: "This field cannot start with a blank space.",
                    onlyPositiveDigits: "Please enter a digit only (e.g., 1, 2, 3).",
                },
                questions_shuffle: "Please select question shuffle!",
                show_ans: "Please select Option!",
                duration: {
                    required: "Please enter duration!",
                    number: "Please enter valid duration!",
                    min: "Please enter valid duration!"
                },
                'image': {
                    required: "Please choose an image",
                },
                'bulk_file': {
                    required: "Please upload questions!",
                },
            },
            submitHandler: function(form) {
                if (confirm("Do you want to submit the form?")) {
                    document.getElementById("test_submit").addEventListener("submit", function(event) {
                        var submitButton = document.getElementById("submit");
                        submitButton.disabled = true;
                        submitButton.innerHTML = "Submitting...";
                    });
                    form.submit();
                }
            }
        });
        
        $("#test_submit_passage").validate({
            ignore: [],
            rules: {
                title: {
                    required: function () {
                        return $("#question_type").val() === "2";
                    }
                },
                description: {
                    required: function () {
                        return $("#question_type").val() === "2";
                    }
                },
                question_type: "required",
                question_0: "required",
                option_1_0: "required",
                option_2_0: "required",
                option_3_0: "required",
                option_4_0: "required",
                correct_option_0: "required",
                positive_marks_0: "required",
                negative_marks_0: "required",
                solution_0: "required",
            },
            messages: {
                title: "Please enter title!",
                description: "Please enter description!",
                question_type: "Please enter question type!",
                question_0: "Please enter question!",
                option_1_0: "Please enter option 1!",
                option_2_0: "Please enter option 2!",
                option_3_0: "Please enter option 3!",
                option_4_0: "Please enter option 4!",
                correct_option_0: "Please select correct option!",
                positive_marks_0: "Please enter positive marks!",
                negative_marks_0: "Please enter negative marks!",
                solution_0: "Please enter solution!",
            },
            submitHandler: function(form) {
                if (confirm("Do you want to submit the form?")) {
                    document.getElementById("test_submit").addEventListener("submit", function(event) {
                        var submitButton = document.getElementById("submit");
                        submitButton.disabled = true;
                        submitButton.innerHTML = "Submitting...";
                    });
                    form.submit();
                }
            }
        });

        CKEDITOR.config.height = 300;
        CKEDITOR.replace('description', {
            extraPlugins: 'filebrowser',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url() ?>Uploader/upload',
        });

        var oldExportAction = function(self, e, dt, button, config) {
            if (button[0].className.indexOf('buttons-excel') >= 0) {
                if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
                } else {
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                }
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
        };
        var newExportAction = function(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function(e, s, data) {
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function(e, settings) {
                    oldExportAction(self, e, dt, button, config);
                    dt.one('preXhr', function(e, s, data) {
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });
                    setTimeout(dt.ajax.reload, 0);
                    return false;
                });
            });
            dt.ajax.reload();
        };
        var table = $('#user_data').DataTable({
            "lengthChange": true,
            "lengthMenu": [10, 25, 50, 100, 200],
            'searching': true,
            "processing": true,
            "serverSide": true,
            "cache": false,
            "order": [],
            "columnDefs": [{
                "orderable": false,
                "targets": "_all"
            }],
            buttons: [{
                extend: "excelHtml5",
                messageBottom: '',
                filename: 'Customer-list',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    modifier: {
                        search: 'applied',
                        order: 'applied'
                    },
                },
            }],
            dom: "Blfrtip",
            "ajax": {
                "url": "<?= base_url(); ?>Ajax_controller/get_test_setup_ajx",
                "type": "POST",
                "data": function(d) {

                }
            },
            "complete": function() {
                $('[data-toggle="tooltip"]').tooltip();
            },
        });
    });
    
    
    var oldExportAction = function(self, e, dt, button, config) {
        if (button[0].className.indexOf('buttons-excel') >= 0) {
            if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
            } else {
                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            }
        } else if (button[0].className.indexOf('buttons-print') >= 0) {
            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
        }
    };
    var newExportAction = function(e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function(e, s, data) {
            data.start = 0;
            data.length = 2147483647;
            dt.one('preDraw', function(e, settings) {
                oldExportAction(self, e, dt, button, config);
                dt.one('preXhr', function(e, s, data) {
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
                setTimeout(dt.ajax.reload, 0);
                return false;
            });
        });
        dt.ajax.reload();
    };
    var table = $('#user_question_data').DataTable({
        "lengthChange": true,
        "lengthMenu": [10, 25, 50, 100, 200],
        'searching': true,
        "processing": true,
        "serverSide": true,
        "cache": false,
        "order": [],
        "columnDefs": [{
            "orderable": false,
            "targets": "_all"
        }],
        buttons: [{
            extend: "excelHtml5",
            messageBottom: '',
            filename: 'Customer-list',
            exportOptions: {
                columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                modifier: {
                    search: 'applied',
                    order: 'applied'
                },
            },
        }],
        dom: "Blfrtip",
        "ajax": {
            "url": "<?= base_url(); ?>Ajax_controller/get_test_all_questions_ajx",
            "type": "POST",
            "data": function(d) {
                d.test_id = '<?php if(isset($_GET['test_id'])) { echo $_GET['test_id']; } ?>';
            }
        },
        "complete": function() {
            $('[data-toggle="tooltip"]').tooltip();
        },
    });
</script>