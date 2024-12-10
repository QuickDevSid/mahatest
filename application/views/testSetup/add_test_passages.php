<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><strong>Dashboard -> Test Setup -> Add Test Passages </strong></h2>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong> Add Test Passages</strong>
                        </h2>
                        <hr>
                        <form id="test_submit_passage" enctype="multipart/form-data" action="<?php echo base_url() ?>TestSetup/add_passage_data" method="POST">
                            <input type="hidden" name="source_type" value="test_setup">
                            <input type="text" id="id" name="id" style="display:none;" value="<?php if (!empty($single)) {
                                                                                                    echo $single->id;
                                                                                                } ?>">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>Question Type*</b>
                                                    <div class="form-group">
                                                        <select id="question_type" class="form-control" name="question_type" onchange="showPassageField()">
                                                            <option value="">Select Option</option>
                                                            <option value="0" <?php if (!empty($single) && $single->group_type == "0") echo "selected"; ?>>Regular</option>
                                                            <option value="2" <?php if (!empty($single) && $single->group_type == "2") echo "selected"; ?>>Passage</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="test_id" id="test_id" value="<?php if (!empty($single)){ echo $single->id; } ?>">
                                            <div class="row clearfix passage_field" style="display:none;">
                                                <div class="col-md-8">
                                                    <b>Passage Title</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">topic</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="title" id="title" class="form-control text" placeholder="Enter Title"
                                                                value="<?php if (!empty($single)) {
                                                                            echo htmlspecialchars($single->group_title);
                                                                        } ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Passage Image</b>
                                                    <?php if (!empty($single) && !empty($single->group_image)): ?>
                                                        <a target="_blank" href="<?= base_url() ?>assets/uploads/questions_images/<?= htmlspecialchars($single->group_image); ?>" style="text-decoration:underline;width: 100px; height: auto;">View</a>
                                                    <?php endif; ?>
                                                    <div class="uploadOuter form-group">
                                                        <span class="dragBox">
                                                            <i class="fa-solid fa-images" style="font-size: 30px;"></i>
                                                            <input style="height: 100px !important" type="file" accept=".jpg,jpeg,.png" name="group_image" id="group_image" class="form-control">
                                                            <input type="hidden" name="current_group_image" value="<?= isset($single) && !empty($single->group_image) ? htmlspecialchars($single->group_image) : '' ?>">
                                                        </span>
                                                        <div id="errorMessage" class="error" style="color: red;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <b>Description*</b>
                                                    <div class="input-group">
                                                        <div class="form-line">
                                                            <textarea name="description" id="description" class="form-control text" placeholder="Enter Passgae Description"><?php if (!empty($single)) {
                                                                                                                                                                                echo htmlspecialchars($single->group_description);
                                                                                                                                                                            } ?></textarea>
                                                        </div>
                                                        <label id="description-error" style="display:none;" class="error" for="description">Please enter Instruction description!</label>
                                                    </div>
                                                </div>
                                            </div>                 
                                            <?php $count = 0; ?>
                                            <div class="row" style="border: 1px solid #ccc;">
                                                <input type="hidden" value="<?=$count;?>" name="indices[]">
                                                <div class="form-group col-lg-10">
                                                    <label for="fullname">Question*</label>
                                                    <input placeholder="Enter Question" type="text" name="question_<?=$count;?>" id="question_<?=$count;?>" class="form-control question">
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label for="fullname">Question Image</label>
                                                    <input accept=".png,.jpeg,.jpg" type="file" name="question_image_<?=$count;?>" id="question_image_<?=$count;?>" class="form-control question_image">
                                                </div>
                                                <div class="form-group col-lg-10">
                                                    <label for="fullname">Option 1</label>
                                                    <input placeholder="Enter Option 1" type="text" name="option_1_<?=$count;?>" id="option_1_<?=$count;?>" class="form-control option_1">
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label for="fullname">Option 1 Image</label>
                                                    <input accept=".png,.jpeg,.jpg" type="file" name="option_1_image_<?=$count;?>" id="option_1_image_<?=$count;?>" class="form-control option_1_image">
                                                </div>
                                                <div class="form-group col-lg-10">
                                                    <label for="fullname">Option 2</label>
                                                    <input placeholder="Enter Option 2" type="text" name="option_2_<?=$count;?>" id="option_2_<?=$count;?>" class="form-control option_2">
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label for="fullname">Option 2 Image</label>
                                                    <input accept=".png,.jpeg,.jpg" type="file" name="option_2_image_<?=$count;?>" id="option_2_image_<?=$count;?>" class="form-control option_2_image">
                                                </div>
                                                <div class="form-group col-lg-10">
                                                    <label for="fullname">Option 3</label>
                                                    <input placeholder="Enter Option 3" type="text" name="option_3_<?=$count;?>" id="option_3_<?=$count;?>" class="form-control option_3">
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label for="fullname">Option 3 Image</label>
                                                    <input accept=".png,.jpeg,.jpg" type="file" name="option_3_image_<?=$count;?>" id="option_3_image_<?=$count;?>" class="form-control option_3_image">
                                                </div>
                                                <div class="form-group col-lg-10">
                                                    <label for="fullname">Option 4</label>
                                                    <input placeholder="Enter Option 4" type="text" name="option_4_<?=$count;?>" id="option_4_<?=$count;?>" class="form-control option_4">
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label for="fullname">Option 4 Image</label>
                                                    <input accept=".png,.jpeg,.jpg" type="file" name="option_4_image_<?=$count;?>" id="option_4_image_<?=$count;?>" class="form-control option_4_image">
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label for="fullname">Correct Option</label>
                                                    <select name="correct_option_<?=$count;?>" id="correct_option_<?=$count;?>" class="form-control correct_option">
                                                        <option value="">Select Correct Option</option>
                                                        <option value="option_1">Option 1</option>
                                                        <option value="option_2">Option 2</option>
                                                        <option value="option_3">Option 3</option>
                                                        <option value="option_4">Option 4</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <label for="fullname">Positive Marks</label>
                                                    <input placeholder="Enter Positive Marks" type="number" min="1" name="positive_marks_<?=$count;?>" id="positive_marks_<?=$count;?>" class="form-control positive_marks">
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <label for="fullname">Negative Marks</label>
                                                    <input placeholder="Enter Negative Marks" type="number" min="1" name="negative_marks_<?=$count;?>" id="negative_marks_<?=$count;?>" class="form-control negative_marks">
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <label for="fullname">Solution</label>
                                                    <textarea placeholder="Enter Solution" name="solution_<?=$count;?>" id="solution_<?=$count;?>" class="form-control solution"></textarea>
                                                </div>
                                            </div>
                                            <?php $count++; ?>
                                            <div id="add_more_div"></div>
                                            <div class="row">  
                                                <div class="form-group col-lg-12">
                                                    <a id="add_more_button" class="btn btn-info" style="margin-top:30px;color:white;" onclick="createAddMoreFields()">Add More Questions</a>
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
        </div>
    </div>
