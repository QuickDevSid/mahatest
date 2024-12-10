<?php include('templates/header.php'); ?>
<style type="text/css">
    .type-title {
        margin-left: 20px;
        color: red;
    }

    .section-title {
        color: black;
        font-weight: bold;
    }

    .error {
        font-weight: bold;
    }

    .chosen-container a {
        background-color: white !important;
        height: 34px !important;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    App Users
                </h3>
            </div>
            <div class="tab-content">
        </div>
        <div class="clearfix"></div> 
            <div class="x_panel">
                <div class="x_content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-5 col-xs-12">
                                <table class="table table-striped responsive-utilities jambo_table"style="width: 100%;" id="example">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Login Status</th>
                                            <th>Last Login On</th>
                                            <th>Username</th>
                                            <th>User Details</th>
                                            <th>Device ID</th>
                                            <th>Device Details</th>
                                            <th>Permission Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
				        </div> 
			        </div>
		        </div>
	        </div>
        </div>
<div class="modal fade" id="CustomerAddPaymentsModal" tabindex="-1" aria-labelledby="CustomerAddPaymentsModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.62);">
    <div class="modal-dialog" style="margin-top:150px;width:800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CustomerAddPaymentsModalLabel">Login Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="float:none !important; position:absolute;right:10px;top:10px;"  onclick="closePopup('CustomerAddPaymentsModal')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="details_response"></div>
        </div>
    </div>
</div>
<?php include('templates / footer.php');?>
<script>
    $(document).ready(function() { 
        var oldExportAction = function (self, e, dt, button, config) {
            if (button[0].className.indexOf('buttons-excel') >= 0) {
                if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
                }
                else {
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                }
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
        };
        var newExportAction = function (e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function (e, s, data) {
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function (e, settings) {
                    oldExportAction(self, e, dt, button, config);
                    dt.one('preXhr', function (e, s, data) {
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });
                    setTimeout(dt.ajax.reload, 0);
                    return false;
                });
            });
            dt.ajax.reload();
        };
        var table = $('#example').DataTable({
            "lengthChange": true, 
            "lengthMenu": [10, 25, 50, 100, 200],
            'searching': true,
            "processing": true,
            "serverSide": true,
            "cache": false,
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": "_all" }
            ],
            buttons:[
                {
                    extend: "excelHtml5",
                    messageBottom: '',
                    filename: 'Customer-list',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7],
                        modifier: {
                            search: 'applied',
                            order: 'applied'
                        },
                    },
                }
            ],
            dom: "Blfrtip",
            "ajax":{
                "url" : "<?=base_url();?>admin/Ajax_controller/get_app_users_ajx",
                "type": "POST",
                "data": function (d) {

                }				
            },
            "complete": function() {
                $('[data-toggle="tooltip"]').tooltip();			
            }, 
        });
        $('.navbar-nav.ml-auto .dropdown-menu').dropdown({
            container: '.navbar-nav.ml-auto'
        });
    });  
    function showDevicePopup(id){
        var exampleModal = $('#'+id);
        exampleModal.css('display','block');
        exampleModal.css('opacity','1');
        $('.modal-open').css('overflow','auto').css('padding-right','0px'); 
    }
    function closeDevicePopup(id){
        var exampleModal = $('#'+id);
        exampleModal.css('display','none');
        exampleModal.css('opacity','0');
        $('.modal-open').css('overflow','auto').css('padding-right','0px');
    }    
    function showLocationPopup(id){
        var exampleModal = $('#'+id);
        exampleModal.css('display','block');
        exampleModal.css('opacity','1');
        $('.modal-open').css('overflow','auto').css('padding-right','0px'); 
    }
    function closeLocationPopup(id){
        var exampleModal = $('#'+id);
        exampleModal.css('display','none');
        exampleModal.css('opacity','0');
        $('.modal-open').css('overflow','auto').css('padding-right','0px');
    } 
</script>