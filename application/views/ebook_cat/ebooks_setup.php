<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Ebook - Ebook Setup</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Ebook Setup</strong>
                        </h2>
                        <hr>
                        <form id="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Ebook_Category/add_ebook_setup_data" method="POST">
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
                                                    <b>Category</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">category</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <select name="category" id="category" class="form-control">
                                                                <option value="" disabled selected>Select Category</option>
                                                                <?php
                                                                $ebook_cat_data = $this->EbookCategory_model->get_select_ebooks_cat();
                                                                $selected_ebook_cat = !empty($single) ? $single->category_id : '';
                                                                if (!empty($ebook_cat_data)) {
                                                                    foreach ($ebook_cat_data as $ebook_cat) { ?>
                                                                        <option value="<?= $ebook_cat->id ?>" <?= ($ebook_cat->id == $selected_ebook_cat) ? 'selected' : '' ?>>
                                                                            <?= $ebook_cat->title ?>
                                                                        </option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                            <input type="hidden" value="0" name="indices[]">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="sub_category">Sub Category</label>
                                                    <select class="form-control" id="sub_category" name="sub_category" value="<?php if (!empty($single)) {
                                                                                                                                    echo $single->sub_category;
                                                                                                                                } ?>">
                                                        <option value="">Select Sub Category</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <b>Book Name*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">title</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="book_name" id="book_name"
                                                                class="form-control text" placeholder="Enter Book Name" value="<?php if (!empty($single)) {
                                                                                                                                    echo $single->book_name;
                                                                                                                                } ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <b>Image*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">image</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input style="height: 100px !important" type="file" name="image" id="image" class="form-control" accept="image/*">
                                                            <input type="hidden" name="current_image" value="<?= isset($single) && !empty($single->icon) ? htmlspecialchars($single->icon) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($single) && !empty($single->icon)): ?>
                                                        <img src="<?= base_url() ?>assets/ebook_images/<?= htmlspecialchars($single->icon); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                    <?php endif; ?>
                                                    <div id="errorMessage" class="error" style="color: red;"></div>
                                                </div>

                                                <div class="col-md-4">
                                                    <button type="button" id="add_more" class="btn btn-success">ADD CHAPTER</button>
                                                    <!-- <button type="button" id="add_more" class="btn btn-link waves-effect">ADD CHAPTER</button> -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="row">
                                                    <div id="dynamic_field_container">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button type="submit" name="submit" value="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS</button>
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
    </div>
</section>