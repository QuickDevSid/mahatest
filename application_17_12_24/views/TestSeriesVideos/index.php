
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
            <h2>DASHBOARD -> Test Series Videos  </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Test Series Videos
                          <button type="button" class="btn bg-teal waves-effect pull-right m-l-5" data-toggle="modal"
                                     data-target="#add_youtube">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Youtube Videos</span>
                             </button>
                            <button type="button" class="btn bg-teal waves-effect pull-right m-l-5" data-toggle="modal"
                                    data-target="#add_vimeo">
                                <i class="material-icons">person_add</i>
                                <span>Add Vimeo Videos</span>
                            </button>

                            <button type="button" class="btn bg-teal waves-effect pull-right m-l-5" data-toggle="modal"
                                    data-target="#add_upload">
                                <i class="material-icons">person_add</i>
                                <span>Upload Videos</span>
                            </button>
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="user_data"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Test Series</th>
                                    <th>Link</th>
                                    <th>Duration</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Added On</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Test Series</th>
                                    <th>Link</th>
                                    <th>Duration</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Added On</th>
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