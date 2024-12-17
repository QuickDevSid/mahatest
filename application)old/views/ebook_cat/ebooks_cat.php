<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Ebook - Ebook Category</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Ebook Category
                            <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                data-target="#add">
                                <i class="material-icons">person_add</i>
                                <span>Add Ebook Category</span>
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
                                        <!-- <th>Can Download</th> -->
                                        <th>Image</th>
                                        <!-- <th>PDF</th> -->
                                        <!-- <th>View Count</th> -->
                                        <!-- <th>Status</th> -->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th width="10%">Action</th>
                                        <th>Title</th>
                                        <!-- <th>Can Download</th> -->
                                        <th>Image</th>
                                        <!-- <th>PDF</th> -->
                                        <!-- <th>View Count</th> -->
                                        <!-- <th>Status</th> -->

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


<div class="modal fade" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="ebooks_cat">
        <form id="submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Ebook_Category/add_ebooks_cat_data" method="POST">
            <input type="hidden" name="source_type" value="ebooks_cat">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Ebook Category </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="title" id="title"
                                                            class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="image" id="Ebook_Category"
                                                            class="form-control text" required accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="ebooks_status" id="ebooks_status">
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>
                                                </select>

                                            </div> -->
                                            <!-- <div class="col-md-4">
                                                <p>
                                                    <b>Can Download</b>
                                                </p>
                                                <select class="form-control show-tick" name="can_download">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>

                                            </div> -->
                                        </div>
                                        <div class="row">

                                            <!-- <div class="col-md-4">
                                                <b>PDF</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="pdf" id="pdf"
                                                            class="form-control text" required accept="application/pdf">
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="description" placeholder="Description" rows="5" cols="5"></textarea>

                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                        data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="ebooks_cat">
        <form id="submit_examsection" enctype="multipart/form-data" action="<?php echo base_url() ?>Ebook_Category/update_ebooks_cat_data" method="POST">
            <input type="hidden" name="source_type" value="ebooks_cat">
            <input type="hidden" name="id" id="edit_id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Ebook Category </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="title" id="edit_title"
                                                            class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="image" id="image"
                                                            class="form-control text" accept="image/*" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" id="edit_status">
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div> -->
                                            <!-- <div class="col-md-4">
                                                <p>
                                                    <b>Can Download</b>
                                                </p>
                                                <select class="form-control show-tick" name="can_download" id="edit_can_download">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>

                                            </div> -->
                                        </div>
                                        <div class="row">

                                            <!-- <div class="col-md-4">
                                                <b>PDF</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="pdf" id="pdf"
                                                            class="form-control text" accept="application/pdf">
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                        data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="show" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="ebooks_cat">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">View Document </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="title" id="s_title"
                                                            class="form-control text" placeholder="Title" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Image :</b>
                                                <div class="input-group">
                                                    <div class="col-md-6 offset-3">
                                                        <img class="img-fluid rounded" style="width: 100%;" id="s_img" src="">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-4">
                                                <p>
                                                    <b>Can Download</b>
                                                </p>
                                                <select class="form-control show-tick" name="can_download" id="s_can_download" disabled>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>

                                            </div> -->
                                        </div>
                                        <div class="row">
                                            <!-- <div class="col-md-4">
                                                <b>PDF: <a href="#" target="_blank" id="s_pdf"><i class="material-icons">download</i> Download PDF</a></b>
                                            </div> -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect"
                        data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let type = 'Docs';
    let id = 'docs';
</script>