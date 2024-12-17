<?php $i = 0; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Exam Material - Add Subjectwise Pdf</h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Add Subjectwise Pdf</strong>
                        </h2>
                        <hr>
                        <form id="chapter_submit" name="chapter_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Exam_Material/add_subjectwise_pdf" method="POST">
                            <input type="hidden" name="source_type" value="test_series">
                            <input type="text" id="id" name="id" style="display:none;" value="<?php if (!empty($single)) {
                                                                                                    echo $single->id;
                                                                                                } ?>">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <?php if (empty($single->id)) { ?>

                                            <div class="demo-masked-input" style="padding:35px; border: 2px solid #ccc; border-radius: 5px; margin-bottom: 15px;" data-index="0">
                                                <div class="row">
                                                    <input type="hidden" value="0" name="indices[]">
                                                    <div class="col-md-4">
                                                        <b>Title</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">person</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="title_0" id="title_0" class="form-control text" placeholder="Title" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <b>Subject</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">check_circle</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <select name="subject_0" id="subject_0" class="form-control text" required>
                                                                    <option value="" disabled selected>-- Select Subject --</option>
                                                                    <?php
                                                                    // Fetch data from your model
                                                                    $subjects_types = $this->Exam_Material_model->get_select_subjects_list(); // Adjust model function name if needed
                                                                    $selected_subject = !empty($single) ? $single->subject_id : ''; // Pre-select value if editing
                                                                    if (!empty($subjects_types)) {
                                                                        foreach ($subjects_types as $subject) { ?>
                                                                            <option value="<?= $subject->id ?>" <?= ($subject->id == $selected_subject) ? 'selected' : '' ?>>
                                                                                <?= $subject->title ?>
                                                                            </option>
                                                                        <?php }
                                                                    } else { ?>
                                                                        <option value="">No Types Available</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <b>PDF File</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">picture_as_pdf</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input
                                                                    type="file"
                                                                    name="pdf_0"
                                                                    id="pdf_0"
                                                                    class="form-control text"
                                                                    required
                                                                    accept="application/pdf">
                                                                <input
                                                                    type="hidden"
                                                                    name="current_pdf_0"
                                                                    value="<?php echo isset($currentPdfPath) ? htmlspecialchars($currentPdfPath) : ''; ?>">
                                                            </div>
                                                        </div>
                                                        <?php if (isset($currentPdfPath) && $currentPdfPath != ''): ?>
                                                            <a href="<?php echo htmlspecialchars($currentPdfPath); ?>" target="_blank" style="color: blue;">View Current PDF</a>
                                                        <?php endif; ?>
                                                        <div id="errorMessage_0" class="error" style="color: red;"></div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <b>Image</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">perm_media</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input
                                                                    type="file"
                                                                    name="image_0"
                                                                    id="image_0"
                                                                    class="form-control text"
                                                                    required
                                                                    accept="image/*">
                                                                <input
                                                                    type="hidden"
                                                                    name="current_image_0"
                                                                    value="<?php echo isset($currentImagePath) ? htmlspecialchars($currentImagePath) : ''; ?>">
                                                            </div>
                                                        </div>
                                                        <?php if (isset($currentImagePath) && $currentImagePath != ''): ?>
                                                            <img src="<?php echo htmlspecialchars($currentImagePath); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                        <?php endif; ?>
                                                        <div id="errorMessage_0" class="error" style="color: red;"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <p><b>Short Description</b></p>
                                                            <textarea class="form-control text" name="description_0" id="description_0" placeholder="Chapter Description" rows="5" cols="5" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <button type="button" class="remove_field btn btn-danger">Remove</button>
                                                <br><br> -->
                                            </div>

                                            <div class="row">
                                                <input type="hidden" name="validate" id="validate" value="1">
                                                <input type="hidden" name="exam_material_id" id="exam_material_id" value="<?= isset($exam_material_id) ? htmlspecialchars($exam_material_id) : '' ?>">
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
                                                $examwise_pdf_data = $this->Exam_Material_model->get_all_examwise_pdf_for_edit($single->id);
                                                // print_r($chapter_data);
                                                // exit;
                                            ?>
                                                <input type="hidden" name="exam_material_id" id="exam_material_id" value="<?= isset($exam_material_id) ? htmlspecialchars($exam_material_id) : '' ?>">
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
                                                                    class="form-control text" placeholder="Enter Title" value="<?php if (!empty($single)) {
                                                                                                                                    echo $single->title;
                                                                                                                                } ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Subject</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">check_circle</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <select name="subject_id" id="subject_id" class="form-control text" required>
                                                                    <option value="" disabled selected>-- Select Subject --</option>
                                                                    <?php
                                                                    // Fetch data from your model
                                                                    $subjects_types = $this->Exam_Material_model->get_select_subjects_list(); // Adjust model function name if needed
                                                                    $selected_subject = !empty($single) ? $single->subject_id : ''; // Pre-select value if editing
                                                                    if (!empty($subjects_types)) {
                                                                        foreach ($subjects_types as $subject) { ?>
                                                                            <option value="<?= $subject->id ?>" <?= ($subject->id == $selected_subject) ? 'selected' : '' ?>>
                                                                                <?= $subject->title ?>
                                                                            </option>
                                                                        <?php }
                                                                    } else { ?>
                                                                        <option value="">No Types Available</option>
                                                                    <?php } ?>
                                                                </select>
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
                                                                <input type="hidden" name="current_image_update" value="<?= isset($single) && !empty($single->image) ? htmlspecialchars($single->image) : '' ?>">
                                                            </div>
                                                            <!-- <?php echo $single->image; ?> -->
                                                        </div>
                                                        <?php if (!empty($single) && !empty($single->image)): ?>
                                                            <img src="<?= base_url() ?>assets/uploads/exam_material/images/<?= htmlspecialchars($single->image); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                        <?php endif; ?>
                                                        <div id="errorMessage" class="error" style="color: red;"></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>PDF*</b>
                                                        <div class="uploadOuter form-group">
                                                            <span class="dragBox">
                                                                <i class="fa-solid fa-file-pdf" style="font-size: 30px; color: #d9534f;"></i>
                                                                <input style="height: 100px !important" type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf">
                                                                <input type="hidden" name="current_pdf_update" value="<?= isset($single) && !empty($single->pdf) ? htmlspecialchars($single->pdf) : '' ?>">
                                                                <!-- <?php echo $single->pdf; ?> -->
                                                            </span><br>
                                                            <?php if (!empty($single) && !empty($single->pdf)): ?>
                                                                <a href="<?= base_url() ?>assets/uploads/exam_material/pdf/<?= htmlspecialchars($single->pdf); ?>" target="_blank">
                                                                    <i class="fa-solid fa-file-pdf" style="font-size: 50px; color: #d9534f;"></i>
                                                                    View PDF
                                                                </a>
                                                            <?php endif; ?>
                                                            <div id="errorMessage" class="error" style="color: red;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <b>Short Description*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">title</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" name="short_description" id="short_description"
                                                                    class="form-control text" placeholder="Enter Short Description" value="<?php if (!empty($single)) {
                                                                                                                                                echo $single->short_description;
                                                                                                                                            } ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            } ?>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <?php if (empty($single->id)) { ?>
                                                    <button type="button" id="add_more" class="btn btn-success">Add Subjectwise Pdf</button>
                                                <?php } ?>
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