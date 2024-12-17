<?php $i = 0; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Exam Material - Add Examwise Test</h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Add Examwise Test</strong>
                        </h2>
                        <hr>
                        <form id="chapter_submit" name="chapter_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Exam_Material/add_examwise_test" method="POST">
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
                                                        <b>Exam Name</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">check_circle</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <select name="exam_name_0" id="exam_name_0" class="form-control text" required>
                                                                    <option value="" disabled selected>-- Select Exam Name --</option>
                                                                    <?php
                                                                    // Fetch data from your model
                                                                    $exam_names = $this->Exam_Material_model->get_select_exam_name(); // Adjust model function name if needed
                                                                    $selected_exam = !empty($single) ? $single->exam_name : ''; // Pre-select value if editing
                                                                    if (!empty($exam_names)) {
                                                                        foreach ($exam_names as $exam) { ?>
                                                                            <option value="<?= $exam->id ?>" <?= ($exam->id == $selected_exam) ? 'selected' : '' ?>>
                                                                                <?= $exam->title ?>
                                                                            </option>
                                                                        <?php }
                                                                    } else { ?>
                                                                        <option value="">No Exams Available</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Exam Year</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">calendar_today</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <select name="exam_year_0" id="exam_year_0" class="form-control text" required>
                                                                    <option value="" disabled selected>-- Select Exam Year --</option>
                                                                    <?php
                                                                    // Fetch data from your model
                                                                    $exam_years = $this->Exam_Material_model->get_select_exam_year(); // Adjust model function name if needed
                                                                    $selected_year = !empty($single) ? $single->exam_year : ''; // Pre-select value if editing
                                                                    if (!empty($exam_years)) {
                                                                        foreach ($exam_years as $year) { ?>
                                                                            <option value="<?= $year->id ?>" <?= ($year->id == $selected_year) ? 'selected' : '' ?>>
                                                                                <?= $year->title ?>
                                                                            </option>
                                                                        <?php }
                                                                    } else { ?>
                                                                        <option value="">No Years Available</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Exam Type</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">check_circle</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <select name="exam_type_0" id="exam_type_0" class="form-control text" required>
                                                                    <option value="" disabled selected>-- Select Exam Type --</option>
                                                                    <?php
                                                                    // Fetch data from your model
                                                                    $exam_types = $this->Exam_Material_model->get_select_exam_type(); // Adjust model function name if needed
                                                                    $selected_type = !empty($single) ? $single->exam_type : ''; // Pre-select value if editing
                                                                    if (!empty($exam_types)) {
                                                                        foreach ($exam_types as $type) { ?>
                                                                            <option value="<?= $type->id ?>" <?= ($type->id == $selected_type) ? 'selected' : '' ?>>
                                                                                <?= $type->title ?>
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
                                                    <div class="col-md-8">
                                                        <b>Tests*</b>
                                                        <select class="form-control show-tick" name="test_id_0_[]" id="test_id" multiple required>
                                                            <option value="">Select Tests</option>
                                                            <?php
                                                            $tests = $this->Exam_Material_model->get_tests_examwise_setup();
                                                            if (!empty($tests)) {
                                                                foreach ($tests as $row) {
                                                            ?>
                                                                    <option value="<?= $row->id; ?>" <?php if (!empty($single) && in_array($row->id, explode(',', $single->tests))) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?= $row->topic; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
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
                                                $examwise_test_data = $this->Exam_Material_model->get_all_examwise_test_for_edit($single->id);
                                                // print_r($chapter_data);
                                                // exit;
                                            ?>
                                                <input type="hidden" name="exam_material_id" id="exam_material_id" value="<?= isset($exam_material_id) ? htmlspecialchars($exam_material_id) : '' ?>">
                                                <input type="hidden" name="validate" id="validate" value="1">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <b>Exam Name*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">category</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <select name="exam_name" id="exam_name" class="form-control">
                                                                    <option value="" disabled selected>Select Exam Name</option>
                                                                    <?php
                                                                    $ebook_cat_data = $this->Exam_Material_model->get_select_exam_name();
                                                                    $selected_ebook_cat = !empty($single) ? $single->exam_name : '';
                                                                    if (!empty($ebook_cat_data)) {
                                                                        foreach ($ebook_cat_data as $ebook_cat) { ?>
                                                                            <option value="<?= $ebook_cat->id ?>" <?= ($ebook_cat->id == $selected_ebook_cat) ? 'selected' : '' ?>>
                                                                                <?= $ebook_cat->title ?>
                                                                            </option>
                                                                    <?php }
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Exam Year*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">category</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <select name="exam_year" id="exam_year" class="form-control">
                                                                    <option value="" disabled selected>Select Exam Year</option>
                                                                    <?php
                                                                    $ebook_cat_data = $this->Exam_Material_model->get_select_exam_year();
                                                                    $selected_ebook_cat = !empty($single) ? $single->exam_year : '';
                                                                    if (!empty($ebook_cat_data)) {
                                                                        foreach ($ebook_cat_data as $ebook_cat) { ?>
                                                                            <option value="<?= $ebook_cat->id ?>" <?= ($ebook_cat->id == $selected_ebook_cat) ? 'selected' : '' ?>>
                                                                                <?= $ebook_cat->title ?>
                                                                            </option>
                                                                    <?php }
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Exam Type*</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">category</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <select name="exam_type" id="exam_type" class="form-control">
                                                                    <option value="" disabled selected>Select Exam Type</option>
                                                                    <?php
                                                                    $ebook_cat_data = $this->Exam_Material_model->get_select_exam_type();
                                                                    $selected_ebook_cat = !empty($single) ? $single->exam_type : '';
                                                                    if (!empty($ebook_cat_data)) {
                                                                        foreach ($ebook_cat_data as $ebook_cat) { ?>
                                                                            <option value="<?= $ebook_cat->id ?>" <?= ($ebook_cat->id == $selected_ebook_cat) ? 'selected' : '' ?>>
                                                                                <?= $ebook_cat->title ?>
                                                                            </option>
                                                                    <?php }
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <b>Tests*</b>
                                                        <select class="form-control show-tick" name="test_id[]" id="test_id" multiple required>
                                                            <option value="">Select Tests</option>
                                                            <?php
                                                            $tests = $this->Exam_Material_model->get_tests_examwise_setup();
                                                            if (!empty($tests)) {
                                                                foreach ($tests as $row) {
                                                            ?>
                                                                    <option value="<?= $row->id; ?>" <?php if (!empty($single) && in_array($row->id, explode(',', $single->tests))) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?= $row->topic; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                </div>

                                            <?php
                                            } ?>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <?php if (empty($single->id)) { ?>
                                                    <button type="button" id="add_more" class="btn btn-success">Add Examwise Test</button>
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