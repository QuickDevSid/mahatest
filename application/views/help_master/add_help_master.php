<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Manage Help Master</h2>
        </div>
        
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Manage Help Master
                            <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                    data-target="#add_help_entry">
                                <i class="material-icons">add_circle</i>
                                <span>ADD HELP ENTRY</span>
                            </button>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="help_data"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th width="20%">Type</th>
                                    <th width="40%">Title</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Created On</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Adding Help Entry -->
<div class="modal fade" id="add_help_entry" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_help_form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/Admin_controller/add_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Help Entry</h4>
                </div>
                <div class="modal-body">
                    <!-- Form Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-md-4">
                                            <b>Type</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">category</i>
                                                </span>
                                                <div class="form-line">
                                                    <select class="form-control" name="type" id="edit_type" required>
                                                        <option value="0">How to use </option>
                                                        <option value="1">Help</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <b>Title</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">title</i>
                                                </span>
                                                <div class="form-line">
                                                    <input type="text" id="edit_title" name="title" class="form-control" placeholder="Enter Title" required>
                                                    <input type="hidden" id="edit_id" name="edit_id" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                        <div class="col-md-12">
                                                <b>
                                                    Description</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="Description" id="Description" placeholder="Description" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-4">
                                            <b>Status</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">check_circle</i>
                                                </span>
                                                <div class="form-line">
                                                    <select class="form-control" name="status" id="edit_status" required>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Form Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </form>
    </div>
</div>
