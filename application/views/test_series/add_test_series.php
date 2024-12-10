<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Test Series - Manage Test Series </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Manage Test Series
                        </h2>
                    </div>
                    <div class="body">

                        <form id="test_submit" name="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>TestSeries/add_test_series" method="POST">
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
                                                                                                                                                                                    echo $single->sub_headings;
                                                                                                                                                                                } ?>">
                                                                <b><span id="subtitle_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <b>Mrp*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">monetization_on</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="mrp" id="mrp" class="form-control text" placeholder="Enter MRP"
                                                                    value="<?php if (!empty($single)) {
                                                                                echo $single->mrp;
                                                                            } ?>">
                                                                <b><span id="mrp_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <b>Discount*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">percent</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="discount" id="discount" class="form-control text" placeholder="Enter Discount"
                                                                    value="<?php if (!empty($single)) {
                                                                                echo $single->discount;
                                                                            } ?>">
                                                                <b><span id="discount_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <b>Sale Price*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">attach_money</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="sale_price" id="sale_price" class="form-control text" placeholder="Sale Price"
                                                                    value="<?php if (!empty($single)) {
                                                                                echo $single->sale_price;
                                                                            } ?>" readonly>
                                                                <b><span id="sale_price_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <b>Validity In Months*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="validity" id="validity" class="form-control text" placeholder="Enter Validity" value="<?php if (!empty($single)) {
                                                                                                                                                                                    echo $single->validity;
                                                                                                                                                                                } ?>">
                                                                <b><span id="validity_error" style="color:red; display:none;"></span></b>
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
                                                                    <option value="Active" <?php if (!empty($single) && $single->record_status == "Active") echo "selected"; ?>>Active</option>
                                                                    <option value="Inactive" <?php if (!empty($single) && $single->record_status == "Inactive") echo "selected"; ?>>Inactive</option>
                                                                </select>
                                                                <b><span id="record_status_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Sequence No*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="sequence_no" id="sequence_no" class="form-control text" placeholder="Enter Sequence no" value="<?php if (!empty($single)) {
                                                                                                                                                                                            echo $single->sequence_no;
                                                                                                                                                                                        } ?>">
                                                                <b><span id="sequence_no_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Tagline*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="tagline" id="tagline" class="form-control text" placeholder="Enter Tagline" value="<?php if (!empty($single)) {
                                                                                                                                                                                echo $single->tagline;
                                                                                                                                                                            } ?>">
                                                                <b><span id="tagline_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <b>Image*</b>
                                                        <div class="uploadOuter form-group">
                                                            <span class="dragBox">
                                                                <i class="fa-solid fa-images" style="font-size: 30px;"></i>

                                                                <input style="height: 100px !important" type="file" name="image" id="image" class="form-control" accept="image/*">
                                                                <input type="hidden" name="current_image" value="<?= isset($single) && !empty($single->banner_image) ? htmlspecialchars($single->banner_image) : '' ?>">
                                                            </span><br>
                                                            <?php if (!empty($single) && !empty($single->banner_image)): ?>
                                                                <img src="<?= base_url() ?>assets/uploads/test_series/images/<?= htmlspecialchars($single->banner_image); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                            <?php endif; ?>
                                                            <div id="errorMessage" class="error" style="color: red;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Inner Banner Image*</b>
                                                        <div class="uploadOuter form-group">
                                                            <span class="dragBox">
                                                                <i class="fa-solid fa-images" style="font-size: 30px;"></i>
                                                                <input style="height: 100px !important" type="file" name="inner_banner_image" id="inner_banner_image" class="form-control" accept="image/*">
                                                                <input type="hidden" name="current_inner_banner_image" value="<?= isset($single) && !empty($single->inner_banner_image) ? htmlspecialchars($single->inner_banner_image) : '' ?>">
                                                            </span><br>
                                                            <?php if (!empty($single) && !empty($single->inner_banner_image)): ?>
                                                                <img src="<?= base_url() ?>assets/uploads/courses/images/<?= htmlspecialchars($single->inner_banner_image); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                            <?php endif; ?>
                                                            <div id="errorMessage" class="error" style="color: red;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Prakaran Lecture*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="prakaran_lecture" id="prakaran_lecture" class="form-control text" placeholder="Enter Prakaran Lecture" value="<?php if (!empty($single)) {
                                                                                                                                                                                                            echo $single->prakaran_lecture;
                                                                                                                                                                                                        } ?>">
                                                                <b><span id="prakaran_lecture_error" style="color:red; display:none;"></span></b>
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