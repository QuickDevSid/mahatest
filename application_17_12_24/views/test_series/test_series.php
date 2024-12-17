<section class="content">
<div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Test Series - Manage Series  </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Manage Series
                          <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                     data-target="#add">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Series</span>
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
                                    <th>Sub Title</th>
                                    <th>Sale Price</th>
                                    <th>MRP</th>
                                    <th>Discount</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Sub Title</th>
                                    <th>Sale Price</th>
                                    <th>MRP</th>
                                    <th>Discount</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    
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
    <div class="modal-dialog modal-lg" role="document">
        <form id="submit" enctype="multipart/form-data" action="<?php echo base_url() ?>TestSeries/add_series_data" method="POST">
            <input type="hidden" name="source_type" value="doc_video">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Document </h4>
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
                                                <b>Sub Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="sub_title" id="sub_title"
                                                               class="form-control text" placeholder="Sub Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>MRP</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="mrp" id="mrp"
                                                               class="form-control text" placeholder="MRP" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Sale Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="sale_price" id="sale_price"
                                                               class="form-control text" placeholder="Sale Price" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Discount</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="discount" id="discount"
                                                               class="form-control text" placeholder="Discount" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="image" id="Doc_Videos"
                                                               class="form-control text" required accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="description" placeholder="Description" rows="5" cols="5" ></textarea>

                                            </div>
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
<div class="modal fade" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="submit_examsection" enctype="multipart/form-data" action="<?php echo base_url() ?>TestSeries/update_series_data" method="POST">
            <input type="hidden" name="source_type" value="doc_video">
            <input type="hidden" name="id" id="edit_id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Document </h4>
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
                                                <b>Sub Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="sub_title" id="edit_sub_title"
                                                               class="form-control text" placeholder="Sub Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>MRP</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="mrp" id="edit_mrp"
                                                               class="form-control text" placeholder="MRP" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Sale Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="sale_price" id="edit_sale_price"
                                                               class="form-control text" placeholder="Sale Price" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Discount</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="discount" id="edit_discount"
                                                               class="form-control text" placeholder="Discount" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" id="edit_status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="image" id="Doc_Videos"
                                                               class="form-control text" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="edit_description" placeholder="Description" rows="5" cols="5" ></textarea>

                                            </div>
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
    <div class="modal-dialog modal-lg" role="document">
        <form >
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
                                                <b>Sub Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="sub_title" id="s_sub_title"
                                                               class="form-control text" placeholder="Sub Title" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>MRP</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="mrp" id="s_mrp"
                                                               class="form-control text" placeholder="MRP" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Sale Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="sale_price" id="s_sale_price"
                                                               class="form-control text" placeholder="Sale Price" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Discount</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="discount" id="s_discount"
                                                               class="form-control text" placeholder="Discount" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" id="s_status" disabled>
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <img src="" alt="" id="s_img" class="img-fluid rounded"  style="width: 50%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="s_description" placeholder="Description" rows="5" cols="5"  disabled></textarea>

                                            </div>
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
    let id = 'manage_series';
    let url = "<?php echo base_url() ?>get_series";
</script>