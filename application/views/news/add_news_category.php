<style>
    .error {
        color: red;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><strong>Dashboard -> News -> Category </strong></h2>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Category</strong>
                        </h2>
                        <hr>
                        <form id="categorysubmit" enctype="multipart/form-data" action="<?php echo base_url() ?>add_news_category" method="POST">
                            <input type="hidden" name="source_type" value="test_series">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>Category Name*</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">touch_app</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="category_name" id="category_name" onkeyup="checkUniqueName()"
                                                                class="form-control text" placeholder="Enter Category Name"
                                                                value="<?php if (!empty($single)) {
                                                                            echo $single->title;
                                                                        } ?>">
                                                            <label id="unique_message" class="error" style="display:none;"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" value="<?php if (!empty($single)) {
                                                                            echo $single->id;
                                                                        } ?>" name="hidden_id" id="hidden_id">
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <button type="submit" name="submit_category" value="submit_category" id="submit_category" class="btn btn-link waves-effect">SAVE DETAILS</button>
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
    function checkUniqueName() {
        var categoryName = $('#category_name').val();
        var hiddenId = $('#hidden_id').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>Ajax_controller/check_unique_news_category/",
            data: {
                name: categoryName,
                id: hiddenId
            },
            dataType: "json",
            success: function(result) {
                if (result == '0') {
                    $('#submit_category').attr('disabled', true);
                    $('#unique_message').text('This category name already exist').show();
                } else {
                    $('#submit_category').attr('disabled', false);
                    $('#unique_message').text('').hide();
                }
            },
            error: function() {
                alert('Some error occurred!');
            }
        });
    }
</script>