<style>
    .error {
        color: red;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><strong>Dashboard -> Current Affairs -> Tests </strong></h2>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Tests</strong>
                        </h2>
                        <hr>
                        <form id="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>current_affairs/add_tests" method="POST">
                            <input type="hidden" name="source_type" value="test_series">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <b>Category*</b>
                                                    <select class="form-control show-tick" name="category_id" id="category_id" onchange="uniqueCategoryTest()">
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        if (isset($category) && !empty($category)) {
                                                            foreach ($category as $row) { ?>
                                                                <option value="<?= $row->id; ?>" <?php if (!empty($single) && $single->id == $row->id) {
                                                                                                        echo 'selected';
                                                                                                    } ?>><?= $row->category_name; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="unique_message" class="error" style="display:none;"></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <b>Tests*</b>
                                                    <select class="form-control show-tick" name="test_id[]" id="test_id" multiple>
                                                        <option value="">Select Tests</option>
                                                        <?php
                                                        $tests = $this->CurrentAffairs_model->get_tests();
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
                                            <input type="hidden" value="<?php if (!empty($single)) {
                                                                            echo $single->id;
                                                                        } ?>" name="hidden_id" id="hidden_id">
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
<script>    
    function uniqueCategoryTest() {
        var category_id = $('#category_id').val();
        var hiddenId = $('#hidden_id').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>Ajax_controller/get_category_tests_ajax/",
            data: {
                category_id: category_id,
                id: hiddenId
            },
            dataType: "json",
            success: function(result) {
                if(result == '0'){
                    $('#submit_course_test').attr('disabled',true);
                    $('#unique_message').text('Test already added for this category').show();
                }else{
                    $('#submit_course_test').attr('disabled',false);
                    $('#unique_message').text('').hide();
                }
            },
            error: function() {
                alert('Some error occurred!');
            }
        });
    }
</script>