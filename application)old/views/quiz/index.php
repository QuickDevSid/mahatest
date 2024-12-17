<section class="content">
<div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Quizs  </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                         Membership Plans
                          <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                     data-target="#add">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Quiz</span>
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
                                    <th>Section</th>
                                    <th>No Of Question</th>
                                    <th>Makers Per Question</th>
                                    <th>Time</th>
                                    <th>Attempt Count</th>
                                    <th>Status</th>
                                    
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Section</th>
                                    <th>No Of Question</th>
                                    <th>Makers Per Question</th>
                                    <th>Time</th>
                                    <th>Attempt Count</th>
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
        <form id="submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Quiz/add_data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Section </h4>
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
                                                <b>Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="price" id="price"
                                                               class="form-control text" placeholder="Price" required>
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
                                                        <input type="number" name="actual_price" id="actual_price"
                                                               class="form-control text" placeholder="Price" required>
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
                                                        <input type="number" name="discount_per" id="discount_per"
                                                               class="form-control text" placeholder="Discount Percentage" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
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
        <form id="submit_examsection" enctype="multipart/form-data" method="POST" action="<?= base_url('Membership_Plans/update_member_data');?>">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Section </h4>
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
                                                <b>Price</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">sell</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="price" id="edit_price"
                                                               class="form-control text" placeholder="Price" required>
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
                                                        <input type="number" name="actual_price" id="edit_actual_price"
                                                               class="form-control text" placeholder="Price" required>
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
                                                        <input type="number" name="discount_per" id="edit_discount_per"
                                                               class="form-control text" placeholder="Discount Percentage" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
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
                                            <div class="col-md-6">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="Title" id="s_Title"
                                                               class="form-control text" placeholder="Title" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Background-Color</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="background_color" id="s_background_color"
                                                               class="form-control text" placeholder="Title" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b>Created On</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="created_at" id="s_created_at"
                                                               class="form-control text" placeholder="Created At" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <img class="img-fluid rounded" style="width: 100%;" id="s_img" src="">
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

