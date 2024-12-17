<?php $i = 0; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Exam Material - Add Subjectwise Test</h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Add Subjectwise Test</strong>
                        </h2>
                        <hr>
                        <form id="chapter_submit" name="chapter_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Exam_Material/add_subjectwise_test" method="POST">
                            <input type="hidden" name="source_type" value="exam_material">
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
                                                $subjectwise_test_data = $this->Exam_Material_model->get_all_subjectwise_test_for_edit_new($single->id);
                                                // print_r($chapter_data);
                                                // exit;
                                            ?>
                                                <input type="hidden" name="exam_material_id" id="exam_material_id" value="<?= isset($exam_material_id) ? htmlspecialchars($exam_material_id) : '' ?>">
                                                <input type="hidden" name="validate" id="validate" value="1">
                                                <div class="row">
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
                                                    <button type="button" id="add_more" class="btn btn-success">Add Subjectwise Test</button>
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