<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Membership Plans  </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                         Membership Plans

                          <button type="button" class="btn bg-teal waves-effect pull-right" style="margin-right: 10px;" data-toggle="modal"
                                     data-target="#add">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Membership Plan</span>
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
                                    <th>Sub Heading</th>
                                    <th>Selling Price</th>
                                    <th>Actual Price</th>
                                    <th>Discount Percentage</th>
                                    <th>No. Of Months</th>
                                    <th>Usage Count</th>
                                    <th>Status</th>
                                    
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Sub Heading</th>
                                    <th>Selling Price</th>
                                    <th>Actual Price</th>
                                    <th>Discount Percentage</th>
                                    <th>No. Of Months</th>
                                    <th>Usage Count</th>
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
        <form id="submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Membership_Plans/add_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Plan </h4>
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
                                                        <input type="text" name="sub_heading" id="sub_heading"
                                                               class="form-control text" placeholder="Sub Title" required>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <b>No. Of Months</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="no_of_months" id="no_of_months"
                                                               class="form-control text" placeholder="No. Of Months" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <b>Actual Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="price" id="price"
                                                               class="form-control text" placeholder="Actual Price" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <b>Discount Percentage</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="discount_per" id="discount_per" max="100" vall
                                                               class="form-control text" placeholder="Discount Percentage" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <b>Selling Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="actual_price" id="actual_price"
                                                               class="form-control text" placeholder="Selling Price" required disabled>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-3">
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
        <form id="submit_examsection" enctype="multipart/form-data" method="POST" action="<?= base_url('Membership_Plans/update_member_data');?>">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Update Plan </h4>
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
                                                        <input type="text" name="sub_heading" id="edit_sub_heading"
                                                               class="form-control text" placeholder="Sub Title" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>No. Of Months</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="no_of_months" id="edit_no_of_months"
                                                               class="form-control text" placeholder="No. Of Months" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <b>Actual Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="price" id="edit_price"
                                                               class="form-control text" placeholder="Actual Price" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <b>Discount Percentage</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="discount_per" id="edit_discount_per" max="100"
                                                               class="form-control text" placeholder="Discount Percentage" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <b>Selling Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="actual_price" id="edit_actual_price"
                                                               class="form-control text" placeholder="Selling Price" required disabled>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="col-md-3">
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
                    <h4 class="modal-title" id="defaultModalLabel">View Membership Plans </h4>
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
                                                        <input type="text" name="sub_heading" id="s_sub_heading"
                                                               class="form-control text" placeholder="Sub Title" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>No. Of Months</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="no_of_months" id="s_no_of_months"
                                                               class="form-control text" placeholder="No. Of Months" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <b>Actual Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="price" id="s_price"
                                                               class="form-control text" placeholder="Actual Price" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <b>Discount Percentage</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="discount_per" id="s_discount_per" max="100"
                                                               class="form-control text" placeholder="Discount Percentage" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <b>Selling Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="actual_price" id="s_actual_price"
                                                               class="form-control text" placeholder="Selling Price" disabled>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="col-md-2">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" id="s_status" disabled>
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>

                                            <div class="col-md-2">
                                                <b>Usage Count</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="usage_count" id="s_usage_count"
                                                               class="form-control text" placeholder="Usage Count" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="s_description" placeholder="Description" rows="5" cols="5" disabled></textarea>

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

