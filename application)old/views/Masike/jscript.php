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

        $('#Masike').addClass('active');
        $('#Masike .menu-toggle').addClass('toggled');
        $('#Masike .ml-menu').css('display','block');

        $('#Masike_masike').addClass('active');
        
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


        CKEDITOR.replace('Description',{
          extraPlugins: 'ckeditor_wiris,filebrowser',
          extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
          filebrowserUploadMethod: "form",
          filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        CKEDITOR.replace('edit_Description',{
          extraPlugins: 'ckeditor_wiris,filebrowser',
          extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
          filebrowserUploadMethod: "form",
          filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        // CKEDITOR.replace('edit_Description');
        CKEDITOR.config.height = 300;

        getData();
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
        var ur = "<?php echo base_url() ?>Masike/fetch_masike";
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
    function getcategoryDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');
        // alert(lid);
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Masike/CategoryById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                if(result["masike_category_id"])
                {
                    $('#edit_id').val(result["masike_category_id"]);
                    $('#CategoryTitle').val(result["category_name"]);
                    $('#Exam_Id').selectpicker('val', result["selected_exams_id"]);
                    $('#category_status').selectpicker('val', result["status"]);
                }

            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }

    function getmasikeDetailsEdit(getID)
    {
        var lid = getID.replace('edit_', '');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Masike/MasikeById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                if(result["id"])
                {
                    $('#edit_id').val(result["id"]);
                    $('#edit_MasikeTitle').val(result["title"]);

                    var eid = result["selected_exams_id"];
                    var res = eid.substring(2, 3);
                   
                    $('#edit_examid').selectpicker('val', res);

                    $('#edit_MasikeCategoryId').selectpicker('val', result["category"]);
                    $('#edit_masike_status').selectpicker('val', result["status"]);
                   

                    CKEDITOR.instances['edit_Description'].setData(result["description"]);
                    
                    get_select_value_edit(res,result["category"]);
                    $('#edit_MasikeCategoryId').selectpicker('val', result["category"]);
                }

            },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }

    //code for delete user
    function deleteDetails(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Category will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deleteCategoryDetailsPerform(lid);
        });
    }

    function deleteCategoryDetailsPerform(getID) {
        var lid = getID.replace('delete_', '');
        showConfirmMessage(lid);
    }

    function showConfirmMessage(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            // myFunctionEr();
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>Masike/deleteMasike",
                data: "id=" + lid,
                success: function (data) {
//                    $('#success_message').html(data);
                    console.log("data "+data);
                    // myFunctionSuc();
                    var str=$.trim(data);
                    if (str == "success") {
                        // alert();
                       swal("Deleted!", "Your User details has been deleted.", "success");
                        getData();

                    } else {
                        alert('error');
                        $("#error_message").html(data);
                        // myFunctionEr();
                    }
                }
            });
        }
    }


</script>
