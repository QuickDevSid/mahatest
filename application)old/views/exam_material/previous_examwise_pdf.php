<?php
$count_of_material = 0;
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Test Series - Test Series PDF </h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="card">

                    <div class="header">

                        <h2>

                            Test Series PDF

                        </h2>

                    </div>

                    <div class="body">



                        <form id="test_submit" name="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Exam_material/previous_examwise_pdf" method="POST">

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
                                                    <!-- <input type="hidden" name="selected_plot_id[]" value="1"> -->
                                                        <b>Title*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="title[]" id="title_0" class="form-control text" placeholder="Enter Title" value="<?php if (!empty($single)) {
                                                                                                                                                                            echo $single->title;
                                                                                                                                                                        } ?>">
                                                                <b><span id="title_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Short Decription*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="description[]" id="description_0" class="form-control text" placeholder="Enter Description" value="<?php if (!empty($single)) {
                                                                                                                                                                                            echo $single->description;
                                                                                                                                                                                        } ?>">
                                                                <b><span id="description_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <b>PDF*</b>
                                                        <div class="uploadOuter form-group">
                                                            <span class="dragBox">
                                                                <i class="fa-solid fa-file-pdf" style="font-size: 30px; color: #d9534f;"></i>
                                                                <input type="file" name="pdf[]" id="pdf_0" class="form-control" accept="application/pdf">

                                                                <!-- <input style="height: 100px !important" type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf"> -->
                                                                <input type="hidden" name="current_pdf" value="<?= isset($single) && !empty($single->pdf_url) ? htmlspecialchars($single->pdf_url) : '' ?>">
                                                            </span><br>
                                                            <?php if (!empty($single) && !empty($single->pdf_url)) : ?>
                                                                <a href="<?= base_url() ?>assets/uploads/exam_material/pdf/<?= htmlspecialchars($single->pdf_url); ?>" target="_blank">
                                                                    <i class="fa-solid fa-file-pdf" style="font-size: 50px; color: #d9534f;"></i>
                                                                    View PDF
                                                                </a>
                                                            <?php endif; ?>
                                                            <div id="errorMessage" class="error" style="color: red;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Image*</b>
                                                        <div class="uploadOuter form-group">
                                                            <span class="dragBox">
                                                                <i class="fa-solid fa-images" style="font-size: 30px;"></i>
                                                                <input type="file" name="icon[]" id="icon_0" class="form-control" accept="image/*">
                                                                
                                                                <!-- <input style="height: 100px !important" type="file" name="icon" id="icon" class="form-control" accept="image/*"> -->
                                                                <input type="hidden" name="current_icon" value="<?= isset($single) && !empty($single->icon) ? htmlspecialchars($single->icon) : '' ?>">
                                                            </span><br>
                                                            <?php if (!empty($single) && !empty($single->icon)) : ?>
                                                                <img src="<?= base_url() ?>assets/uploads/exam_material/images/<?= htmlspecialchars($single->icon); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                            <?php endif; ?>
                                                            <div id="errorMessage" class="error" style="color: red;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?php
                                                        if (!empty($single)) {
                                                        } else {
                                                        ?>
                                                            <div class="row">
                                                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                                                    <br>
                                                                    <button id="add_more_button" name="add_more_button" value="1" class="btn btn-success">Add More</button>
                                                                </div>
                                                            </div>

                                                        <?php }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="matrial_master">

                                            </div>
                                            <div class="row" id="show_material_table" style="<?php if (!empty($single)) {
                                                                                                    echo "display:block;";
                                                                                                } else {
                                                                                                    echo "display:none;";
                                                                                                } ?>">
                                                                                                <div class="row" id="matrial_master">

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