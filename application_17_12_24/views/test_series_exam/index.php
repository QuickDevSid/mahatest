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
            <h2>DASHBOARD -> MANAGE Test Series Exams</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                          Manage Test Series Exam And Add Question
                          <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                     data-target="#addquiz">
                                 <i class="material-icons">person_add</i>
                                 <span>ADD Test Series Exams</span>
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
                                    <th>Title</th>
                                    <th>Test Series</th>
                                    <th>Quiz Question</th>
                                    <th>Quiz Duration</th>
                                    <th>Status</th>
                                    <th>Added On</th>

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>Title</th>
                                    <th>Test Series</th>
                                    <th>Quiz Question</th>
                                    <th>Quiz Duration</th>
                                    <th>Status</th>
                                    <th>Added On</th>
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
