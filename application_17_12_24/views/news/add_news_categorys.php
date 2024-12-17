<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> News - Add News Category </h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            News Category
                        </h2>
                    </div>
                    <div class="body">
                        <form id="test_submit" name="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>News/add_news_categorys" method="POST">
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
                                                        <b>News Category*</b>
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
                                                        <b>Icon Image*</b>
                                                        <div class="uploadOuter form-group">
                                                            <span class="dragBox">
                                                                <i class="fa-solid fa-images" style="font-size: 30px;"></i>
                                                                <input style="height: 100px !important" type="file" name="image" id="image" class="form-control" accept="image/*">
                                                                <input type="hidden" name="current_image" value="<?= isset($single) && !empty($single->icon_img) ? htmlspecialchars($single->icon_img) : '' ?>">
                                                            </span><br>
                                                            <?php if (!empty($single) && !empty($single->icon_img)): ?>
                                                                <img src="<?= base_url() ?>assets/uploads/news/images/<?= htmlspecialchars($single->icon_img); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                            <?php endif; ?>
                                                            <div id="errorMessage" class="error" style="color: red;"></div>
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