<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Ebook - Ebook Video Setup</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Video Setup</strong>
                        </h2>
                        <hr>

                        <form id="video_setup_submit" name="video_setup_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Ebook_Category/add_ebooks_video_setup" method="POST">
                            <input type="hidden" name="source_type" value="test_series">
                            <input type="text" id="id" name="id" style="display:none;" value="<?php if (!empty($single)) {
                                                                                                    echo $single->id;
                                                                                                } ?>">


                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <?php if (empty($single->id)) { ?>
                                            <div class="row">
                                                <button type="button" id="add_more" class="btn btn-success">ADD Video</button>
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
                                                        <b>Title*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="title" id="title"
                                                                    class="form-control text" placeholder="Enter Chapter Name" value="<?php if (!empty($single)) {
                                                                                                                                            echo $single->title;
                                                                                                                                        } ?>">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4" id="video-section">
                                                        <b>Video File</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">perm_media</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <?php if (isset($single) && !empty($single->file_name)): ?>
                                                                    <p>Current Video: <?= basename($single->file_name) ?></p>
                                                                    <input type="file" name="file_name" id="file_name" class="form-control text" accept="video/*">
                                                                    <input type="hidden" name="current_video_update" value="<?= isset($single) && !empty($single->file_name) ? htmlspecialchars($single->file_name) : '' ?>">
                                                                <?php else: ?>
                                                                    <input type="file" name="file_name" id="file_name" class="form-control text" accept="video/*">
                                                                    <input type="hidden" name="current_video_update" value="<?= isset($single) && !empty($single->file_name) ? htmlspecialchars($single->file_name) : '' ?>">
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
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