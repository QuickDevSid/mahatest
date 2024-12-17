<style>
    .error {
        color: red;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><strong>Dashboard -> Test Series -> Quiz </strong></h2>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Quiz</strong>
                        </h2>
                        <hr>
                        <form id="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>TestSeries/add_test_series_quizs_tests" method="POST">
                            <input type="hidden" name="source_type" value="test_series">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <input type="hidden" value="<?php if (!empty($single)) {
                                                                                echo $single->id;
                                                                            } ?>" name="id" id="id">
                                                <div class="col-md-4">
                                                    <b>Tests Series*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">category</i>
                                                        </span>
                                                        <div class="form-line">

                                                            <select name="title" id="title" class="form-control">
                                                                <option value="" disabled selected>Select Tests Series</option>
                                                                <?php
                                                                $test_data = $this->Test_series_model->get_select_test();
                                                                $selected_test = !empty($single) ? $single->title : '';
                                                                if (!empty($test_data)) {
                                                                    foreach ($test_data as $test) { ?>
                                                                        <option value="<?= $test->id ?>" <?= ($test->title == $selected_test) ? 'selected' : '' ?>>
                                                                            <?= $test->title ?>
                                                                        </option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <b>Tests*</b>
                                                    <select class="form-control show-tick" name="test_id[]" id="test_id" multiple>
                                                        <option value="">Select Tests</option>
                                                        <?php
                                                        $tests = $this->Test_series_model->get_tests();
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

                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <button type="submit" name="submit_course_test" value="submit_course_test" id="submit_course_test" class="btn btn-link waves-effect">SAVE DETAILS</button>
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
        </div>
    </div>
</section>