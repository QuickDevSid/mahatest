<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Membership Plans - Add Membership Plans</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Membership Plans
                        </h2>
                    </div>
                    <div class="body">
                        <form id="test_submit" name="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Membership_Plans/add_membership_plans" method="POST">
                            <input type="hidden" name="source_type" value="test_series">
                            <input type="text" id="id" name="id" style="display:none;" value="<?php if (!empty($single)) {
                                                                                                    echo $single->id;
                                                                                                } ?>">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <b>Title*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="title" id="title"
                                                                    class="form-control text" placeholder="Enter Title" value="<?php if (!empty($single)) {
                                                                                                                                    echo $single->title;
                                                                                                                                } ?>">
                                                                <b><span id="title_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <b>Sub Title*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="subtitle" id="subtitle" class="form-control text" placeholder="Enter Sub Title" value="<?php if (!empty($single)) {
                                                                                                                                                                                    echo $single->sub_heading;
                                                                                                                                                                                } ?>">
                                                                <b><span id="subtitle_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>No. of Months*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="validity" id="validity" class="form-control text" placeholder="Enter No. of Months" value="<?php if (!empty($single)) {
                                                                                                                                                                                        echo $single->no_of_months;
                                                                                                                                                                                    } ?>">
                                                                <b><span id="validity_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <b>Actual Price*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">monetization_on</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="mrp" id="mrp" class="form-control text" placeholder="Enter MRP"
                                                                    value="<?php if (!empty($single)) {
                                                                                echo $single->actual_price;
                                                                            } ?>">
                                                                <b><span id="mrp_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Discount Percentage*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">percent</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="discount" id="discount" class="form-control text" placeholder="Enter Discount"
                                                                    value="<?php if (!empty($single)) {
                                                                                echo $single->discount_per;
                                                                            } ?>">
                                                                <b><span id="discount_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Selling Price*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">attach_money</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="sale_price" id="sale_price" class="form-control text" placeholder="Sale Price"
                                                                    value="<?php if (!empty($single)) {
                                                                                echo $single->price;
                                                                            } ?>" readonly>
                                                                <b><span id="sale_price_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <b>Status*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">check_circle</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <select name="record_status" id="record_status" class="form-control">
                                                                    <option value="Active" <?php if (!empty($single) && $single->status == "Active") echo "selected"; ?>>Active</option>
                                                                    <option value="Inactive" <?php if (!empty($single) && $single->status == "Inactive") echo "selected"; ?>>Inactive</option>
                                                                </select>
                                                                <b><span id="record_status_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <b>Description*</b>
                                                        <div class="input-group">
                                                            <div class="form-line">
                                                                <textarea name="description" id="description" class="form-control text" placeholder="Enter Description" rows="5" cols="5"><?php if (!empty($single)) {
                                                                                                                                                                                                echo $single->description;
                                                                                                                                                                                            } ?></textarea>
                                                            </div>
                                                            <b><span id="description_error" style="color:red; display:none;"></span></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <button type="submit" name="submit" value="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->

        </div>
    </div>
</section>

<script>
    let type = 'Docs';
    let id = 'manage_courses';
    let url = "<?php echo base_url() ?>get_courses";
</script>