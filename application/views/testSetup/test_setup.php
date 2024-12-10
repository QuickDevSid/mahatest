<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><strong>Dashboard -> Test Setup </strong></h2>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Test Setup</strong>
                        </h2>
                        <hr>
                        <!-- <form id="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>TestSetup/add_data" method="POST">
                            <input type="hidden" name="source_type" value="test_setup">
                            <input type="text" id="id" name="id" style="display:none;" value="<?php if (!empty($single)) {
                                                                                                    echo $single->id;
                                                                                                } ?>">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <b>Subject/Topic*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">topic</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="topic" id="topic"
                                                                class="form-control text" placeholder="Enter Subject/Topic">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Short Note* <small>(For Test List Card)</small></b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">description</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="short_note" id="short_note"
                                                                class="form-control text" placeholder="Enter Short Note">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Short Description</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">note</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="short_description" id="short_description"
                                                                class="form-control text" placeholder="Enter Short Description">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <b>Duration* <small>(In Min.)</small></b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">note</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="duration" id="duration"
                                                                class="form-control text" placeholder="Enter Duration" value>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Questions File*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">note</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="file" accept=".xlxs,.csv" name="bulk_file" id="bulk_file"
                                                                class="form-control file">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Sorting order*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">title</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="sequence_no" id="sequence_no" class="form-control text" placeholder="Enter Sorting order" value="<?php if (!empty($single)) {
                                                                                                                                                                                            echo $single->sequence_no;
                                                                                                                                                                                        } ?>">
                                                            <b><span id="sequence_no_error" style="color:red; display:none;"></span></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <b>Questions shuffle*</b>
                                                    <div class="form-group">
                                                        <select id="" class="form-control" name="questions_shuffle">
                                                            <option value="">Select Questions shuffle</option>
                                                            <option value="Yes" <?php if (!empty($single) && $single->questions_shuffle == "Yes") echo "selected"; ?>>Yes</option>
                                                            <option value="No" <?php if (!empty($single) && $single->questions_shuffle == "No") echo "selected"; ?>>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Show answer at the time of exam*</b>
                                                    <div class="form-group">
                                                        <select id="" class="form-control" name="show_ans">
                                                            <option value="">Select</option>
                                                            <option value="Yes" <?php if (!empty($single) && $single->show_ans == "Yes") echo "selected"; ?>>Yes</option>
                                                            <option value="No" <?php if (!empty($single) && $single->show_ans == "No") echo "selected"; ?>>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Image*</b>
                                                    <div class="uploadOuter form-group">
                                                        <span class="dragBox">
                                                            <i class="fa-solid fa-images" style="font-size: 30px;"></i>
                                                            <input style="height: 100px !important" type="file" name="image" id="image" class="form-control" accept="image/*">
                                                            <input type="hidden" name="current_image" value="<?= isset($single) && !empty($single->image) ? htmlspecialchars($single->image) : '' ?>">
                                                        </span><br>
                                                        <?php if (!empty($single) && !empty($single->image)): ?>
                                                            <img src="<?= base_url() ?>assets/uploads/test_series/images/<?= htmlspecialchars($single->image); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                        <?php endif; ?>
                                                        <div id="errorMessage" class="error" style="color: red;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-12">
                                                    <b>Instruction Description*</b>
                                                    <div class="input-group">
                                                        <div class="form-line">
                                                            <textarea name="description" id="description"
                                                                class="form-control text" placeholder="Enter Test Description"></textarea>
                                                        </div>
                                                        <label id="description-error" style="display:none;" class="error" for="description">Please enterInstruction description!</label>
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
                        </form> -->
                        <form id="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>TestSetup/add_data" method="POST">
                            <input type="hidden" name="source_type" value="test_setup">
                            <input type="text" id="id" name="id" style="display:none;" value="<?php if (!empty($single)) {
                                                                                                    echo $single->id;
                                                                                                } ?>">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <b>Subject/Topic*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">topic</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="topic" id="topic" class="form-control text" placeholder="Enter Subject/Topic"
                                                                value="<?php if (!empty($single)) {
                                                                            echo htmlspecialchars($single->topic);
                                                                        } ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Short Note* <small>(For Test List Card)</small></b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">description</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="short_note" id="short_note" class="form-control text" placeholder="Enter Short Note"
                                                                value="<?php if (!empty($single)) {
                                                                            echo htmlspecialchars($single->short_note);
                                                                        } ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Short Description</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">note</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="short_description" id="short_description" class="form-control text" placeholder="Enter Short Description"
                                                                value="<?php if (!empty($single)) {
                                                                            echo htmlspecialchars($single->short_description);
                                                                        } ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <b>Duration* <small>(In Min.)</small></b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">note</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="duration" id="duration" class="form-control text" placeholder="Enter Duration"
                                                                value="<?php if (!empty($single)) {
                                                                            echo htmlspecialchars($single->duration);
                                                                        } ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if (!empty($single->questions_file)): ?>
                                                    <div style="margin-top: 10px;">
                                                        <span>
                                                            <b>Uploaded File: </b>
                                                            <?= htmlspecialchars($single->questions_file); ?>
                                                        </span>
                                                        <a href="<?= base_url() ?>assets/uploads/questions_bulk/<?= htmlspecialchars($single->questions_file); ?>"
                                                            target="_blank"
                                                            style="margin-left: 10px; color: blue; text-decoration: none;">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="col-md-4">
                                                    <b>Questions File*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">note</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <!-- Removed value attribute, file input can't have a pre-set value -->
                                                            <input type="file" accept=".xlsx,.csv" name="bulk_file" id="bulk_file" class="form-control file">
                                                            <!-- Hidden input field for the existing file (if any) -->
                                                            <input type="hidden" name="current_file" value="<?= isset($single) && !empty($single->questions_file) ? htmlspecialchars($single->questions_file) : '' ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <b>Sorting order*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">title</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="sequence_no" id="sequence_no" class="form-control text" placeholder="Enter Sorting order"
                                                                value="<?php if (!empty($single)) {
                                                                            echo htmlspecialchars($single->sequence_no);
                                                                        } ?>">
                                                            <b><span id="sequence_no_error" style="color:red; display:none;"></span></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <b>Questions shuffle*</b>
                                                    <div class="form-group">
                                                        <select id="questions_shuffle" class="form-control" name="questions_shuffle">
                                                            <option value="">Select Questions shuffle</option>
                                                            <option value="Yes" <?php if (!empty($single) && $single->questions_shuffle == "Yes") echo "selected"; ?>>Yes</option>
                                                            <option value="No" <?php if (!empty($single) && $single->questions_shuffle == "No") echo "selected"; ?>>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Show answer at the time of exam*</b>
                                                    <div class="form-group">
                                                        <select id="show_ans" class="form-control" name="show_ans">
                                                            <option value="">Select</option>
                                                            <option value="Yes" <?php if (!empty($single) && $single->show_ans == "Yes") echo "selected"; ?>>Yes</option>
                                                            <option value="No" <?php if (!empty($single) && $single->show_ans == "No") echo "selected"; ?>>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Image*</b>
                                                    <?php if (!empty($single) && !empty($single->image)): ?>
                                                        <a target="_blank" href="<?= base_url() ?>assets/uploads/test_setup/images/<?= htmlspecialchars($single->image); ?>" alt="Image" style="text-decoration:underline;width: 100px; height: auto;">View</a>
                                                    <?php endif; ?>
                                                    <div class="uploadOuter form-group">
                                                        <span class="dragBox">
                                                            <i class="fa-solid fa-images" style="font-size: 30px;"></i>
                                                            <input style="height: 100px !important" type="file" name="image" id="image" class="form-control" accept="image/*">
                                                            <input type="hidden" name="current_image" value="<?= isset($single) && !empty($single->image) ? htmlspecialchars($single->image) : '' ?>">
                                                        </span>
                                                        <div id="errorMessage" class="error" style="color: red;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Test PDF</b>
                                                    <?php if (!empty($single) && !empty($single->test_pdf)): ?>
                                                        <a target="_blank" href="<?= base_url() ?>assets/uploads/test_pdfs/<?= htmlspecialchars($single->test_pdf); ?>" style="text-decoration:underline;width: 100px; height: auto;">View</a>
                                                    <?php endif; ?>
                                                    <div class="uploadOuter form-group">
                                                        <span class="dragBox">
                                                            <i class="fa-solid fa-images" style="font-size: 30px;"></i>
                                                            <input style="height: 100px !important" type="file" accept=".pdf" name="test_pdf" id="test_pdf" class="form-control">
                                                            <input type="hidden" name="current_test_pdf" value="<?= isset($single) && !empty($single->image) ? htmlspecialchars($single->test_pdf) : '' ?>">
                                                        </span>
                                                        <div id="errorMessage" class="error" style="color: red;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Download PDF</b>
                                                    <div class="form-group">
                                                        <select id="download_test_pdf" class="form-control" name="download_test_pdf">
                                                            <option value="">Select Option</option>
                                                            <option value="Yes" <?php if (!empty($single) && $single->download_test_pdf == "Yes") echo "selected"; ?>>Yes</option>
                                                            <option value="No" <?php if (!empty($single) && $single->download_test_pdf == "No") echo "selected"; ?>>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>     
                                            <div class="row clearfix">
                                                <div class="col-md-12">
                                                    <b>Instruction Description*</b>
                                                    <div class="input-group">
                                                        <div class="form-line">
                                                            <textarea name="description" id="description" class="form-control text" placeholder="Enter Test Description"><?php if (!empty($single)) {
                                                                                                                                                                                echo htmlspecialchars($single->description);
                                                                                                                                                                            } ?></textarea>
                                                        </div>
                                                        <label id="description-error" style="display:none;" class="error" for="description">Please enter Instruction description!</label>
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
        </div>
    </div>
</section>