<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Other Options - Add Other Options Category</h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Add Other Options Category
                        </h2>
                    </div>
                    <div class="body">
                        <form id="category_submit" name="category_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>Other_options_controller/add_other_option_category" method="POST">
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
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <b>Short Description*</b>
                                                        <div class="input-group">
                                                            <div class="form-line">
                                                                <textarea name="description" id="description" class="form-control text" placeholder="Enter Short Description" rows="5" cols="5"><?php if (!empty($single)) {
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