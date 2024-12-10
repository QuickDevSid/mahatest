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
        $('#user_payment').addClass('active');



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

        CKEDITOR.replace('description',{
            extraPlugins: 'ckeditor_wiris,filebrowser',
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });

        // CKEDITOR.replace('edit_Description');
        CKEDITOR.config.height = 300;


        getData();
    });


    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>UserPayments/fetch_user";
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

    //end code here
    function getDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>UserPayments/feedbackById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                $("#d_user_title").html(result["full_name"]);
                $("#d_exam_group").html(result["selected_exams"]);
                $("#d_email").html("Email Id - " + result["email"]);
                $("#d_mobile_number").html("Mobile Number - " + result["mobile_number"]);
                $("#d_test_series").html("Test Series - " + result["test_series_title"]);
                
                    $("#d_purchased_item_id").html("Transaction Id - " + result["purchased_item_id"]);
                    $("#d_purchased_item_type").html("Type - " + result["purchased_item_type"]);
                    $("#d_payment_gateway").html("Gateway - " + result["payment_gateway"]);
                    $("#d_payment_gateway_date").html("Date - " + result["payment_gateway_date"]);
                    $("#d_payment_gateway_status").html("Status - " + result["payment_gateway_status"]);
                    $("#d_payment_gateway_method").html("Method - " + result["payment_gateway_method"]);
                    $("#d_payment_gateway_id").html("ID - " + result["payment_gateway_id"]);
                    $("#d_payment_gateway_amount").html("Amount - " + result["payment_gateway_amount"]);
                    $("#d_payment_gateway_currency").html("Currency - " + result["payment_gateway_currency"]);
                    $("#d_payment_gateway_charges").html("Charges - " + result["payment_gateway_charges"]);
                   $("#d_payment_gateway_order_id").html("Order Id - " + result["payment_gateway_order_id"]);
                    $("#d_payment_gateway_order_description").html("Description - " + result["payment_gateway_amount"]);
                
                $('#id').val(result["id"]);

            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    //code for delete user
    function showConfirmMessage(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Dought will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deleteFeedbackDetailsPerform(lid);
        });
    }

    function deleteDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteFeedbackDetailsPerform(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "DELETE",
                url: "<?php echo base_url() ?>UserPayments/deleteFeedback/" + lid,
                data: "id=" + lid,
                success: function (data) {
                    $('#success_message').html(data);
                    console.log(data);
                    myFunctionSuc();
                    if (data === "success") {
                        swal("Deleted!", "Feedback details has been deleted.", "success");
                        getData();
                    } else {
                        $("#error_message").html(data);
                        myFunctionEr();
                    }
                }
            });
        }
    }

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


</script>
