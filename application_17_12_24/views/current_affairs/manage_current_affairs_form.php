<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Current Affairs - Manage Current Affair </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Manage Current Affair
                        </h2>
                    </div>
                    <div class="body">

                        <form id="currentaffairsubmit" name="currentaffairsubmit" enctype="multipart/form-data" action="<?php echo base_url() ?>CurrentAffairs/manage_current_affairs_form" method="POST">
                            <input type="hidden" name="source_type" value="current_affairs">
                            <input type="text" id="id" name="id" style="display:none;" value="<?php if (!empty($single)) {
                                                                                                    echo $single->current_affair_id;
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
                                                                                                                                    echo $single->current_affair_title;
                                                                                                                                } ?>">
                                                                <b><span id="title_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-4">
                                                        <b>Title*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="title" id="title" class="form-control text" placeholder="Enter Title" value="<?php if (!empty($single)) {
                                                                                                                                                                            echo $single->current_affair_title;
                                                                                                                                                                        } ?>">
                                                                <b><span id="title_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div> -->

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
                                                        <b>Category*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">category</i>
                                                            </span>

                                                            <div class="form-line">



                                                                <select name="category" id="category" class="form-control">

                                                                    <option value="" disabled selected>Select Current Affairs</option>

                                                                    <?php

                                                                    $category_data = $this->CurrentAffairs_model->get_select_category();

                                                                    $selected_category = !empty($single) ? $single->category : '';

                                                                    if (!empty($category_data)) {

                                                                        foreach ($category_data as $categorys) { ?>

                                                                            <option value="<?= $categorys->id ?>" <?= ($categorys->id == $selected_category) ? 'selected' : '' ?>>

                                                                                <?= $categorys->category_name ?>

                                                                            </option>

                                                                    <?php }
                                                                    } ?>

                                                                </select>

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
                                                                <select name="status" id="status" class="form-control">
                                                                    <option value="Active" <?php if (!empty($single) && $single->status == 'Active') echo 'selected'; ?>>Active</option>
                                                                    <option value="Inactive" <?php if (!empty($single) && $single->status == 'Inactive') echo 'selected'; ?>>Inactive</option>
                                                                </select>
                                                                <b><span id="status_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Image*</b>
                                                        <div class="uploadOuter form-group">
                                                            <span class="dragBox">
                                                                <i class="fa-solid fa-images" style="font-size: 30px;"></i>

                                                                <input style="height: 100px !important" type="file" name="image" id="image" class="form-control" accept="image/*">
                                                                <input type="hidden" name="current_image" value="<?= isset($single) && !empty($single->current_affair_image) ? htmlspecialchars($single->current_affair_image) : '' ?>">
                                                            </span><br>
                                                            <?php if (!empty($single) && !empty($single->current_affair_image)) : ?>
                                                                <img src="<?= base_url() ?>assets/uploads/current_affairs/images/<?= htmlspecialchars($single->current_affair_image); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                            <?php endif; ?>
                                                            <div id="errorMessage" class="error" style="color: red;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Date*</b>
                                                        <div class="uploadOuter form-group">
                                                            <span class="dragBox">
                                                                <input type="date" name="date" id="date" class="form-control" value="<?php if (!empty($single)) {
                                                                                                                                            echo $single->date;
                                                                                                                                        } ?>" required />
                                                            </span>
                                                            <br>
                                                            <div id="errorMessage" class="error" style="color: red;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <b>Description*</b>
                                                        <div class="input-group">
                                                            <div class="form-line">
                                                                <textarea name="description" id="description" class="form-control text" placeholder="Enter Description" rows="5" cols="5"><?php if (!empty($single)) {
                                                                                                                                                                                                echo $single->current_affair_description;
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