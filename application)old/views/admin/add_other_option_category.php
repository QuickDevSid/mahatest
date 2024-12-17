<?php $this->load->view('templates/header1'); ?>


<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Manage Other Option Categories</h2>
        </div>
        
        <div class="row clearfix">
            <!-- Category Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Manage Other Option Categories
                            <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                    data-target="#add_option_category">
                                <i class="material-icons">add</i>
                                <span>ADD CATEGORY</span>
                            </button>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="category_data"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th width="60%">Category Name</th>
                                    <th width="20%">Status</th>
                                    <th width="10%">Created On</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    <!-- Populate with data from the database -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Category Info -->
        </div>
    </div>
</section>

<div class="modal fade" id="add_option_category" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add_option_category_form" action="<?php echo base_url() ?>OptionCategory/addPost" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Option Category</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-md-6">
                                            <b>Category Name</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">category</i>
                                                </span>
                                                <div class="form-line">
                                                    <input type="text" name="category_name" id="category_name"
                                                           class="form-control" placeholder="Category Name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <b>Status</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">check_circle</i>
                                                </span>
                                                <div class="form-line">
                                                    <select class="form-control" name="status" id="status" required>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <b>Description</b>
                                            <div class="input-group">
                                                <div class="form-line">
                                                    <textarea name="description" id="description" placeholder="Description" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="CategoryDetailModel" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Category Details</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h1 class="mt-4" id="d_category_name">Category Name</h1>
                                        <hr>
                                        <p id="d_description">Description</p>
                                        <hr>
                                        <p id="d_status">Status: Active</p>
                                        <p id="d_created_at">Created on: January 1, 2019</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                </button>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('templates/footer1'); ?>

<!-- JavaScript to handle form submission and AJAX calls -->
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#category_data').DataTable();

    // Handle add category form submission
    $('#add_category_form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#add_category_modal').modal('hide');
                location.reload(); // Reload the page to see changes
            },
            error: function() {
                alert("An error occurred.");
            }
        });
    });

    // Handle edit button click
    $('.edit-category').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const description = $(this).data('description');
        const status = $(this).data('status');

        $('#edit_category_id').val(id);
        $('#edit_category_name').val(name);
        $('#edit_description').val(description);
        $('#edit_status').val(status);

        $('#edit_category_modal').modal('show');
    });

    // Handle edit category form submission
    $('#edit_category_form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#edit_category_modal').modal('hide');
                location.reload(); // Reload the page to see changes
            },
            error: function() {
                alert("An error occurred.");
            }
        });
    });

    // Handle delete button click
    $('.delete-category').on('click', function() {
        const id = $(this).data('id');
        if (confirm("Are you sure you want to delete this category?")) {
            $.ajax({
                url: '<?= base_url('OtherOptionCategory/deletePost') ?>',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    location.reload(); // Reload the page to see changes
                },
                error: function() {
                    alert("An error occurred.");
                }
            });
        }
    });
});
</script>





