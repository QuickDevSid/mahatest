<section class="content">
<div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> doc_video - Quiz's  </h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Quiz's
                          <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                     data-target="#add">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Quiz</span>
                             </button>
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="user_data"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Number Of Questions</th>
                                    <th>Marks</th>
                                    <th>Time</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Number Of Questions</th>
                                    <th>Marks</th>
                                    <th>Time</th>
                                    <th>Image</th>
                                    <th>Status</th>

                                </tr>
                                </tfoot>
                                <tbody>

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
        <form id="submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Quizs/add_data" method="POST">
            <input type="hidden" name="source_type" value="courses">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Quiz </h4>
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
                                                <select class="form-control show-tick" name="source_id" id="source_id" >
                                                    <option value="">Select Course</option>
                                                    <?php
                                                    $courses = courses();
                                                    if (isset($courses) && !empty($courses)){
                                                        foreach ($courses as $row)
                                                        {?>
                                                            <option value="<?=$row->id;?>"><?= $row->title;?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Number Of Questions</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="num_of_question" id="num_of_question"
                                                               class="form-control text" placeholder="Number Of Questions" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Marks Per Question</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="marks_per_question" id="marks_per_question"
                                                               class="form-control text" placeholder="Marks" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Time</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="time" id="time"
                                                               class="form-control text" placeholder="Time" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Can Download</b>
                                                </p>
                                                <select class="form-control show-tick" name="can_download" id="can_download" >
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>

                                            </div>
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="image" id="Doc_Videos"
                                                               class="form-control text"  required accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Pdf</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="pdf" id="pdf"
                                                               class="form-control text"  required accept="application/pdf">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="description" placeholder="Description" rows="5" cols="5" ></textarea>

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
                    <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS
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
        <form id="submit_examsection" enctype="multipart/form-data" action="<?php echo base_url() ?>Quizs/update_data" method="POST">
            <input type="hidden" name="source_type" value="courses">
            <input type="hidden" name="id" id="edit_id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit New Quiz </h4>
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
                                                <select class="form-control show-tick" name="source_id" id="edit_source_id" >
                                                    <option value="">Select Course</option>
                                                    <?php
                                                    $courses = courses();
                                                    if (isset($courses) && !empty($courses)){
                                                        foreach ($courses as $row)
                                                        {?>
                                                            <option value="<?=$row->id;?>"><?= $row->title;?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Number Of Questions</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="num_of_question" id="edit_num_of_question"
                                                               class="form-control text" placeholder="Number Of Questions" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Marks Per Question</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="marks_per_question" id="edit_marks_per_question"
                                                               class="form-control text" placeholder="Marks" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Time</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="time" id="edit_time"
                                                               class="form-control text" placeholder="Time" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" id="edit_status" >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>
                                                    <b>Can Download</b>
                                                </p>
                                                <select class="form-control show-tick" name="can_download" id="edit_can_download" >
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>

                                            </div>
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="image" id="Doc_Videos"
                                                               class="form-control text"  accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Pdf</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">perm_media</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="file" name="pdf" id="pdf"
                                                               class="form-control text"  accept="application/pdf">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="edit_description" placeholder="Description" rows="5" cols="5" ></textarea>

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
                    <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
 </div>
<div class="modal fade" id="manage-questions" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Question </h4>
                </div>
                <div class="modal-body">
                    <form id="submit_question" enctype="multipart/form-data" action="<?php echo base_url() ?>Quizs/add_question" method="POST">
                        <input type="hidden" name="source_type" value="courses">
                        <input type="hidden" name="quiz_id" value="" id="quiz_id">
                        <input type="hidden" name="id" id="question_id" value="">
                        <!-- Masked Input -->
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">

                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <b>Question</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">person</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="question" id="question"
                                                                class="form-control text" placeholder="Question" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Option 1</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">person</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="option1" id="option1"
                                                                class="form-control text" placeholder="Option 1" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Option 2</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">person</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="option2" id="option2"
                                                                class="form-control text" placeholder="Option 2" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Option 3</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">person</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="option3" id="option3"
                                                                class="form-control text" placeholder="Option 3" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Option 4</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">person</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="option4" id="option4"
                                                                class="form-control text" placeholder="Option 4" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>
                                                        <b>Correct Option</b>
                                                    </p>
                                                    <select class="form-control show-tick" name="answer" id="answer" >
                                                        <option value="">Select Option</option>
                                                        <?php
                                                        $options = ['option1', 'option2','option3','option4'];
                                                        if (isset($options) && !empty($options)){
                                                            foreach ($options as $row)
                                                            {?>
                                                                <option value="<?=$row;?>"><?= $row;?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>
                                                        <b>Status</b>
                                                    </p>
                                                    <select class="form-control show-tick" name="status" id="edit_stauts" >
                                                        <option value="Active">Active</option>
                                                        <option value="InActive">InActive</option>

                                                    </select>

                                                </div>
                                                <!-- <div class="col-md-4">
                                                    <b>Image</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">perm_media</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="file" name="image" id="Doc_Videos"
                                                                class="form-control text" accept="image/*">
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-12">
                                                    <p>
                                                        <b>Description</b>
                                                    </p>
                                                    <textarea class="form-control text" name="description" id="question_description" placeholder="Description" rows="5" cols="5" ></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-bottom:20px;">
                                        <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect pull-right">SAVE DETAILS
                                    </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- #END# Masked Input -->
                    </form>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="questions"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%">Action</th>
                                        <th>Question</th>
                                        <th>Option 1</th>
                                        <th>Option 2</th>
                                        <th>Option 3</th>
                                        <th>Option 4</th>
                                        <th>Answer</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Question</th>
                                    <th>Option 1</th>
                                    <th>Option 2</th>
                                    <th>Option 3</th>
                                    <th>Option 4</th>
                                    <th>Answer</th>
                                    <th>Status</th>

                                </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
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

<div class="modal fade" id="show" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">View Document </h4>
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
                                                    <b>Courses</b>
                                                </p>
                                                <select class="form-control show-tick" name="source_id" id="s_source_id" disabled>
                                                    <option value="">Select Course</option>
                                                    <?php
                                                    $courses = courses();
                                                    if (isset($courses) && !empty($courses)){
                                                        foreach ($courses as $row)
                                                        {?>
                                                            <option value="<?=$row->id;?>"><?= $row->title;?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Number Of Questions</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="num_of_question" id="s_num_of_question"
                                                               class="form-control text" placeholder="Number Of Questions" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Marks Per Question</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="marks_per_question" id="s_marks_per_question"
                                                               class="form-control text" placeholder="Marks" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Time</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="time" id="s_time"
                                                               class="form-control text" placeholder="Time" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <p>
                                                    <b>Status</b>
                                                </p>
                                                <select class="form-control show-tick" name="status" id="s_status" disabled >
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>

                                                </select>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Image</b>
                                                <div class="input-group">
                                                    <img src="" alt="" id="s_img" class="img-fluid rounded"  style="width: 50%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea class="form-control text" name="description" id="s_description" placeholder="Description" rows="5" cols="5"  disabled></textarea>

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
    let type = 'course';
    let id = 'courses_quizs';
    let url = "<?php echo base_url() ?>get_quizs_details?section="+type;
</script>