</section>
<script>    
    var count = <?php echo $count; ?>;
    function createAddMoreFields() {
        let appedData = `<div class="row" style="border: 1px solid #ccc;">
                            <input type="hidden" value="${count}" name="indices[]">
                            <div class="form-group col-lg-10">
                                <label for="fullname">Question*</label>
                                <input placeholder="Enter Question" type="text" name="question_${count}" id="question_${count}" class="form-control question">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="fullname">Question Image</label>
                                <input accept=".png,.jpeg,.jpg" type="file" name="question_image_${count}" id="question_image_${count}" class="form-control question_image">
                            </div>
                            <div class="form-group col-lg-10">
                                <label for="fullname">Option 1</label>
                                <input placeholder="Enter Option 1" type="text" name="option_1_${count}" id="option_1_${count}" class="form-control option_1">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="fullname">Option 1 Image</label>
                                <input accept=".png,.jpeg,.jpg" type="file" name="option_1_image_${count}" id="option_1_image_${count}" class="form-control option_1_image">
                            </div>
                            <div class="form-group col-lg-10">
                                <label for="fullname">Option 2</label>
                                <input placeholder="Enter Option 2" type="text" name="option_2_${count}" id="option_2_${count}" class="form-control option_2">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="fullname">Option 2 Image</label>
                                <input accept=".png,.jpeg,.jpg" type="file" name="option_2_image_${count}" id="option_2_image_${count}" class="form-control option_2_image">
                            </div>
                            <div class="form-group col-lg-10">
                                <label for="fullname">Option 3</label>
                                <input placeholder="Enter Option 3" type="text" name="option_3_${count}" id="option_3_${count}" class="form-control option_3">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="fullname">Option 3 Image</label>
                                <input accept=".png,.jpeg,.jpg" type="file" name="option_3_image_${count}" id="option_3_image_${count}" class="form-control option_3_image">
                            </div>
                            <div class="form-group col-lg-10">
                                <label for="fullname">Option 4</label>
                                <input placeholder="Enter Option 4" type="text" name="option_4_${count}" id="option_4_${count}" class="form-control option_4">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="fullname">Option 4 Image</label>
                                <input accept=".png,.jpeg,.jpg" type="file" name="option_4_image_${count}" id="option_4_image_${count}" class="form-control option_4_image">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="fullname">Correct Option</label>
                                <select name="correct_option_${count}" id="correct_option_${count}" class="form-control correct_option">
                                    <option value="">Select Correct Option</option>
                                    <option value="option_1">Option 1</option>
                                    <option value="option_2">Option 2</option>
                                    <option value="option_3">Option 3</option>
                                    <option value="option_4">Option 4</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="fullname">Positive Marks</label>
                                <input placeholder="Enter Positive Marks" type="number" min="1" name="positive_marks_${count}" id="positive_marks_${count}" class="form-control positive_marks">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="fullname">Negative Marks</label>
                                <input placeholder="Enter Negative Marks" type="number" min="1" name="negative_marks_${count}" id="negative_marks_${count}" class="form-control negative_marks">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="fullname">Solution</label>
                                <textarea placeholder="Enter Solution" name="solution_${count}" id="solution_${count}" class="form-control solution"></textarea>
                            </div>
                            <div class="form-group col-lg-2 "  style="margin-top:25px;">
                                <span onclick="removeRow(this)" class="delete_area"><i class="fa fa-trash" style="color:red;" aria-hidden="true"></i></span>
                            </div>
                        </div>`;
        $('#add_more_div').append(appedData);
        count++;
        initializeValidationForFields();
    }
    function removeRow(arg) {
        $(arg).parent().parent().remove();
        initializeValidationForFields();
    }   
    function initializeValidationForFields() {
        $(".correct_option").each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please select correct option",
                },
            });
        });

        $(".option_4").each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter option 4",
                },
            });
        });

        $(".option_3").each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter option 3",
                },
            });
        });

        $(".option_2").each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter option 2",
                },
            });
        });

        $(".option_1").each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter option 1",
                },
            });
        });

        $(".question").each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter question",
                },
            });
        });

        $(".negative_marks").each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter negative marks",
                },
            });
        });

        $(".positive_marks").each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter positive marks",
                },
            });
        });

        $(".solution").each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter solution",
                },
            });
        });
    }
    function deleteRow(id) {
        if(confirm("Are you sure you want to delete this?")){ 
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>admin/Ajax_controller/remove_unused_details",
                data: {
                    'id': id,
                },
                success: function(data) {
                        $("#removable_details_"+id).remove();
                        initializeValidationForFields();                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    }

    $(document).ready(function() { 
        initializeValidationForFields();
    });
</script>