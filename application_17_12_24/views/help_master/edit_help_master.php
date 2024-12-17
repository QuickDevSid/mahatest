<!-- Modal for Adding Help Entry -->
<div class="modal fade" id="add_help_entry" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_help_form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/Admin_controller/update_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Help Entry</h4>
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
                                                    <select class="form-control" name="type" required>
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
                                                    <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
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
                                                    <select class="form-control" name="status" required>
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
                    <button type="submit" class="btn btn-link waves-effect">SAVE DETAILS</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </form>
    </div>
</div>