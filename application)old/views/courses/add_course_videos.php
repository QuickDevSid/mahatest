<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Courses - Courses Videos </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Courses Videos
                        </h2>
                    </div>
                    <div class="body">
                        <form id="test_submit" name="test_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Courses/add_course_videos" method="POST">
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
                                                                <b><span id="title_error" style="color:red; display:none;"></span></b>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <b>Courses</b>
                                                        <div class="form-group">
                                                            <select id="courses" class="form-control" name="source_id">
                                                                <option value="">Select Courses</option>
                                                                <?php
                                                                $course_data = $this->Courses_model->get_select_course();
                                                                $selected_course = !empty($single) ? $single->source_id : ''; // Corrected here to source_id

                                                                if (!empty($course_data)) {
                                                                    foreach ($course_data as $course) { ?>
                                                                        <option value="<?= $course->id ?>" <?= ($course->id == $selected_course) ? 'selected' : '' ?>>
                                                                            <?= $course->title ?>
                                                                        </option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <b>Image*</b>
                                                        <div class="uploadOuter form-group">
                                                            <span class="dragBox">
                                                                <i class="fa-solid fa-images" style="font-size: 30px;"></i>

                                                                <input style="height: 100px !important" type="file" name="image" id="image" class="form-control" accept="image/*">
                                                                <input type="hidden" name="current_image" value="<?= isset($single) && !empty($single->image_url) ? htmlspecialchars($single->image_url) : '' ?>">
                                                            </span><br>
                                                            <?php if (!empty($single) && !empty($single->image_url)): ?>
                                                                <img src="<?= base_url() ?>assets/uploads/courses/images/<?= htmlspecialchars($single->image_url); ?>" alt="Image" style="width: 100px; height: auto;" />
                                                            <?php endif; ?>
                                                            <div id="errorMessage" class="error" style="color: red;"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <b>Video Type*</b>
                                                        <div class="form-group">
                                                            <select id="video_type" class="form-control" name="video_source" onchange="toggleVideoInput()">
                                                                <option value="">Select Video Type</option>
                                                                <option value="Hosted" <?php if (!empty($single) && $single->video_source == "Hosted") echo "selected"; ?>>Video</option>
                                                                <option value="YouTube" <?php if (!empty($single) && $single->video_source == "YouTube") echo "selected"; ?>>YouTube</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-md-4" id="url-section" style="display: none;">
                                                        <b>YouTube Link</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">link</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="url" name="youtube_url" id="youtube_url" class="form-control text" placeholder="Enter YouTube URL">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" id="video-section" style="display: none;">
                                                        <b>Video File</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">perm_media</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="file" name="video_file" id="video_file" class="form-control text" accept="video/*">
                                                            </div>
                                                        </div>
                                                    </div> -->

                                                    <div class="col-md-4" id="url-section" style="display: none;">
                                                        <b>YouTube Link</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">link</i>
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="url" name="youtube_url" id="youtube_url" class="form-control text" placeholder="Enter YouTube URL"
                                                                    value="<?= isset($single) && !empty($single->video_url) ? htmlspecialchars($single->video_url) : '' ?>">
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
                                                                <?php if (isset($single) && !empty($single->video_url)): ?>
                                                                    <p>Current Video: <?= basename($single->video_url) ?></p>
                                                                    <input type="file" name="video_file" id="video_file" class="form-control text" accept="video/*">
                                                                    <input type="hidden" name="current_video" value="<?= isset($single) && !empty($single->video_url) ? htmlspecialchars($single->video_url) : '' ?>">
                                                                <?php else: ?>
                                                                    <input type="file" name="video_file" id="video_file" class="form-control text" accept="video/*">
                                                                    <input type="hidden" name="current_video" value="<?= isset($single) && !empty($single->video_url) ? htmlspecialchars($single->video_url) : '' ?>">
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <b>Description*</b>
                                                        <div class="input-group">
                                                            <div class="form-line">
                                                                <textarea name="description" id="description" class="form-control text" placeholder="Enter Description" rows="5" cols="5"><?php if (!empty($single)) {
                                                                                                                                                                                                echo $single->description;
                                                                                                                                                                                            } ?></textarea>
                                                            </div>
                                                            <b><span id="description_error" style="color:red; display:none;"></span></b>
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