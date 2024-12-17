<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Coupon - Add Coupon</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Coupon Setup</strong>
                        </h2>
                        <hr>
                        <form id="test_submit" name="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Mahatest_Coupon/add_coupon_data" method="POST">
                            <input type="hidden" name="source_type" value="test_series">
                            <input type="text" id="id" name="id" style="display:none;" value="<?php if (!empty($single)) {
                                                                                                    echo $single->id;
                                                                                                } ?>">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <b>Coupon Name*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">title</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="name" id="name"
                                                                class="form-control text" placeholder="Enter Coupon Name" value="<?php if (!empty($single)) {
                                                                                                                                        echo $single->name;
                                                                                                                                    } ?>" required>
                                                            <b><span id="name_error" style="color:red; display:none;"></span></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Coupon Code*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">title</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="code" id="code"
                                                                class="form-control text" placeholder="Enter Coupon Code" value="<?php if (!empty($single)) {
                                                                                                                                        echo $single->code;
                                                                                                                                    } ?>" required>
                                                            <b><span id="code_error" style="color:red; display:none;"></span></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Discount Type*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">description</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <select name="discount_type" id="discount_type" class="form-control" required>
                                                                <option value="">Select Discount Type</option>
                                                                <option value="0" <?php if (!empty($single) && $single->discount_type == '0') echo 'selected'; ?>>%</option>
                                                                <option value="1" <?php if (!empty($single) && $single->discount_type == '1') echo 'selected'; ?>>Flat</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <b>Discount Amount*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">title</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="discount" id="discount"
                                                                class="form-control text" placeholder="Enter Discount Amount" value="<?php if (!empty($single)) {
                                                                                                                                            echo $single->discount;
                                                                                                                                        } ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Coupon Type*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">description</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <select name="type" id="type" class="form-control" required>
                                                                <option value="">Select Coupon Type</option>
                                                                <option value="0" <?php if (!empty($single) && $single->type == '0') echo 'selected'; ?>>Membership</option>
                                                                <option value="1" <?php if (!empty($single) && $single->type == '1') echo 'selected'; ?>>Testseries</option>
                                                                <option value="2" <?php if (!empty($single) && $single->type == '2') echo 'selected'; ?>>Courses</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Coupon Description*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">title</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="description" id="description"
                                                                class="form-control text" placeholder="Enter Coupon Name" value="<?php if (!empty($single)) {
                                                                                                                                        echo $single->description;
                                                                                                                                    } ?>" required>
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
        </div>
    </div>
</section>

<!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->

<script>
    $(document).ready(function() {
        $("#test_submit").validate({
            ignore: '',
            rules: {
                'title': {
                    required: true,
                }
            },
            messages: {
                'title': {
                    required: "Please enter title",
                }
            },
            submitHandler: function(form) {
                console.log("Form is valid and being submitted.");
                form.submit();
            }
        });
    });
</script>