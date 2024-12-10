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
            <h2>DASHBOARD</h2>
        </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <div class="content">
                            <div class="text">Users</div>
                            <div id="Users" class="number count-to" data-from="0" data-to="241" data-speed="1000"
                                 data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-cyan hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">devices_other</i>
                            </div>
                            <div class="content">
                                <div class="text">Exams</div>
                                <div id="Exams" class="number count-to" data-from="0" data-to="4" data-speed="1000"
                                     data-fresh-interval="20"></div>
                            </div>
                        </div>
                    </div>
      
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">verified_user</i>
                        </div>
                        <div class="content">
                            <div class="text">Videos</div>
                            <div id="Videos" class="number count-to" data-from="0" data-to="243"
                                 data-speed="1000"
                                 data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">security</i>
                        </div>
                        <div class="content">
                            <div class="text">Jobs</div>
                            <div id="Jobs" class="number count-to" data-from="0" data-to="3" data-speed="1000"
                                 data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="header">
                        <h2>RECENT User's</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">

                            <table id="user_data"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable table-sm nowrap"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email Id</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Added On</th>
                                    <th>Selected Exams</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email Id</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Added On</th>
                                    <th>Selected Exams</th>
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

            <!-- Browser Usage -->
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>User'S by STATUS</h2>
                        </div>
                        <div class="body">
                            <div id="donut_chart" class="dashboard-donut-chart"></div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- #END# Browser Usage -->
        </div>
        
    </div>
</section>
