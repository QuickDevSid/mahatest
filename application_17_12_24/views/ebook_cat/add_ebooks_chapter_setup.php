<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Ebook - Ebook Chapter Setup</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Chapter Setup</strong>
                        </h2>
                        <hr>

                        <form id="chapter_submit" name="chapter_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Ebook_Category/add_ebooks_chapter_setup" method="POST">
                            <input type="hidden" name="source_type" value="test_series">
                            <input type="text" id="id" name="id" style="display:none;" value="<?php if (!empty($single)) {
                                                                                                    echo $single->id;
                                                                                                } ?>">


                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <?php if (empty($single->id)) { ?>
                                            <div class="row">
                                                <button type="button" id="add_more" class="btn btn-success">ADD CHAPTER</button>
                                                <input type="hidden" name="validate" id="validate" value="1">
                                                <input type="hidden" name="ebook_id" id="ebook_id" value="<?= isset($ebook_id) ? htmlspecialchars($ebook_id) : '' ?>">
                                            </div>
                                        <?php } ?>
                                        <br>
                                        <div class="row" id="chapter_row">
                                            <div id="dynamic_field_container">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php
                                            if (!empty($single)) {
                                                $chapter_data = $this->EbookCategory_model->get_all_chapter_for_edit($single->id);
                                                // print_r($chapter_data);
                                                // exit;
                                            ?>
                                                <input type="hidden" name="ebook_id" id="ebook_id" value="<?= isset($ebook_id) ? htmlspecialchars($ebook_id) : '' ?>">
                                                <input type="hidden" name="validate" id="validate" value="1">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <b>Chapter Name*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="chapter_name" id="chapter_name"
                                                                    class="form-control text" placeholder="Enter Chapter Name" value="<?php if (!empty($single)) {
                                                                                                                                            echo $single->chapter_name;
                                                                                                                                        } ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Chapter Description*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="chapter_description" id="chapter_description"
                                                                    class="form-control text" placeholder="Enter Chapter Description" value="<?php if (!empty($single)) {
                                                                                                                                                    echo $single->chapter_description;
                                                                                                                                                } ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Chapter Solution*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="chapter_solution" id="chapter_solution"
                                                                    class="form-control text" placeholder="Enter Chapter Description" value="<?php if (!empty($single)) {
                                                                                                                                                    echo $single->chapter_solution;
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
                                                                <input type="hidden" name="current_image_update" value="<?= isset($single) && !empty($single->chapter_image) ? htmlspecialchars($single->chapter_image) : '' ?>">
                                                            </div>
                                                        </div>
                                                        <?php if (!empty($single) && !empty($single->chapter_image)): ?>
                                                            <img src="<?= base_url() ?>assets/ebook_images/<?= htmlspecialchars($single->chapter_image); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                        <?php endif; ?>
                                                        <div id="errorMessage" class="error" style="color: red;"></div>
                                                    </div>
                                                </div>

                                            <?php
                                            } ?>
                                        </div>
                                        <div class="row clearfix">
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
</section>