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

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> App Users</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                        App User Device Details
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="user_device_data"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
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
                                <tfoot>
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
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->

        </div>
    </div>
</section>
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
