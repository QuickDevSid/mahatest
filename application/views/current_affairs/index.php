<?php
/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Manage Current Affair's</h2>
        </div>
    

        
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Manage Current Affair's
                            <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                    data-target="#add_current_aff" >
                                <i class="material-icons">perm_media</i>
                                <span>ADD CURRENT AFFAIRS</span>
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
                                    <th width="60%">Title</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Views</th>
                                    <th width="10%">Created On</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Created On</th>
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


<div class="modal fade" id="add_current_aff" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_current_affair_form" enctype="multipart/form-data" action="<?php echo base_url() ?>CurrentAffairs/addPost" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Current Affair Post </h4>
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
                                                <b>Current Posts Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="PostTitle" id="PostTitle"
                                                               class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Sequence</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" min="1" name="sequence_no" id="sequence_no"
                                                               class="form-control text" placeholder="Sequence" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Category</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        
                                                    <select class="form-control show-tick" name="Category" id="Category" required>
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        if (isset($category)){
                                                            //print_r($category);
                                                            foreach ($category as $key) { 
                                                                //print_r($key);
                                                                if($key->category_name != "All"){
                                                                ?>
                                                                <option value="<?php echo($key->id); ?>"><?php echo($key->category_name); ?></option>
                                                                <?php
                                                                }
                                                            }
                                                        } 
                                                        ?>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b>Post Image</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="post_image" type="file" multiple />
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <b>Date</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input name="current_date" type="date" style="background: transparent;border:none;" value="<?php echo date('Y-m-d')?>" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-md-12">
                                                <b>
                                                    Description</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="Description" id="Description" placeholder="Description" required></textarea>
                                                    </div>
                                                </div>
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


<div class="modal fade" id="PostDetailModel" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Post Details</h4>
            </div>
            <div class="modal-body">
                <!-- Masked Input -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body">
                                <div class="row">
                                    <!-- Post Content Column -->
                                    <div class="col-lg-12">
                                        <!-- Title -->
                                        <h1 class="mt-4" id="d_post_title">Post Title</h1>
                                        <!-- Author -->
                                        
                                        <hr>
                                        <div class="col-lg-4">
                                            <p class="lead">
                                                Category : <a href="#" id="d_category">Category</a>
                                            </p>
                                        </div>
                                        <div class="col-lg-4">
                                            <!-- Date/Time -->
                                            <p id="d_created_at">Posted on January 1, 2019 at 12:00 PM</p>
                                        </div>
                                        <div class="col-lg-4">
                                            <!-- Date/Time -->
                                            <p id="d_views">Views : 2</p>
                                        </div>
                                        
                                       
                                       
                                        <hr>


                                        <hr>
                                        <!-- Preview Image -->
                                        <div id="d_post_image">
                                            <img class="img-fluid rounded" style="width: 100%;" src="http://placehold.it/900x300" alt="" >
                                        </div>
                                        
                                        <hr>
                                        <!-- Post Content -->
                                        <p id="d_post_description">Description</p>
                                        <hr>
                                        <!-- Comment with nested comments -->
                                        <div class="media mb-4" id="d_comment">
                                        <div class="media mt-4">
                                            <div class="media-left">
                                                <img class="d-flex mr-3 rounded-circle media-left" width="64" height="64" src="http://placehold.it/50x50" alt=""></div>
                                            <div class="media-body">
                                                <h5 class="mt-0">Commenter Name</h5>
                                                Comment Detail
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Masked Input -->

            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                </button>
            </div>
        </div>

    </div>
</div>

