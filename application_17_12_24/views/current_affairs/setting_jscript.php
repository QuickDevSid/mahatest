<script type="text/javascript">
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function() {
        $('#current_affairs').addClass('active');
        $('#current_affairs .menu-toggle').addClass('toggled');
        $('#current_affairs .ml-menu').css('display', 'block');
        $('#current_affairs').addClass('active');
        getData();
    });

    $(document).ready(function() {
        /**
         * $type may be success, danger, warning, info
         */
        <?php
        if (isset($this->session->get_userdata()['alert_msg'])) {
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
        }, {
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
        var ur = "<?php echo base_url() ?>CurrentAffairs/fetch_setting";
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

    function getPostDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');
        // alert(lid);
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>CurrentAffairs/postById_setting/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function(result) {
                $('#edit_id').val(result[0]["id"]);
                $('#post_image_old').val(result[0]["icon_img"]);
                $('#edit_Title').val(result[0]["title"]);

                $("#e_img").attr("src", result[0]["icon_img"]);
                $("#edit_subtitle").val(result[0]["subtitle"]);
                $("#edit_subtitle1").val(result[0]["section_title_1"]);
                $("#edit_subtitle2").val(result[0]["section_title_2"]);
                $("#edit_subtitle3").val(result[0]["section_title_3"]);
                $("#edit_subtitle4").val(result[0]["section_title_4"]);
                $("#edit_subtitle5").val(result[0]["section_title_5"]);
                $("#edit_Section").val(result[0]["Section"]);
                $("#edit_description").val(result[0]["Description"]);

            },
            error: function() {
                alert('Some error occurred!');
            }
        });
    }
</script>