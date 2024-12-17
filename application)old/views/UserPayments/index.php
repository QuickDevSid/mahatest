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
            <h2>DASHBOARD -> MANAGE User Payments</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                          Manage User Payments
                            <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                    data-target="#add">
                                <i class="material-icons">person_add</i>
                                <span>Add User Payment</span>
                            </button>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="user_data"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Selected Exam</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Test Title</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Selected Exam</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Test Title</th>
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
