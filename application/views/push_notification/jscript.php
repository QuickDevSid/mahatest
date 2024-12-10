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
        $('#Push_notification').addClass('active');
        $('#Push_notification .menu-toggle').addClass('toggled');
        $('#Push_notification .ml-menu').css('display','block');
        
        // $('#Pariksha_paddhati_abhyaskram').addClass('active');
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



</script>