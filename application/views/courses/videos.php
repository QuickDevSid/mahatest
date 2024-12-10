<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Courses -> Videos </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Videos
                            <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                data-target="#add">
                                <i class="material-icons">person_add</i>
                                <span>Add Videos</span>
                            </button>
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="user_data_videos"
                                class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%">Action</th>
                                        <th>Title</th>
                                        <th>Video Type</th>
                                        <th>Video Link</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th width="10%">Action</th>
                                        <th>Title</th>
                                        <th>Video Type</th>
                                        <th>Video Link</th>
                                        <th>Image</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($course_videos)) {
                                        foreach ($course_videos as $row) {
                                            if ($row->video_source == 'Hosted') {
                                                $video_link = base_url() . '' . $row->video_url;
                                            } else {
                                                $video_link = $row->video_url;
                                            }

                                            if ($row->image_url != '') {
                                                $image_link = '<a href="' . base_url() . $row->image_url . '" target="_blank" style="text-decoration:underline;">View</a>';
                                            } else {
                                                $image_link = '';
                                            }
                                    ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $row->title; ?></td>
                                                <td><?= $row->video_source; ?></td>
                                                <td><a href="<?= $video_link; ?>" target="_blank" style="text-decoration:underline;">View</a></td>
                                                <td><?= $image_link; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->

        </div>
    </div>
</section>


<div class="modal fade" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Courses/add_video_data" method="POST">
            <input type="hidden" name="source_type" value="courses">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Document </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="title" id="title"
                                                            class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Courses</b>
                                                </p>
                                                <select class="form-control show-tick" name="source_id" id="source_id">
                                                    <option value="">Select Course</option>
                                                    <?php
                                                    $courses = courses();
                                                    if (isset($courses) && !empty($courses)) {
                                                        foreach ($courses as $row) { ?>
                                                            <option value="<?= $row->id; ?>"><?= $row->title; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div> -->
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="image" id="image"
                                                            class="form-control text" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Video Type</b>
                                                </p>
                                                <select class="form-control show-tick" name="video_source" id="video_source">
                                                    <option value="Hosted">Video</option>
                                                    <option value="YouTube">YouTube</option>
                                                </select>

                                            </div>
                                            <div class="col-md-4" id="video-section">
                                                <b>Video</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="video_url" id="video_url"
                                                            class="form-control text" accept="video/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="url-section">
                                                <b>You Tube</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">link</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="url" name="video_url" id="video_url"
                                                            class="form-control text" placeholder="Enter Url Link">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="description" placeholder="Description" rows="5" cols="5"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="video_submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                        data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="submit_examsection" enctype="multipart/form-data" action="<?php echo base_url() ?>Courses/update_video_data" method="POST">
            <input type="hidden" name="source_type" value="courses">
            <input type="hidden" name="id" id="edit_id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Document </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="title" id="edit_title"
                                                            class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Courses</b>
                                                </p>
                                                <select class="form-control show-tick" name="source_id" id="edit_source_id">
                                                    <option value="">Select Course</option>
                                                    <?php
                                                    $courses = courses();
                                                    if (isset($courses) && !empty($courses)) {
                                                        foreach ($courses as $row) { ?>
                                                            <option value="<?= $row->id; ?>"><?= $row->title; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="edit_status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div> -->
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="image" id="image"
                                                            class="form-control text" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Video Type</b>
                                                </p>
                                                <select class="form-control show-tick" name="video_source" id="edit_video_source">
                                                    <option value="Hosted">Video</option>
                                                    <option value="YouTube">YouTube</option>

                                                </select>

                                            </div>
                                            <div class="col-md-4" id="edit_video-section">
                                                <b>Video</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="video_url" id="edit_video_url"
                                                            class="form-control text" accept="video/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="edit_url-section">
                                                <b>You Tube</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">link</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="url" name="video_url" id="edit_video_url"
                                                            class="form-control text" placeholder="Enter Url Link">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="edit_description" placeholder="Description" rows="5" cols="5"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="video_submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                        data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="show" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">View Video </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">
                                            <div class="col-md-4">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="title" id="s_title"
                                                            class="form-control text" placeholder="Title" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="s_status" disabled>
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Video Type</b>
                                                </p>
                                                <select class="form-control show-tick" name="video_source" id="video_source" disabled>
                                                    <option value="Hosted">Video</option>
                                                    <option value="YouTube">YouTube</option>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <img src="" alt="" id="s_img" class="img-fluid rounded" style="width: 50%;">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Video</b>
                                                <div class="input-group" id="video">

                                                </div>
                                            </div>
                                            <div class="col-md-4" id="url-section">
                                                <b>You Tube</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">link</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="url" name="video_url" id="video_url"
                                                            class="form-control text" placeholder="Enter Url Link">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="s_description" placeholder="Description" rows="5" cols="5" disabled></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect"
                        data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let type = 'Video';
    let id = 'videos';
</script>